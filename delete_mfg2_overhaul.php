<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->prepare("DELETE FROM master_parameter_check WHERE lokasi = 'MFG 2' AND jenis_check = 'Overhaul'");
$stmt->execute();
echo "Deleted " . $stmt->rowCount() . " records for MFG 2 Overhaul.\n";
