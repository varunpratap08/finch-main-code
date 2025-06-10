<?php
// inc/fetch_sizes.php
header('Content-Type: application/json');
require_once 'db.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if (!$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// Example: sizes stored as comma-separated in `sizes` column of products table
$sql = "SELECT sizes FROM products WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $sizes = array_map('trim', explode(',', $row['sizes']));
    echo json_encode(['status' => 'success', 'sizes' => $sizes]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
}
