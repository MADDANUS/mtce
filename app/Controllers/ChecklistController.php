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
    ];

    public function index()
    {
        return view('checklist/index', [
            'title'      => 'Pilih Kategori Pengecekan',
            'categories' => $this->categoryMap,
        ]);
    }

    /**
     * GET /checklist/mfg1-preventive/create/(:segment)
     * Menampilkan form pengecekan Preventive MFG 1 per kategori.
     */
    public function createMfg1Preventive(string $categorySlug)
    {
        if (! isset($this->categoryMap[$categorySlug])) {
            return redirect()->to('/checklist/mfg1-preventive')->with('error', 'Kategori tidak valid.');
        }

        $categoryName = $this->categoryMap[$categorySlug];
        $waktuMulai   = Time::now();

        $data = [
            'title'             => 'Form Pengecekan - ' . $categoryName,
            'categorySlug'      => $categorySlug,
            'categoryName'      => $categoryName,
            'daftarMesin'       => $this->mesinModel->getByLokasi('MFG 1'),
            'rows'              => $this->parameterModel->getFormRows('MFG 1', 'Preventive', $categoryName),
            'namaStaff'         => session()->get('nama'),
            'waktuMulai'        => $waktuMulai->toDateTimeString(),
            'waktuMulaiDisplay' => $waktuMulai->toLocalizedString('dd MMMM yyyy, HH:mm:ss'),
        ];

        return view('checklist/mfg1_preventive_form', $data);
    }

    /**
     * POST /checklist/mfg1-preventive/store
     */
    public function storeMfg1Preventive()
    {
        $rules = [
            'id_mesin'    => 'required|numeric',
            'waktu_mulai' => 'required',
            'kategori'    => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

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
            'lokasi_check'  => 'MFG 1',
            'jenis_check'   => 'Preventive',
            'kategori'      => $kategoriName,
            'waktu_mulai'   => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
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

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data pengecekan.');
        }

        return redirect()->to('/checklist/mfg1-preventive/create/' . $categorySlug)
                          ->with('success', 'Pengecekan berhasil disimpan. Durasi: '
                              . $this->formatDurasi($waktuMulai, $waktuSelesai));
    }

    private function formatDurasi(string $mulai, string $selesai): string
    {
        $detik = strtotime($selesai) - strtotime($mulai);
        $menit = intdiv($detik, 60);
        $sisaDetik = $detik % 60;

        return "{$menit} menit {$sisaDetik} detik";
    }
}
