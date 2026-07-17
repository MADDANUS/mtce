<?php

namespace App\Controllers;

use App\Models\TransaksiCheckModel;

class LaporanController extends BaseController
{
    public function durasi()
    {
        $role = session()->get('role');
        $lokasi = ($role === 'leader') ? session()->get('lokasi') : null;
        
        $laporan = (new TransaksiCheckModel())->getLaporanDurasi($lokasi);

        $totalDurasi = 0;
        $count       = 0;
        foreach ($laporan as $l) {
            if ($l['durasi_detik'] !== null) {
                $totalDurasi += (int) $l['durasi_detik'];
                $count++;
            }
        }
        $rataDetik = $count > 0 ? intdiv($totalDurasi, $count) : 0;

        return view('laporan/durasi', [
            'title'     => 'Laporan Durasi Pengecekan',
            'laporan'   => $laporan,
            'rataDetik' => $rataDetik,
        ]);
    }
}
