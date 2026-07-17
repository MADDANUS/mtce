<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBarFeederToMasterMesin extends Migration
{
    public function up()
    {
        $fields = [
            'bar_feeder_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'serial_nomor',
            ]
        ];
        $this->forge->addColumn('master_mesin', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('master_mesin', 'bar_feeder_type');
    }
}
