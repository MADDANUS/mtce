<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SELECT * FROM master_parameter_check WHERE kategori = 'KASAHARA MILLING'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Count: " . count($rows) . "\n";
print_r($rows);
