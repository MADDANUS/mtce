<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingLampuAreaAtasParameterToMfg1 extends Migration
{
    public function up()
    {
        // 1. Shift urutan parameters for MFG 1 Preventive starting from urutan 11
        $db = \Config\Database::connect();
        $db->query("UPDATE master_parameter_check SET urutan = urutan + 1 WHERE lokasi = 'MFG 1' AND jenis_check = 'Preventive' AND urutan >= 11");

        // 2. Insert the missing row at urutan 11
        $now = date('Y-m-d H:i:s');
        $db->table('master_parameter_check')->insert([
            'lokasi'         => 'MFG 1',
            'jenis_check'    => 'Preventive',
            'kategori'       => 'Penerangan',
            'bagian_check'   => 'Lampu Area Atas Mesin',
            'point_check'    => 'Kondisi Lampu',
            'standard_check' => 'Bersih',
            'urutan'         => 11,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // 1. Delete the parameter we inserted
        $db->table('master_parameter_check')
           ->where('lokasi', 'MFG 1')
           ->where('jenis_check', 'Preventive')
           ->where('bagian_check', 'Lampu Area Atas Mesin')
           ->where('point_check', 'Kondisi Lampu')
           ->where('standard_check', 'Bersih')
           ->where('urutan', 11)
           ->delete();

        // 2. Shift urutan back
        $db->query("UPDATE master_parameter_check SET urutan = urutan - 1 WHERE lokasi = 'MFG 1' AND jenis_check = 'Preventive' AND urutan >= 12");
    }
}
