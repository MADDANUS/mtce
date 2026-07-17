<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$pdo->exec("ALTER TABLE users ADD COLUMN lokasi VARCHAR(50) NULL DEFAULT NULL AFTER role");
echo "Column added successfully";
