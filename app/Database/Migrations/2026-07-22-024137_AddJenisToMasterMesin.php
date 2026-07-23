<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisToMasterMesin extends Migration
{
    public function up()
    {
        $fields = [
            'jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'type_mesin', // Or put it after whatever column
            ],
        ];
        $this->forge->addColumn('master_mesin', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('master_mesin', 'jenis');
    }
}
