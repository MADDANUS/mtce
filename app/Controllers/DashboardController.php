<?php

namespace App\Controllers;

use App\Models\MesinModel;
use App\Models\ParameterCheckModel;
use App\Models\TransaksiCheckModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        return match (session()->get('role')) {
            'admin'  => $this->admin(),
            'leader' => $this->leader(),
            default  => $this->staff(),
        };
    }

    private function staff()
    {
        $transaksiModel = new TransaksiCheckModel();
        $userId         = session()->get('user_id');
        $riwayat        = $transaksiModel->getRiwayat($userId);

        $hariIni = 0;
        $minggu  = 0;
        $today   = date('Y-m-d');
        $weekAgo = date('Y-m-d', strtotime('-7 days'));

        foreach ($riwayat as $r) {
            $tgl = substr($r['waktu_mulai'], 0, 10);
            if ($tgl === $today) {
                $hariIni++;
            }
            if ($tgl >= $weekAgo) {
                $minggu++;
            }
        }

        return view('dashboard/staff', [
            'title'         => 'Dashboard Staff',
            'hariIni'       => $hariIni,
            'minggu'        => $minggu,
            'riwayatTerbaru' => array_slice($riwayat, 0, 5),
        ]);
    }

    private function leader()
    {
        $transaksiModel = new TransaksiCheckModel();
        $laporan        = $transaksiModel->getLaporanDurasi();

        $totalTransaksi = count($laporan);
        $totalDurasi    = 0;
        $perluTindakan  = 0; // jumlah temuan Δ / X yang butuh perhatian

        $detailModel = new \App\Models\TransaksiCheckDetailModel();
        $findings    = $detailModel->whereIn('hasil_check', ['Δ', 'X'])->countAllResults();

        foreach ($laporan as $l) {
            if ($l['durasi_detik'] !== null) {
                $totalDurasi += (int) $l['durasi_detik'];
            }
        }
        $rataDetik = $totalTransaksi > 0 ? intdiv($totalDurasi, $totalTransaksi) : 0;

        return view('dashboard/leader', [
            'title'          => 'Dashboard Leader',
            'totalTransaksi' => $totalTransaksi,
            'rataDetik'      => $rataDetik,
            'perluTindakan'  => $findings,
            'terbaru'        => array_slice($laporan, 0, 8),
        ]);
    }

    private function admin()
    {
        return view('dashboard/admin', [
            'title'        => 'Dashboard Admin',
            'totalUser'    => (new UserModel())->countAllResults(),
            'totalMesin'   => (new MesinModel())->countAllResults(),
            'totalParam'   => (new ParameterCheckModel())->countAllResults(),
            'totalTrans'   => (new TransaksiCheckModel())->countAllResults(),
        ]);
    }
}
