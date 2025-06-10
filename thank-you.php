<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get order ID from URL or session
$order_id = $_GET['order_id'] ?? ($_SESSION['order_id'] ?? null);

// Include database connection
require_once 'inc/db.php';

// Fetch order details if order ID is available
$order_details = null;
if ($order_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
        $stmt->execute([$order_id]);
        $order_details = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log('Error fetching order details: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Order - Pali Industries</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #212529;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .thank-you-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #d4edda;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .success-icon svg {
            width: 40px;
            height: 40px;
            color: #28a745;
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #2c3e50;
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        .order-details h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #6c757d;
        }
        .detail-value {
            font-weight: 500;
        }
        .btn-container {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #f1c40f;
            border: 1px solid #f1c40f;
            color: #000;
        }
        .btn-primary:hover {
            background-color: #d4ac0d;
            border-color: #d4ac0d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(241, 196, 15, 0.3);
        }
        .btn-outline-secondary {
            border: 1px solid #6c757d;
            color: #6c757d;
            background: transparent;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
            transform: translateY(-2px);
        }
        .btn i {
            margin-right: 0.5rem;
        }
        @ (max-width: 576px) {
            .btn-container {
                flex-direction: column;
                gap: 0.75rem;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1>Thank You for Your Order!</h1>
        
        <p class="text-center text-muted mb-4">Your order has been received and is being processed.</p>
        
        <?php if ($order_id): ?>
        <div class="order-details">
            <h3>Order Details</h3>
            <div class="detail-item">
                <span class="detail-label">Order Number:</span>
                <span class="detail-value">#<?php echo htmlspecialchars($order_id); ?></span>
            </div>
            <?php if ($order_details && isset($order_details['created_at'])): ?>
            <div class="detail-item">
                <span class="detail-label">Date:</span>
                <span class="detail-value"><?php echo date('F j, Y', strtotime($order_details['created_at'])); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value">₹<?php echo number_format($order_details['total_price'] ?? 0, 2); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">Cash on Delivery</span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="alert alert-success" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-envelope-check-fill me-2" style="font-size: 1.5rem;"></i>
                <div>
                    <h4 class="h6 mb-0">Check your email</h4>
                    <p class="mb-0 small">We've sent the order confirmation to your email address.</p>
                </div>
            </div>
        </div>
        
        <div class="btn-container">
            <a href="products.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Back to Home
            </a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Clear the order ID from session to prevent showing it again on refresh
unset($_SESSION['order_id']);
?>
