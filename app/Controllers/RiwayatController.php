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
        'bearing-cam'    => 'Bearing Cam',
        'gearbox'        => 'Gearbox',
        'belt-cam'       => 'Belt Cam',
        'mesin-cnc-bar-feeder' => 'Mesin CNC & Bar Feeder',
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
        
        // Validasi lokasi khusus untuk Leader Produksi
        if (session()->get('role') === 'leader') {
            $userLokasi = session()->get('lokasi');
            if ($userLokasi && $userLokasi !== $lokasiName) {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda hanya dapat mengakses riwayat lokasi ' . $userLokasi);
            }
        }

        $mesinModel = new MesinModel();
        $transaksiModel = new TransaksiCheckModel();

        // Dropdown filter mesin dinamis (hanya mesin yang terdaftar di lokasi ini)
        $daftarMesin = $mesinModel->getByLokasi($lokasiName);

        // Ambil input filter pencarian
        $filters = [
            'lokasi'      => $lokasiName,
            'id_mesin'    => $this->request->getGet('id_mesin') ?: null,
            'jenis_check' => $this->request->getGet('jenis_check') ?: null,
            'kategori'    => $this->request->getGet('kategori') ?: null,
            'tanggal'     => $this->request->getGet('tanggal') ?: null,
            'status'      => $this->request->getGet('status') ?: null,
            'sort_by'     => $this->request->getGet('sort_by') ?: 'id_transaksi',
            'order'       => $this->request->getGet('order') ?: 'desc',
        ];

        // Semua role bisa lihat semua riwayat
        $riwayat = $transaksiModel->getRiwayatFiltered($filters);

        // Pisahkan kategori dropdown berdasarkan Lokasi & Jenis Check secara dinamis
        $parameterModel = new \App\Models\ParameterCheckModel();
        
        // Jenis check pada transaksi_check bisa "Checklist Report", "Preventive", "Overhaul", "Inspection Report"
        // Tapi di master_parameter_check cuma ada "Preventive" dan "Overhaul".
        $jenisDb = (in_array(strtolower($filters['jenis_check']), ['preventive', 'checklist report'])) ? 'Preventive' : 'Overhaul';
        
        $dbCategories = $parameterModel->select('kategori')
            ->where('lokasi', $lokasiName)
            ->where('jenis_check', $jenisDb)
            ->distinct()
            ->findAll();

        $categoriesList = [];
        foreach ($dbCategories as $cat) {
            $slug = strtolower(str_replace(' ', '-', $cat['kategori']));
            $categoriesList[$slug] = $cat['kategori'];
        }

        $jenisLabel = $filters['jenis_check'] === 'Preventive' ? 'Checklist Report' : ($filters['jenis_check'] === 'Overhaul' ? 'Inspection Report' : 'Pengecekan');
        $title = "Riwayat {$jenisLabel} — {$lokasiName}";

        return view('riwayat/index', [
            'title'           => $title,
            'jenisLabel'      => $jenisLabel,
            'lokasiSlug'      => $lokasiSlug,
            'lokasiName'      => $lokasiName,
            'daftarMesin'     => $daftarMesin,
            'categories'      => $categoriesList,
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

        // Semua role bisa lihat semua riwayat (tidak ada pembatasan per user)

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
     * GET /riwayat/edit/(:num)
     * Menampilkan form edit riwayat pengecekan (Khusus Admin).
     */
    public function edit(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $transaksiModel = new TransaksiCheckModel();
        $header = $transaksiModel->getDetailTransaksi($id);
        if (!$header) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $detailModel = new TransaksiCheckDetailModel();
        $details = $detailModel->where('id_transaksi', $id)->findAll();

        $detailsMap = [];
        foreach ($details as $d) {
            $detailsMap[$d['id_parameter']] = $d;
        }

        $mesinModel = new MesinModel();
        $parameterModel = new \App\Models\ParameterCheckModel();
        
        // Convert string ke format routing (slug)
        $lokasiSlug = strtolower(str_replace(' ', '', $header['lokasi_check']));
        $jenisSlug = strtolower(str_replace(' ', '-', $header['jenis_check']));
        $categorySlug = array_search($header['kategori'], $this->categoryMap, true) ?: 'penerangan';
        $waktuMulai = new \CodeIgniter\I18n\Time($header['waktu_mulai']);

        $data = [
            'title'             => "Edit Pengecekan {$header['jenis_check']} - {$header['kategori']}",
            'lokasiSlug'        => $lokasiSlug,
            'lokasiName'        => $header['lokasi_check'],
            'jenisSlug'         => $jenisSlug,
            'jenisName'         => $header['jenis_check'],
            'categorySlug'      => $categorySlug,
            'categoryName'      => $header['kategori'],
            'daftarMesin'       => $mesinModel->getByLokasi($header['lokasi_check']),
            'rows'              => $parameterModel->getFormRows($header['lokasi_check'], $header['jenis_check'], $header['kategori']),
            'masterPic'         => (new \App\Models\PicModel())->findAll(),
            'namaPic'           => $header['nama_pic'],
            'namaStaff'         => $header['nama_staff'],
            'waktuMulai'        => $header['waktu_mulai'],
            'waktuMulaiDisplay' => $waktuMulai->toLocalizedString('dd MMMM yyyy, HH:mm:ss'),
            'idMesin'           => $header['id_mesin'],
            'isEdit'            => true,
            'idTransaksi'       => $id,
            'detailsMap'        => $detailsMap,
        ];

        // Jika overhaul, ambil bar_feeder_type dan support_pic
        if (strtolower($header['jenis_check']) === 'overhaul') {
            $db = \Config\Database::connect();
            $overhaul = $db->table('transaksi_overhaul')->where('id_transaksi', $id)->get()->getRowArray();
            if ($overhaul) {
                $data['barFeederType'] = $overhaul['bar_feeder_type'];
                $data['supportPic'] = $overhaul['support_pic'];
            }
        }

        return view('checklist/form', $data);
    }

    /**
     * POST /riwayat/update/(:num)
     * Menyimpan perubahan dari form edit riwayat pengecekan (Khusus Admin).
     */
    public function update(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $transaksiModel = new TransaksiCheckModel();
        $header = $transaksiModel->find($id);
        if (!$header) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $rules = [
            'id_mesin'    => 'required|numeric',
            'waktu_mulai' => 'required',
            'kategori'    => 'required',
        ];

        if (strtolower($header['jenis_check']) === 'overhaul') {
            $rules['bar_feeder_type'] = 'permit_empty|string';
            $rules['support_pic']     = 'permit_empty|string';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }

        $idMesin      = (int) $this->request->getPost('id_mesin');
        $namaPic      = $this->request->getPost('nama_pic') ?: $header['nama_pic'];
        $waktuMulai   = $this->request->getPost('waktu_mulai');
        $kategoriName = $this->request->getPost('kategori');
        $waktuSelesai = $header['waktu_selesai']; // Tetap pakai waktu selesai asli

        $hasilCheck = $this->request->getPost('hasil_check') ?? [];
        $ulasan     = $this->request->getPost('ulasan') ?? [];

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update Header
        $transaksiModel->update($id, [
            'id_mesin'      => $idMesin,
            'nama_pic'      => $namaPic,
            'kategori'      => $kategoriName,
            'waktu_mulai'   => $waktuMulai,
            'status'        => 'Pending', // Reset approval on edit?
            'approved_by'   => null,
            'approved_at'   => null,
        ]);

        // 2. Delete existing detail & laporan_abnormal
        $detailModel = new TransaksiCheckDetailModel();
        // Delete cascading will handle laporan_abnormal
        $detailModel->where('id_transaksi', $id)->delete();

        // 3. Re-insert Details
        $parameterModel = new \App\Models\ParameterCheckModel();
        foreach ($hasilCheck as $idParameter => $hasil) {
            $idDetail = $detailModel->insert([
                'id_transaksi' => $id,
                'id_parameter' => (int) $idParameter,
                'hasil_check'  => $hasil !== '' ? $hasil : null,
                'ulasan'       => $ulasan[$idParameter] ?? null,
            ]);

            // Save to laporan_abnormal ONLY if status is Δ (segitiga)
            if ($hasil === 'Δ') {
                $paramInfo = $parameterModel->find((int)$idParameter);
                $pointCheckName = $paramInfo ? $paramInfo['point_check'] : 'Parameter #' . $idParameter;
                
                $abnormalDesc = $ulasan[$idParameter] ?? '';
                if (empty($abnormalDesc)) {
                    $abnormalDesc = 'Ditemukan kondisi abnormal (' . $hasil . ')';
                }

                $db->table('laporan_abnormal')->insert([
                    'id_transaksi'       => $id,
                    'id_detail'          => $idDetail,
                    'id_mesin'           => $idMesin,
                    'point_check'        => $pointCheckName,
                    'abnormal_condition' => $abnormalDesc,
                    'pengecekan_tanggal' => date('Y-m-d', strtotime($waktuSelesai)),
                    'pengecekan_pic'     => session()->get('nama') ?: 'Admin', // who edited
                    'created_at'         => $waktuSelesai,
                    'updated_at'         => $waktuSelesai,
                ]);
            }
        }

        // 4. Update Overhaul Table
        if (strtolower($header['jenis_check']) === 'overhaul') {
            $barFeederType = $this->request->getPost('bar_feeder_type');
            $supportPic    = $this->request->getPost('support_pic');
            
            $existing = $db->table('transaksi_overhaul')->where('id_transaksi', $id)->get()->getRowArray();
            if ($existing) {
                $db->table('transaksi_overhaul')->where('id_transaksi', $id)->update([
                    'bar_feeder_type' => $barFeederType ?: null,
                    'support_pic'     => $supportPic ?: null,
                ]);
            } else {
                $db->table('transaksi_overhaul')->insert([
                    'id_transaksi'    => $id,
                    'bar_feeder_type' => $barFeederType ?: null,
                    'support_pic'     => $supportPic ?: null,
                ]);
            }
        }

        // 5. Update Ceklis Kontrol (jika preventive)
        if (strtolower($header['jenis_check']) === 'preventive' || strtolower($header['jenis_check']) === 'checklist report') {
            // Re-calculate
            $combinedUlasan = [];
            foreach ($ulasan as $idParam => $text) {
                $text = trim($text);
                if ($text !== '') {
                    $combinedUlasan[] = $text;
                }
            }
            $ulasanKontrol = !empty($combinedUlasan) ? implode(', ', $combinedUlasan) : null;

            $overallStatus = 'V';
            $hasTriangle   = false;
            $allAreX       = true;
            foreach ($hasilCheck as $hasil) {
                if ($hasil === 'Δ') {
                    $hasTriangle = true;
                    $allAreX = false;
                } elseif ($hasil === 'V') {
                    $allAreX = false;
                } elseif ($hasil !== 'X') {
                    $allAreX = false;
                }
            }
            if ($allAreX && count($hasilCheck) > 0) {
                $overallStatus = 'X';
            } elseif ($hasTriangle) {
                $overallStatus = 'Δ';
            } else {
                $overallStatus = 'V';
            }

            $tanggalCheckDate = date('Y-m-d', strtotime($waktuSelesai));
            
            // Try updating where id_mesin + kategori + tanggal_check matches
            $db->table('ceklis_kontrol')
               ->where('id_mesin', $header['id_mesin'])
               ->where('kategori', $header['kategori'])
               ->where('tanggal_check', $tanggalCheckDate)
               ->update([
                   'id_mesin'     => $idMesin, // in case it changed
                   'status_check' => $overallStatus,
                   'ulasan'       => $ulasanKontrol,
               ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate riwayat.');
        }

        return redirect()->to('/riwayat/' . $id)->with('success', 'Riwayat berhasil diupdate.');
    }

    /**
     * POST /riwayat/delete/(:num)
     * Menghapus riwayat pengecekan (Khusus Admin).
     */
    public function delete(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $transaksiModel = new TransaksiCheckModel();
        $header = $transaksiModel->find($id);
        if (!$header) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Jika tipe checklist ini update ceklis_kontrol, coba hapus
        if (in_array(strtolower($header['jenis_check']), ['preventive', 'checklist report'], true)) {
            $tanggalCheckDate = date('Y-m-d', strtotime($header['waktu_selesai']));
            $db->table('ceklis_kontrol')
               ->where('id_mesin', $header['id_mesin'])
               ->where('kategori', $header['kategori'])
               ->where('tanggal_check', $tanggalCheckDate)
               ->delete();
        }

        // Delete transaksi (transaksi_check_detail, laporan_abnormal, transaksi_overhaul will cascade)
        $transaksiModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus riwayat.');
        }

        return redirect()->back()->with('success', 'Riwayat pengecekan berhasil dihapus.');
    }

    /**
     * POST /riwayat/approve/(:num)
     * Menyetujui laporan pengecekan dan memproses laporan_abnormal & ceklis_kontrol.
     */
    public function approve($idTransaksi)
    {
        $role = session()->get('role');
        if (!in_array($role, ['member', 'sheadprd', 'sheadmtc', 'admin', 'leader'], true)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui laporan.');
        }

        $transaksiModel = new TransaksiCheckModel();
        $transaksi = $transaksiModel->find($idTransaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        if ($role === 'leader') {
            $mesinModel = new \App\Models\MesinModel();
            $mesinInfo = $mesinModel->find($transaksi['id_mesin']);
            if ($mesinInfo && session()->get('lokasi') && $mesinInfo['lokasi'] !== session()->get('lokasi')) {
                return redirect()->back()->with('error', 'Anda hanya dapat menyetujui laporan dari mesin di lokasi ' . session()->get('lokasi'));
            }
        }

        if ($transaksi['status'] === 'Approved') {
            return redirect()->back()->with('error', 'Laporan ini sudah disetujui sepenuhnya.');
        }

        $jenisSlug = strtolower(str_replace(' ', '-', $transaksi['jenis_check']));
        $now = date('Y-m-d H:i:s');
        $userId = session()->get('user_id');
        $waktuSelesai = $transaksi['waktu_selesai'] ?? $now;

        $updateData = [];
        $newStatus = '';

        if ($jenisSlug === 'overhaul') {
            // MULTI-LEVEL APPROVAL UNTUK OVERHAUL
            if ($role === 'admin') {
                $newStatus = 'Approved';
                $updateData = [
                    'status' => 'Approved',
                    'approved_by' => $userId,
                    'approved_at' => $now,
                ];
            } elseif ($role === 'leader') {
                if ($transaksi['status'] !== 'Pending') {
                    return redirect()->back()->with('error', 'Laporan sudah diperiksa (bukan status Pending).');
                }
                $newStatus = 'Approved L1';
                $updateData = [
                    'status' => 'Approved L1',
                    'approval_l1_by' => $userId,
                    'approval_l1_at' => $now,
                ];
            } elseif ($role === 'sheadprd') {
                if ($transaksi['status'] !== 'Approved L1') {
                    return redirect()->back()->with('error', 'Laporan belum diperiksa oleh Leader.');
                }
                $newStatus = 'Approved L2';
                $updateData = [
                    'status' => 'Approved L2',
                    'approval_l2_by' => $userId,
                    'approval_l2_at' => $now,
                ];
            } elseif ($role === 'sheadmtc') {
                if ($transaksi['status'] !== 'Approved L2') {
                    return redirect()->back()->with('error', 'Laporan belum disetujui oleh S. Head Produksi.');
                }
                $newStatus = 'Approved';
                $updateData = [
                    'status' => 'Approved',
                    'approved_by' => $userId,
                    'approved_at' => $now,
                ];
            } else {
                return redirect()->back()->with('error', 'Role Anda tidak memiliki akses persetujuan untuk laporan Overhaul.');
            }
        } else {
            // PREVENTIVE (SINGLE-LEVEL)
            if (!in_array($role, ['admin', 'leader'], true)) {
                return redirect()->back()->with('error', 'Hanya Admin atau Leader yang dapat menyetujui laporan Preventive.');
            }
            $newStatus = 'Approved';
            $updateData = [
                'status' => 'Approved',
                'approved_by' => $userId,
                'approved_at' => $now,
            ];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update status
        $transaksiModel->update($idTransaksi, $updateData);

        // Jika sudah Final (Approved), barulah proses Laporan Abnormal & Ceklis Kontrol
        if ($newStatus === 'Approved') {

        // 2. Fetch details for laporan_abnormal
        $detailModel = new TransaksiCheckDetailModel();
        $details = $detailModel->where('id_transaksi', $idTransaksi)->findAll();
        
        $parameterModel = new \App\Models\ParameterCheckModel();
        
        // Setup data for ceklis_kontrol
        $hasilCheck = [];
        $ulasan = [];
        
        foreach ($details as $d) {
            $idParameter = $d['id_parameter'];
            $hasil       = $d['hasil_check'];
            $ulasanParam = $d['ulasan'];
            
            $hasilCheck[$idParameter] = $hasil;
            $ulasan[$idParameter]     = $ulasanParam;

            // Save to laporan_abnormal ONLY if status is Δ (segitiga)
            if ($hasil === 'Δ') {
                $paramInfo = $parameterModel->find((int)$idParameter);
                $pointCheckName = $paramInfo ? $paramInfo['point_check'] : 'Parameter #' . $idParameter;
                
                $abnormalDesc = $ulasanParam ?? '';
                if (empty($abnormalDesc)) {
                    $abnormalDesc = 'Ditemukan kondisi abnormal (' . $hasil . ')';
                }

                $db->table('laporan_abnormal')->insert([
                    'id_transaksi'       => $idTransaksi,
                    'id_detail'          => $d['id_detail'],
                    'id_mesin'           => $transaksi['id_mesin'],
                    'point_check'        => $pointCheckName,
                    'abnormal_condition' => $abnormalDesc,
                    'pengecekan_tanggal' => date('Y-m-d', strtotime($waktuSelesai)),
                    'pengecekan_pic'     => $transaksi['nama_pic'],
                    'created_at'         => date('Y-m-d H:i:s'),
                    'updated_at'         => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // 3. Simpan atau update Ceklis Kontrol jika jenisnya adalah Preventive
        $jenisSlug = strtolower(str_replace(' ', '-', $transaksi['jenis_check']));
        if ($jenisSlug === 'preventive' || $jenisSlug === 'checklist-report') {
            $kategoriName = $transaksi['kategori'];
            $lokasiName   = $transaksi['lokasi_check'];
            $idMesin      = $transaksi['id_mesin'];
            $picNama      = $transaksi['nama_pic'];

            // Gabungkan ulasan parameter yang tidak kosong
            $combinedUlasan = [];
            foreach ($ulasan as $text) {
                $text = trim($text ?? '');
                if ($text !== '') {
                    $combinedUlasan[] = $text;
                }
            }
            $ulasanKontrol = !empty($combinedUlasan) ? implode(', ', $combinedUlasan) : null;

            // Hitung status keseluruhan (Δ > V) (X diabaikan kecuali semuanya X)
            $overallStatus = 'V';
            $hasTriangle   = false;
            $allAreX       = true;
            foreach ($hasilCheck as $hasil) {
                if ($hasil === 'Δ') {
                    $hasTriangle = true;
                    $allAreX = false;
                } elseif ($hasil === 'V') {
                    $allAreX = false;
                } elseif ($hasil !== 'X') {
                    $allAreX = false;
                }
            }
            if ($allAreX && count($hasilCheck) > 0) {
                $overallStatus = 'X';
            } elseif ($hasTriangle) {
                $overallStatus = 'Δ';
            } else {
                $overallStatus = 'V';
            }

            $bulanTahun = date('Y-m', strtotime($waktuSelesai));
            $tanggalCheckDate = date('Y-m-d', strtotime($waktuSelesai));

            // Ambil jadwal rencana untuk bulan ini
            $schedule = $db->table('jadwal_preventive')
                           ->where('lokasi', $lokasiName)
                           ->where('kategori', $kategoriName)
                           ->where('bulan_tahun', $bulanTahun)
                           ->get()
                           ->getRowArray();

            $outOfPlanDate = null;
            $periodeKe     = null;

            if ($schedule) {
                $tglRencana = strtotime($schedule['tanggal_rencana']);
                $dayOfWeek  = (int) date('N', $tglRencana); 
                $mondayTs   = strtotime('-' . ($dayOfWeek - 1) . ' days', $tglRencana);

                $weekDates = []; 
                for ($d = 0; $d < 5; $d++) {
                    $weekDates[$d + 1] = date('Y-m-d', strtotime("+{$d} days", $mondayTs));
                }

                $matchedCol = array_search($tanggalCheckDate, $weekDates);
                if ($matchedCol !== false) {
                    $periodeKe = (int) $matchedCol;
                } else {
                    $outOfPlanDate = $tanggalCheckDate;
                    $day = (int) date('d', strtotime($waktuSelesai));
                    $periodeKe = intval(($day - 1) / 7) + 1;
                    if ($periodeKe > 5) $periodeKe = 5;
                }
            } else {
                $outOfPlanDate = $tanggalCheckDate;
                $day = (int) date('d', strtotime($waktuSelesai));
                $periodeKe = intval(($day - 1) / 7) + 1;
                if ($periodeKe > 5) $periodeKe = 5;
            }

            $kontrolData = [
                'id_mesin'      => $idMesin,
                'kategori'      => $kategoriName,
                'bulan_tahun'   => $bulanTahun,
                'periode_ke'    => $periodeKe,
                'status_check'  => $overallStatus,
                'pic_nama'      => $picNama,
                'out_of_plan'   => $outOfPlanDate,
                'ulasan'        => $ulasanKontrol,
                'tanggal_check' => $tanggalCheckDate,
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $exist = $db->table('ceklis_kontrol')
                        ->where('id_mesin', $idMesin)
                        ->where('kategori', $kategoriName)
                        ->where('bulan_tahun', $bulanTahun)
                        ->where('periode_ke', $periodeKe)
                        ->get()
                        ->getRowArray();

            if ($exist) {
                $db->table('ceklis_kontrol')
                   ->where('id_kontrol', $exist['id_kontrol'])
                   ->update($kontrolData);
            } else {
                $kontrolData['created_at'] = date('Y-m-d H:i:s');
                $db->table('ceklis_kontrol')->insert($kontrolData);
            }
        }

        } // <-- End of if ($newStatus === 'Approved')

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses persetujuan laporan.');
        }

        if ($newStatus === 'Approved') {
            return redirect()->back()->with('success', 'Laporan berhasil disetujui sepenuhnya. Data kini masuk ke Ceklis Kontrol dan Laporan Abnormal jika ada.');
        } else {
            return redirect()->back()->with('success', 'Laporan berhasil disetujui (Tahap: ' . $newStatus . '). Menunggu persetujuan selanjutnya.');
        }
    }
}
