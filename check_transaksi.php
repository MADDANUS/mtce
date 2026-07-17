<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SHOW COLUMNS FROM transaksi_check");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
