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
            // KATEGORI: Bearing
            // Sumber: foto form (baris Bearing Spindle sampai Bearing Center Shaft C)
            // + tambahan Bearing CAM sesuai permintaan user
            // ============================================================
            ['Bearing', 'Bearing Spindle',       'Noise',       'Halus'],
            ['Bearing', 'Bearing Spindle',       'Temperature', '40°C - 50°C'],
            ['Bearing', 'Bearing Chucking',      'Noise',       'Halus'],
            ['Bearing', 'Bearing Chucking',      'Temperature', '40°C - 50°C'],
            ['Bearing', 'Bearing Center Shaft A','Noise',       'Halus'],
            ['Bearing', 'Bearing Center Shaft A','Temperature', '40°C - 50°C'],
            ['Bearing', 'Bearing Center Shaft B','Noise',       'Halus'],
            ['Bearing', 'Bearing Center Shaft B','Temperature', '40°C - 50°C'],
            ['Bearing', 'Bearing Center Shaft C','Noise',       'Halus'],
            ['Bearing', 'Bearing Center Shaft C','Temperature', '40°C - 50°C'],
            ['Bearing', 'Bearing CAM',           'Noise',       'Halus'],
            ['Bearing', 'Bearing CAM',           'Temperature', '40°C - 50°C'],

            // ============================================================
            // KATEGORI: Gearbox
            // Sumber: foto form (OLI / MATA GEAR / NOK SEAL)
            // ============================================================
            ['Gearbox', 'Gearbox', 'Oli',       'Oli Terlihat Dari Lubang Pengisian'],
            ['Gearbox', 'Gearbox', 'Mata Gear', 'Tidak Backloss'],
            ['Gearbox', 'Gearbox', 'Nok Seal',  'Tidak Rembes'],

            // ============================================================
            // KATEGORI: Belt
            // Sumber: foto form (Belt Spindle, Belt Gearbox, Belt Motor,
            //         Belt Optional, Belt Oil Pump)
            // + tambahan Belt CAM sesuai permintaan user
            // ============================================================
            ['Belt', 'Belt Spindle',  'Sambungan', 'Lem Tidak Mengelupas'],
            ['Belt', 'Belt Spindle',  'Belt',      'Tidak Sobek/Berlubang/Terkikis'],
            ['Belt', 'Belt Gearbox',  'Sambungan', 'Tidak Pecah'],
            ['Belt', 'Belt Gearbox',  'Belt',      'Tidak Getas/Pecah'],
            ['Belt', 'Belt Motor',    'Belt',      'Tidak Pecah'],
            ['Belt', 'Belt Motor',    'Belt',      'Tidak Terbalik'],
            ['Belt', 'Belt Motor',    'Belt',      'Tidak Sobek'],
            ['Belt', 'Belt Optional', 'Sambungan', 'Tidak Pecah'],
            ['Belt', 'Belt Optional', 'Belt',      'Tidak Getas/Pecah'],
            ['Belt', 'Belt Oil Pump', 'Sambungan', 'Tidak Pecah'],
            ['Belt', 'Belt Oil Pump', 'Belt',      'Tidak Getas/Pecah'],
            ['Belt', 'Belt CAM',      'Sambungan', 'Tidak Pecah'],
            ['Belt', 'Belt CAM',      'Belt',      'Tidak Getas/Pecah'],
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
