<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoteToTransaksiOverhaul extends Migration
{
    public function up()
    {
        $fields = [
            'note_recommendation' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('transaksi_overhaul', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_overhaul', 'note_recommendation');
    }
}
