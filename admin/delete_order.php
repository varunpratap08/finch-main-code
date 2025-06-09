<?php
session_start();
header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Get order ID from request
$order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if (!$order_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit();
}

try {
    // Include database connection
    require_once '../inc/db.php';
    
    // Start transaction
    $pdo->beginTransaction();
    
    // First, delete any related records in order_items (if this table exists)
    // This is a safety check in case there are foreign key constraints
    try {
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
    } catch (PDOException $e) {
        // Table might not exist or no foreign key constraints
        // We can continue with order deletion
    }
    
    // Delete the order
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $result = $stmt->execute([$order_id]);
    
    if ($result && $stmt->rowCount() > 0) {
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
    } else {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Order not found or could not be deleted']);
    }
    
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Error deleting order: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
