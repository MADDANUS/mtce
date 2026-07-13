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
        return view('admin/parameter/index', [
            'title'  => 'Master Parameter Check',
            'daftar' => $this->model->orderBy('lokasi', 'ASC')
                                     ->orderBy('jenis_check', 'ASC')
                                     ->orderBy('urutan', 'ASC')
                                     ->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/parameter/form', [
            'title'     => 'Tambah Parameter Check',
            'parameter' => null,
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
            'bagian_check'   => $this->request->getPost('bagian_check'),
            'point_check'    => $this->request->getPost('point_check'),
            'standard_check' => $this->request->getPost('standard_check'),
            'urutan'         => (int) $this->request->getPost('urutan'),
        ]);

        return redirect()->to('/admin/parameter')->with('success', 'Parameter check berhasil ditambahkan.');
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
            'bagian_check'   => $this->request->getPost('bagian_check'),
            'point_check'    => $this->request->getPost('point_check'),
            'standard_check' => $this->request->getPost('standard_check'),
            'urutan'         => (int) $this->request->getPost('urutan'),
        ]);

        return redirect()->to('/admin/parameter')->with('success', 'Parameter check berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to('/admin/parameter')->with('error', 'Parameter tidak ditemukan.');
        }

        $this->model->delete($id);
        return redirect()->to('/admin/parameter')->with('success', 'Parameter check berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'lokasi'         => 'required|in_list[MFG 1,MFG 2]',
            'jenis_check'    => 'required|in_list[Preventive,Overhaul]',
            'kategori'       => 'required|max_length[100]',
            'bagian_check'   => 'required|max_length[150]',
            'point_check'    => 'required|max_length[150]',
            'standard_check' => 'required|max_length[150]',
            'urutan'         => 'required|is_natural',
        ];
    }
}
