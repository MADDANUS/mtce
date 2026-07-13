<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiOverhaulAndOverhaulParameters extends Migration
{
    public function up()
    {
        // 1. Buat tabel transaksi_overhaul
        $this->forge->addField([
            'id_meta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bar_feeder_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'support_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_meta', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi_check', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi_overhaul');

        // 2. Seeding parameter Overhaul untuk MFG 1 & MFG 2
        $now = date('Y-m-d H:i:s');
        $locations = ['MFG 1', 'MFG 2'];
        $insertData = [];

        // Bar Feeder CNC Parameters (29 items)
        $barFeederRows = [
            // 1. Equipment Check
            ['1. EQUIPMENT CHECK', 'RELL URETHAN', 'RUBBER LAYER', 'NOT PEELED'],
            ['1. EQUIPMENT CHECK', 'FEED BAR', 'TENSION', '3 - 5 CM'],
            ['1. EQUIPMENT CHECK', 'MOTOR POWER', 'TENSION', '3 - 5 CM'],
            ['1. EQUIPMENT CHECK', 'SYNCRONOUS', 'TENSION', '3 - 5 CM'],
            ['1. EQUIPMENT CHECK', 'MATERIAL PUSH', 'TENSION', '3 - 5 CM'],
            ['1. EQUIPMENT CHECK', 'FEED BAR/CJ/FC', 'STANDARD CONDITION', 'BASE ON BARTOP TYPE'],
            ['1. EQUIPMENT CHECK', 'FRONT VIBRATION ROLLER DIA .20MM', 'MECHANICS, ROLLER, & FUCTION', 'OPEN - CLOSE STANDARD ROLLER'],
            ['1. EQUIPMENT CHECK', 'NR IN VIBRATION ROLLER DIA 40MM ROLLER ARM', 'MECHANICS, ROLLER, & FUNCTION', 'OPEN - CLOSE STANDARD ROLLER'],
            ['1. EQUIPMENT CHECK', 'SYNCHRONOUS DEVICE', 'MECHANICS & FUNCTION', 'MACHINE CONNECTION'],
            ['1. EQUIPMENT CHECK', 'INDEX DISK', 'MECHANICS & FUNCTION', 'FLAT IRON PLATE'],
            ['1. EQUIPMENT CHECK', 'SLIDER DISK', 'MECHANICS & FUNCTION', 'STRAIGHT PLATE'],
            ['1. EQUIPMENT CHECK', 'BAR TIP DETECTION', 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['1. EQUIPMENT CHECK', 'SHUTTER 1', 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['1. EQUIPMENT CHECK', 'SHUTTER 2', 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['1. EQUIPMENT CHECK', 'SHUTTER 3', 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['1. EQUIPMENT CHECK', 'SHUTTER 4', 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['1. EQUIPMENT CHECK', 'CLAMP', 'MECHANICS & FUNCTION', 'NOT BROKEN'],
            ['1. EQUIPMENT CHECK', 'SOLEOID VALVE NR IN L', 'MECHANICS & FUNCTION', 'MOVING VALVE'],
            ['1. EQUIPMENT CHECK', 'BAR FEEDER OIL', 'CHANGE', 'SPINDLE 10'],

            // 2. Electrical Check
            ['2. ELECTRICAL CHECK', 'OPERATION BOX PANEL', 'PHYSICAL', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'TOUCH PANEL', 'PHYSICAL & FUNCTION', 'NOT REFLECTING'],
            ['2. ELECTRICAL CHECK', 'CONTROL SWITCH', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'AC SERVO MOTOR ( M1 )', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'AC SERVO AMPLIFIER', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'AC MOTOR GEARBOX', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'GEAR HEAD', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'LIMIT SWITCH / SENSOR', 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'OIL MOTOR PUMP', 'SOUND, FUNCTION & PHYSICAL CONDITION', 'NOT BROKEN'],
            ['2. ELECTRICAL CHECK', 'BATTERY MEMORY', 'VOLTAGE CAPACITY', '3 - 3.6 VDC'],

            // 3. Function Test
            ['3. FUNCTION TEST', 'CHECK MANUAL', 'FUNCTION TEST', ''],
            ['3. FUNCTION TEST', 'CHECK AUTO', 'FUNCTION TEST', ''],
            ['3. FUNCTION TEST', 'CHECK MDI', 'FUNCTION TEST', ''],
            ['3. FUNCTION TEST', 'CHECK ALARM', 'FUNCTION TEST', ''],
        ];

        // Mesin CNC Parameters (44 items)
        $mesinCncRows = [
            // 1. Ballscrew
            ['1. BALLSCREW', 'X AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'Y AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'Z AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'XB AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'ZB AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'YB AXIS', 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['1. BALLSCREW', 'ROTARY GUIDEUSH', 'BACKLASH', '< 10μ'],
            ['1. BALLSCREW', 'BALL SCREW ( CINCOM )', 'GREASING', '10 GRAM'],
            ['1. BALLSCREW', 'LUBRICANT OIL PUMP', 'PHYSICAL', 'CLEAN'],
            ['1. BALLSCREW', 'BATTERY ABS', 'CHANGE / CHECK DIAGNOS', '5 - 6 VDC'],
            ['1. BALLSCREW', 'BATTERY MEMORY', 'CHANGE / CHECK DIAGNOS', '5 - 6 VDC'],

            // 2. Belt
            ['2. BELT', 'SPINDLE HEAD 1', 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['2. BELT', 'SPINDLE HEAD 2', 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['2. BELT', 'COUNTER UNIT / RGB', 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['2. BELT', 'CONVEYOR', 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['2. BELT', 'BARFEEDER', 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],

            // 3. Bearing
            ['3. BEARING', 'SPINDLE HEAD 1 (1000/3000/5000 RPM)', 'ROTATION & SOUND', 'NOT NOISY'],
            ['3. BEARING', 'SPINDLE HEAD 2 (1000/3000/5000 RPM)', 'ROTATION & SOUND', 'NOT NOISY'],
            ['3. BEARING', 'COUNTER UNIT / RGB (1000/3000/5000 RPM)', 'ROTATION & SOUND', 'NOT NOISY'],
            ['3. BEARING', 'SPINDLE CHUCK HEAD 1 (1000/3000/5000 RPM)', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['3. BEARING', 'SPINDLE CHUCK HEAD 2 (1000/3000/5000 RPM)', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['3. BEARING', 'CROSS DRILL UNIT (1000/3000/5000 RPM)', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['3. BEARING', 'CONVEYOR', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],

            // 4. Electrical Check
            ['4. ELECTRICAL CHECK', 'DOORLOCK (HEAD 1 / HEAD 2)', 'PHYSICAL & FUNCTION', '1 WHEN THE DOOR IS CLOSED / CLOSED'],
            ['4. ELECTRICAL CHECK', 'AC FAN MOTOR', 'PHYSICAL & FUNCTION', 'SPINNING'],
            ['4. ELECTRICAL CHECK', 'EMERGENCY SWITCH', 'PHYSICAL & FUNCTION', 'ALARM WHEN PRESSED'],
            ['4. ELECTRICAL CHECK', 'CONTROL SWITCH', 'PHYSICAL & FUNCTION', 'OUTPUT WHEN PRESSED'],
            ['4. ELECTRICAL CHECK', 'MONITOR', 'DISPLAY BRIGHTNESS', 'CLEARLY VISIBLE'],
            ['4. ELECTRICAL CHECK', 'KEYPAD / SOFTKEY', 'PHYSICAL & FUNCTION', 'OUTPUT WHEN PRESSED'],
            ['4. ELECTRICAL CHECK', 'SOCKET MEMORY CARD', 'PHYSICAL & FUNCTION', 'SD CARD CONNECTION'],
            ['4. ELECTRICAL CHECK', 'TOWER LIGHT', 'PHYSICAL & FUNCTION', 'LIGHT IS ON'],
            ['4. ELECTRICAL CHECK', 'BACK UP PARAMETER', 'MACHINE TO MEMORY CARD', 'SAVED'],
            ['4. ELECTRICAL CHECK', 'SENSOR TOOL BROKEN (STAR)', 'MDI : M27 (HEAD 1)', 'NO ALARM'],
            ['4. ELECTRICAL CHECK', 'LEVELING LOCK', 'LOCKING BOLT', 'LOCKED'],
            ['4. ELECTRICAL CHECK', 'COUPLING EXTERNAL PUMP', 'PHYSICAL', 'NOT CRACKED'],

            // 5. Function Test
            ['5. FUNCTION TEST', 'CHECK MANUAL', 'FUNCTION TEST', ''],
            ['5. FUNCTION TEST', 'CHECK AUTO', 'FUNCTION TEST', ''],
            ['5. FUNCTION TEST', 'CHECK MDI', 'FUNCTION TEST', ''],
            ['5. FUNCTION TEST', 'CHECK ALARM', 'FUNCTION TEST', ''],
        ];

        foreach ($locations as $loc) {
            // Bar Feeder parameters
            $idx = 1;
            foreach ($barFeederRows as $r) {
                $insertData[] = [
                    'lokasi'         => $loc,
                    'jenis_check'    => 'Overhaul',
                    'kategori'       => 'Bar Feeder CNC',
                    'bagian_check'   => $r[0],
                    'point_check'    => $r[1],
                    'standard_check' => $r[2],
                    'urutan'         => $idx++,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ];
            }

            // Mesin CNC parameters
            $idx = 1;
            foreach ($mesinCncRows as $r) {
                $insertData[] = [
                    'lokasi'         => $loc,
                    'jenis_check'    => 'Overhaul',
                    'kategori'       => 'Mesin CNC',
                    'bagian_check'   => $r[0],
                    'point_check'    => $r[1],
                    'standard_check' => $r[2],
                    'urutan'         => $idx++,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ];
            }
        }

        $this->db->table('master_parameter_check')->insertBatch($insertData);
    }

    public function down()
    {
        // 1. Hapus parameter Overhaul
        $this->db->table('master_parameter_check')
                 ->where('jenis_check', 'Overhaul')
                 ->whereIn('kategori', ['Bar Feeder CNC', 'Mesin CNC'])
                 ->delete();

        // 2. Drop table transaksi_overhaul
        $this->forge->dropTable('transaksi_overhaul');
    }
}
