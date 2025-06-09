<?php
require_once 'inc/db.php';

// Get orders table structure
$stmt = $pdo->query("SHOW CREATE TABLE orders");
$table = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Orders Table Structure:\n";
echo $table['Create Table'] . "\n\n";

// Get first few rows from orders table
echo "Sample Orders:\n";
$stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 3");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

// Get first few products
echo "\nSample Products:\n";
$stmt = $pdo->query("SELECT id, name FROM products LIMIT 3");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
