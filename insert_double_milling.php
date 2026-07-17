<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'DOUBLE MILLING';

$data = [
    // 1. HYDRO UNIT
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'TABUNG HYDRO UNIT', 'point_check' => 'CHECK DENTED INSIDE TUBE'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'HOSE HYDRO UNIT', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'FITTING HYDRO UNIT', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'BRACKET HYDRO UNIT', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'OIL HYDRO UNIT', 'point_check' => 'CHANGE'],

    // 2. MECHANIC SUPPLY MATERIAL
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'CYLINDER FORWARD/BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'CYLINDER CLAMP/UNCLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'SENSOR FORWARD-BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'PUSH BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'HOSE FORWARD/BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'HOSE UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC SUPPLY MATERIAL', 'bagian_check' => 'HOSE CLAMP/UNCLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 3. MECHANIC OUTPUT MATERIAL
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'CYLINDER FORWARD/BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'CYLINDER CLAMP/UNCLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'SENSOR FORWARD-BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'SENSOR UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'SENSOR CLAMP/UNCLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'HOSE UNIT FORWARD/BACK', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'HOSE UNIT UP/DOWN', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC OUTPUT MATERIAL', 'bagian_check' => 'HOSE UNIT CLAMP/UNCLAMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 4. MECHANIC CLAMP MATERIAL
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'CYLINDER CLAMP 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'CYLINDER CLAMP 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'SENSOR CLAMP 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'SENSOR CLAMP 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'MECHANIC CLAMP 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'MECHANIC CLAMP 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'HOSE CLAMP 1', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'HOSE CLAMP 2', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANIC CLAMP MATERIAL', 'bagian_check' => 'CYLINDER (LONG STROKE)', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 5. LEFT SPINDLE
    ['section_check' => 'LEFT SPINDLE', 'bagian_check' => 'MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'LEFT SPINDLE', 'bagian_check' => 'BELT', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'LEFT SPINDLE', 'bagian_check' => 'SPINDLE', 'point_check' => 'CHECK NOISE'],
    ['section_check' => 'LEFT SPINDLE', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'LEFT SPINDLE', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 6. RIGHT SPINDLE
    ['section_check' => 'RIGHT SPINDLE', 'bagian_check' => 'MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'RIGHT SPINDLE', 'bagian_check' => 'BELT', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'RIGHT SPINDLE', 'bagian_check' => 'SPINDLE', 'point_check' => 'CHECK NOISE'],
    ['section_check' => 'RIGHT SPINDLE', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'RIGHT SPINDLE', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 7. STOPPER LENGTH
    ['section_check' => 'STOPPER LENGTH', 'bagian_check' => 'CYLINDER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'STOPPER LENGTH', 'bagian_check' => 'SENSOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'STOPPER LENGTH', 'bagian_check' => 'HOSE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 8. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'PUSH BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'EMERGENCY BUTTON', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOGGLE SWITCH', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 9. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION, FUNCTION, AND NOISE'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION']
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

echo "Successfully inserted " . count($data) . " parameters for DOUBLE MILLING.\n";
