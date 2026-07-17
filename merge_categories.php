<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

// Ambil data lama sebelum diupdate untuk diurutkan
$stmt = $pdo->prepare("SELECT id_parameter, kategori, urutan FROM master_parameter_check WHERE lokasi = 'MFG 1' AND jenis_check = 'Overhaul' AND kategori IN ('Mesin CNC', 'Bar Feeder CNC') ORDER BY kategori DESC, urutan ASC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// "Mesin CNC" (M comes after B, so DESC puts Mesin CNC first, Bar Feeder CNC second).
$newUrutan = 1;
foreach ($rows as $row) {
    $update = $pdo->prepare("UPDATE master_parameter_check SET kategori = 'Mesin CNC & Bar Feeder', urutan = ? WHERE id_parameter = ?");
    $update->execute([$newUrutan, $row['id_parameter']]);
    $newUrutan++;
}

// Update existing transactions if any
$pdo->exec("UPDATE transaksi_check SET kategori = 'Mesin CNC & Bar Feeder' WHERE lokasi_check = 'MFG 1' AND jenis_check = 'Overhaul' AND kategori IN ('Mesin CNC', 'Bar Feeder CNC')");
$pdo->exec("UPDATE ceklis_kontrol SET kategori = 'Mesin CNC & Bar Feeder' WHERE id_mesin IN (SELECT id_mesin FROM master_mesin WHERE lokasi = 'MFG 1') AND kategori IN ('Mesin CNC', 'Bar Feeder CNC')");

echo "Successfully merged categories. Total updated rows: " . count($rows);
