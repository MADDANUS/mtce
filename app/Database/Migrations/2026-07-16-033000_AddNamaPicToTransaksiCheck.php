<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaPicToTransaksiCheck extends Migration
{
    public function up()
    {
        $fields = [
            'nama_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'id_user',
            ]
        ];
        $this->forge->addColumn('transaksi_check', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_check', 'nama_pic');
    }
}
