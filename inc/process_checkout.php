<?php
// Ensure no output is sent before headers
define('NO_OUTPUT', true);

// Start output buffering to catch any unexpected output
ob_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); // Show errors for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

// Set content type to JSON
header('Content-Type: application/json');

// Log request data
error_log('=== New Request ===');
error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
error_log('Content Type: ' . ($_SERVER['CONTENT_TYPE'] ?? 'not set'));

// Log raw input
$rawInput = file_get_contents('php://input');
error_log('Raw input: ' . $rawInput);

// Log POST data
if (!empty($_POST)) {
    error_log('POST data: ' . print_r($_POST, true));
} else {
    error_log('No POST data received');
}

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
    sendJsonResponse('error', 'Invalid request method. Only POST requests are allowed.');
}

// Determine content type and parse input accordingly
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$isJsonRequest = strpos($contentType, 'application/json') !== false;

// Always initialize $data as an array before use
$data = [];

// Parse input based on content type
if ($isJsonRequest) {
    $input = file_get_contents('php://input');
    if (!empty($input)) {
        $jsonData = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $data = array_merge($data, $jsonData);
        } else {
            error_log('Failed to parse JSON input: ' . json_last_error_msg());
        }
    }
} else {
    // Handle form data
    $data = array_merge($data, $_POST);
    
    // Try to decode any JSON fields
    foreach (['cart_items', 'items'] as $field) {
        if (!empty($data[$field]) && is_string($data[$field])) {
            $decoded = json_decode($data[$field], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data[$field] = $decoded;
            }
        }
    }
}

