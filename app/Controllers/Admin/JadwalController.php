<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalPreventiveModel;

class JadwalController extends BaseController
{
    protected JadwalPreventiveModel $jadwalModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalPreventiveModel();
    }

    /**
     * GET /admin/jadwal
     */
    public function index()
    {
        $categories = [
            'Penerangan'     => 'Penerangan',
            'Kabel dan Pipa' => 'Kabel dan Pipa',
            'Angin Bocor'    => 'Angin Bocor',
            'Bearing Cam'    => 'Bearing Cam',
            'Gearbox'        => 'Gearbox',
            'Belt Cam'       => 'Belt Cam',
        ];

        // Buat list 12 bulan ke depan untuk dropdown
        $months = [];
        for ($i = -2; $i < 10; $i++) {
            $time = \CodeIgniter\I18n\Time::now()->addMonths($i);
            $val  = $time->format('Y-m');
            $label = $time->toLocalizedString('MMMM yyyy');
            $months[$val] = $label;
        }

        return view('admin/jadwal/index', [
            'title'      => 'Jadwal Pengecekan Preventive',
            'categories' => $categories,
            'months'     => $months,
        ]);
    }

    /**
     * GET /admin/jadwal/events
     */
    public function events()
    {
        $schedules = $this->jadwalModel->findAll();

        $events = [];
        foreach ($schedules as $s) {
            $periodeKe = (int) $s['periode_ke'];

            // Hitung Senin dan Sabtu (exclusive end) dari tanggal_rencana yang sebenarnya
            $tglRencana = strtotime($s['tanggal_rencana']);
            $dayOfWeek  = (int) date('N', $tglRencana); // 1=Senin ... 7=Minggu
            $mondayTs   = strtotime('-' . ($dayOfWeek - 1) . ' days', $tglRencana);
            $saturdayTs = strtotime('+5 days', $mondayTs);

            $startDate = date('Y-m-d', $mondayTs);
            $endDate   = date('Y-m-d', $saturdayTs); // FullCalendar end exclusive = Sabtu → bar sampai Jumat

            // Warna penanda mfg
            $color = $s['lokasi'] === 'MFG 1' ? '#0d6efd' : '#198754'; // Biru mfg 1, hijau mfg 2

            // Label: tampilkan rentang tanggal Senin-Jumat di judul
            $fridayTs = strtotime('+4 days', $mondayTs);
            $label = esc($s['lokasi'] . ' - ' . $s['kategori'] . ' (' . date('d', $mondayTs) . '-' . date('d', $fridayTs) . '/' . date('m', $mondayTs) . ')');

            $events[] = [
                'id'              => (int) $s['id_jadwal'],
                'title'           => $label,
                'start'           => $startDate,
                'end'             => $endDate,
                'allDay'          => true,
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'textColor'       => '#ffffff',
                'extendedProps'   => [
                    'lokasi'          => $s['lokasi'],
                    'kategori'        => $s['kategori'],
                    'bulanTahun'      => $s['bulan_tahun'],
                    'periodeKe'       => $s['periode_ke'],
                    'tanggalRencana'  => $s['tanggal_rencana']
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * POST /admin/jadwal/store
     */
    public function store()
    {
        if (!in_array(session()->get('role'), ['admin', 'member'], true)) {
            return redirect()->back()->with('error', 'Hanya Admin dan Member yang dapat membuat jadwal.');
        }

        $rules = [
            'lokasi'          => 'required|in_list[MFG 1,MFG 2]',
            'kategori'        => 'required',
            'tanggal_rencana' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lokasi         = $this->request->getPost('lokasi');
        $kategori       = $this->request->getPost('kategori');
        $tanggalRencana = $this->request->getPost('tanggal_rencana');

        // Hitung bulan_tahun dan periode_ke otomatis dari tanggal_rencana
        $bulanTahun = date('Y-m', strtotime($tanggalRencana));
        $day        = (int) date('d', strtotime($tanggalRencana));
        $periodeKe  = intval(($day - 1) / 7) + 1;
        if ($periodeKe > 5) {
            $periodeKe = 5;
        }

        // Cek duplikasi bulanan: Kategori per lokasi hanya boleh dijadwalkan SATU kali per bulan
        $exist = $this->jadwalModel->where('lokasi', $lokasi)
                                   ->where('kategori', $kategori)
                                   ->where('bulan_tahun', $bulanTahun)
                                   ->first();

        if ($exist) {
            $existDate = date('d/m/Y', strtotime($exist['tanggal_rencana']));
            return redirect()->back()->withInput()->with('error', "Jadwal untuk {$lokasi} - {$kategori} pada bulan ini sudah terdaftar (tanggal {$existDate}, Pekan ke-{$exist['periode_ke']}). Hapus jadwal lama terlebih dahulu jika ingin mengubah.");
        }

        $this->jadwalModel->insert([
            'lokasi'          => $lokasi,
            'kategori'        => $kategori,
            'bulan_tahun'     => $bulanTahun,
            'periode_ke'      => $periodeKe,
            'tanggal_rencana' => $tanggalRencana,
        ]);

        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal preventive berhasil disimpan.');
    }

    /**
     * POST /admin/jadwal/delete/(:num)
     */
    public function delete(int $id)
    {
        if (!in_array(session()->get('role'), ['admin', 'member'], true)) {
            return redirect()->back()->with('error', 'Hanya Admin dan Member yang dapat menghapus jadwal.');
        }

        $schedule = $this->jadwalModel->find($id);

        if (!$schedule) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        $this->jadwalModel->delete($id);

        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal preventive berhasil dihapus.');
    }
}
