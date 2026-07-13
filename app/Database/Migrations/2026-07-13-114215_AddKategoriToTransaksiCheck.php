<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToTransaksiCheck extends Migration
{
    public function up()
    {
        $fields = [
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'jenis_check',
            ]
        ];
        $this->forge->addColumn('transaksi_check', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_check', 'kategori');
    }
}
