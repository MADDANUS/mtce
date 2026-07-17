<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SHOW COLUMNS FROM ceklis_kontrol");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
