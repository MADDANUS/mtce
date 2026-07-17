<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder untuk data tambahan Preventive MFG 1:
 * - Bearing (CAM + semua bearing dari foto form)
 * - Gearbox
 * - Belt (CAM + semua belt dari foto form)
 */
class MasterParameterMfg1BearingGearboxBeltSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            // ============================================================
            // KATEGORI: Bearing Cam
            // Sumber: foto form (baris Bearing Spindle sampai Bearing Center Shaft C)
            // + tambahan Bearing CAM sesuai permintaan user
            // ============================================================
            ['Bearing Cam', 'Bearing Spindle',       'Noise',       'Halus'],
            ['Bearing Cam', 'Bearing Spindle',       'Temperature', '40°C - 50°C'],
            ['Bearing Cam', 'Bearing Chucking',      'Noise',       'Halus'],
            ['Bearing Cam', 'Bearing Chucking',      'Temperature', '40°C - 50°C'],
            ['Bearing Cam', 'Bearing Center Shaft A','Noise',       'Halus'],
            ['Bearing Cam', 'Bearing Center Shaft A','Temperature', '40°C - 50°C'],
            ['Bearing Cam', 'Bearing Center Shaft B','Noise',       'Halus'],
            ['Bearing Cam', 'Bearing Center Shaft B','Temperature', '40°C - 50°C'],
            ['Bearing Cam', 'Bearing Center Shaft C','Noise',       'Halus'],
            ['Bearing Cam', 'Bearing Center Shaft C','Temperature', '40°C - 50°C'],
            ['Bearing Cam', 'Bearing CAM',           'Noise',       'Halus'],
            ['Bearing Cam', 'Bearing CAM',           'Temperature', '40°C - 50°C'],

            // ============================================================
            // KATEGORI: Gearbox
            // Sumber: foto form (OLI / MATA GEAR / NOK SEAL)
            // ============================================================
            ['Gearbox', 'Gearbox', 'Oli',       'Oli Terlihat Dari Lubang Pengisian'],
            ['Gearbox', 'Gearbox', 'Mata Gear', 'Tidak Backloss'],
            ['Gearbox', 'Gearbox', 'Nok Seal',  'Tidak Rembes'],

            // ============================================================
            // KATEGORI: Belt Cam
            // Sumber: foto form (Belt Spindle, Belt Gearbox, Belt Motor,
            //         Belt Optional, Belt Oil Pump)
            // + tambahan Belt CAM sesuai permintaan user
            // ============================================================
            ['Belt Cam', 'Belt Spindle',  'Sambungan', 'Lem Tidak Mengelupas'],
            ['Belt Cam', 'Belt Spindle',  'Belt',      'Tidak Sobek/Berlubang/Terkikis'],
            ['Belt Cam', 'Belt Gearbox',  'Sambungan', 'Tidak Pecah'],
            ['Belt Cam', 'Belt Gearbox',  'Belt',      'Tidak Getas/Pecah'],
            ['Belt Cam', 'Belt Motor',    'Belt',      'Tidak Pecah'],
            ['Belt Cam', 'Belt Motor',    'Belt',      'Tidak Terbalik'],
            ['Belt Cam', 'Belt Motor',    'Belt',      'Tidak Sobek'],
            ['Belt Cam', 'Belt Optional', 'Sambungan', 'Tidak Pecah'],
            ['Belt Cam', 'Belt Optional', 'Belt',      'Tidak Getas/Pecah'],
            ['Belt Cam', 'Belt Oil Pump', 'Sambungan', 'Tidak Pecah'],
            ['Belt Cam', 'Belt Oil Pump', 'Belt',      'Tidak Getas/Pecah'],
            ['Belt Cam', 'Belt CAM',      'Sambungan', 'Tidak Pecah'],
            ['Belt Cam', 'Belt CAM',      'Belt',      'Tidak Getas/Pecah'],
        ];

        $now  = date('Y-m-d H:i:s');

        // Dapatkan urutan terakhir yang sudah ada agar tidak bentrok
        $lastUrutan = $this->db
            ->table('master_parameter_check')
            ->where('lokasi', 'MFG 1')
            ->where('jenis_check', 'Preventive')
            ->selectMax('urutan')
            ->get()
            ->getRow()
            ->urutan ?? 0;

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'lokasi'         => 'MFG 1',
                'jenis_check'    => 'Preventive',
                'kategori'       => $r[0],
                'bagian_check'   => $r[1],
                'point_check'    => $r[2],
                'standard_check' => $r[3],
                'urutan'         => $lastUrutan + $i + 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ];
        }

        $this->db->table('master_parameter_check')->insertBatch($data);
        echo 'Seeder Bearing / Gearbox / Belt selesai: ' . count($data) . " baris ditambahkan.\n";
    }
}
