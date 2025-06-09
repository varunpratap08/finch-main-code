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
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $pincode = trim($_POST['pincode'] ?? '');
        $country = trim($_POST['country'] ?? 'India');
        $order_notes = trim($_POST['order_notes'] ?? '');
        $total_amount = floatval($_POST['total_amount'] ?? 0);
        
        // Get cart items from JSON
        $cart_items = [];
        if (!empty($_POST['cart_items'])) {
            $cart_items = json_decode($_POST['cart_items'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid cart data');
            }
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
            'shipping_address' => 'Shipping Address',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode'
        ];
        
        $errors = [];
        foreach ($required as $field => $label) {
            if (empty($$field)) {
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
        
        foreach ($cart_items as $item) {
            if (!isset($item['id'], $item['qty'], $item['price'])) {
                throw new Exception('Invalid item in cart');
            }
            
            $item_total = $item['price'] * $item['qty'];
            $calculated_total += $item_total;
            
            $order_items[] = [
                'product_id' => $item['id'],
                'name' => $item['name'] ?? 'Product ' . $item['id'],
                'image' => $item['image'] ?? '',
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item_total
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
            // Insert order with order_details as JSON
            $stmt = $pdo->prepare("
                INSERT INTO orders (
                    customer_name, 
                    customer_email, 
                    customer_phone, 
                    shipping_address, 
                    city, 
                    state, 
                    pincode, 
                    country, 
                    order_notes, 
                    total_amount,
                    order_details,
                    status,
                    created_at
                ) VALUES (
                    :customer_name,
                    :customer_email,
                    :customer_phone,
                    :shipping_address,
                    :city,
                    :state,
                    :pincode,
                    :country,
                    :order_notes,
                    :total_amount,
                    :order_details,
                    'pending',
                    NOW()
                )
            ");
            
            // Use the calculated total instead of the potentially undefined $order_total
            $stmt->execute([
                ':customer_name' => $customer_name,
                ':customer_email' => $customer_email,
                ':customer_phone' => $customer_phone,
                ':shipping_address' => $shipping_address,
                ':city' => $city,
                ':state' => $state,
                ':pincode' => $pincode,
                ':country' => $country,
                ':order_notes' => $order_notes,
                ':total_amount' => $calculated_total,
                ':order_details' => $order_details
            ]);
            
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
        error_log('Unexpected Error: ' . $e->getMessage());
        sendJsonResponse('error', 'An unexpected error occurred. Please try again.');
    }
