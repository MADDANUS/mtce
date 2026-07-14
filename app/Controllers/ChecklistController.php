<?php

namespace App\Controllers;

use App\Models\MesinModel;
use App\Models\ParameterCheckModel;
use App\Models\TransaksiCheckModel;
use App\Models\TransaksiCheckDetailModel;
use CodeIgniter\I18n\Time;

class ChecklistController extends BaseController
{
    protected MesinModel $mesinModel;
    protected ParameterCheckModel $parameterModel;
    protected TransaksiCheckModel $transaksiModel;
    protected TransaksiCheckDetailModel $detailModel;

    public function __construct()
    {
        $this->mesinModel     = new MesinModel();
        $this->parameterModel = new ParameterCheckModel();
        $this->transaksiModel = new TransaksiCheckModel();
        $this->detailModel    = new TransaksiCheckDetailModel();
    }

    private array $categoryMap = [
        // Preventive
        'penerangan'     => 'Penerangan',
        'kabel-dan-pipa' => 'Kabel dan Pipa',
        'angin-bocor'    => 'Angin Bocor',
        'bearing'        => 'Bearing',
        'gearbox'        => 'Gearbox',
        'belt'           => 'Belt',
        // Overhaul
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

    private function resolveJenis(string $slug): string
    {
        return match (strtolower($slug)) {
            'overhaul' => 'Overhaul',
            default    => 'Preventive',
        };
    }

    /**
     * GET /checklist
     * Halaman pilih lokasi (MFG 1 / MFG 2).
     */
    public function pilihLokasi()
    {
        return view('checklist/pilih_lokasi', [
            'title' => 'Pilih Lokasi Pengecekan',
        ]);
    }

    /**
     * GET /checklist/(:segment)
     * Halaman pilih jenis pengecekan (Preventive / Overhaul).
     */
    public function pilihJenis(string $lokasiSlug)
    {
        return view('checklist/pilih_jenis', [
            'title'      => 'Pilih Jenis Pengecekan',
            'lokasiSlug' => $lokasiSlug,
            'lokasiName' => $this->resolveLokasi($lokasiSlug),
        ]);
    }

    /**
     * GET /checklist/(:segment)/(:segment)
     * Halaman pilih kategori berdasarkan jenis (Preventive / Overhaul).
     */
    public function indexKategori(string $lokasiSlug, string $jenisSlug)
    {
        $lokasiName = $this->resolveLokasi($lokasiSlug);
        $jenisName  = $this->resolveJenis($jenisSlug);
        $idMesin    = $this->request->getGet('id_mesin') ?: null;

        // Pisahkan kategori berdasarkan jenis_check
        if (strtolower($jenisSlug) === 'overhaul') {
            $categories = [
                'bar-feeder-cnc' => 'Bar Feeder CNC',
                'mesin-cnc'      => 'Mesin CNC',
            ];
        } else {
            $categories = [
                'penerangan'     => 'Penerangan',
                'kabel-dan-pipa' => 'Kabel dan Pipa',
                'angin-bocor'    => 'Angin Bocor',
                'bearing'        => 'Bearing',
                'gearbox'        => 'Gearbox',
                'belt'           => 'Belt',
            ];
        }

        return view('checklist/index', [
            'title'      => "Pilih Kategori - {$jenisName} {$lokasiName}",
            'lokasiSlug' => $lokasiSlug,
            'lokasiName' => $lokasiName,
            'jenisSlug'  => $jenisSlug,
            'jenisName'  => $jenisName,
            'categories' => $categories,
            'idMesin'    => $idMesin,
        ]);
    }

    /**
     * GET /checklist/(:segment)/(:segment)/create/(:segment)
     * Menampilkan form pengecekan.
     */
    public function create(string $lokasiSlug, string $jenisSlug, string $categorySlug)
    {
        if (! isset($this->categoryMap[$categorySlug])) {
            return redirect()->to("/checklist/{$lokasiSlug}/{$jenisSlug}")->with('error', 'Kategori tidak valid.');
        }

        $lokasiName   = $this->resolveLokasi($lokasiSlug);
        $jenisName    = $this->resolveJenis($jenisSlug);
        $categoryName = $this->categoryMap[$categorySlug];
        $waktuMulai   = Time::now();
        $idMesin      = $this->request->getGet('id_mesin') ?: null;

        $data = [
            'title'             => "Form Pengecekan {$jenisName} - {$categoryName}",
            'lokasiSlug'        => $lokasiSlug,
            'lokasiName'        => $lokasiName,
            'jenisSlug'         => $jenisSlug,
            'jenisName'         => $jenisName,
            'categorySlug'      => $categorySlug,
            'categoryName'      => $categoryName,
            'daftarMesin'       => $this->mesinModel->getByLokasi($lokasiName),
            'rows'              => $this->parameterModel->getFormRows($lokasiName, $jenisName, $categoryName),
            'namaStaff'         => session()->get('nama'),
            'waktuMulai'        => $waktuMulai->toDateTimeString(),
            'waktuMulaiDisplay' => $waktuMulai->toLocalizedString('dd MMMM yyyy, HH:mm:ss'),
            'idMesin'           => $idMesin,
        ];

        return view('checklist/form', $data);
    }

    /**
     * POST /checklist/(:segment)/(:segment)/store
     */
    public function store(string $lokasiSlug, string $jenisSlug)
    {
        $rules = [
            'id_mesin'    => 'required|numeric',
            'waktu_mulai' => 'required',
            'kategori'    => 'required',
        ];

        if (strtolower($jenisSlug) === 'overhaul') {
            $rules['bar_feeder_type'] = 'permit_empty|string';
            $rules['support_pic']     = 'permit_empty|string';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lokasiName   = $this->resolveLokasi($lokasiSlug);
        $jenisName    = $this->resolveJenis($jenisSlug);
        $idMesin      = (int) $this->request->getPost('id_mesin');
        $waktuMulai   = $this->request->getPost('waktu_mulai');
        $kategoriName = $this->request->getPost('kategori');
        $waktuSelesai = Time::now()->toDateTimeString();

        $hasilCheck = $this->request->getPost('hasil_check') ?? [];
        $ulasan     = $this->request->getPost('ulasan') ?? [];

        $categorySlug = array_search($kategoriName, $this->categoryMap, true) ?: 'penerangan';

        $db = \Config\Database::connect();
        $db->transStart();

        $idTransaksi = $this->transaksiModel->insert([
            'id_user'       => session()->get('user_id'),
            'id_mesin'      => $idMesin,
            'lokasi_check'  => $lokasiName,
            'jenis_check'   => $jenisName,
            'kategori'      => $kategoriName,
            'waktu_mulai'   => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'status'        => 'Pending',
        ]);

        $detailData = [];
        foreach ($hasilCheck as $idParameter => $hasil) {
            $idDetail = $this->detailModel->insert([
                'id_transaksi' => $idTransaksi,
                'id_parameter' => (int) $idParameter,
                'hasil_check'  => $hasil !== '' ? $hasil : null,
                'ulasan'       => $ulasan[$idParameter] ?? null,
            ]);

            // Save to laporan_abnormal if status is Δ or X
            if (in_array($hasil, ['Δ', 'X'], true)) {
                $paramInfo = $this->parameterModel->find((int)$idParameter);
                $pointCheckName = $paramInfo ? $paramInfo['point_check'] : 'Parameter #' . $idParameter;
                
                $abnormalDesc = $ulasan[$idParameter] ?? '';
                if (empty($abnormalDesc)) {
                    $abnormalDesc = 'Ditemukan kondisi abnormal (' . $hasil . ')';
                }

                $picNama = $this->request->getPost('pic_nama') ?: 'Staff';

                $db->table('laporan_abnormal')->insert([
                    'id_transaksi'       => $idTransaksi,
                    'id_detail'          => $idDetail,
                    'id_mesin'           => $idMesin,
                    'point_check'        => $pointCheckName,
                    'abnormal_condition' => $abnormalDesc,
                    'pengecekan_tanggal' => date('Y-m-d', strtotime($waktuSelesai)),
                    'pengecekan_pic'     => $picNama,
                    'created_at'         => $waktuSelesai,
                    'updated_at'         => $waktuSelesai,
                ]);
            }
        }

        // Simpan atau update Ceklis Kontrol jika jenisnya adalah Preventive
        if (strtolower($jenisSlug) === 'preventive') {
            $picNama       = $this->request->getPost('pic_nama') ?: 'Staff';
            $isOutOfPlan   = $this->request->getPost('is_out_of_plan') === '1';
            $outOfPlanDate = $isOutOfPlan ? ($this->request->getPost('out_of_plan_date') ?: date('Y-m-d')) : null;
            $ulasanKontrol = $this->request->getPost('ulasan_kontrol') ?: null;

            // Hitung status akumulatif (X > Δ > V)
            $overallStatus = 'V';
            $hasTriangle   = false;
            foreach ($hasilCheck as $hasil) {
                if ($hasil === 'X') {
                    $overallStatus = 'X';
                    break;
                }
                if ($hasil === 'Δ') {
                    $hasTriangle = true;
                }
            }
            if ($overallStatus !== 'X' && $hasTriangle) {
                $overallStatus = 'Δ';
            }

            // Hitung periode ke (1 s.d 5)
            $day = (int) date('d', strtotime($waktuSelesai));
            $periodeKe = intval(($day - 1) / 7) + 1;
            if ($periodeKe > 5) {
                $periodeKe = 5;
            }

            $bulanTahun = date('Y-m', strtotime($waktuSelesai));

            $kontrolData = [
                'id_mesin'      => $idMesin,
                'kategori'      => $kategoriName,
                'bulan_tahun'   => $bulanTahun,
                'periode_ke'    => $periodeKe,
                'status_check'  => $overallStatus,
                'pic_nama'      => $picNama,
                'out_of_plan'   => $outOfPlanDate,
                'ulasan'        => $ulasanKontrol,
                'tanggal_check' => date('Y-m-d', strtotime($waktuSelesai)),
                'updated_at'    => $waktuSelesai,
            ];

            // Cek apakah sudah terisi di database untuk periode ini
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
                $kontrolData['created_at'] = $waktuSelesai;
                $db->table('ceklis_kontrol')->insert($kontrolData);
            }
        }

        // Simpan metadata khusus Overhaul (Opsi C: Tabel transaksi_overhaul)
        if (strtolower($jenisSlug) === 'overhaul') {
            $db->table('transaksi_overhaul')->insert([
                'id_transaksi'    => $idTransaksi,
                'bar_feeder_type' => $this->request->getPost('bar_feeder_type') ?: null,
                'support_pic'     => $this->request->getPost('support_pic') ?: null,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data pengecekan.');
        }

        if (strtolower($jenisSlug) === 'preventive') {
            $redirectParams = [
                'lokasi'   => $lokasiName,
                'kategori' => $kategoriName,
                'bulan'    => $bulanTahun,
                'auto'     => 1
            ];
            $redirectUrl = site_url('kontrol') . '?' . http_build_query($redirectParams);
            return redirect()->to($redirectUrl)->with('success', 'Pengecekan berhasil disimpan. Mengalihkan ke Ceklis Kontrol...');
        }

        return redirect()->to("/checklist/{$lokasiSlug}/{$jenisSlug}/create/{$categorySlug}")
                          ->with('success', 'Pengecekan berhasil disimpan. Durasi: '
                              . $this->formatDurasi($waktuMulai, $waktuSelesai));
    }

    /**
     * GET /checklist/(:segment)/overhaul
     * Halaman placeholder Overhaul.
     */
    public function overhaulPlaceholder(string $lokasiSlug)
    {
        // Sejak Overhaul sudah aktif, kita redirect ke indexKategori
        return redirect()->to("/checklist/{$lokasiSlug}/overhaul");
    }

    private function formatDurasi(string $mulai, string $selesai): string
    {
        $detik = strtotime($selesai) - strtotime($mulai);
        $menit = intdiv($detik, 60);
        $sisaDetik = $detik % 60;

        return "{$menit} menit {$sisaDetik} detik";
    }
}
