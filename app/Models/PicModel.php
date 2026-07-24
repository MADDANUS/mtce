<?php

namespace App\Models;

use CodeIgniter\Model;

class PicModel extends Model
{
    protected $table            = 'master_pic';
    protected $primaryKey       = 'id_pic';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'id_pic',
        'nama_pic',
        'role_pic'
    ];

    // Validation
    protected $validationRules      = [
        'id_pic'   => 'required|max_length[20]|is_unique[master_pic.id_pic]',
        'nama_pic' => 'required|max_length[255]',
    ];
    protected $validationMessages   = [
        'id_pic' => [
            'is_unique' => 'ID PIC sudah terdaftar, silakan gunakan ID lain.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
