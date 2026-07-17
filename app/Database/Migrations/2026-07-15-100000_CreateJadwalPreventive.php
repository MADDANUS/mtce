<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalPreventive extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'lokasi' => [
                'type'       => 'ENUM',
                'constraint' => ['MFG 1', 'MFG 2'],
                'default'    => 'MFG 1',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'bulan_tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 7, // YYYY-MM
            ],
            'periode_ke' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tanggal_rencana' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_jadwal', true);
        $this->forge->addKey(['lokasi', 'kategori', 'bulan_tahun', 'periode_ke']);
        $this->forge->createTable('jadwal_preventive');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_preventive');
    }
}
