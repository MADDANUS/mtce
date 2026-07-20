<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLineToMasterMesin extends Migration
{
    public function up()
    {
        $this->forge->addColumn('master_mesin', [
            'line' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'lokasi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('master_mesin', 'line');
    }
}
