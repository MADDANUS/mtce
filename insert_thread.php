<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'THREAD';

$data = [
    // 1. MECHANICAL PARTS
    ['section_check' => 'MECHANICAL PARTS', 'bagian_check' => 'UNIT MECHANICAL PART', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANICAL PARTS', 'bagian_check' => 'SUPPORT COMPONENTS MECH.', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANICAL PARTS', 'bagian_check' => 'MECHANIC SPINDLE', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MECHANICAL PARTS', 'bagian_check' => 'GEARBOX', 'point_check' => 'ADD/CHANGE GREASE'],

    // 2. MOTOR SPINDLE KANAN
    ['section_check' => 'MOTOR SPINDLE KANAN', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE KANAN', 'bagian_check' => 'PULLEY MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE KANAN', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CHECK ROTATION'],

    // 3. MOTOR SPINDLE KIRI
    ['section_check' => 'MOTOR SPINDLE KIRI', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE KIRI', 'bagian_check' => 'PULLEY MOTOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'MOTOR SPINDLE KIRI', 'bagian_check' => 'AS MOTOR', 'point_check' => 'CHECK ROTATION'],

    // 4. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION AND FUNCTION'],

    // 5. BELT
    ['section_check' => 'BELT', 'bagian_check' => 'BELT MOTOR KE SPINDLE KIRI', 'point_check' => 'CHECK TENSION AND CONDITION'],
    ['section_check' => 'BELT', 'bagian_check' => 'BELT MOTOR KE SPINDLE KANAN', 'point_check' => 'CHECK TENSION AND CONDITION'],
    ['section_check' => 'BELT', 'bagian_check' => 'BELT PENGGERAK MEKANIK SPINDLE', 'point_check' => 'CHECK TENSION AND CONDITION'],
    ['section_check' => 'BELT', 'bagian_check' => 'BELT COOLANT PUMP 1', 'point_check' => 'CHECK TENSION AND CONDITION'],
    ['section_check' => 'BELT', 'bagian_check' => 'BELT COOLANT PUMP 2', 'point_check' => 'CHECK TENSION AND CONDITION'],

    // 6. SENSOR MESIN
    ['section_check' => 'SENSOR MESIN', 'bagian_check' => 'UNIT SENSOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SENSOR MESIN', 'bagian_check' => 'WIRING SENSOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SENSOR MESIN', 'bagian_check' => 'BRACKET SENSOR', 'point_check' => 'CHECK CONDITION'],

    // 7. SENSOR SUPPLY
    ['section_check' => 'SENSOR SUPPLY', 'bagian_check' => 'UNIT SENSOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'SENSOR SUPPLY', 'bagian_check' => 'WIRING SENSOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'SENSOR SUPPLY', 'bagian_check' => 'BRACKET SENSOR', 'point_check' => 'CHECK CONDITION'],

    // 8. CONVEYOR
    ['section_check' => 'CONVEYOR', 'bagian_check' => 'MOTOR CONVEYOR', 'point_check' => 'CHECK CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR', 'bagian_check' => 'WIRING CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'CONVEYOR', 'bagian_check' => 'PULLEY CONVEYOR', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'CONVEYOR', 'bagian_check' => 'AS UNIT CONVEYOR', 'point_check' => 'CHECK ROTATION'],
    ['section_check' => 'CONVEYOR', 'bagian_check' => 'BELT CONVEYOR', 'point_check' => 'CHECK TENSION AND CONDITION']
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

echo "Successfully inserted " . count($data) . " parameters for THREAD.\n";
