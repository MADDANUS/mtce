<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'BURNISHING';

$data = [
    // 1. MOTOR SPINDLE
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'PULLEY MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CHECK CONDITION AND CLEANING'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'BUTTON START MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE', 'bagian_check' => 'BUTTON STOP MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 2. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'OIL LEVEL COOLANT PUMP', 'point_check' => 'CLEANING UNIT'],

    // 3. CONVEYOR IN
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'MOTOR UNIT CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'GEARHEAD MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'PULLEY MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'AS MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'FRONT BEARING', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'BACK BEARING', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'BELT CONVEYOR', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'BASE CONVEYOR', 'point_check' => 'CHECK CONDITION AND CLEANING'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'CYLINDER UP DOWN CONVEYOR', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'SOLENOID CONVEYOR', 'point_check' => 'CHECK FUNGSIONAL'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'SENSOR CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'BUTTON START CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'BUTTON STOP CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'SELECTOR SWITCH CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'TOGGLE SWITCH CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'INDICATOR LAMP POWER CONV.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR IN', 'bagian_check' => 'TOWER LIGHT CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 4. CONVEYOR OUT
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'MOTOR UNIT CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'GEARHEAD MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'PULLEY MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'AS MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'FRONT BEARING', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'BACK BEARING', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'BELT CONVEYOR', 'point_check' => 'CHECK CONDITION AND TENSION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'BASE CONVEYOR', 'point_check' => 'CHECK CONDITION AND CLEANING'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'CYLINDER UP DOWN CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'SOLENOID CONVEYOR', 'point_check' => 'CHECK FUNGSIONAL'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'SENSOR CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'BUTTON START CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'BUTTON STOP CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'SELECTOR SWITCH CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'TOGGLE SWITCH CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'INDICATOR LAMP POWER CONV.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUT', 'bagian_check' => 'TOWER LIGHT CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION']
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

echo "Successfully inserted " . count($data) . " parameters for BURNISHING.\n";
