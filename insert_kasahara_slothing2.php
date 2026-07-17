<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'KASAHARA SLOTHING';

// We get the max urutan currently in this category to continue the numbering
$stmt = $pdo->query("SELECT MAX(urutan) FROM master_parameter_check WHERE kategori = 'KASAHARA SLOTHING'");
$maxUrutan = (int) $stmt->fetchColumn();
$urutan = $maxUrutan > 0 ? $maxUrutan + 1 : 1;

$data = [
    // 6. ROTATION CLAMP 2
    ['section_check' => 'ROTATION CLAMP 2', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 2', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 2', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 2', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 2', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 7. ROTATION CLAMP 3
    ['section_check' => 'ROTATION CLAMP 3', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 3', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 3', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 3', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 3', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 8. ROTATION CLAMP 4
    ['section_check' => 'ROTATION CLAMP 4', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 4', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 4', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 4', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 4', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 9. ROTATION CLAMP 5
    ['section_check' => 'ROTATION CLAMP 5', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 5', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 5', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 5', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 5', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 10. ROTATION CLAMP 6
    ['section_check' => 'ROTATION CLAMP 6', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 6', 'bagian_check' => 'SOLENOID', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 6', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'ROTATION CLAMP 6', 'bagian_check' => 'CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ROTATION CLAMP 6', 'bagian_check' => 'SUPPORT CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 11. GENERAL ITEM
    ['section_check' => 'GENERAL ITEM', 'bagian_check' => 'CYLINDER PUSHER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'GENERAL ITEM', 'bagian_check' => 'CYLINDER CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'GENERAL ITEM', 'bagian_check' => 'SENSOR START MATERIAL', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'GENERAL ITEM', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'GENERAL ITEM', 'bagian_check' => 'SLIDE OIL', 'point_check' => 'SLIDE OIL 68'],

    // 12. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND LEAKAGE'],

    // 13. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON ROTATION', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'EMERGENCY BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'], // Fixed typo SIWTCH to SWITCH
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOOGLE SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'COUNTER', 'point_check' => 'CHECK CONDITION AND FUNCTION']
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

echo "Successfully inserted " . count($data) . " parameters for KASAHARA SLOTHING Part 2.\n";