try {
    // Initialize data array
    $data = [];
    
    // First, try to get data from $_POST
    $data = $_POST;
    
    // Debug: Log received data
    error_log('POST data: ' . print_r($_POST, true));
    
    // Check for JSON input
    $input = file_get_contents('php://input');
    error_log('Raw input: ' . $input);
    
    // If no POST data but we have input, try to parse it
    if (empty($data) && !empty($input)) {
        $json = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $data = $json;
            error_log('Successfully parsed JSON input');
        } else {
            // Try to parse as form data
            parse_str($input, $formData);
            if (!empty($formData)) {
                $data = $formData;
                error_log('Successfully parsed form data');
            }
        }
    }
    
    // Remove all code that tries to reconstruct cart items from separate arrays
    // Only use the cart_items field for order processing
    // After parsing input, do:
    $cart_items = [];
    if (!empty($data['cart_items'])) {
        if (is_string($data['cart_items'])) {
            $cart_items = json_decode($data['cart_items'], true);
        } else if (is_array($data['cart_items'])) {
            $cart_items = $data['cart_items'];
        }
    }
    if (empty($cart_items) || !is_array($cart_items)) {
        cleanOutputBuffer();
        sendJsonResponse('error', 'No cart items received');
    }
    
    // Debug: Log the cart items
    error_log('Cart items: ' . print_r($cart_items, true));
    
    // Validate required fields
    $required = [
        'customer_name' => 'Full Name',
        'customer_email' => 'Email Address',
        'customer_phone' => 'Phone Number',
        'shipping_address' => 'Shipping Address'
    ];
    
    $missing = [];
    foreach ($required as $field => $name) {
        if (empty($data[$field])) {
            $missing[] = $name;
        }
    }
    
    if (!empty($missing)) {
        sendJsonResponse('error', 'Please fill in all required fields: ' . implode(', ', $missing));
    }
    
    // Get form data
    $customer_name = trim($data['customer_name']);
    $customer_email = trim($data['customer_email']);
    $customer_phone = trim($data['customer_phone']);
    $shipping_address = trim($data['shipping_address']);
    $total_amount = floatval($data['total_amount'] ?? 0);

    // For backward compatibility
    $city = '';
    $state = '';
    $pincode = '';
    $country = 'India';
    $order_notes = '';
    
    // Get cart items from form data
    if (empty($data['cart_items'])) {
        error_log('No cart items received. Data received: ' . print_r($data, true));
        cleanOutputBuffer();
        sendJsonResponse('error', 'No cart items received');
    }

    $cart_items = $data['cart_items'];

    // If cart_items is a string, try to decode it as JSON
    if (is_string($cart_items)) {
        $cart_items = json_decode($cart_items, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            cleanOutputBuffer();
            sendJsonResponse('error', 'Invalid cart data format');
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

    // Prepare order details as JSON using normalized $order_items
    $order_details_json = json_encode([
        'items' => $order_items,
        'subtotal' => $total_amount,
        'shipping' => 0, // Add shipping cost if any
        'total' => $total_amount,
        'notes' => $data['additional_notes'] ?? ''
    ], JSON_PRETTY_PRINT);

    // Get the first product details for the main order record
    $first_product_id = $product_ids[0];
    $first_item = $order_items[0];
    
    // Insert order with order_details as JSON
    $stmt = $pdo->prepare("
        INSERT INTO orders (
            customer_name, 
            customer_email, 
            customer_phone, 
            customer_address,
            order_details,
            total_price,
            product_id,
            product_name,
            product_image,
            created_at,
            updated_at
        ) VALUES (
            :customer_name,
            :customer_email,
            :customer_phone,
            :customer_address,
            :order_details,
            :total_price,
            :product_id,
            :product_name,
            :product_image,
            NOW(),
            NOW()
        )
    ");

    // Prepare order data
    $order_data = [
        ':customer_name' => $customer_name,
        ':customer_email' => $customer_email,
        ':customer_phone' => $customer_phone,
        ':customer_address' => $shipping_address,
        ':order_details' => $order_details_json,
        ':total_price' => $total_amount,
        ':product_id' => $first_product_id,
        ':product_name' => $first_item['name'],
        ':product_image' => $first_item['image']
    ];

    // Execute the order insertion
    $stmt->execute($order_data);
    $order_id = $pdo->lastInsertId();

    // Verify all product IDs exist in the database before processing the order
    if (empty($cart_items)) {
        throw new Exception('No items in cart');
    }

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

    $calculated_total = 0;
    $order_items = [];

    // Process each item in the cart
    foreach ($cart_items as $item) {
        if (!isset($item['id'], $item['qty'], $item['price'])) {
            throw new Exception('Invalid item in cart');
        }
        
        $item_total = $item['price'] * $item['qty'];
        $calculated_total += $item_total;
        
        $order_items[] = [
            'product_id' => (int)$item['id'],
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


    // Prepare order details as JSON using normalized $order_items
    $order_details_json = json_encode([
        'items' => $order_items,
        'subtotal' => $total_amount,
        'shipping' => 0,
        'total' => $total_amount,
        'notes' => $data['additional_notes'] ?? ''
    ], JSON_PRETTY_PRINT);

    // Get the first product details for the main order record
    $first_product_id = $product_ids[0];
    $first_item = $cart_items[0];

    // If we get here, everything was successful
    $pdo->commit();
    
    // Log success
    error_log('Order placed successfully. Order ID: ' . $order_id);
    
    // Send success response with order ID
    sendJsonResponse('success', 'Order placed successfully', [
        'order_id' => $order_id,
        'redirect' => 'thank-you.php?order_id=' . $order_id
    ]);
    exit;

} catch (Exception $e) {
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    
    error_log('Checkout Process Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    error_log('POST data: ' . print_r($_POST, true));
    error_log('Backtrace: ' . print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true));
    
    $errorMessage = 'An error occurred: ' . $e->getMessage();
    if (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || ($_SERVER['REMOTE_ADDR'] ?? '') === '127.0.0.1') {
        $errorMessage .= ' in ' . basename($e->getFile()) . ' on line ' . $e->getLine();
    }
    
    sendJsonResponse('error', $errorMessage);
}
?>
