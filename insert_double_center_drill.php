<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'DOUBLE CENTER DRILL';

$data = [];

// 1. TOOL NO 1
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'BELT SPINDLE', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 1', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 2. TOOL NO 2
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'BELT SPINDLE', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 2', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 3. TOOL NO 3
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'UNIT SELFEEDER', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'MOTOR SELFEEDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'BELT SELFEEDER', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'PULLEY SELFEEDER', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 3', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 4. TOOL NO 4
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'UNIT SELFEEDER', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'MOTOR SELFEEDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'BELT SELFEEDER', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'PULLEY SELFEEDER', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 4', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 5. TOOL NO 5
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'UNIT SELFEEDER', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'MOTOR SELFEEDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'BELT SELFEEDER', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'PULLEY SELFEEDER', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 5', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 6. TOOL NO 6
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'UNIT SELFEEDER', 'point_check' => 'CHECK NOISE'];
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'MOTOR SELFEEDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'FAN MOTOR SPINDLE', 'point_check' => 'CHECK CONDITION AND CLEANING'];
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'BELT SELFEEDER', 'point_check' => 'CHECK CONDITION AND TENSION'];
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'PULLEY SELFEEDER', 'point_check' => 'CHECK CONDITION'];
$data[] = ['section_check' => 'TOOL NO 6', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 7. SUPPLY / CLAMP / MOVEMENT COMPONENTS
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER SUPLLY MAGAZINE', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER SUPPLY MATERIAL', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER UP/DOWN 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER UP/DOWN 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER CLAMP 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER CLAMP 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'CYLINDER CLAMP 3', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SUPPLY / CLAMP / MOVEMENT COMPONENTS', 'bagian_check' => 'MECHANICAL PART MOVEMENT', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 8. ELECTRICAL
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'PUSH BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'EMERGENCY BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOGGLE SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SENSOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'];

// 9. COOLANT PUMP
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK NOISE DAN OVERHEAT'];
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'];
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'];

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

echo "Successfully inserted " . count($data) . " parameters for DOUBLE CENTER DRILL.\n";
