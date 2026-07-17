<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
$col = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($col);
