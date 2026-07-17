<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SHOW COLUMNS FROM users");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
