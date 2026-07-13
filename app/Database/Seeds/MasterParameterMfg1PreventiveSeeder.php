<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterParameterMfg1PreventiveSeeder extends Seeder
{
    public function run()
    {
        // Baris di bawah ini disalin PERSIS urutannya dari 3 foto form kertas
        // "Pengecekan Preventive MFG 1" yang diupload user.
        // Kolom: kategori, bagian_check, point_check, standard_check
        $rows = [
            // === Halaman 1: Penerangan ===
            ['Penerangan', 'Lampu Sorot', 'Fungsi', 'Nyala'],
            ['Penerangan', 'Lampu Sorot', 'Kondisi Fisik', 'Normal'],
            ['Penerangan', 'Lampu Sorot', 'Kondisi Kaca', 'Bersih'],
            ['Penerangan', 'Headstock Room', 'Fungsi', 'Nyala'],
            ['Penerangan', 'Headstock Room', 'Kondisi Cover Akrilik', 'Bersih'],
            ['Penerangan', 'Cutting Room', 'Fungsi', 'Nyala'],
            ['Penerangan', 'Cutting Room', 'Kondisi Cover Akrilik', 'Bersih'],
            ['Penerangan', 'Lampu Area Atas Mesin', 'Fungsi', 'Nyala'],
            ['Penerangan', 'Lampu Area Atas Mesin', 'Kelengkapan', 'Lampu Lengkap'],
            ['Penerangan', 'Lampu Area Atas Mesin', 'Kondisi Lampu', 'Nyala Terang'],
            ['Penerangan', 'Lampu Area Atas Mesin', 'Kondisi Rumah Lampu', 'Bersih'],
            ['Penerangan', 'Lampu Area Atas Mesin', 'Lumen', '300 - 600'],

            // === Halaman 2: Angin Bocor ===
            ['Angin Bocor', 'Solenoid Mesin', 'Solenoid Unit', 'Tidak Bocor'],
            ['Angin Bocor', 'Solenoid Mesin', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Solenoid Mesin', 'Selang Angin', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Mesin', 'Regulator Unit', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Mesin', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Mesin', 'Coupler', 'Tidak Bocor'],
            ['Angin Bocor', 'Solenoid Bartop', 'Solenoid Unit', 'Tidak Bocor'],
            ['Angin Bocor', 'Solenoid Bartop', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Solenoid Bartop', 'Selang Angin', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Bartop', 'Regulator Unit', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Bartop', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Regulator Bartop', 'Coupler', 'Tidak Bocor'],
            ['Angin Bocor', 'Percabangan Selang', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Percabangan Selang', 'Selang Angin', 'Tidak Bocor'],
            ['Angin Bocor', 'Cylider', 'Cylinder Unit', 'Tidak Bocor'],
            ['Angin Bocor', 'Cylider', 'Fitting', 'Tidak Bocor'],
            ['Angin Bocor', 'Air Gun', 'Airgun Unit', 'Tidak Bocor'],

            // === Halaman 3: Kabel dan Pipa ===
            ['Kabel dan Pipa', 'Kabel Mesin ke Bartop', 'Kondisi Kabel', 'Rapi'],
            ['Kabel dan Pipa', 'Kabel Mesin ke Bartop', 'Kondisi Kabel', 'Safety'],
            ['Kabel dan Pipa', 'Kabel Solenoid Bartop', 'Kondisi Kabel', 'Rapi'],
            ['Kabel dan Pipa', 'Kabel Solenoid Bartop', 'Kondisi Kabel', 'Safety'],
            ['Kabel dan Pipa', 'Selang Hydroulic', 'Kondisi Selang', 'Tidak Bocor'],
            ['Kabel dan Pipa', 'Selang Hydroulic', 'Kondisi Selang', 'Tidak Terjepit'],
            ['Kabel dan Pipa', 'Selang Hydroulic', 'Kondisi Selang', 'Tidak Terlipat'],
            ['Kabel dan Pipa', 'Saluran Amano', 'Kodisi Pipa Sedot', 'Tidak Pecah'],
            ['Kabel dan Pipa', 'Saluran Amano', 'Kodisi Pipa Sedot', 'Tidak Bocor/Rembes'],
            ['Kabel dan Pipa', 'Saluran Amano', 'Kondisi Selang Vacuum', 'Tidak Terlipat'],
            ['Kabel dan Pipa', 'Saluran Amano', 'Kondisi Selang Vacuum', 'Terendam'],
            ['Kabel dan Pipa', 'Kabel dan Selang Oli', 'Kondisi Kabel', 'Safety'],
            ['Kabel dan Pipa', 'Kabel dan Selang Oli', 'Kondisi Kabel', 'Rapi'],
            ['Kabel dan Pipa', 'Kabel dan Selang Oli', 'Kondisi Selang', 'Tidak Bocor/Rembes'],
        ];

        $now  = date('Y-m-d H:i:s');
        $data = [];

        foreach ($rows as $i => $r) {
            $data[] = [
                'lokasi'         => 'MFG 1',
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
}
