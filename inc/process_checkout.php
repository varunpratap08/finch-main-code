<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        
        // Get cart items
        $product_ids = $_POST['product_ids'] ?? [];
        $quantities = $_POST['quantities'] ?? [];
        $prices = $_POST['prices'] ?? [];
        
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
        
        // Check if cart is not empty
        if (empty($product_ids) || empty($quantities) || empty($prices)) {
            $errors[] = "Your cart is empty";
        }
        
        if (!empty($errors)) {
            echo json_encode(['status' => 'error', 'message' => implode("\n", $errors)]);
            exit;
        }
        
        // Prepare order items
        $order_items = [];
        $order_total = 0;
        
        for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = intval($product_ids[$i]);
            $quantity = intval($quantities[$i]);
            $price = floatval($prices[$i]);
            
            if ($product_id > 0 && $quantity > 0 && $price >= 0) {
                $order_items[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity
                ];
                $order_total += $price * $quantity;
            }
        }
        
        if (empty($order_items)) {
            throw new Exception("No valid items in the cart");
        }
        
        // Start transaction
        $pdo->beginTransaction();
        
        try {
            // Insert order
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
                    'pending',
                    NOW()
                )
            ");
            
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
                ':total_amount' => $order_total
            ]);
            
            $order_id = $pdo->lastInsertId();
            
            // Insert order items
            // Prepare the order items statement
            $stmt = $pdo->prepare("
                INSERT INTO order_items (
                    order_id, 
                    product_id, 
                    quantity, 
                    price, 
                    subtotal,
                    created_at
                ) VALUES (
                    :order_id,
                    :product_id,
                    :quantity,
                    :price,
                    :subtotal,
                    NOW()
                )
            ");
            
            // Insert each order item
            foreach ($order_items as $item) {
                $params = [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ];
                $stmt->execute($params);
            }
            
            // Commit transaction
            $pdo->commit();
            
            // Send order confirmation email (you can implement this function)
            // sendOrderConfirmationEmail($order_id, $customer_email, $customer_name);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Order placed successfully!',
                'order_id' => $order_id
            ]);
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Error processing your order: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}
