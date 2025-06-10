<?php
require_once 'inc/db.php';

try {
    // Check if orders table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'orders'");
    if ($stmt->rowCount() === 0) {
        die("Orders table does not exist. Please run the database setup script.");
    }

    // Get orders table structure
    $stmt = $pdo->query("DESCRIBE orders");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Orders table exists with columns: " . implode(", ", $columns) . "\n";
    
    // Check for required columns
    $required_columns = ['id', 'customer_name', 'customer_email', 'customer_phone', 'customer_address', 'total_price', 'order_details', 'status', 'created_at'];
    $missing_columns = array_diff($required_columns, $columns);
    
    if (!empty($missing_columns)) {
        echo "\nMissing required columns: " . implode(", ", $missing_columns) . "\n";
        echo "Please run the following SQL to add missing columns:\n\n";
        
        $alter_sql = [];
        if (in_array('status', $missing_columns)) {
            $alter_sql[] = "ALTER TABLE orders ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER product_id";
        }
        
        echo implode(";\n", $alter_sql) . ";\n";
    } else {
        echo "\nAll required columns are present.\n";
    }
    
} catch (PDOException $e) {
    die("Error checking orders table: " . $e->getMessage());
}

echo "\nCheck complete.\n";
