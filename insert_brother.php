<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');

$lokasi = 'MFG 2';
$jenis_check = 'Overhaul';
$kategori = 'BROTHER';

$data = [
    // 1. AXIS X
    ['section_check' => 'AXIS X', 'bagian_check' => 'BALLSCREW X AXIS', 'point_check' => 'CHECK BACKLASH'],
    ['section_check' => 'AXIS X', 'bagian_check' => 'SHAFT X AXIS', 'point_check' => 'CHECK CONDITION & GREASING'],
    ['section_check' => 'AXIS X', 'bagian_check' => 'SENSOR X AXIS', 'point_check' => 'CHECK CONDITION & FUNCTION'],

    // 2. AXIS Y
    ['section_check' => 'AXIS Y', 'bagian_check' => 'BALLSCREW Y AXIS', 'point_check' => 'CHECK BACKLASH'],
    ['section_check' => 'AXIS Y', 'bagian_check' => 'SHAFT Y AXIS', 'point_check' => 'CHECK CONDITION & GREASING'],
    ['section_check' => 'AXIS Y', 'bagian_check' => 'SENSOR Y AXIS', 'point_check' => 'CHECK CONDITION & FUNCTION'],

    // 3. AXIS Z
    ['section_check' => 'AXIS Z', 'bagian_check' => 'BALLSCREW Z AXIS', 'point_check' => 'CHECK BACKLASH'],
    ['section_check' => 'AXIS Z', 'bagian_check' => 'SHAFT Z AXIS', 'point_check' => 'CHECK CONDITION & GREASING'],
    ['section_check' => 'AXIS Z', 'bagian_check' => 'SENSOR Z AXIS', 'point_check' => 'CHECK CONDITION & FUNCTION'],

    // 4. BEARING
    ['section_check' => 'BEARING', 'bagian_check' => 'BEARING (HOLDER AREA-14)', 'point_check' => 'CHECK CENTER ROTATION'],
    ['section_check' => 'BEARING', 'bagian_check' => 'BEARING (HOLDER AREA-14)', 'point_check' => 'CLEANING BEARING'],

    // 5. ELECTRICAL
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'DOORLOCK', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'PUSH BUTTON', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'SELECTOR SWITCH', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'EMG BUTTON', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'KEYPAD / SOFTKEY', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'TOWER LAMP', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'CUTTING LAMP', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'ELECTRICAL', 'bagian_check' => 'LCD MONITOR', 'point_check' => 'CHECK CONDITION'],

    // 6. COOLANT PUMP
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP 1', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'MOTOR COOLANT PUMP 2', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'HOSE COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],
    ['section_check' => 'COOLANT PUMP', 'bagian_check' => 'PIPING COOLANT PUMP', 'point_check' => 'CHECK CONDITION'],

    // 7. FAN
    ['section_check' => 'FAN', 'bagian_check' => 'UNIT FAN', 'point_check' => 'CHECK CONDITION & FUNCTION'],
    ['section_check' => 'FAN', 'bagian_check' => 'UNIT FAN', 'point_check' => 'CLEANING FAN']
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

echo "Successfully inserted " . count($data) . " parameters for BROTHER.\n";
