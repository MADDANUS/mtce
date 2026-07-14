<?php

namespace App\Controllers;

use App\Models\CeklisKontrolModel;
use App\Models\MesinModel;
use CodeIgniter\I18n\Time;

class KontrolController extends BaseController
{
    protected CeklisKontrolModel $kontrolModel;
    protected MesinModel $mesinModel;

    public function __construct()
    {
        $this->kontrolModel = new CeklisKontrolModel();
        $this->mesinModel   = new MesinModel();
    }

    /**
     * GET /kontrol
     * Dashboard Ceklis Kontrol bulanan.
     */
    public function index()
    {
        $lokasi   = $this->request->getGet('lokasi') ?: 'MFG 1';
        $kategori = $this->request->getGet('kategori') ?: 'Penerangan';
        $bulan    = $this->request->getGet('bulan') ?: date('Y-m');

        // Daftar kategori khusus Preventive
        $categories = [
            'Penerangan'     => 'Penerangan',
            'Kabel dan Pipa' => 'Kabel dan Pipa',
            'Angin Bocor'    => 'Angin Bocor',
            'Bearing'        => 'Bearing',
            'Gearbox'        => 'Gearbox',
            'Belt'           => 'Belt',
        ];

        // Buat list 12 bulan terakhir untuk dropdown filter
        $bulanList = [];
        for ($i = 0; $i < 12; $i++) {
            $time = Time::now()->subMonths($i);
            $val  = $time->format('Y-m');
            $label = $time->toLocalizedString('MMMM yyyy');
            $bulanList[$val] = $label;
        }

        $grid = $this->kontrolModel->getGridData($lokasi, $kategori, $bulan);

        return view('kontrol/index', [
            'title'       => 'Ceklis Kontrol Bulanan',
            'lokasi'      => $lokasi,
            'kategori'    => $kategori,
            'bulan'       => $bulan,
            'categories'  => $categories,
            'bulanList'   => $bulanList,
            'grid'        => $grid,
        ]);
    }

    /**
     * POST /kontrol/update-cell
     * Menyimpan atau memperbarui data sel ceklis kontrol (dari Modal Quick Edit).
     */
    public function updateCell()
    {
        $idKontrol   = $this->request->getPost('id_kontrol');
        $idMesin     = (int) $this->request->getPost('id_mesin');
        $kategori    = $this->request->getPost('kategori');
        $bulanTahun  = $this->request->getPost('bulan_tahun');
        $periodeKe   = (int) $this->request->getPost('periode_ke');
        $statusCheck = $this->request->getPost('status_check');
        $picNama     = $this->request->getPost('pic_nama');
        $outOfPlan   = $this->request->getPost('out_of_plan') ?: null; // Tanggal Realita (jika ada)
        $ulasan      = $this->request->getPost('ulasan');

        // Filter lokasi asal mesin untuk redirect
        $mesin = $this->mesinModel->find($idMesin);
        $lokasiRedirect = $mesin ? $mesin['lokasi'] : 'MFG 1';

        $data = [
            'id_mesin'      => $idMesin,
            'kategori'      => $kategori,
            'bulan_tahun'   => $bulanTahun,
            'periode_ke'    => $periodeKe,
            'status_check'  => $statusCheck,
            'pic_nama'      => $picNama,
            'out_of_plan'   => $outOfPlan,
            'ulasan'        => $ulasan,
            'tanggal_check' => date('Y-m-d'),
        ];

        // Jika ID kontrol dikirim, langsung update
        if ($idKontrol && (int)$idKontrol > 0) {
            $this->kontrolModel->update((int)$idKontrol, $data);
        } else {
            // Cek apakah sudah ada untuk periode ini agar tidak duplikat
            $exist = $this->kontrolModel->where('id_mesin', $idMesin)
                                        ->where('kategori', $kategori)
                                        ->where('bulan_tahun', $bulanTahun)
                                        ->where('periode_ke', $periodeKe)
                                        ->first();
            if ($exist) {
                $this->kontrolModel->update($exist['id_kontrol'], $data);
            } else {
                $this->kontrolModel->insert($data);
            }
        }

        return redirect()->to("/kontrol?lokasi=" . urlencode($lokasiRedirect) . "&kategori=" . urlencode($kategori) . "&bulan=" . urlencode($bulanTahun))
                         ->with('success', 'Sel Ceklis Kontrol berhasil diperbarui.');
    }
}
