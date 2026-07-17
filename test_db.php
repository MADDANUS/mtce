<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SELECT id_parameter, section_check, bagian_check, point_check FROM master_parameter_check WHERE section_check LIKE '%BEARING%' OR bagian_check LIKE '%BEARING%' OR point_check LIKE '%BEARING%'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);
