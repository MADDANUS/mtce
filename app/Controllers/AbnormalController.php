<?php

namespace App\Controllers;

use App\Models\LaporanAbnormalModel;
use App\Models\MesinModel;

class AbnormalController extends BaseController
{
    protected LaporanAbnormalModel $abnormalModel;
    protected MesinModel $mesinModel;

    public function __construct()
    {
        $this->abnormalModel = new LaporanAbnormalModel();
        $this->mesinModel    = new MesinModel();
    }

    /**
     * GET /abnormal
     */
    public function index()
    {
        $lokasiFilter   = $this->request->getGet('lokasi') ?: 'MFG 1';
        $searchFilter   = $this->request->getGet('search') ?: '';
        $kategoriFilter = $this->request->getGet('kategori') ?: 'Penerangan';
        $bulanFilter    = $this->request->getGet('bulan') ?: date('Y-m');

        // Build query
        $db = \Config\Database::connect();
        $builder = $db->table('laporan_abnormal')
                      ->select('laporan_abnormal.*, master_mesin.no_mesin, master_mesin.type_mesin, master_mesin.lokasi, transaksi_check.kategori')
                      ->join('master_mesin', 'master_mesin.id_mesin = laporan_abnormal.id_mesin')
                      ->join('transaksi_check', 'transaksi_check.id_transaksi = laporan_abnormal.id_transaksi', 'left');

        if (!empty($lokasiFilter)) {
            $builder->where('master_mesin.lokasi', $lokasiFilter);
        }

        if (!empty($kategoriFilter)) {
            $builder->where('transaksi_check.kategori', $kategoriFilter);
        }

        if (!empty($bulanFilter)) {
            $builder->like('laporan_abnormal.pengecekan_tanggal', $bulanFilter . '-', 'after');
        }

        if (!empty($searchFilter)) {
            $builder->groupStart()
                    ->like('laporan_abnormal.point_check', $searchFilter)
                    ->orLike('laporan_abnormal.abnormal_condition', $searchFilter)
                    ->orLike('master_mesin.no_mesin', $searchFilter)
                    ->orLike('master_mesin.type_mesin', $searchFilter)
                    ->groupEnd();
        }

        $reports = $builder->orderBy('laporan_abnormal.pengecekan_tanggal', 'DESC')
                           ->orderBy('laporan_abnormal.id_abnormal', 'DESC')
                           ->get()
                           ->getResultArray();

        if ($lokasiFilter === 'MFG 2') {
            $categories = ['Penerangan', 'Kabel dan Pipa', 'Angin Bocor'];
        } else {
            $categories = ['Penerangan', 'Kabel dan Pipa', 'Angin Bocor', 'Bearing Cam', 'Gearbox', 'Belt Cam'];
        }

        if (!in_array($kategoriFilter, $categories)) {
            $kategoriFilter = 'Penerangan';
        }

        // Buat list bulan untuk filter
        $bulanList = [];
        for ($i = 0; $i < 12; $i++) {
            $time = \CodeIgniter\I18n\Time::now()->subMonths($i);
            $val  = $time->format('Y-m');
            $label = $time->toLocalizedString('MMMM yyyy');
            $bulanList[$val] = $label;
        }

        // Cek semua terisi
        $allFilled = true;
        foreach ($reports as $r) {
            if (empty($r['action'])) {
                $allFilled = false;
                break;
            }
        }

        return view('abnormal/index', [
            'title'          => 'Laporan Abnormal Condition',
            'reports'        => $reports,
            'lokasiFilter'   => $lokasiFilter,
            'searchFilter'   => $searchFilter,
            'kategoriFilter' => $kategoriFilter,
            'bulanFilter'    => $bulanFilter,
            'categories'     => $categories,
            'bulanList'      => $bulanList,
            'allFilled'      => $allFilled,
        ]);
    }

    /**
     * POST /abnormal/update
     */
    public function update()
    {
        $idAbnormal = (int) $this->request->getPost('id_abnormal');
        if ($idAbnormal <= 0) {
            return redirect()->back()->with('error', 'Laporan Abnormal tidak valid.');
        }

        $data = [
            'type_sparepart'  => $this->request->getPost('type_sparepart') ?: null,
            'progres_stock'   => $this->request->getPost('progres_stock') ?: null,
            'progres_tanggal' => $this->request->getPost('progres_tanggal') ?: null,
            'action'          => $this->request->getPost('action') ?: null,
            'repair_pic'      => $this->request->getPost('repair_pic') ?: null,
            'keterangan'      => $this->request->getPost('keterangan') ?: null,
        ];

        if ($this->abnormalModel->update($idAbnormal, $data)) {
            return redirect()->to('/abnormal')->with('success', 'Rencana perbaikan Laporan Abnormal berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui Laporan Abnormal.');
    }

}
