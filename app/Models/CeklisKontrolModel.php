<?php

namespace App\Models;

use CodeIgniter\Model;

class CeklisKontrolModel extends Model
{
    protected $table         = 'ceklis_kontrol';
    protected $primaryKey    = 'id_kontrol';
    protected $allowedFields = [
        'id_mesin', 
        'kategori', 
        'bulan_tahun', 
        'periode_ke', 
        'status_check', 
        'pic_nama', 
        'out_of_plan', 
        'ulasan', 
        'tanggal_check'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Mengambil data ceklis kontrol untuk lokasi, kategori, dan bulan tertentu.
     * Mengembalikan data yang distrukturkan per mesin lengkap dengan data periode 1-5.
     */
    public function getGridData(string $lokasi, string $kategori, string $bulanTahun, ?string $line = null): array
    {
        // 1. Ambil semua mesin untuk lokasi ini
        $mesinModel = new MesinModel();
        $builder = $mesinModel->where('lokasi', $lokasi);
        if ($line) {
            $builder->where('line', $line);
        }
        $daftarMesin = $builder->orderBy('no_mesin', 'ASC')->findAll();

        // 2. Ambil semua catatan ceklis kontrol untuk kategori & bulan ini
        $records = $this->where('kategori', $kategori)
                        ->where('bulan_tahun', $bulanTahun)
                        ->findAll();

        // Map records by [id_mesin][periode_ke] untuk akses instan
        $mapped = [];
        foreach ($records as $r) {
            $mapped[$r['id_mesin']][$r['periode_ke']] = $r;
        }

        // 3. Gabungkan data mesin dengan data ceklis kontrol periode 1 s.d 5
        $grid = [];
        foreach ($daftarMesin as $m) {
            $idMesin = (int) $m['id_mesin'];
            $row = [
                'mesin' => $m,
                'periodes' => []
            ];

            // Inisialisasi default ulasan dan out_of_plan global bulanan (diambil dari periode terbaru jika ada)
            $rowUlasan = '';
            $rowOutOfPlan = null;
            $rowPic = '';

            for ($p = 1; $p <= 5; $p++) {
                if (isset($mapped[$idMesin][$p])) {
                    $rec = $mapped[$idMesin][$p];
                    $row['periodes'][$p] = [
                        'id_kontrol'   => (int) $rec['id_kontrol'],
                        'status_check' => $rec['status_check'],
                        'pic_nama'     => $rec['pic_nama'],
                        'out_of_plan'  => $rec['out_of_plan'],
                        'ulasan'       => $rec['ulasan'],
                        'tanggal_check'=> $rec['tanggal_check'],
                    ];
                    
                    // Ambil PIC, out_of_plan, ulasan terisi untuk data ringkasan baris
                    if (!empty($rec['pic_nama'])) {
                        $rowPic = $rec['pic_nama'];
                    }
                    if (!empty($rec['ulasan'])) {
                        $rowUlasan = $rec['ulasan'];
                    }
                    if (!empty($rec['out_of_plan'])) {
                        $rowOutOfPlan = $rec['out_of_plan']; // Tanggal Realita
                    }
                } else {
                    $row['periodes'][$p] = null;
                }
            }

            $row['pic_nama']    = $rowPic ?: 'PIC';
            $row['out_of_plan'] = $rowOutOfPlan; // date or null
            $row['ulasan']      = $rowUlasan ?: '';

            $grid[] = $row;
        }

        return $grid;
    }
}
