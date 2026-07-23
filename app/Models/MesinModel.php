<?php

namespace App\Models;

use CodeIgniter\Model;

class MesinModel extends Model
{
    protected $table         = 'master_mesin';
    protected $primaryKey    = 'id_mesin';
    protected $allowedFields = ['no_mesin', 'type_mesin', 'serial_nomor', 'lokasi', 'line', 'bar_feeder_type', 'jenis'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Dropdown mesin untuk lokasi tertentu (dipakai di form MFG 1 Preventive).
     */
    public function getByLokasi(string $lokasi): array
    {
        return $this->where('lokasi', $lokasi)->orderBy('no_mesin', 'ASC')->findAll();
    }
}
