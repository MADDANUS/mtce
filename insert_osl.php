<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'OSL';

$data = [
    // 1. MECHANIC COMPONENTS
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC ROTATION', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC SLOTHING/CLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'GREASE MECHANICAL PARTS', 'point_check' => 'ADD GREASE (ALL)'],

    // 2. BELT
    ['section_check' => 'BELT', 'bagian_check' => 'MOTOR KE CONNECTOR A', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'BELT', 'bagian_check' => 'CONNECTOR A KE GEARBOX', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'BELT', 'bagian_check' => 'GEARBOX KE CONNECTOR B', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'BELT', 'bagian_check' => 'CONNECTOR B KE SPINDLE', 'point_check' => 'CHECK CONDITION AND TENSION'],

    // 3. MOTOR
    ['section_check' => 'MOTOR', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR', 'bagian_check' => 'PULLEY MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 4. GEARBOX
    ['section_check' => 'GEARBOX', 'bagian_check' => 'UNIT GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'GEAR GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'ADJUSTER GEARBOX', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'AS GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'LEVEL INDICATOR OIL', 'point_check' => 'CHECK KONDISI DAN KEBERSIHAN'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'OIL GEARBOX', 'point_check' => 'CHANGE'],

    // 5. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],

    // 6. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON STOP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'WIRING POWER', 'point_check' => 'CHECK CONDITION AND FUNCTION']
];

$stmt = $pdo->prepare("INSERT INTO master_parameter_check (lokasi, jenis_check, kategori, section_check, bagian_check, point_check, standard_check, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$urutan = 1;
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

echo "Successfully inserted " . count($data) . " parameters for OSL.\n";
