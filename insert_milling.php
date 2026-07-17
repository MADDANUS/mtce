<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'MILLING';

$data = [
    // 1. HYDRO UNIT
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'TABUNG HYDRO UNIT', 'point_check' => 'CHECK DENT DALAM TABUNG'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'HOSE HYDRO UNIT', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'FITTING HYDRO UNIT', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'WIRING HYDRO UNIT', 'point_check' => 'CHECK KONDISI DAN SAFETY'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'BRACKET HYDRO UNIT', 'point_check' => 'CHECK KONDISI DAN SAFETY'],
    ['section_check' => 'HYDRO UNIT', 'bagian_check' => 'OIL HYDRO UNIT', 'point_check' => 'CHANGE'],

    // 2. MECHANIC CLAMP
    ['section_check' => 'MECHANIC CLAMP', 'bagian_check' => 'CYLINDER OPEN/CLOSE', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'MECHANIC CLAMP', 'bagian_check' => 'CYLINDER UP/DOWN', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'MECHANIC CLAMP', 'bagian_check' => 'SENSOR OPEN/CLOSE', 'point_check' => 'CHECK KONDISI, FUNGSIONAL, & SAFETY'],
    ['section_check' => 'MECHANIC CLAMP', 'bagian_check' => 'SENSOR UP/DOWN', 'point_check' => 'CHECK KONDISI, FUNGSIONAL, & SAFETY'],
    ['section_check' => 'MECHANIC CLAMP', 'bagian_check' => 'OIL SLIDING', 'point_check' => 'ADD OIL'],

    // 3. SPINDLE A (KIRI)
    ['section_check' => 'SPINDLE A (KIRI)', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'],
    ['section_check' => 'SPINDLE A (KIRI)', 'bagian_check' => 'MOTOR SPINDLE', 'point_check' => 'CHECK NOISE DAN OVERHEAT'],
    ['section_check' => 'SPINDLE A (KIRI)', 'bagian_check' => 'BELT SPINDLE', 'point_check' => 'CHECK KONDISI DAN FUNGSIONAL'],
    ['section_check' => 'SPINDLE A (KIRI)', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK KONDISI DAN ROTATION'],
    ['section_check' => 'SPINDLE A (KIRI)', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK KONDISI DAN ROTATION'],

    // 4. SPINDLE B (KANAN)
    ['section_check' => 'SPINDLE B (KANAN)', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'],
    ['section_check' => 'SPINDLE B (KANAN)', 'bagian_check' => 'MOTOR SPINDLE', 'point_check' => 'CHECK NOISE DAN OVERHEAT'],
    ['section_check' => 'SPINDLE B (KANAN)', 'bagian_check' => 'BELT SPINDLE', 'point_check' => 'CHECK KONDISI DAN FUNGSIONAL'],
    ['section_check' => 'SPINDLE B (KANAN)', 'bagian_check' => 'PULLEY + AS MOTOR', 'point_check' => 'CHECK KONDISI DAN ROTATION'],
    ['section_check' => 'SPINDLE B (KANAN)', 'bagian_check' => 'PULLEY + AS SPINDLE', 'point_check' => 'CHECK KONDISI DAN ROTATION'],

    // 5. SUPPLY MATERIAL
    ['section_check' => 'SUPPLY MATERIAL', 'bagian_check' => 'UNIT SLIDE MAGAZINE', 'point_check' => 'CHECK KONDISI DAN FUNGSIONAL'],
    ['section_check' => 'SUPPLY MATERIAL', 'bagian_check' => 'CYLINDER SLIDE MAGAZINE', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'SUPPLY MATERIAL', 'bagian_check' => 'CYLINDER PUSH MATERIAL', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'SUPPLY MATERIAL', 'bagian_check' => 'SENSOR PUSH MATERIAL', 'point_check' => 'CHECK KONDISI, FUNGSIONAL, & SAFETY'],

    // 6. OUTPUT MATERIAL
    ['section_check' => 'OUTPUT MATERIAL', 'bagian_check' => 'PIPE TRANSFER MATERIAL', 'point_check' => 'CHECK KONDISI DAN FUNGSIONAL'],
    ['section_check' => 'OUTPUT MATERIAL', 'bagian_check' => 'SLIDING TRANSFER MATERIAL', 'point_check' => 'CHECK KONDISI DAN FUNGSIONAL'],
    ['section_check' => 'OUTPUT MATERIAL', 'bagian_check' => 'CYLINDER PUSH MATERIAL', 'point_check' => 'CHECK KONDISI DAN KEBOCORAN'],
    ['section_check' => 'OUTPUT MATERIAL', 'bagian_check' => 'SENSOR PUSH MATERIAL', 'point_check' => 'CHECK KONDISI, FUNGSIONAL, & SAFETY'],

    // 7. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'CHECK KONDISI, FUNGSIONAL & SAFETY'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON STOP', 'point_check' => 'CHECK KONDISI, FUNGSIONAL & SAFETY'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK KONDISI, FUNGSIONAL & SAFETY'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOGGLE SWITCH', 'point_check' => 'CHECK KONDISI, FUNGSIONAL & SAFETY'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP POWER', 'point_check' => 'CHECK KONDISI, FUNGSIONAL & SAFETY'],

    // 8. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK NOISE DAN OVERHEAT'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'WIRING COOLANT PUMP', 'point_check' => 'CHECK KONDISI DAN SAFETY']
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

echo "Successfully inserted " . count($data) . " parameters for MILLING.\n";
