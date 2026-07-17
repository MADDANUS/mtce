<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonthlyApprovalTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_approval' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['kontrol', 'abnormal'],
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'bulan_tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Pending',
            ],
            'approved_l1_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'approved_l1_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'approved_l2_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'approved_l2_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'approved_final_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'approved_final_at' => [
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

        $this->forge->addKey('id_approval', true);
        // Unique constraint so we don't have duplicates per location/category/month/type
        $this->forge->addUniqueKey(['type', 'lokasi', 'kategori', 'bulan_tahun']);
        $this->forge->createTable('approval_bulanan');
    }

    public function down()
    {
        $this->forge->dropTable('approval_bulanan');
    }
}
