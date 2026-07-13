<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiCheck extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_mesin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'lokasi_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'MFG 1',
            ],
            'jenis_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Preventive',
            ],
            'waktu_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_selesai' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_mesin', 'master_mesin', 'id_mesin', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('transaksi_check');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_check');
    }
}
