<?php
session_start();

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
    // Fetch orders with product details
    $stmt = $pdo->query("SELECT o.id, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.order_details, o.total_price, o.created_at, 
                                 p.product_name, p.product_image 
                          FROM orders o 
                          JOIN products p ON o.product_id = p.id 
                          ORDER BY o.created_at DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <?php if ($orders): ?>
                        <?php foreach ($orders as $order): 
                            $order_details = json_decode($order['order_details'], true);
                            $first_item = $order_details[0] ?? [];
                            $image_path = !empty($order['product_image']) ? 
                                (strpos($order['product_image'], 'http') === 0 ? 
                                    $order['product_image'] : 
                                    '../' . ltrim($order['product_image'], '/')) : 
                                '../assets/img/no-image.png';
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
                                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                                 alt="<?php echo htmlspecialchars($order['product_name']); ?>" 
                                                 class="product-img me-3">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h6>
                                                <p class="text-muted small mb-0">
                                                    Order Total: <strong>₹<?php echo number_format($order['total_price'], 2); ?></strong>
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
                                                        <?php foreach ($order_details as $item): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($item['size']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['finish']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                            <td>₹<?php echo number_format($item['price_per_unit'], 2); ?></td>
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
                                                <p class="mb-1">
                                                    <i class="bi bi-person me-2"></i>
                                                    <?php echo htmlspecialchars($order['customer_name']); ?>
                                                </p>
                                                <p class="mb-1">
                                                    <i class="bi bi-envelope me-2"></i>
                                                    <a href="mailto:<?php echo htmlspecialchars($order['customer_email']); ?>">
                                                        <?php echo htmlspecialchars($order['customer_email']); ?>
                                                    </a>
                                                </p>
                                                <p class="mb-1">
                                                    <i class="bi bi-telephone me-2"></i>
                                                    <a href="tel:<?php echo htmlspecialchars($order['customer_phone']); ?>">
                                                        <?php echo htmlspecialchars($order['customer_phone']); ?>
                                                    </a>
                                                </p>
                                                <p class="mb-0">
                                                    <i class="bi bi-geo-alt me-2"></i>
                                                    <?php echo nl2br(htmlspecialchars($order['customer_address'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-info btn-sm" onclick="showOrderDetails(<?php echo htmlspecialchars(json_encode($order), ENT_QUOTES, 'UTF-8'); ?>)">
                                                <i class="bi bi-eye me-1"></i> View Details
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
    function deleteOrder(orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            window.location.href = 'delete_order.php?id=' + orderId;
        }
    }

    function showOrderDetails(order) {
        // Create order details HTML
        let details = `
            <div class="order-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Order #${order.id}</h6>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">Completed</span></p>
                        <p class="mb-1"><strong>Order Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                        <p class="mb-1"><strong>Total Amount:</strong> ₹${parseFloat(order.total_price).toFixed(2)}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Customer Details</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><i class="bi bi-person me-2"></i> ${order.customer_name}</p>
                                <p class="mb-2"><i class="bi bi-envelope me-2"></i> <a href="mailto:${order.customer_email}">${order.customer_email}</a></p>
                                <p class="mb-2"><i class="bi bi-telephone me-2"></i> <a href="tel:${order.customer_phone}">${order.customer_phone}</a></p>
                                <p class="mb-0"><i class="bi bi-geo-alt me-2"></i> ${order.customer_address.replace(/\n/g, '<br>')}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Order Items</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Item</th>
                                                <th>Size</th>
                                                <th>Finish</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
        
        // Add order items
        const orderDetails = JSON.parse(order.order_details);
        orderDetails.forEach(item => {
            details += `
                <tr>
                    <td>${order.product_name}</td>
                    <td>${item.size || 'N/A'}</td>
                    <td>${item.finish || 'N/A'}</td>
                    <td>${item.quantity}</td>
                    <td>₹${parseFloat(item.price_per_unit).toFixed(2)}</td>
                </tr>`;
        });
        
        details += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        
        // Show in modal
        const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
        const modalTitle = document.querySelector('#orderDetailsModal .modal-title');
        const modalBody = document.querySelector('#orderDetailsModal .modal-body');
        
        modalTitle.textContent = `Order #${order.id} Details`;
        modalBody.innerHTML = details;
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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