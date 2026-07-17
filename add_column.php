<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("ALTER TABLE master_parameter_check ADD COLUMN sub_item_check VARCHAR(150) NULL AFTER bagian_check");
if ($stmt) {
    echo "Column sub_item_check added successfully.\n";
} else {
    print_r($pdo->errorInfo());
}
