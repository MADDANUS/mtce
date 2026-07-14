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

        // 2. Tambah kolom struktur di master_parameter_check
        $this->forge->addColumn('master_parameter_check', [
            'section_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'kategori',
            ],
            'sub_item_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'bagian_check',
            ],
        ]);

        // 3. Seeding parameter Overhaul untuk MFG 1 & MFG 2
        $now = date('Y-m-d H:i:s');
        $locations = ['MFG 1', 'MFG 2'];
        $insertData = [];

        // Bar Feeder CNC Parameters
        // Kolom: section_check, bagian_check, sub_item_check, point_check, standard_check
        $barFeederRows = [
            // 1. Equipment Check
            ['EQUIPMENT CHECK', 'RELL URETHAN', null, 'RUBBER LAYER', 'NOT PEELED'],
            ['EQUIPMENT CHECK', 'RANTAI', 'FEED BAR', 'TENSION', '3 - 5 CM'],
            ['EQUIPMENT CHECK', 'RANTAI', 'MOTOR POWER', 'TENSION', '3 - 5 CM'],
            ['EQUIPMENT CHECK', 'RANTAI', 'SYNCRONOUS', 'TENSION', '3 - 5 CM'],
            ['EQUIPMENT CHECK', 'RANTAI', 'MATERIAL PUSH', 'TENSION', '3 - 5 CM'],
            ['EQUIPMENT CHECK', 'FEED BAR/CJ/FC', null, 'STANDARD CONDITION', 'BASE ON BARTOP TYPE'],
            ['EQUIPMENT CHECK', 'FRONT VIBRATION ROLLER DIA .20MM', null, 'MECHANICS, ROLLER, & FUCTION', 'OPEN - CLOSE STANDARD ROLLER'],
            ['EQUIPMENT CHECK', 'NR IN VIBRATION ROLLER DIA 40MM ROLLER ARM', null, 'MECHANICS, ROLLER, & FUNCTION', 'OPEN - CLOSE STANDARD ROLLER'],
            ['EQUIPMENT CHECK', 'SYNCHRONOUS DEVICE', null, 'MECHANICS & FUNCTION', 'MACHINE CONNECTION'],
            ['EQUIPMENT CHECK', 'INDEX DISK', null, 'MECHANICS & FUNCTION', 'FLAT IRON PLATE'],
            ['EQUIPMENT CHECK', 'SLIDER DISK', null, 'MECHANICS & FUNCTION', 'STRAIGHT PLATE'],
            ['EQUIPMENT CHECK', 'BAR TIP DETECTION', null, 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['EQUIPMENT CHECK', 'SHUTTER 1', null, 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['EQUIPMENT CHECK', 'SHUTTER 2', null, 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['EQUIPMENT CHECK', 'SHUTTER 3', null, 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['EQUIPMENT CHECK', 'SHUTTER 4', null, 'MECHANICS & FUNCTION', 'NOT BENT'],
            ['EQUIPMENT CHECK', 'CLAMP', null, 'MECHANICS & FUNCTION', 'NOT BROKEN'],
            ['EQUIPMENT CHECK', 'SOLEOID VALVE NR IN L', null, 'MECHANICS & FUNCTION', 'MOVING VALVE'],
            ['EQUIPMENT CHECK', 'BAR FEEDER OIL', null, 'CHANGE', 'SPINDLE 10'],

            // 2. Electrical Check
            ['ELECTRICAL CHECK', 'OPERATION BOX PANEL', null, 'PHYSICAL', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'TOUCH PANEL', null, 'PHYSICAL & FUNCTION', 'NOT REFLECTING'],
            ['ELECTRICAL CHECK', 'CONTROL SWITCH', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'AC SERVO MOTOR ( M1 )', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'AC SERVO AMPLIFIER', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'AC MOTOR GEARBOX', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'GEAR HEAD', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'LIMIT SWITCH / SENSOR', null, 'PHYSICAL & FUNCTION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'OIL MOTOR PUMP', null, 'SOUND, FUNCTION & PHYSICAL CONDITION', 'NOT BROKEN'],
            ['ELECTRICAL CHECK', 'BATTERY MEMORY', null, 'VOLTAGE CAPACITY', '3 - 3.6 VDC'],

            // Bottom Items (No Section Check)
            [null, 'CHECK MANUAL', null, 'FUNCTION TEST', ''],
            [null, 'CHECK AUTO', null, 'FUNCTION TEST', ''],
            [null, 'CHECK MDI', null, 'FUNCTION TEST', ''],
            [null, 'CHECK ALARM', null, 'FUNCTION TEST', ''],
        ];

        // Mesin CNC Parameters
        // Kolom: section_check, bagian_check, sub_item_check, point_check, standard_check
        $mesinCncRows = [
            // 1. Ballscrew
            ['BALLSCREW', 'X AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'Y AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'Z AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'XB AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'ZB AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'YB AXIS', null, 'BACKLASH & SOUND', '< 15μ & SMOOTH'],
            ['BALLSCREW', 'ROTARY GUIDEUSH', null, 'BACKLASH', '< 10μ'],
            ['BALLSCREW', 'BALL SCREW ( CINCOM )', null, 'GREASING', '10 GRAM'],
            ['BALLSCREW', 'LUBRICANT OIL PUMP', null, 'PHYSICAL', 'CLEAN'],
            ['BALLSCREW', 'BATTERY ABS', null, 'CHANGE / CHECK DIAGNOS', '5 - 6 VDC'],
            ['BALLSCREW', 'BATTERY MEMORY', null, 'CHANGE / CHECK DIAGNOS', '5 - 6 VDC'],

            // 2. Belt
            ['BELT', 'SPINDLE HEAD 1', null, 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['BELT', 'SPINDLE HEAD 2', null, 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['BELT', 'COUNTER UNIT / RGB', null, 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['BELT', 'CONVEYOR', null, 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],
            ['BELT', 'BARFEEDER', null, 'TENSION & BELT', 'NOT CRACKED / NOT WORN OUT / NOT LOOSE'],

            // 3. Bearing
            ['BEARING', 'SPINDLE HEAD 1', '1000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE HEAD 1', '3000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE HEAD 1', '5000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE HEAD 2', '1000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE HEAD 2', '3000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE HEAD 2', '5000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'COUNTER UNIT / RGB', '1000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'COUNTER UNIT / RGB', '3000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'COUNTER UNIT / RGB', '5000 RPM', 'ROTATION & SOUND', 'NOT NOISY'],
            ['BEARING', 'SPINDLE CHUCK HEAD 1', '1000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'SPINDLE CHUCK HEAD 1', '3000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'SPINDLE CHUCK HEAD 1', '5000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'SPINDLE CHUCK HEAD 2', '1000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'SPINDLE CHUCK HEAD 2', '3000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'SPINDLE CHUCK HEAD 2', '5000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'CROSS DRILL UNIT', '1000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'CROSS DRILL UNIT', '3000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'CROSS DRILL UNIT', '5000 RPM', 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],
            ['BEARING', 'CONVEYOR', null, 'ROTATION, SOUND & PHYSICAL CONDITION', 'NO NOISE & SURFACE IS NOT WORN'],

            // 4. Electrical Check
            ['ELECTRICAL CHECK', 'DOORLOCK', 'HEAD 1', 'PHYSICAL & FUNCTION', '1 WHEN THE DOOR IS CLOSED'],
            ['ELECTRICAL CHECK', 'DOORLOCK', 'HEAD 2', 'PHYSICAL & FUNCTION', 'CLOSED'],
            ['ELECTRICAL CHECK', 'AC FAN MOTOR', null, 'PHYSICAL & FUNCTION', 'SPINNING'],
            ['ELECTRICAL CHECK', 'EMERGENCY SWITCH', null, 'PHYSICAL & FUNCTION', 'ALARM WHEN PRESSED'],
            ['ELECTRICAL CHECK', 'CONTROL SWITCH', null, 'PHYSICAL & FUNCTION', 'OUTPUT WHEN PRESSED'],
            ['ELECTRICAL CHECK', 'MONITOR', null, 'DISPLAY BRIGHTNESS', 'CLEARLY VISIBLE'],
            ['ELECTRICAL CHECK', 'KEYPAD / SOFTKEY', null, 'PHYSICAL & FUNCTION', 'OUTPUT WHEN PRESSED'],
            ['ELECTRICAL CHECK', 'SOCKET MEMORY CARD', null, 'PHYSICAL & FUNCTION', 'SD CARD CONNECTION'],
            ['ELECTRICAL CHECK', 'TOWER LIGHT', null, 'PHYSICAL & FUNCTION', 'LIGHT IS ON'],
            ['ELECTRICAL CHECK', 'BACK UP PARAMETER', null, 'MACHINE TO MEMORY CARD', 'SAVED'],
            ['ELECTRICAL CHECK', 'SENSOR TOOL BROKEN (STAR)', null, 'MDI : M27 (HEAD 1)', 'NO ALARM'],
            ['ELECTRICAL CHECK', 'LEVELING LOCK', null, 'LOCKING BOLT', 'LOCKED'],
            ['ELECTRICAL CHECK', 'COUPLING EXTERNAL PUMP', null, 'PHYSICAL', 'NOT CRACKED'],

            // Bottom Items (No Section Check)
            [null, 'CHECK MANUAL', null, 'FUNCTION TEST', ''],
            [null, 'CHECK AUTO', null, 'FUNCTION TEST', ''],
            [null, 'CHECK MDI', null, 'FUNCTION TEST', ''],
            [null, 'CHECK ALARM', null, 'FUNCTION TEST', ''],
        ];

        foreach ($locations as $loc) {
            // Bar Feeder parameters
            $idx = 1;
            foreach ($barFeederRows as $r) {
                $insertData[] = [
                    'lokasi'         => $loc,
                    'jenis_check'    => 'Overhaul',
                    'kategori'       => 'Bar Feeder CNC',
                    'section_check'  => $r[0],
                    'bagian_check'   => $r[1],
                    'sub_item_check' => $r[2],
                    'point_check'    => $r[3],
                    'standard_check' => $r[4],
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
                    'section_check'  => $r[0],
                    'bagian_check'   => $r[1],
                    'sub_item_check' => $r[2],
                    'point_check'    => $r[3],
                    'standard_check' => $r[4],
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

        // 3. Drop kolom di master_parameter_check
        $this->forge->dropColumn('master_parameter_check', ['section_check', 'sub_item_check']);
    }
}
