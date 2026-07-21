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
        // Jika parameter view=summary atau tidak ada parameter spesifik, tampilkan halaman ringkasan
        if ($this->request->getGet('view') === 'summary' || (!$this->request->getGet('lokasi') && !$this->request->getGet('search') && !$this->request->getGet('kategori'))) {
            return $this->summary();
        }

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
     * Halaman Ringkasan (Summary) Abnormal
     */
    private function summary()
    {
        $bulan = $this->request->getGet('bulan') ?: date('Y-m');
        $filterLokasi = $this->request->getGet('filter_lokasi') ?: '';
        $filterLine = $this->request->getGet('filter_line') ?: '';
        $filterKategori = $this->request->getGet('filter_kategori') ?: '';
        $filterStatus = $this->request->getGet('filter_status') ?: '';
        $sortBy = $this->request->getGet('sort_by') ?: 'lokasi';
        $order = strtolower($this->request->getGet('order') ?: 'asc');

        $db = \Config\Database::connect();

        // Ambil semua data master mesin
        $mesinQuery = $db->table('master_mesin')
                         ->select('lokasi, line')
                         ->groupBy('lokasi, line')
                         ->get()->getResultArray();

        $linesByLokasi = [];
        foreach($mesinQuery as $m) {
            $linesByLokasi[$m['lokasi']][] = $m['line'];
        }

        // Hitung abnormal terbuka (belum ada action) per lokasi, line, kategori
        $openAbnormal = $db->table('laporan_abnormal')
                           ->select('master_mesin.lokasi, master_mesin.line, transaksi_check.kategori, COUNT(laporan_abnormal.id_abnormal) as total')
                           ->join('master_mesin', 'master_mesin.id_mesin = laporan_abnormal.id_mesin')
                           ->join('transaksi_check', 'transaksi_check.id_transaksi = laporan_abnormal.id_transaksi', 'left')
                           ->where("(laporan_abnormal.action IS NULL OR laporan_abnormal.action = '')")
                           ->like('laporan_abnormal.pengecekan_tanggal', $bulan . '-', 'after')
                           ->groupBy('master_mesin.lokasi, master_mesin.line, transaksi_check.kategori')
                           ->get()->getResultArray();
                           
        $abnormalData = [];
        foreach($openAbnormal as $oa) {
            $kategori = $oa['kategori'] ?: 'Penerangan'; // Default fallback
            $abnormalData[$oa['lokasi']][$oa['line']][$kategori] = (int) $oa['total'];
        }

        $kategoriByLokasi = [
            'MFG 1' => ['Penerangan', 'Kabel dan Pipa', 'Angin Bocor', 'Bearing Cam', 'Gearbox', 'Belt Cam'],
            'MFG 2' => ['Penerangan', 'Kabel dan Pipa', 'Angin Bocor']
        ];

        // List bulan
        $bulanList = [];
        for ($i = 0; $i < 12; $i++) {
            $time = \CodeIgniter\I18n\Time::now()->subMonths($i);
            $val  = $time->format('Y-m');
            $label = $time->toLocalizedString('MMMM yyyy');
            $bulanList[$val] = $label;
        }

        // Build flat array for summary rows
        $summaryRows = [];
        foreach ($kategoriByLokasi as $lokasi => $categories) {
            if (!empty($filterLokasi) && $lokasi !== $filterLokasi) continue; 
            
            $lines = isset($linesByLokasi[$lokasi]) ? array_unique($linesByLokasi[$lokasi]) : [];
            sort($lines);

            foreach ($lines as $line) {
                if (!empty($filterLine) && $line !== $filterLine) continue; 

                foreach ($categories as $kategori) {
                    if (!empty($filterKategori) && $kategori !== $filterKategori) continue;
                    
                    $totalOpen = $abnormalData[$lokasi][$line][$kategori] ?? 0;
                    if ($totalOpen == 0) continue; 
                    
                    // Di Laporan Abnormal, jika totalOpen > 0 berarti belum selesai
                    $badgeClass = 'bg-danger';
                    $statusText = 'Belum Ada Action';
                    
                    if (!empty($filterStatus) && $statusText !== $filterStatus) continue;

                    $summaryRows[] = [
                        'lokasi'      => $lokasi,
                        'line'        => $line,
                        'kategori'    => $kategori,
                        'totalOpen'   => $totalOpen,
                        'statusText'  => $statusText,
                        'badgeClass'  => $badgeClass
                    ];
                }
            }
        }

        // Sort the flat array
        usort($summaryRows, function($a, $b) use ($sortBy, $order) {
            $valA = $a[$sortBy] ?? '';
            $valB = $b[$sortBy] ?? '';
            
            if ($valA == $valB) return 0;
            
            $cmp = ($valA < $valB) ? -1 : 1;
            return ($order === 'asc') ? $cmp : -$cmp;
        });

        return view('abnormal/summary', [
            'title'            => 'Ringkasan Laporan Abnormal',
            'bulan'            => $bulan,
            'bulanList'        => $bulanList,
            'summaryRows'      => $summaryRows,
            'filterLokasi'     => $filterLokasi,
            'filterLine'       => $filterLine,
            'filterKategori'   => $filterKategori,
            'filterStatus'     => $filterStatus,
            'sortBy'           => $sortBy,
            'order'            => $order,
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
