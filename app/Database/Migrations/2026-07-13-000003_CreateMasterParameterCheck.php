<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterParameterCheck extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_parameter' => [
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
            'jenis_check' => [
                'type'       => 'ENUM',
                'constraint' => ['Preventive', 'Overhaul'],
                'default'    => 'Preventive',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'bagian_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'point_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'standard_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            // Preserves the exact row order of the physical paper form so the
            // view can rebuild BAGIAN CHECK / POINT CHECK rowspans reliably.
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        $this->forge->addKey('id_parameter', true);
        $this->forge->addKey(['lokasi', 'jenis_check']);
        $this->forge->createTable('master_parameter_check');
    }

    public function down()
    {
        $this->forge->dropTable('master_parameter_check');
    }
}
