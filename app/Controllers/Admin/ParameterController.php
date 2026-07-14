<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ParameterCheckModel;

class ParameterController extends BaseController
{
    protected ParameterCheckModel $model;

    public function __construct()
    {
        $this->model = new ParameterCheckModel();
    }

    public function index()
    {
        $lokasi     = $this->request->getGet('lokasi') ?: 'MFG 1';
        $jenisCheck = $this->request->getGet('jenis_check') ?: 'Preventive';

        // Ambil daftar kategori unik untuk lokasi + jenis check ini
        // Urutkan kategori berdasarkan urutan terkecil (urutan pertama baris parameter)
        $kategoriQuery = $this->model->where('lokasi', $lokasi)
                                     ->where('jenis_check', $jenisCheck)
                                     ->select('kategori, MIN(urutan) as min_urut')
                                     ->groupBy('kategori')
                                     ->orderBy('min_urut', 'ASC')
                                     ->findAll();

        $daftarKategori = array_column($kategoriQuery, 'kategori');

        // Ambil parameter per kategori lengkap dengan rowspan dinamisnya
        $kategoriParameters = [];
        foreach ($daftarKategori as $kat) {
            $kategoriParameters[$kat] = $this->model->getFormRows($lokasi, $jenisCheck, $kat);
        }

        $selectedKategori = $this->request->getGet('kategori') ?: null;

        return view('admin/parameter/index', [
            'title'              => 'Master Parameter Check',
            'lokasi'             => $lokasi,
            'jenisCheck'         => $jenisCheck,
            'daftarKategori'     => $daftarKategori,
            'kategoriParameters' => $kategoriParameters,
            'selectedKategori'   => $selectedKategori,
        ]);
    }

    public function create()
    {
        return view('admin/parameter/form', [
            'title'     => 'Tambah Parameter Check',
            'parameter' => null,
            'prefill'   => [
                'lokasi'      => $this->request->getGet('lokasi') ?: 'MFG 1',
                'jenis_check' => $this->request->getGet('jenis_check') ?: 'Preventive',
                'kategori'    => $this->request->getGet('kategori') ?: '',
            ]
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'lokasi'         => $this->request->getPost('lokasi'),
            'jenis_check'    => $this->request->getPost('jenis_check'),
            'kategori'       => $this->request->getPost('kategori'),
            'section_check'  => $this->request->getPost('section_check') ?: null,
            'bagian_check'   => $this->request->getPost('bagian_check'),
            'sub_item_check' => $this->request->getPost('sub_item_check') ?: null,
            'point_check'    => $this->request->getPost('point_check'),
            'standard_check' => $this->request->getPost('standard_check'),
            'urutan'         => (int) $this->request->getPost('urutan'),
        ]);

        return redirect()->to('/admin/parameter?lokasi=' . urlencode($this->request->getPost('lokasi')) . '&jenis_check=' . urlencode($this->request->getPost('jenis_check')))->with('success', 'Parameter check berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $parameter = $this->model->find($id);
        if (! $parameter) {
            return redirect()->to('/admin/parameter')->with('error', 'Parameter tidak ditemukan.');
        }

        return view('admin/parameter/form', [
            'title'     => 'Edit Parameter Check',
            'parameter' => $parameter,
            'prefill'   => null,
        ]);
    }

    public function update(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to('/admin/parameter')->with('error', 'Parameter tidak ditemukan.');
        }

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'lokasi'         => $this->request->getPost('lokasi'),
            'jenis_check'    => $this->request->getPost('jenis_check'),
            'kategori'       => $this->request->getPost('kategori'),
            'section_check'  => $this->request->getPost('section_check') ?: null,
            'bagian_check'   => $this->request->getPost('bagian_check'),
            'sub_item_check' => $this->request->getPost('sub_item_check') ?: null,
            'point_check'    => $this->request->getPost('point_check'),
            'standard_check' => $this->request->getPost('standard_check'),
            'urutan'         => (int) $this->request->getPost('urutan'),
        ]);

        return redirect()->to('/admin/parameter?lokasi=' . urlencode($this->request->getPost('lokasi')) . '&jenis_check=' . urlencode($this->request->getPost('jenis_check')))->with('success', 'Parameter check berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $parameter = $this->model->find($id);
        if (! $parameter) {
            return redirect()->to('/admin/parameter')->with('error', 'Parameter tidak ditemukan.');
        }

        $this->model->delete($id);
        return redirect()->to('/admin/parameter?lokasi=' . urlencode($parameter['lokasi']) . '&jenis_check=' . urlencode($parameter['jenis_check']))->with('success', 'Parameter check berhasil dihapus.');
    }

    public function fixUrutan()
    {
        $db = \Config\Database::connect();

        // Ambil semua kombinasi lokasi, jenis_check, kategori
        $combinations = $db->table('master_parameter_check')
                           ->select('lokasi, jenis_check, kategori')
                           ->groupBy('lokasi, jenis_check, kategori')
                           ->get()
                           ->getResultArray();

        $totalUpdated = 0;
        foreach ($combinations as $combo) {
            $params = $db->table('master_parameter_check')
                         ->where('lokasi', $combo['lokasi'])
                         ->where('jenis_check', $combo['jenis_check'])
                         ->where('kategori', $combo['kategori'])
                         ->orderBy('urutan', 'ASC')
                         ->orderBy('id_parameter', 'ASC')
                         ->get()
                         ->getResultArray();
            
            $index = 1;
            foreach ($params as $p) {
                $db->table('master_parameter_check')
                   ->where('id_parameter', $p['id_parameter'])
                   ->update(['urutan' => $index]);
                $index++;
                $totalUpdated++;
            }
        }

        return redirect()->to('/admin/parameter')->with('success', "Berhasil mereset penomoran urutan {$totalUpdated} parameter check menjadi mulai dari 1 per kategori!");
    }

    private function rules(): array
    {
        return [
            'lokasi'         => 'required|in_list[MFG 1,MFG 2]',
            'jenis_check'    => 'required|in_list[Preventive,Overhaul]',
            'kategori'       => 'required|max_length[100]',
            'section_check'  => 'permit_empty|max_length[150]',
            'bagian_check'   => 'required|max_length[150]',
            'sub_item_check' => 'permit_empty|max_length[150]',
            'point_check'    => 'required|max_length[150]',
            'standard_check' => 'required|max_length[150]',
            'urutan'         => 'required|is_natural',
        ];
    }
}
