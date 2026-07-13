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
        'penerangan'     => 'Penerangan',
        'kabel-dan-pipa' => 'Kabel dan Pipa',
        'angin-bocor'    => 'Angin Bocor',
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
            ];
        }

        return view('checklist/index', [
            'title'      => "Pilih Kategori - {$jenisName} {$lokasiName}",
            'lokasiSlug' => $lokasiSlug,
            'lokasiName' => $lokasiName,
            'jenisSlug'  => $jenisSlug,
            'jenisName'  => $jenisName,
            'categories' => $categories,
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
            $detailData[] = [
                'id_transaksi' => $idTransaksi,
                'id_parameter' => (int) $idParameter,
                'hasil_check'  => $hasil !== '' ? $hasil : null,
                'ulasan'       => $ulasan[$idParameter] ?? null,
            ];
        }

        if (! empty($detailData)) {
            $this->detailModel->insertBatch($detailData);
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
