<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLineToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'line' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'lokasi',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'line');
    }
}
