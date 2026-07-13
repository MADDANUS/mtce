<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMfg2AndApprovalToTransaksiCheck extends Migration
{
    public function up()
    {
        // 1. Tambah kolom status persetujuan (approval) ke tabel transaksi_check
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending', 'Approved'],
                'default'    => 'Pending',
                'after'      => 'waktu_selesai',
            ],
            'approved_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'status',
            ],
            'approved_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'approved_by',
            ],
        ];
        $this->forge->addColumn('transaksi_check', $fields);
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'CASCADE', 'RESTRICT');

        // 2. Tambah mesin demo untuk MFG 2
        $now = date('Y-m-d H:i:s');
        $this->db->table('master_mesin')->insertBatch([
            [
                'no_mesin'     => 'MC-201',
                'type_mesin'   => 'Press Machine',
                'serial_nomor' => 'SN-2022-201',
                'lokasi'       => 'MFG 2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'no_mesin'     => 'MC-202',
                'type_mesin'   => 'Bending Machine',
                'serial_nomor' => 'SN-2022-202',
                'lokasi'       => 'MFG 2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);

        // 3. Tambah parameter pengecekan MFG 2 Preventive
        $parameterRows = [
            // Penerangan (11 items)
            ['Penerangan', 'LAMPU ATAS MESIN', 'FUNGSI', 'NYALA'],
            ['Penerangan', 'LAMPU ATAS MESIN', 'KELENGKAPAN', 'LENGKAP'],
            ['Penerangan', 'LAMPU ATAS MESIN', 'KONDISI RM. LAMPU', 'BERSIH'],
            ['Penerangan', 'LAMPU ATAS MESIN', 'LUMEN', '300-600'],
            ['Penerangan', 'LAMPU ATAS MESIN', 'KONDISI LAMPU', 'NYALA TERANG'],
            ['Penerangan', 'LAMPU ATAS MESIN', 'KONDISI LAMPU', 'BERSIH'],
            ['Penerangan', 'LAMPU SOROT', 'FUNGSI', 'NYALA'],
            ['Penerangan', 'LAMPU SOROT', 'KONDISI FISIK', 'NORMAL'],
            ['Penerangan', 'LAMPU SOROT', 'BRACKET', 'SAFETY'],
            ['Penerangan', 'LAMPU SOROT', 'KONDISI LAMPU', 'NYALA TERANG'],
            ['Penerangan', 'LAMPU SOROT', 'KONDISI LAMPU', 'BERSIH'],

            // Angin Bocor (13 items)
            ['Angin Bocor', 'REGULATOR', 'REGULATOR UNIT', 'TIDAK BOCOR'],
            ['Angin Bocor', 'REGULATOR', 'FITTING', 'TIDAK BOCOR'],
            ['Angin Bocor', 'REGULATOR', 'COUPLER', 'TIDAK BOCOR'],
            ['Angin Bocor', 'SELENOID', 'SOLENOID UNIT', 'TIDAK BOCOR'],
            ['Angin Bocor', 'SELENOID', 'FITTING', 'TIDAK BOCOR'],
            ['Angin Bocor', 'SELENOID', 'CYLINCER', 'TIDAK BOCOR'],
            ['Angin Bocor', 'CYLINDER', 'CYLINDER UNIT', 'TIDAK BOCOR'],
            ['Angin Bocor', 'CYLINDER', 'FITTING', 'TIDAK BOCOR'],
            ['Angin Bocor', 'AIR GUN', 'AIRGUN UNIT', 'TIDAK BOCOR'],
            ['Angin Bocor', 'AIR GUN', 'COUPLER', 'TIDAK BOCOR'],
            ['Angin Bocor', 'PERCAB. SELANG', 'FITTING', 'TIDAK BOCOR'],
            ['Angin Bocor', 'SAMB. SELANG', 'FITTING', 'TIDAK BOCOR'],
            ['Angin Bocor', 'SELANG UNIT', 'SELANG', 'TIDAK BOCOR'],

            // Kabel dan Pipa (18 items)
            ['Kabel dan Pipa', 'KABEL MESIN KE PANEL', 'KONDISI KABEL', 'RAPI'],
            ['Kabel dan Pipa', 'KABEL MESIN KE PANEL', 'KONDISI KABEL', 'SAFETY'],
            ['Kabel dan Pipa', 'KABEL AREA SOLENOID', 'KONDISI KABEL', 'RAPI'],
            ['Kabel dan Pipa', 'KABEL AREA SOLENOID', 'KONDISI KABEL', 'SAFETY'],
            ['Kabel dan Pipa', 'KABEL AREA OIL PUMP/HYDROULIC', 'KONDISI KABEL', 'RAPI'],
            ['Kabel dan Pipa', 'KABEL AREA OIL PUMP/HYDROULIC', 'KONDISI KABEL', 'SAFETY'],
            ['Kabel dan Pipa', 'KABEL CONVEYOR (OPTIONAL)', 'KONDISI KABEL', 'RAPI'],
            ['Kabel dan Pipa', 'KABEL CONVEYOR (OPTIONAL)', 'KONDISI KABEL', 'SAFETY'],
            ['Kabel dan Pipa', 'SELANG HYDRO UNIT (OPTIONAL)', 'KONDISI SELANG', 'TIDAK BOCOR'],
            ['Kabel dan Pipa', 'SELANG HYDRO UNIT (OPTIONAL)', 'KONDISI SELANG', 'SAFETY'],
            ['Kabel dan Pipa', 'SELANG OIL PUMP/HYDROULIC', 'KONDISI SELANG', 'TIDAK BOCOR'],
            ['Kabel dan Pipa', 'SELANG OIL PUMP/HYDROULIC', 'KONDISI SELANG', 'SAFETY'],
            ['Kabel dan Pipa', 'SELANG FLEXIBEL NOZZLE (OPTIONAL)', 'KONDISI SELANG', 'TIDAK BOCOR'],
            ['Kabel dan Pipa', 'SELANG FLEXIBEL NOZZLE (OPTIONAL)', 'KELENGKAPAN', 'LENGKAP'],
            ['Kabel dan Pipa', 'SELANG FLEXIBEL AMANO (CG AREA)', 'KONDISI SELANG', 'TIDAK BOCOR'],
            ['Kabel dan Pipa', 'SELANG FLEXIBEL AMANO (CG AREA)', 'KONDISI SELANG', 'SAFETY'],
            ['Kabel dan Pipa', 'PIPA SEPARATOR (CG AREA)', 'KONDISI PIPA', 'TIDAK BOCOR'],
            ['Kabel dan Pipa', 'PIPA SEPARATOR (CG AREA)', 'KONDISI PIPA', 'SAFETY'],
        ];

        $data = [];
        foreach ($parameterRows as $i => $r) {
            $data[] = [
                'lokasi'         => 'MFG 2',
                'jenis_check'    => 'Preventive',
                'kategori'       => $r[0],
                'bagian_check'   => $r[1],
                'point_check'    => $r[2],
                'standard_check' => $r[3],
                'urutan'         => $i + 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ];
        }

        $this->db->table('master_parameter_check')->insertBatch($data);
    }

    public function down()
    {
        // 1. Hapus parameter pengecekan MFG 2
        $this->db->table('master_parameter_check')->where('lokasi', 'MFG 2')->delete();

        // 2. Hapus mesin demo MFG 2
        $this->db->table('master_mesin')->where('lokasi', 'MFG 2')->delete();

        // 3. Drop foreign key dan kolom dari transaksi_check
        try {
            $this->forge->dropForeignKey('transaksi_check', 'transaksi_check_approved_by_foreign');
        } catch (\Exception $e) {
            // Abaikan jika tidak didukung atau nama constraint berbeda
        }
        $this->forge->dropColumn('transaksi_check', ['status', 'approved_by', 'approved_at']);
    }
}
