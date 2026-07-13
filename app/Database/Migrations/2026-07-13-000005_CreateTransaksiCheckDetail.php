<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiCheckDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_parameter' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // 'V' = OK, 'Δ' = Perlu Tindakan, 'X' = Tidak Ada
            'hasil_check' => [
                'type'       => 'ENUM',
                'constraint' => ['V', 'Δ', 'X'],
                'null'       => true,
            ],
            'ulasan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi_check', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_parameter', 'master_parameter_check', 'id_parameter', 'CASCADE', 'RESTRICT');
        // NOTE: create this table with charset/collation utf8mb4 so the 'Δ' enum
        // value stores correctly (see README for the exact CREATE TABLE fallback
        // if your DB default collation does not support it).
        $this->forge->createTable('transaksi_check_detail');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_check_detail');
    }
}
