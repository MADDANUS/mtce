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
        $lokasiFilter = $this->request->getGet('lokasi') ?: '';
        $searchFilter = $this->request->getGet('search') ?: '';

        // Build query
        $db = \Config\Database::connect();
        $builder = $db->table('laporan_abnormal')
                      ->select('laporan_abnormal.*, master_mesin.no_mesin, master_mesin.type_mesin, master_mesin.lokasi')
                      ->join('master_mesin', 'master_mesin.id_mesin = laporan_abnormal.id_mesin');

        if (!empty($lokasiFilter)) {
            $builder->where('master_mesin.lokasi', $lokasiFilter);
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

        return view('abnormal/index', [
            'title'        => 'Laporan Abnormal Condition',
            'reports'      => $reports,
            'lokasiFilter' => $lokasiFilter,
            'searchFilter' => $searchFilter,
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
