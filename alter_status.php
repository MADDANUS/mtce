<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$pdo->exec("ALTER TABLE transaksi_check MODIFY status VARCHAR(50) DEFAULT 'Pending'");
echo "Success\n";
