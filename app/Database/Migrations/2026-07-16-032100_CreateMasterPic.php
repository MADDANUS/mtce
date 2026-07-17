<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterPic extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id_pic', true);
        $this->forge->createTable('master_pic');
    }

    public function down()
    {
        $this->forge->dropTable('master_pic');
    }
}
