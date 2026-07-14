<?php

namespace App\Controllers;

use App\Models\TransaksiCheckDetailModel;
use App\Models\TransaksiCheckModel;
use App\Models\MesinModel;

class RiwayatController extends BaseController
{
    private array $categoryMap = [
        'penerangan'     => 'Penerangan',
        'kabel-dan-pipa' => 'Kabel dan Pipa',
        'angin-bocor'    => 'Angin Bocor',
        'bearing'        => 'Bearing',
        'gearbox'        => 'Gearbox',
        'belt'           => 'Belt',
        'bar-feeder-cnc' => 'Bar Feeder CNC',
        'mesin-cnc'      => 'Mesin CNC',
    ];

    private function resolveLokasi(string $slug): string
    {
        return match (strtolower($slug)) {
            'mfg2'  => 'MFG 2',
            default => 'MFG 1',
        };
    }

    /**
     * GET /riwayat
     * Halaman pilih lokasi (MFG 1 / MFG 2) untuk melihat riwayat.
     */
    public function index()
    {
        return view('riwayat/landing', [
            'title' => 'Pilih Lokasi Riwayat',
        ]);
    }

    /**
     * GET /riwayat/lokasi/(:segment)
     * Daftar riwayat pengecekan untuk lokasi terpilih beserta filter pencarian.
     */
    public function lokasi(string $lokasiSlug)
    {
        $lokasiName = $this->resolveLokasi($lokasiSlug);
        $mesinModel = new MesinModel();
        $transaksiModel = new TransaksiCheckModel();

        // Dropdown filter mesin dinamis (hanya mesin yang terdaftar di lokasi ini)
        $daftarMesin = $mesinModel->getByLokasi($lokasiName);

        // Ambil input filter pencarian
        $filters = [
            'lokasi'   => $lokasiName,
            'id_mesin' => $this->request->getGet('id_mesin') ?: null,
            'kategori' => $this->request->getGet('kategori') ?: null,
            'tanggal'  => $this->request->getGet('tanggal') ?: null,
            'status'   => $this->request->getGet('status') ?: null,
            'sort_by'  => $this->request->getGet('sort_by') ?: 'id_transaksi',
            'order'    => $this->request->getGet('order') ?: 'desc',
        ];

        $role = session()->get('role');
        $riwayat = $role === 'staff'
            ? $transaksiModel->getRiwayatFiltered($filters, session()->get('user_id'))
            : $transaksiModel->getRiwayatFiltered($filters);

        return view('riwayat/index', [
            'title'           => 'Riwayat Pengecekan — ' . $lokasiName,
            'lokasiSlug'      => $lokasiSlug,
            'lokasiName'      => $lokasiName,
            'daftarMesin'     => $daftarMesin,
            'categories'      => $this->categoryMap,
            'riwayat'         => $riwayat,
            'selectedFilters' => $filters,
        ]);
    }

    /**
     * GET /riwayat/kategori/(:segment)
     * Fallback redirect untuk kompatibilitas tautan lama agar mengarah ke riwayat lokasi MFG 1.
     */
    public function kategori(string $categorySlug)
    {
        if (! isset($this->categoryMap[$categorySlug])) {
            return redirect()->to('/riwayat')->with('error', 'Kategori tidak valid.');
        }

        $categoryName = $this->categoryMap[$categorySlug];
        return redirect()->to('/riwayat/lokasi/mfg1?kategori=' . urlencode($categoryName));
    }

    /**
     * GET /riwayat/(:num)
     * Detail pengerjaan checklist riwayat pengecekan.
     */
    public function detail(int $id)
    {
        $transaksiModel = new TransaksiCheckModel();
        $header         = $transaksiModel->getDetailTransaksi($id);

        if (! $header) {
            return redirect()->to('/riwayat')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Staff hanya boleh lihat transaksi miliknya sendiri
        if (session()->get('role') === 'staff' && (int) $header['id_user'] !== (int) session()->get('user_id')) {
            return redirect()->to('/riwayat')->with('error', 'Anda tidak memiliki akses ke transaksi tersebut.');
        }

        $detailModel = new TransaksiCheckDetailModel();
        $details     = $detailModel->getDetailByTransaksi($id);
        $details     = $detailModel->calculateRowspans($details, $header['jenis_check']);

        $durasiDetik = null;
        if (! empty($header['waktu_mulai']) && ! empty($header['waktu_selesai'])) {
            $durasiDetik = strtotime($header['waktu_selesai']) - strtotime($header['waktu_mulai']);
        }

        return view('riwayat/detail', [
            'title'       => 'Detail Pengecekan #' . $id,
            'header'      => $header,
            'details'     => $details,
            'durasiDetik' => $durasiDetik,
        ]);
    }

    /**
     * POST /riwayat/approve/(:num)
     * Menyetujui transaksi pengecekan oleh Leader / Admin.
     */
    public function approve(int $id)
    {
        $role = session()->get('role');
        if (! in_array($role, ['leader', 'admin'], true)) {
            return redirect()->back()->with('error', 'Hanya Leader atau Admin yang dapat menyetujui pengecekan.');
        }

        $transaksiModel = new TransaksiCheckModel();
        $header         = $transaksiModel->find($id);

        if (! $header) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($header['status'] === 'Approved') {
            return redirect()->back()->with('error', 'Transaksi ini sudah disetujui sebelumnya.');
        }

        $transaksiModel->update($id, [
            'status'      => 'Approved',
            'approved_by' => session()->get('user_id'),
            'approved_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/riwayat/' . $id)->with('success', 'Pengecekan berhasil disetujui.');
    }
}
