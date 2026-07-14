<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanAbnormal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_abnormal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_detail' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_mesin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'point_check' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'abnormal_condition' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'type_sparepart' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'pengecekan_tanggal' => [
                'type' => 'DATE',
            ],
            'pengecekan_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'progres_stock' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'progres_tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'action' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'repair_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
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

        $this->forge->addKey('id_abnormal', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi_check', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_detail', 'transaksi_check_detail', 'id_detail', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_mesin', 'master_mesin', 'id_mesin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('laporan_abnormal');
    }

    public function down()
    {
        $this->forge->dropTable('laporan_abnormal');
    }
}
