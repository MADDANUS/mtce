<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'CENTERING GRINDING';

$data = [
    // 1. GRINDING WHEEL
    ['section_check' => 'GRINDING WHEEL', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'GRINDING WHEEL', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CLEANING'],
    ['section_check' => 'GRINDING WHEEL', 'bagian_check' => 'PULLEY MOTOR & SPINDLE', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'GRINDING WHEEL', 'bagian_check' => 'BELT MOTOR KE SPINDLE', 'point_check' => 'TENSION AND CONDITION'],
    ['section_check' => 'GRINDING WHEEL', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'],

    // 2. RUBBER WHEEL
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'UNIT MOTOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'FAN MOTOR', 'point_check' => 'CLEANING'],
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'PULLEY MOTOR & SPINDLE', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'BELT MOTOR KE SPINDLE', 'point_check' => 'TENSION AND CONDITION'],
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'UNIT SPINDLE', 'point_check' => 'CHECK NOISE'],
    ['section_check' => 'RUBBER WHEEL', 'bagian_check' => 'ADJUSTER', 'point_check' => 'BACKLASH'],

    // 3. SEPARATOR
    ['section_check' => 'SEPARATOR', 'bagian_check' => 'MOTOR SEPARATOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'SEPARATOR', 'bagian_check' => 'MAGNET SEPARATOR', 'point_check' => 'FUNCTION'],
    ['section_check' => 'SEPARATOR', 'bagian_check' => 'RUBBER SEPARATOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'SEPARATOR', 'bagian_check' => 'BEARING SEPARATOR', 'point_check' => 'CONDITION AND NOISE'],
    ['section_check' => 'SEPARATOR', 'bagian_check' => 'SPRING SEPARATOR', 'point_check' => 'CONDITION AND FUNCTION'],

    // 4. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'LEAKAGE'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'LEAKAGE'],

    // 5. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON START', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON STOP', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'BUTTON EMG', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'INDICATOR LAMP', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'LCD MONITOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'AMPERE METER', 'point_check' => 'PHYSICAL AND FUNCTION'],

    // 6. MONITORING OIL LEVEL
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'FRONT SPINDLE', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'BACK SPINDLE', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'LUBE SLIDING', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'LUBE TURBIN', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'TANK OIL', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],
    ['section_check' => 'MONITORING OIL LEVEL', 'bagian_check' => 'GEARBOX', 'point_check' => 'BETWEEN MIN. AND MAX. RANGE'],

    // 7. CONVEYOR INPUT
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'MOTOR UNIT CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'GEARHEAD MOTOR CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'PULLEY MOTOR CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'FRONT BEARING', 'point_check' => 'CONDITION AND NOISE'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'BACK BEARING', 'point_check' => 'CONDITION AND NOISE'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'BELT / RANTAI CONVEYOR', 'point_check' => 'TENSION AND CONDITION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'RAIL / BASE CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'CYLINDER UP DOWN CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'SOLENOID CONVEYOR', 'point_check' => 'FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'HOSE CONVEYOR', 'point_check' => 'CONDITION AND LEAKAGE'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'SENSOR CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'BUTTON START CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'BUTTON STOP CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'SELECTOR SWITCH CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'TOGGLE SWITCH CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'INDICATOR LAMP POWER CONV.', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR INPUT', 'bagian_check' => 'TOWER LIGHT CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],

    // 8. CONVEYOR OUTPUT
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'MOTOR UNIT CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'GEARHEAD MOTOR CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'PULLEY MOTOR CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'FRONT BEARING', 'point_check' => 'CONDITION AND NOISE'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'BACK BEARING', 'point_check' => 'CONDITION AND NOISE'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'BELT / RANTAI CONVEYOR', 'point_check' => 'TENSION AND CONDITION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'RAIL / BASE CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'CYLINDER UP DOWN CONVEYOR', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'SOLENOID CONVEYOR', 'point_check' => 'FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'HOSE CONVEYOR', 'point_check' => 'CONDITION AND LEAKAGE'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'SENSOR CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'BUTTON START CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'BUTTON STOP CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'SELECTOR SWITCH CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'TOGGLE SWITCH CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'INDICATOR LAMP POWER CONV.', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'CONVEYOR OUTPUT', 'bagian_check' => 'TOWER LIGHT CONVEYOR', 'point_check' => 'PHYSICAL AND FUNCTION'],

    // 9. OIL MATIC
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'FILTER COOLER PAPER', 'point_check' => 'CHANGE'],
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'FILTER COOLER EXTERNAL', 'point_check' => 'CLEANING'],
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'FILTER COOLER MACHINE', 'point_check' => 'CLEANING'],
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'HOSE COOLER', 'point_check' => 'CONDITION AND LEAKAGE'],
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'CONTROL COOLER', 'point_check' => 'PHYSICAL AND FUNCTION'],
    ['section_check' => 'OIL MATIC', 'bagian_check' => 'BASE & SUPPORT COOLER', 'point_check' => 'CONDITION'],

    // 10. OIL TANK SPINDLE
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'UNIT TANK', 'point_check' => 'LEAKAGE'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'MOTOR TANK', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'PIPING TANK', 'point_check' => 'LEAKAGE'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'HOSE TANK', 'point_check' => 'LEAKAGE'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'PRESSURE GAUGE TANK', 'point_check' => 'FUNCTION'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'FILTER TANK', 'point_check' => 'CONDITION'],
    ['section_check' => 'OIL TANK SPINDLE', 'bagian_check' => 'OIL TANK', 'point_check' => 'ADD/CHANGE'],

    // 11. GEARBOX
    ['section_check' => 'GEARBOX', 'bagian_check' => 'UNIT GEARBOX', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'ADJUSTER GEARBOX', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'RANTAI GEARBOX', 'point_check' => 'CONDITION AND FUNCTION'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'OIL LEVEL GEARBOX', 'point_check' => 'CLEANING'],
    ['section_check' => 'GEARBOX', 'bagian_check' => 'OIL GEARBOX', 'point_check' => 'CHANGE'],

    // 12. LUBRICATION (SLIDE)
    ['section_check' => 'LUBRICATION (SLIDE)', 'bagian_check' => 'PUMP LUBRICATION', 'point_check' => 'FUNCTION'],
    ['section_check' => 'LUBRICATION (SLIDE)', 'bagian_check' => 'HOSE LUBRICATION', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'LUBRICATION (SLIDE)', 'bagian_check' => 'FITTING LUBRICATION', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'LUBRICATION (SLIDE)', 'bagian_check' => 'OIL LEVEL LUBRICATION', 'point_check' => 'CLEANING'],
    ['section_check' => 'LUBRICATION (SLIDE)', 'bagian_check' => 'OIL LUBRICATION', 'point_check' => 'CHANGE'],

    // 13. MIST COLLECTOR
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'UNIT MIST COLLECTOR', 'point_check' => 'CHECK FUNGSIONAL'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'MOTOR MIST COLLECTOR', 'point_check' => 'CHECK NOISE DAN OVERHEAT'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'HOSE MIST COLLECTOR', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'FLEXIBEL HOSE MIST COLLECTOR', 'point_check' => 'CHECK KEBOCORAN DAN ALIRAN'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'WIRING MIST COLLECTOR', 'point_check' => 'CHECK KONDISI DAN SAFETY'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'OIL TANK MIST COLLECTOR', 'point_check' => 'CLEAN DAN CHANGE WATER'],
    ['section_check' => 'MIST COLLECTOR', 'bagian_check' => 'FILTER MIST COLLECTOR', 'point_check' => 'CHANGE']
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

echo "Successfully inserted " . count($data) . " parameters for CENTERING GRINDING.\n";
