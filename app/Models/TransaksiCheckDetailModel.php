<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiCheckDetailModel extends Model
{
    protected $table         = 'transaksi_check_detail';
    protected $primaryKey    = 'id_detail';
    protected $allowedFields = ['id_transaksi', 'id_parameter', 'hasil_check', 'ulasan'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Semua hasil centangan untuk satu transaksi, dijoin dengan info
     * parameter (kategori/bagian/point/standard), diurutkan sesuai
     * urutan form kertas aslinya.
     */
    public function getDetailByTransaksi(int $idTransaksi): array
    {
        return $this->select('transaksi_check_detail.*, master_parameter_check.kategori, master_parameter_check.bagian_check, master_parameter_check.point_check, master_parameter_check.standard_check, master_parameter_check.urutan')
                    ->join('master_parameter_check', 'master_parameter_check.id_parameter = transaksi_check_detail.id_parameter')
                    ->where('transaksi_check_detail.id_transaksi', $idTransaksi)
                    ->orderBy('master_parameter_check.urutan', 'ASC')
                    ->findAll();
    }
}
