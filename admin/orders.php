<?php
session_start();

// Function to find existing image file
function findImageFile($image_path) {
    if (empty($image_path)) return '';
    
    // If it's already a full URL, return as is
    if (strpos($image_path, 'http') === 0) {
        return $image_path;
    }
    
    // Clean the path
    $clean_path = ltrim($image_path, '/.');
    
    // Possible locations to check
    $possible_paths = [
        '../' . $clean_path,
        '../assets/img/products/' . basename($clean_path),
        '../assets/img/' . basename($clean_path)
    ];
    
    // Check each possible location
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }
    
    // If not found, try the original path as fallback
    return '../' . ltrim($image_path, '/');
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard </title>
  <meta content="" name="description">
  <meta content="" name="keywords">



  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
    .order-card {
        transition: transform 0.2s;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .order-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    .order-body {
        padding: 15px;
    }
    .order-details {
        font-size: 0.9rem;
    }
    .order-details dt {
        font-weight: 600;
        color: #495057;
    }
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
    }
    .order-item {
        padding: 10px 0;
        border-bottom: 1px dashed #eee;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .order-actions .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }
    @media (max-width: 768px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .order-actions .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
  </style>
  


</head>

<body>

  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">orders</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    
   <?php
require_once '../inc/db.php'; // Ensure this file contains the PDO connection

try {
    // First, get all orders
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all product IDs from orders
    $productIds = [];
    $orderProductMap = [];
    
    foreach ($orders as $order) {
        $orderDetails = json_decode($order['order_details'], true);
        if (is_array($orderDetails)) {
            foreach ($orderDetails as $item) {
                if (isset($item['product_id']) && is_numeric($item['product_id'])) {
                    $productIds[] = (int)$item['product_id'];
                    $orderProductMap[$order['id']][] = (int)$item['product_id'];
                }
            }
        }
    }
    
    // Get product details in one query
    $products = [];
    if (!empty($productIds)) {
        $placeholders = rtrim(str_repeat('?,', count(array_unique($productIds))), ',');
        $stmt = $pdo->prepare("SELECT id, product_name, product_image FROM products WHERE id IN ($placeholders)");
        $stmt->execute(array_unique($productIds));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Create a product ID to details map
    $productMap = [];
    foreach ($products as $product) {
        $productMap[$product['id']] = $product;
    }
    
    // Enrich orders with product details
    foreach ($orders as &$order) {
        $order['items'] = [];
        $orderDetails = json_decode($order['order_details'], true);
        
        if (is_array($orderDetails)) {
            if (isset($orderDetails['product_id'])) { // Single item
                $orderDetails = [$orderDetails];
            }
            
            foreach ($orderDetails as $item) {
                if (is_array($item)) {
                    $productId = $item['product_id'] ?? null;
                    if ($productId && isset($productMap[$productId])) {
                        $item = array_merge($item, $productMap[$productId]);
                    }
                    $order['items'][] = $item;
                }
            }
        }
    }
    unset($order); // Break the reference
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Management</h5>
                    <p class="text-muted mb-0">View and manage customer orders</p>
                </div>
                <div class="card-body">
                    <?php 
                    // Group orders by customer and timestamp
                    $grouped_orders = [];
                    foreach ($orders as $order) {
                        // Skip if order_details is empty
                        if (empty($order['order_details'])) {
                            continue;
                        }
                        
                        // Decode the order details
                        $order_details = json_decode($order['order_details'], true);
                        
                        // Handle case where order_details is a JSON string of an array
                        if (is_string($order_details)) {
                            $order_details = json_decode($order_details, true);
                        }
                        
                        // If order_details is still not an array, initialize it as an empty array
                        if (!is_array($order_details)) {
                            $order_details = [];
                        }
                        
                        // Handle the new structure where items are in 'items' key
                        if (isset($order_details['items']) && is_array($order_details['items'])) {
                            $items = $order_details['items'];
                            $finish_image = $order_details['finish_image'] ?? '';
                        } else {
                            // Handle old structure where items are directly in the array
                            $items = isset($order_details[0]) ? $order_details : [$order_details];
                            $finish_image = '';
                        }
                        
                        $order_key = $order['customer_email'] . '_' . strtotime($order['created_at']);
                        
                        if (!isset($grouped_orders[$order_key])) {
                            $grouped_orders[$order_key] = [
                                'id' => $order['id'],
                                'customer_name' => $order['customer_name'],
                                'customer_email' => $order['customer_email'],
                                'customer_phone' => $order['customer_phone'],
                                'customer_address' => $order['customer_address'],
                                'created_at' => $order['created_at'],
                                'total_price' => 0,
                                'items' => []
                            ];
                        }
                        
                        // Process each item in the order details
                        foreach ($items as $item) {
                            if (!is_array($item)) {
                                continue; // Skip invalid items
                            }
                            
                            // Generate a unique ID for the item if not present
                            $product_id = $item['id'] ?? $item['product_id'] ?? 'unknown_' . uniqid();
                            $product_name = $item['name'] ?? 'Product ' . $product_id;
                            
                            $item_data = [
                                'product_id' => $product_id,
                                'name' => $product_name,
                                'image' => $item['image'] ?? '',
                                'size' => $item['size'] ?? '',
                                'finish' => $item['finish'] ?? $item['finish_display'] ?? '',
                                'finish_image' => $item['finish_image'] ?? $finish_image,
                                'quantity' => isset($item['quantity']) ? (int)$item['quantity'] : (isset($item['qty']) ? (int)$item['qty'] : 1),
                                'price' => isset($item['price']) ? (float)$item['price'] : 0,
                                'price_per_unit' => $item['price_per_unit'] ?? 0,
                                'subtotal' => isset($item['subtotal']) ? (float)$item['subtotal'] : 0
                            ];
                            
                            $grouped_orders[$order_key]['items'][] = $item_data;
                            $grouped_orders[$order_key]['total_price'] += $item_data['subtotal'] ?? $order['total_price'] ?? 0;
                        }
                    }
                    ?>
                    
                    <?php if (!empty($grouped_orders)): ?>
                        <?php foreach ($grouped_orders as $order_key => $order): 
                            // Initialize order details array
                            $order_details = [];
                            
                            // Decode order details if it's a JSON string
                            if (!empty($order['order_details']) && is_string($order['order_details'])) {
                                $decoded_details = json_decode($order['order_details'], true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $order_details = $decoded_details;
                                    $order = array_merge($order, $order_details);
                                }
                            }
                            
                            // Get first item and its details
                            $first_item = [];
                            if (!empty($order['items']) && is_array($order['items'])) {
                                $first_item = $order['items'][0] ?? [];
                                // If finish_image is at the order level, copy it to the first item
                                if (!empty($order['finish_image']) && empty($first_item['finish_image'])) {
                                    $first_item['finish_image'] = $order['finish_image'];
                                }
                            }
                            
                            $image_path = '';
                            
                            // Initialize image path
                            $image_path = '';
                            
                            // Try to find an image in this order:
                            // 1. Check if item has a direct image path
                            if (empty($image_path) && !empty($first_item['image'])) {
                                $image_path = $first_item['image'];
                            }
                            // 2. Check if item has a product_image from the database
                            if (empty($image_path) && !empty($first_item['product_image'])) {
                                $image_path = $first_item['product_image'];
                            }
                            
                            // Process the found image path
                            if (!empty($image_path)) {
                                // Handle full URLs
                                if (strpos($image_path, 'http') !== 0) {
                                    // For relative paths, try to find the file
                                    $image_path = findImageFile($image_path);
                                    
                                    // If file doesn't exist locally, try to make it a full URL
                                    if (!file_exists($image_path)) {
                                        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
                                        $image_path = $base_url . '/' . ltrim($image_path, '/');
                                    }
                                }
                            }
                            
                            // Fallback to no-image placeholder
                            if (empty($image_path)) {
                                $no_image_path = '../assets/img/no-image.png';
                                $image_path = file_exists($no_image_path) ? $no_image_path : '';
                            }
                        ?>
                        <div class="card order-card mb-4">
                            <div class="order-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Order #<?php echo $order['id']; ?></h6>
                                    <small class="text-muted">Placed on <?php echo date('M d, Y', strtotime($order['created_at'])); ?></small>
                                </div>
                                <div>
                                    <span class="badge bg-primary status-badge">Completed</span>
                                </div>
                            </div>
                            <div class="order-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="d-flex" style="gap: 10px;">
                                                <!-- Main product image -->
                                                <div class="product-image-container me-3" style="width: 120px; height: 120px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px;">
                                                    <?php if (!empty($image_path)): ?>
                                                       <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                                             alt="<?php echo htmlspecialchars($first_item['name'] ?? 'Product Image'); ?>" 
                                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Finish image if available -->
                                                <?php 
                                                $finish_image = $first_item['finish_image'] ?? '';
                                                if (!empty($finish_image)): 
                                                    $finish_image_path = findImageFile($finish_image);
                                                    // If the image doesn't exist locally, try to use it as a direct URL
                                                    if (!file_exists($finish_image_path) && strpos($finish_image, 'http') === 0) {
                                                        $finish_image_path = $finish_image;
                                                    }
                                                ?>
                                                    <div class="finish-image-container" style="width: 80px; height: 120px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px; padding: 5px; border: 1px solid #dee2e6;">
                                                        <small class="text-muted mb-1">Finish</small>
                                                        <img src="<?php echo htmlspecialchars($finish_image_path); ?>" 
                                                             alt="Finish: <?php echo htmlspecialchars($first_item['finish'] ?? ''); ?>" 
                                                             style="max-width: 100%; max-height: 80%; object-fit: contain;"
                                                             onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%22%20height%3D%22100%22%20fill%3D%22%23e9ecef%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22Arial%2C%20sans-serif%22%20font-size%3D%2212%22%20text-anchor%3D%22middle%22%20alignment-baseline%3D%22middle%22%20fill%3D%22%236c757d%22%3ENo%20Image%3C%2Ftext%3E%3C%2Fsvg%3E';">
                                                        <small class="text-muted mt-1 text-truncate" style="max-width: 70px;" title="<?php echo htmlspecialchars($first_item['finish'] ?? ''); ?>">
                                                            <?php echo htmlspecialchars($first_item['finish'] ?? ''); ?>
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Order #<?php echo $order['id']; ?></h6>
                                                <p class="text-muted small mb-0">
                                                    Order Total: <strong>₹<?php echo number_format($order['total_price'], 2); ?></strong>
                                                    (<?php echo count($order['items']); ?> item<?php echo count($order['items']) !== 1 ? 's' : ''; ?>)
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="order-details">
                                            <h6 class="mb-2">Order Details:</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>Size</th>
                                                            <th>Finish</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($order['items'] as $item): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($item['size']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['finish']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                                                            <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">Customer Details</h6>
                                               <!-- <h6 class="card-title">Customer Details</h6> -->
                                                <p class="mb-1">
                                                    <strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?>
                                                </p>
                                                <p class="mb-0">
                                                    <strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['customer_address'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <button type="button" class="btn btn-info btn-sm" onclick="showOrderDetails(<?php echo htmlspecialchars(json_encode($order), ENT_QUOTES, 'UTF-8'); ?>)">
                                                <i class="bi bi-eye me-1"></i> View Details
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="return deleteOrder(<?php echo $order['id']; ?>, this)">
                                                <i class="bi bi-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                            </div>
                            <h5>No orders found</h5>
                            <p class="text-muted">When you receive new orders, they will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function deleteOrder(orderId, button) {
        if (!confirm('Are you sure you want to delete order #' + orderId + '? This action cannot be undone.')) {
            return false;
        }
        
        // Show loading state
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>';
        
        // Find the order card for removal later
        const orderCard = button.closest('.order-card');
        
        // Send delete request
        fetch('delete_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `order_id=${orderId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mb-3';
                alert.role = 'alert';
                alert.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i> Order #${orderId} has been deleted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                // Insert alert before the orders list
                const ordersContainer = document.querySelector('.card-body');
                if (ordersContainer) {
                    ordersContainer.insertBefore(alert, ordersContainer.firstChild);
                }
                
                // Remove the order card with animation
                if (orderCard) {
                    orderCard.style.transition = 'opacity 0.3s ease';
                    orderCard.style.opacity = '0';
                    setTimeout(() => {
                        orderCard.remove();
                        
                        // Check if there are no more orders
                        if (!document.querySelector('.order-card')) {
                            const noOrdersDiv = document.createElement('div');
                            noOrdersDiv.className = 'text-center py-5';
                            noOrdersDiv.innerHTML = `
                                <div class="mb-3">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                </div>
                                <h5>No orders found</h5>
                                <p class="text-muted">When you receive new orders, they will appear here.</p>
                            `;
                            ordersContainer.appendChild(noOrdersDiv);
                        }
                    }, 300);
                }
                
                // Remove alert after 5 seconds
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            } else {
                throw new Error(data.message || 'Failed to delete order');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete order: ' + (error.message || 'Unknown error'));
            button.disabled = false;
            button.innerHTML = originalText;
        });
        
        return false;
    }

    function showOrderDetails(order) {
        // Parse the order details if it's a string
        if (typeof order === 'string') {
            order = JSON.parse(order);
        }

        // Format the order date
        const orderDate = new Date(order.created_at);
        const formattedDate = orderDate.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Create order details HTML
        let details = `
            <div class="order-details">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Order #${order.id}</h4>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Order Date:</strong> ${formattedDate}</p>
                                <p class="mb-1"><strong>Total Amount:</strong> ₹${parseFloat(order.total_price || 0).toFixed(2)}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Customer Details</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><i class="bi bi-person me-2"></i> ${order.customer_name || 'N/A'}</p>
                                <p class="mb-2"><i class="bi bi-envelope me-2"></i> ${order.customer_email ? `<a href="mailto:${order.customer_email}">${order.customer_email}</a>` : 'N/A'}</p>
                                <p class="mb-2"><i class="bi bi-telephone me-2"></i> ${order.customer_phone ? `<a href="tel:${order.customer_phone}">${order.customer_phone}</a>` : 'N/A'}</p>
                                <p class="mb-0"><i class="bi bi-geo-alt me-2"></i> ${order.customer_address ? order.customer_address.replace(/\n/g, '<br>') : 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Order Items (${order.items ? order.items.length : 0})</h6>
                                <span class="badge bg-primary">Total: ₹${parseFloat(order.total_price || 0).toFixed(2)}</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Item</th>
                                                <th>Size</th>
                                                <th>Finish</th>
                                                <th class="text-end">Qty</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
        
        // Add order items
        const items = order.items || [];
        let totalItems = 0;
        
        items.forEach(item => {
            const quantity = parseInt(item.quantity || 1);
            const price = parseFloat(item.price || 0);
            const subtotal = quantity * price;
            totalItems += quantity;
            
            details += `
                <tr>
                    <td>${item.name || 'Product'}</td>
                    <td>${item.size || 'N/A'}</td>
                    <td>${item.finish || 'N/A'}</td>
                    <td class="text-end">${quantity}</td>
                    <td class="text-end">₹${price.toFixed(2)}</td>
                    <td class="text-end fw-bold">₹${subtotal.toFixed(2)}</td>
                </tr>`;
        });
        
        // Add order summary
        const subtotal = parseFloat(order.total_price || 0);
        const shipping = 0; // Add shipping calculation if needed
        const total = subtotal + shipping;
        
        details += `
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold">Subtotal:</td>
                                                <td class="text-end">₹${subtotal.toFixed(2)}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold">Shipping:</td>
                                                <td class="text-end">₹${shipping.toFixed(2)}</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td colspan="5" class="text-end fw-bold">Total:</td>
                                                <td class="text-end fw-bold">₹${total.toFixed(2)}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        
        // Show in modal
        const modalElement = document.getElementById('orderDetailsModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalBody = modalElement.querySelector('.modal-body');
        
        modalTitle.textContent = `Order #${order.id} Details`;
        modalBody.innerHTML = details;
        
        // Initialize any tooltips in the modal
        const tooltipTriggerList = [].slice.call(modalElement.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        modal.show();
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Close
                </button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>



    





  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Icon Furniture</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
     
      Designed by <a href="https://volvrit.com/">Volvrit</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>