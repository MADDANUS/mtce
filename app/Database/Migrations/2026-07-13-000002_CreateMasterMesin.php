<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterMesin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mesin' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_mesin' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'type_mesin' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'serial_nomor' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'lokasi' => [
                'type'       => 'ENUM',
                'constraint' => ['MFG 1', 'MFG 2'],
                'default'    => 'MFG 1',
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
        $this->forge->addKey('id_mesin', true);
        $this->forge->createTable('master_mesin');
    }

    public function down()
    {
        $this->forge->dropTable('master_mesin');
    }
}
