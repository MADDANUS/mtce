<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'KASAHARA MILLING';

$data = [
    // 1. SPINDLE ENDMILL KIRI
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'AS SPINDLE', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KIRI', 'bagian_check' => 'SPINDLE SPEED | RPM', 'point_check' => 'CHECK NOMINAL RPM', 'standard_check' => 'OK'],

    // 2. SPINDLE CUTTER
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'AS SPINDLE', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE CUTTER', 'bagian_check' => 'SPINDLE SPEED | RPM', 'point_check' => 'CHECK NOMINAL RPM', 'standard_check' => 'OK'],

    // 3. SPINDLE ENDMILL KANAN
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'AS SPINDLE', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'SPINDLE ENDMILL KANAN', 'bagian_check' => 'SPINDLE SPEED | RPM', 'point_check' => 'CHECK NOMINAL RPM', 'standard_check' => 'OK'],

    // 4. BELT
    ['section_check' => 'BELT', 'bagian_check' => 'MOTOR - SPINDLE KIRI', 'point_check' => 'TENSION AND CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'BELT', 'bagian_check' => 'MOTOR - SPINDLE KANAN ATAS', 'point_check' => 'TENSION AND CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'BELT', 'bagian_check' => 'MOTOR - SPINDLE KANAN BAWAH', 'point_check' => 'TENSION AND CONDITION', 'standard_check' => 'OK'],

    // 5. HYDRO SPEED REGULATOR
    ['section_check' => 'HYDRO SPEED REGULATOR', 'bagian_check' => 'UNIT HYDRO SPEED REG.', 'point_check' => 'FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'HYDRO SPEED REGULATOR', 'bagian_check' => 'BRACKET HYDRO SPEED REG.', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],

    // 6. MECHANIC CHECK
    ['section_check' => 'MECHANIC CHECK', 'bagian_check' => 'UNIT CYLINDER', 'point_check' => 'FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'MECHANIC CHECK', 'bagian_check' => 'SPRING CLAMP', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],
    ['section_check' => 'MECHANIC CHECK', 'bagian_check' => 'SUPPORT COMPONENT', 'point_check' => 'CONDITION', 'standard_check' => 'OK'],

    // 7. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CONDITION AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'LEAKAGE', 'standard_check' => 'OK'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'LEAKAGE', 'standard_check' => 'OK'],

    // 8. ELECTRICAL CHECK
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'SENSOR CYLINDER', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'SENSOR LENGTH', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'BUTTON ON', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'BUTTON START', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'BUTTON EMERGENCY', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK'],
    ['section_check' => 'ELECTRICAL CHECK', 'bagian_check' => 'COUNTER', 'point_check' => 'PHYSICAL AND FUNCTION', 'standard_check' => 'OK']
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
        $row['standard_check'],
        $urutan++
    ]);
}

echo "Successfully inserted " . count($data) . " parameters for KASAHARA MILLING.\n";
