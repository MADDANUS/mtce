<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovalLevels extends Migration
{
    public function up()
    {
        // Add multi-level approval columns to transaksi_check
        $this->forge->addColumn('transaksi_check', [
            'approval_l1_by' => [
                'type'       => 'INT',
                'null'       => true,
                'default'    => null,
                'after'      => 'status',
            ],
            'approval_l1_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
                'after'      => 'approval_l1_by',
            ],
            'approval_l2_by' => [
                'type'       => 'INT',
                'null'       => true,
                'default'    => null,
                'after'      => 'approval_l1_at',
            ],
            'approval_l2_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
                'after'      => 'approval_l2_by',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_check', ['approval_l1_by', 'approval_l1_at', 'approval_l2_by', 'approval_l2_at']);
    }
}
