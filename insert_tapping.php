<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'KASAHARA TAPPING';

$data = [];

// 1 - 8: ROTATION CLAMP 1 - 8
for ($i = 1; $i <= 8; $i++) {
    $section = "ROTATION CLAMP $i";
    $data[] = ['section_check' => $section, 'bagian_check' => 'MECHANIC CLAMP', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'CYLINDER', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'SOLENOID', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CONDITION AND LEAKAGE'];
}

// 9 - 11: SPINDLE TOOL 1 - 3
for ($i = 1; $i <= 3; $i++) {
    $section = "SPINDLE TOOL $i";
    $data[] = ['section_check' => $section, 'bagian_check' => 'SELFEEDER UNIT', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'MECHANIC VALVE', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'CYLINDER', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CONDITION AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
    $data[] = ['section_check' => $section, 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];
}

// 12. SPINDLE TOOL 4
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'MOTOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'CYLINDER LEFT/RIGHT', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'TENSION AND CONDITION'];
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 4', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 13. SPINDLE TOOL 5
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'MOTOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'CYLINDER TOOL BROKEN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'ARM TOOL', 'point_check' => 'TENSION AND CONDITION'];
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 5', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 14. SPINDLE TOOL 6
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'MOTOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'CYLINDER TOOL BROKEN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'ARM TOOL', 'point_check' => 'TENSION AND CONDITION'];
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 6', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 15. SPINDLE TOOL 7A - ATAS
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'SELFEEDER UNIT', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'MECHANIC VALVE', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'CYLINDER', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'HYDRO SPEED REGULATOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7A - ATAS', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 16. SPINDLE TOOL 7B - BAWAH
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'MOTOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'CYLINDER TOOL BROKEN', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'BELT MOTOR', 'point_check' => 'TENSION AND CONDITION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'SENSOR', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'SPINDLE TOOL 7B - BAWAH', 'bagian_check' => 'LIMIT SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 17. ELECTRICAL
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON STOP', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON CLAMP', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOGGLE SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP ROTATION', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'COUNTER', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'AMPLIFIER LENGTH', 'point_check' => 'PHYSICAL AND FUNCTION'];
$data[] = ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SENSOR LENGTH', 'point_check' => 'PHYSICAL AND FUNCTION'];

// 18. COOLANT PUMP
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'LEAKAGE'];
$data[] = ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'LEAKAGE'];

// 19. CLAMPING SUPPORT
$data[] = ['section_check' => 'CLAMPING SUPPORT', 'bagian_check' => 'CYLINDER CLAMP', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'CLAMPING SUPPORT', 'bagian_check' => 'SENSOR', 'point_check' => 'CONDITION AND FUNCTION'];
$data[] = ['section_check' => 'CLAMPING SUPPORT', 'bagian_check' => 'HOSE CYLINDER - SOLENOID', 'point_check' => 'CONDITION AND LEAKAGE'];
$data[] = ['section_check' => 'CLAMPING SUPPORT', 'bagian_check' => 'MECHANIC SUPPORT', 'point_check' => 'CONDITION AND FUNCTION'];


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

echo "Successfully inserted " . count($data) . " parameters for KASAHARA TAPPING.\n";
