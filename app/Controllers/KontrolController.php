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
        $outOfPlan   = $this->request->getPost('out_of_plan') ?: null;
        $ulasan      = $this->request->getPost('ulasan');

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

        if ($idKontrol && (int)$idKontrol > 0) {
            $this->kontrolModel->update((int)$idKontrol, $data);
        } else {
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

    /**
     * GET /kontrol
     * Dashboard Ceklis Kontrol bulanan.
     */
    public function index()
    {
        $lokasi   = $this->request->getGet('lokasi') ?: 'MFG 1';
        $kategori = $this->request->getGet('kategori') ?: 'Penerangan';
        $bulan    = $this->request->getGet('bulan') ?: date('Y-m');
        $line     = $this->request->getGet('line') ?: null;

        // Daftar kategori khusus Preventive
        if ($lokasi === 'MFG 2') {
            $categories = [
                'Penerangan'     => 'Penerangan',
                'Kabel dan Pipa' => 'Kabel dan Pipa',
                'Angin Bocor'    => 'Angin Bocor',
            ];
        } else {
            $categories = [
                'Penerangan'     => 'Penerangan',
                'Kabel dan Pipa' => 'Kabel dan Pipa',
                'Angin Bocor'    => 'Angin Bocor',
                'Bearing Cam'    => 'Bearing Cam',
                'Gearbox'        => 'Gearbox',
                'Belt Cam'       => 'Belt Cam',
            ];
        }

        // Fallback jika kategori tidak valid untuk lokasi saat ini
        if (!isset($categories[$kategori])) {
            $kategori = 'Penerangan';
        }

        // Buat list 12 bulan terakhir untuk dropdown filter
        $bulanList = [];
        for ($i = 0; $i < 12; $i++) {
            $time = Time::now()->subMonths($i);
            $val  = $time->format('Y-m');
            $label = $time->toLocalizedString('MMMM yyyy');
            $bulanList[$val] = $label;
        }

        $availableLines = [];
        if ($lokasi === 'MFG 1') {
            $availableLines = ['Line 1', 'Line 2', 'Line 3'];
        } elseif ($lokasi === 'MFG 2') {
            $availableLines = ['CG', 'Second'];
        }

        if (empty($line) && !empty($availableLines)) {
            $line = $availableLines[0];
        }

        $grid = $this->kontrolModel->getGridData($lokasi, $kategori, $bulan, $line);

        // Ambil jadwal rencana untuk lokasi, kategori, dan bulan berjalan (maks 1 per bulan)
        $db = \Config\Database::connect();
        $schedule = $db->table('jadwal_preventive')
                       ->where('lokasi', $lokasi)
                       ->where('kategori', $kategori)
                       ->where('bulan_tahun', $bulan)
                       ->get()
                       ->getRowArray();

        // Hitung 5 tanggal hari kerja (Senin-Jumat) dari pekan terjadwal
        $columnDates = []; // Array 5 elemen: tanggal Senin s.d Jumat
        $hasSchedule = false;

        if ($schedule) {
            $hasSchedule    = true;
            $tglRencana     = strtotime($schedule['tanggal_rencana']);
            $dayOfWeek      = (int) date('N', $tglRencana); // 1=Senin ... 7=Minggu
            $mondayTs       = strtotime('-' . ($dayOfWeek - 1) . ' days', $tglRencana);

            for ($d = 0; $d < 5; $d++) {
                $columnDates[$d + 1] = date('Y-m-d', strtotime("+{$d} days", $mondayTs));
            }
        }

        $allChecked = true;
        foreach ($grid as $row) {
            if ($row['pic_nama'] === 'PIC') {
                $allChecked = false;
                break;
            }
        }

        // Ambil status approval beserta nama approver
        $approvalQuery = $db->table('approval_bulanan a')
                       ->select('a.*, u1.nama as l1_name, u2.nama as l2_name, u3.nama as final_name')
                       ->join('users u1', 'u1.id = a.approved_l1_by', 'left')
                       ->join('users u2', 'u2.id = a.approved_l2_by', 'left')
                       ->join('users u3', 'u3.id = a.approved_final_by', 'left')
                       ->where('a.type', 'kontrol')
                       ->where('a.lokasi', $lokasi)
                       ->where('a.kategori', $kategori)
                       ->where('a.bulan_tahun', $bulan);

        if ($line) {
            $approvalQuery->where('a.line', $line);
        } else {
            // Jika tidak ada line yang dipilih, paksakan tidak menemukan approval (atau bisa juga buat kondisi 'IS NULL')
            $approvalQuery->where('a.line', 'NONE');
        }
        
        $approval = $approvalQuery->get()->getRowArray();

        $approvalStatus = $approval ? $approval['status'] : 'Pending';

        return view('kontrol/index', [
            'title'          => 'Ceklis Kontrol Bulanan',
            'lokasi'         => $lokasi,
            'line'           => $line,
            'kategori'       => $kategori,
            'bulan'          => $bulan,
            'categories'     => $categories,
            'availableLines' => $availableLines,
            'bulanList'      => $bulanList,
            'grid'           => $grid,
            'hasSchedule'    => $hasSchedule,
            'columnDates'    => $columnDates,
            'allChecked'     => $allChecked,
            'approvalStatus' => $approvalStatus,
            'approvalData'   => $approval,
        ]);
    }

    /**
     * POST /kontrol/approve
     */
    public function approveBulanan()
    {
        $role = session()->get('role');
        if (!in_array($role, ['member', 'sheadprd', 'sheadmtc', 'admin'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $lokasi   = $this->request->getPost('lokasi');
        $line     = $this->request->getPost('line');
        $kategori = $this->request->getPost('kategori');
        $bulan    = $this->request->getPost('bulan_tahun');

        if (empty($line)) {
            return redirect()->back()->with('error', 'Silakan pilih Line terlebih dahulu untuk melakukan persetujuan.');
        }

        $db = \Config\Database::connect();
        $approval = $db->table('approval_bulanan')
                       ->where('type', 'kontrol')
                       ->where('lokasi', $lokasi)
                       ->where('line', $line)
                       ->where('kategori', $kategori)
                       ->where('bulan_tahun', $bulan)
                       ->get()
                       ->getRowArray();

        $currentStatus = $approval ? $approval['status'] : 'Pending';
        $userId        = session()->get('user_id');
        $now           = date('Y-m-d H:i:s');

        $data = [
            'type'        => 'kontrol',
            'lokasi'      => $lokasi,
            'line'        => $line,
            'kategori'    => $kategori,
            'bulan_tahun' => $bulan,
            'updated_at'  => $now,
        ];

        // Admin override
        if ($role === 'admin') {
            $data['status'] = 'Approved Final';
            $data['approved_final_by'] = $userId;
            $data['approved_final_at'] = $now;
        } elseif ($role === 'member') {
            if ($currentStatus !== 'Pending') return redirect()->back()->with('error', 'Sudah diproses L1.');
            
            $picLineNama = $this->request->getPost('pic_line_nama');
            if (empty(trim($picLineNama))) {
                return redirect()->back()->with('error', 'Nama PIC Line wajib diisi.');
            }
            
            $data['status'] = 'Approved L1';
            $data['approved_l1_by'] = $userId;
            $data['pic_line_nama']  = trim($picLineNama);
            $data['approved_l1_at'] = $now;
        } elseif ($role === 'sheadprd') {
            if ($currentStatus !== 'Approved L1') return redirect()->back()->with('error', 'Belum disetujui L1.');
            $data['status'] = 'Approved L2';
            $data['approved_l2_by'] = $userId;
            $data['approved_l2_at'] = $now;
        } elseif ($role === 'sheadmtc') {
            if ($currentStatus !== 'Approved L2') return redirect()->back()->with('error', 'Belum disetujui L2.');
            $data['status'] = 'Approved Final';
            $data['approved_final_by'] = $userId;
            $data['approved_final_at'] = $now;
        }

        if ($approval) {
            $db->table('approval_bulanan')->where('id_approval', $approval['id_approval'])->update($data);
        } else {
            $data['created_at'] = $now;
            $db->table('approval_bulanan')->insert($data);
        }

        return redirect()->back()->with('success', 'Berhasil menyetujui Ceklis Kontrol bulanan.');
    }
}
