<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiCheckModel extends Model
{
    protected $table         = 'transaksi_check';
    protected $primaryKey    = 'id_transaksi';
    protected $allowedFields = [
        'id_user', 'id_mesin', 'lokasi_check', 'jenis_check', 'kategori',
        'waktu_mulai', 'waktu_selesai',
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Durasi pengerjaan dalam detik (waktu_selesai - waktu_mulai).
     * Berguna untuk analisis efisiensi (dipakai Leader).
     */
    public function getDurasiDetik(array $row): ?int
    {
        if (empty($row['waktu_mulai']) || empty($row['waktu_selesai'])) {
            return null;
        }

        return strtotime($row['waktu_selesai']) - strtotime($row['waktu_mulai']);
    }

    /**
     * Daftar riwayat transaksi (join users + master_mesin), terbaru dulu.
     * $userId null -> semua staff (dipakai Leader/Admin).
     * $userId diisi -> hanya milik staff tsb (dipakai Staff).
     */
    public function getRiwayat(?int $userId = null, ?int $limit = null, ?string $kategori = null): array
    {
        $builder = $this->select('transaksi_check.*, users.nama as nama_staff, master_mesin.no_mesin, master_mesin.type_mesin')
                         ->join('users', 'users.id = transaksi_check.id_user')
                         ->join('master_mesin', 'master_mesin.id_mesin = transaksi_check.id_mesin')
                         ->orderBy('transaksi_check.id_transaksi', 'DESC');

        if ($userId !== null) {
            $builder->where('transaksi_check.id_user', $userId);
        }
        if ($kategori !== null) {
            $builder->where('transaksi_check.kategori', $kategori);
        }
        if ($limit !== null) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    /**
     * Header transaksi + info staff & mesin, untuk halaman detail riwayat.
     */
    public function getDetailTransaksi(int $idTransaksi): ?array
    {
        return $this->select('transaksi_check.*, users.nama as nama_staff, master_mesin.no_mesin, master_mesin.type_mesin, master_mesin.serial_nomor')
                    ->join('users', 'users.id = transaksi_check.id_user')
                    ->join('master_mesin', 'master_mesin.id_mesin = transaksi_check.id_mesin')
                    ->where('transaksi_check.id_transaksi', $idTransaksi)
                    ->first();
    }

    /**
     * Laporan durasi pengecekan (analisis efisiensi) untuk Leader/Admin.
     */
    public function getLaporanDurasi(): array
    {
        return $this->select("transaksi_check.*, users.nama as nama_staff, master_mesin.no_mesin, master_mesin.type_mesin, TIMESTAMPDIFF(SECOND, transaksi_check.waktu_mulai, transaksi_check.waktu_selesai) as durasi_detik")
                    ->join('users', 'users.id = transaksi_check.id_user')
                    ->join('master_mesin', 'master_mesin.id_mesin = transaksi_check.id_mesin')
                    ->orderBy('transaksi_check.id_transaksi', 'DESC')
                    ->findAll();
    }
}
