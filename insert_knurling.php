<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'KNURLING';

$data = [
    // 1. MECHANIC COMPONENTS
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC SLIDE/GESER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC BASE MATERIAL', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'MECHANIC SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC COMPONENTS', 'bagian_check' => 'GREASE MECHANICAL PARTS', 'point_check' => 'ADD GREASE (ALL)'],

    // 2. BELT
    ['section_check' => 'BELT', 'bagian_check' => 'MOTOR KE SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 3. MOTOR
    ['section_check' => 'MOTOR', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR', 'bagian_check' => 'PULLEY MOTOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'MOTOR', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CHECK CONDITION'],

    // 4. GEARBOX
    ['section_check' => 'GEARBOX', 'bagian_check' => 'UNIT GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'GEAR GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'ADJUSTER GEARBOX', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'AS GEARBOX', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'OIL GEARBOX', 'point_check' => 'CHANGE'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'LEVEL INDICATOR OIL', 'point_check' => 'CHECK CONDITION'],

    // 5. BOWL FEEDER / CONVEYOR
    ['section_check' => 'BOWL FEEDER / CONVEYOR', 'bagian_check' => 'MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'BOWL FEEDER / CONVEYOR', 'bagian_check' => 'PULLEY CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'BOWL FEEDER / CONVEYOR', 'bagian_check' => 'AS UNIT CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'BOWL FEEDER / CONVEYOR', 'bagian_check' => 'BELT CONVEYOR', 'point_check' => 'CHECK CONDITION AND TENSION'],

    // 6. SENSOR
    ['section_check' => 'SENSOR', 'bagian_check' => 'SENSOR SUPPLY', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SENSOR', 'bagian_check' => 'SENSOR ROTATION', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SENSOR', 'bagian_check' => 'SENSOR MOVING', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 7. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],

    // 8. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON STOP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOGGLE SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'CHECK CONDITION AND FUNCTION']
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

echo "Successfully inserted " . count($data) . " parameters for KNURLING.\n";
