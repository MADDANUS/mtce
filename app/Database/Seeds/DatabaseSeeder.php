<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Demo users (password untuk semua akun demo: "password123")
        $this->db->table('users')->insertBatch([
            [
                'nama'       => 'Panji (Staff)',
                'username'   => 'panji',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'staff',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama'       => 'Leader MFG 1',
                'username'   => 'leader1',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'leader',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama'       => 'Administrator',
                'username'   => 'admin',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Demo mesin di MFG 1
        $this->db->table('master_mesin')->insertBatch([
            [
                'no_mesin'     => 'MC-001',
                'type_mesin'   => 'CNC Router',
                'serial_nomor' => 'SN-2021-001',
                'lokasi'       => 'MFG 1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'no_mesin'     => 'MC-002',
                'type_mesin'   => 'Cutting Machine',
                'serial_nomor' => 'SN-2021-002',
                'lokasi'       => 'MFG 1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);

        // Parameter form MFG 1 Preventive (43 baris, sesuai foto form kertas)
        $this->call(MasterParameterMfg1PreventiveSeeder::class);
    }
}
