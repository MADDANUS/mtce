<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCeklisKontrol extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kontrol' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mesin' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
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
            'status_check' => [
                'type'       => 'ENUM',
                'constraint' => ['V', 'Δ', 'X'],
            ],
            'pic_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'out_of_plan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'ulasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_check' => [
                'type' => 'DATE',
                'null' => true,
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

        $this->forge->addKey('id_kontrol', true);
        $this->forge->addForeignKey('id_mesin', 'master_mesin', 'id_mesin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ceklis_kontrol');
    }

    public function down()
    {
        $this->forge->dropTable('ceklis_kontrol');
    }
}
