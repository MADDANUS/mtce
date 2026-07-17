<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query('DESCRIBE master_parameter_check');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
