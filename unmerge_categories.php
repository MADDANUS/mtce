<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

// Ambil data untuk Mesin CNC (urutan 1 sampai 52)
$stmt = $pdo->prepare("SELECT id_parameter, urutan FROM master_parameter_check WHERE lokasi = 'MFG 1' AND jenis_check = 'Overhaul' AND urutan <= 52 ORDER BY urutan ASC");
$stmt->execute();
$mesinRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$newUrutan = 1;
foreach ($mesinRows as $row) {
    $update = $pdo->prepare("UPDATE master_parameter_check SET kategori = 'Mesin CNC', urutan = ? WHERE id_parameter = ?");
    $update->execute([$newUrutan, $row['id_parameter']]);
    $newUrutan++;
}

// Ambil data untuk Bar Feeder CNC (urutan 53 sampai 85)
$stmt = $pdo->prepare("SELECT id_parameter, urutan FROM master_parameter_check WHERE lokasi = 'MFG 1' AND jenis_check = 'Overhaul' AND urutan > 52 ORDER BY urutan ASC");
$stmt->execute();
$barFeederRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$newUrutan = 1;
foreach ($barFeederRows as $row) {
    $update = $pdo->prepare("UPDATE master_parameter_check SET kategori = 'Bar Feeder CNC', urutan = ? WHERE id_parameter = ?");
    $update->execute([$newUrutan, $row['id_parameter']]);
    $newUrutan++;
}

// Update existing transactions back to Mesin CNC
// Wait, if a transaction has "Mesin CNC & Bar Feeder", we can just rename it to "Mesin CNC".
// But when we render the detail view, it uses `kategori` to fetch parameters.
// If the transaction has `kategori = 'Mesin CNC'`, but it contains details for BOTH Mesin CNC and Bar Feeder CNC...
// The logic for displaying details in `RiwayatController` gets all parameters from `TransaksiCheckDetailModel`, which joins `master_parameter_check`. It doesn't rely strictly on the transaction's `kategori` field to filter details.
$pdo->exec("UPDATE transaksi_check SET kategori = 'Mesin CNC' WHERE lokasi_check = 'MFG 1' AND jenis_check = 'Overhaul' AND kategori = 'Mesin CNC & Bar Feeder'");
$pdo->exec("UPDATE ceklis_kontrol SET kategori = 'Mesin CNC' WHERE id_mesin IN (SELECT id_mesin FROM master_mesin WHERE lokasi = 'MFG 1') AND kategori = 'Mesin CNC & Bar Feeder'");

echo "Successfully unmerged categories.";
