<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'KASAHARA SLOTHING';

// We get the max urutan currently in this category just in case we insert part 2 later.
$stmt = $pdo->query("SELECT MAX(urutan) FROM master_parameter_check WHERE kategori = 'KASAHARA SLOTHING'");
$maxUrutan = (int) $stmt->fetchColumn();
$urutan = $maxUrutan > 0 ? $maxUrutan + 1 : 1;

$data = [
    // 1. SPINDLE 1
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'UNIT HYDRO SPEED REG.', 'point_check' => 'CHECK FUNCTION AND NOMINAL SET'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'BRACKET HYDRO SPEED REG.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'SENSOR / SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'MEKANIK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 1', 'bagian_check' => 'SPINDLE SPEED', 'point_check' => 'CHECK NOMINAL RPM'],

    // 2. SPINDLE 2
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'UNIT HYDRO SPEED REG.', 'point_check' => 'CHECK FUNCTION AND NOMINAL SET'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'BRACKET HYDRO SPEED REG.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'SENSOR / SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'MEKANIK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 2', 'bagian_check' => 'SPINDLE SPEED', 'point_check' => 'CHECK NOMINAL RPM'],

    // 3. SPINDLE 3
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'UNIT HYDRO SPEED REG.', 'point_check' => 'CHECK FUNCTION AND NOMINAL SET'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'BRACKET HYDRO SPEED REG.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'SENSOR / SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'MEKANIK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 3', 'bagian_check' => 'SPINDLE SPEED', 'point_check' => 'CHECK NOMINAL RPM'],

    // 4. SPINDLE 4
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'UNIT HYDRO SPEED REG.', 'point_check' => 'CHECK FUNCTION AND NOMINAL SET'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'BRACKET HYDRO SPEED REG.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'SENSOR / SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'MEKANIK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SPINDLE 4', 'bagian_check' => 'SPINDLE SPEED', 'point_check' => 'CHECK NOMINAL RPM'],

    // 5. ROTATION CLAMP 1
    ['section_check' => 'ROTATION CLAMP 1', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 1', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 1', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 1', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 1', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION']
];

$stmt = $pdo->prepare("INSERT INTO master_parameter_check (lokasi, jenis_check, kategori, section_check, bagian_check, point_check, standard_check, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($data as $row) {
    $stmt->execute([
        $lokasi,
        $jenis_check,
        $kategori,
        $row['section_check'],
        $row['bagian_check'],
        $row['point_check'],
        'OK', // Default standard_check
        $urutan++
    ]);
}

echo "Successfully inserted " . count($data) . " parameters for KASAHARA SLOTHING.\n";
