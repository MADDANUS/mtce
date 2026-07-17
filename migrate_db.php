<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // 1. Update data
    $stmt = $pdo->prepare("UPDATE master_parameter_check SET bagian_check = CONCAT(bagian_check, ' ', sub_item_check) WHERE sub_item_check IS NOT NULL AND sub_item_check != ''");
    $stmt->execute();
    echo "Update successful.\n";
    
    // 2. Drop column
    $stmt = $pdo->prepare("ALTER TABLE master_parameter_check DROP COLUMN sub_item_check");
    $stmt->execute();
    echo "Column dropped successfully.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
