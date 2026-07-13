<?php

namespace App\Controllers;

use App\Models\TransaksiCheckDetailModel;
use App\Models\TransaksiCheckModel;

class RiwayatController extends BaseController
{
    private array $categoryMap = [
        'penerangan'     => 'Penerangan',
        'kabel-dan-pipa' => 'Kabel dan Pipa',
        'angin-bocor'    => 'Angin Bocor',
        'bar-feeder-cnc' => 'Bar Feeder CNC',
        'mesin-cnc'      => 'Mesin CNC',
    ];

    public function index()
    {
        return view('riwayat/landing', [
            'title'      => 'Pilih Kategori Riwayat',
            'categories' => $this->categoryMap,
        ]);
    }

    public function kategori(string $categorySlug)
    {
        if (! isset($this->categoryMap[$categorySlug])) {
            return redirect()->to('/riwayat')->with('error', 'Kategori tidak valid.');
        }

        $categoryName   = $this->categoryMap[$categorySlug];
        $transaksiModel = new TransaksiCheckModel();
        $role           = session()->get('role');

        $riwayat = $role === 'staff'
            ? $transaksiModel->getRiwayat(session()->get('user_id'), null, $categoryName)
            : $transaksiModel->getRiwayat(null, null, $categoryName);

        return view('riwayat/index', [
            'title'        => 'Riwayat Pengecekan - ' . $categoryName,
            'categorySlug' => $categorySlug,
            'categoryName' => $categoryName,
            'riwayat'      => $riwayat,
        ]);
    }

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
