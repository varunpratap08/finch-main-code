<?php
// inc/fetch_sizes.php
header('Content-Type: application/json');
require_once 'db.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if (!$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// Fetch the pricing JSON column for the product
$stmt = $pdo->prepare("SELECT pricing FROM products WHERE id = ? LIMIT 1");
$stmt->execute([$product_id]);
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sizes = [];
    $pricing = json_decode($row['pricing'], true);
    if (is_array($pricing)) {
        foreach ($pricing as $entry) {
            if (!empty($entry['size']) && !in_array($entry['size'], $sizes)) {
                $sizes[] = $entry['size'];
            }
        }
    }
    echo json_encode(['status' => 'success', 'sizes' => $sizes]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
}
