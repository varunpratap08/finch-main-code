<?php
// Ensure no output is sent before headers
define('NO_OUTPUT', true);

// Start output buffering to catch any unexpected output
ob_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't output errors to the response

// Set content type to JSON
header('Content-Type: application/json');

// Function to send JSON response and exit
function sendJsonResponse($status, $message, $data = []) {
    // Clear any previous output
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    http_response_code($status === 'error' ? 400 : 200);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Handle database connection
try {
    require_once 'db.php';
    
    // Verify database connection
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        throw new Exception('Database connection failed');
    }
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Start transaction
    $pdo->beginTransaction();
} catch (Exception $e) {
    sendJsonResponse('error', 'Database connection error: ' . $e->getMessage());
}

// Function to clean output buffer and return its contents
function cleanOutputBuffer() {
    return ob_get_clean();
}

// Verify request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Clean any output that might have been generated
    cleanOutputBuffer();
    header('HTTP/1.1 405 Method Not Allowed');
    sendJsonResponse('error', 'Method not allowed');
}
    try {
        // Get form data
        $customer_name = trim($_POST['customer_name'] ?? '');
        $customer_email = trim($_POST['customer_email'] ?? '');
        $customer_phone = trim($_POST['customer_phone'] ?? '');
        $shipping_address = trim($_POST['shipping_address'] ?? '');
        $total_amount = floatval($_POST['total_amount'] ?? 0);
        
        // For backward compatibility
        $city = '';
        $state = '';
        $pincode = '';
        $country = 'India';
        $order_notes = '';
        
        // Get cart items from form data
        if (empty($_POST['cart_items'])) {
            cleanOutputBuffer();
            sendJsonResponse('error', 'No cart items received');
        }
        
        $cart_items = json_decode($_POST['cart_items'], true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            cleanOutputBuffer();
            sendJsonResponse('error', 'Invalid cart data: ' . json_last_error_msg());
        }
        
        if (empty($cart_items)) {
            cleanOutputBuffer();
            sendJsonResponse('error', 'Your cart is empty');
        }
        
        // Validate required fields
        $required = [
            'customer_name' => 'Full Name',
            'customer_email' => 'Email Address',
            'customer_phone' => 'Phone Number',
            'shipping_address' => 'Shipping Address'
        ];
        
        $errors = [];
        foreach ($required as $field => $label) {
            if (empty($$field) && !empty($label)) {
                $errors[] = "$label is required";
            }
        }
        
        // Validate email
        if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address";
        }
        
        // Validate phone (basic validation)
        if (!preg_match('/^[0-9]{10,15}$/', $customer_phone)) {
            $errors[] = "Invalid phone number";
        }
        
        // Calculate total from cart items
        $calculated_total = 0;
        $order_items = [];
        
        // First, verify all product IDs exist in the database
        $product_ids = array_column($cart_items, 'id');
        $placeholders = rtrim(str_repeat('?,', count($product_ids)), ',');
        
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id IN ($placeholders)");
        $stmt->execute($product_ids);
        $valid_product_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Log for debugging
        error_log('Cart product IDs: ' . print_r($product_ids, true));
        error_log('Valid product IDs: ' . print_r($valid_product_ids, true));
        
        // Check if all products in cart exist in database
        $invalid_products = array_diff($product_ids, $valid_product_ids);
        if (!empty($invalid_products)) {
            throw new Exception('One or more products in your cart are no longer available');
        }
        
        foreach ($cart_items as $item) {
            if (!isset($item['id'], $item['qty'], $item['price'])) {
                throw new Exception('Invalid item in cart');
            }
            
            $item_total = $item['price'] * $item['qty'];
            $calculated_total += $item_total;
            
            $order_items[] = [
                'product_id' => (int)$item['id'],  // Ensure it's an integer
                'name' => $item['name'] ?? 'Product ' . $item['id'],
                'image' => $item['image'] ?? '',
                'quantity' => (int)$item['qty'],
                'price' => (float)$item['price'],
                'subtotal' => $item_total,
                'size' => $item['size'] ?? '',
                'finish' => $item['finish'] ?? ''
            ];
        }
        
        // Verify total matches
        if (abs($calculated_total - $total_amount) > 0.01) {
            error_log("Total mismatch: Calculated: $calculated_total, Received: $total_amount");
            // Uncomment the line below to enforce total validation
            // $errors[] = "Cart total does not match";
        }
        
        if (!empty($errors)) {
            cleanOutputBuffer();
            sendJsonResponse('error', implode("\n", $errors));
        }
        
        // Use the order items we already prepared
        $order_details = $order_items;
        
        // Encode order items as JSON
        $order_details = json_encode($order_items);
        
        try {
            // First, verify the product IDs exist
            $product_ids = array_unique(array_column($order_items, 'product_id'));
            $placeholders = rtrim(str_repeat('?,', count($product_ids)), ',');
            
            $stmt = $pdo->prepare("SELECT id FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $existing_products = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Check for missing products
            $missing_products = array_diff($product_ids, $existing_products);
            if (!empty($missing_products)) {
                throw new Exception('The following product IDs are not valid: ' . implode(', ', $missing_products));
            }
            
            // Insert order with order_details as JSON
            $stmt = $pdo->prepare("
                INSERT INTO orders (
                    customer_name, 
                    customer_email, 
                    customer_phone, 
                    customer_address,
                    total_price,
                    order_details,
                    product_id,  
                    created_at
                ) VALUES (
                    :customer_name,
                    :customer_email,
                    :customer_phone,
                    :customer_address,
                    :total_price,
                    :order_details,
                    :product_id,
                    NOW()
                )
            ");
            
            // For each product, insert a separate order record
            foreach ($order_items as $item) {
                $order_data = [
                    ':customer_name' => $customer_name,
                    ':customer_email' => $customer_email,
                    ':customer_phone' => $customer_phone,
                    ':customer_address' => $shipping_address,
                    ':total_price' => $item['subtotal'],
                    ':order_details' => json_encode($item),
                    ':product_id' => $item['product_id']
                ];
                
                $stmt->execute($order_data);
            }
            
            $order_id = $pdo->lastInsertId();
            
            // Commit the transaction
            $pdo->commit();
            
            // Send success response
            sendJsonResponse('success', 'Order placed successfully!', [
                'order_id' => $order_id,
                'redirect' => 'thank-you.php?order_id=' . $order_id
            ]);
            
        } catch (Exception $e) {
            if (isset($pdo)) {
                $pdo->rollBack();
            }
            error_log('Checkout Error: ' . $e->getMessage());
            sendJsonResponse('error', 'Error processing your order: ' . $e->getMessage());
        }
    } catch (Exception $e) {
        error_log('Checkout Process Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
        error_log('POST data: ' . print_r($_POST, true));
        error_log('Backtrace: ' . print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true));
        
        // For development - show detailed error
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        if (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || ($_SERVER['REMOTE_ADDR'] ?? '') === '127.0.0.1') {
            $errorMessage .= ' in ' . basename($e->getFile()) . ' on line ' . $e->getLine();
        }
        
        sendJsonResponse('error', $errorMessage);
    }
