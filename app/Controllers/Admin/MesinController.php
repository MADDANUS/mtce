<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MesinModel;

class MesinController extends BaseController
{
    protected MesinModel $model;

    public function __construct()
    {
        $this->model = new MesinModel();
    }

    public function index()
    {
        return view('admin/mesin/index', [
            'title'  => 'Master Mesin',
            'daftar' => $this->model->orderBy('lokasi', 'ASC')->orderBy('no_mesin', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/mesin/form', [
            'title' => 'Tambah Mesin',
            'mesin' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'no_mesin'     => $this->request->getPost('no_mesin'),
            'type_mesin'   => $this->request->getPost('type_mesin'),
            'serial_nomor' => $this->request->getPost('serial_nomor'),
            'lokasi'       => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/admin/mesin')->with('success', 'Mesin berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $mesin = $this->model->find($id);
        if (! $mesin) {
            return redirect()->to('/admin/mesin')->with('error', 'Mesin tidak ditemukan.');
        }

        return view('admin/mesin/form', [
            'title' => 'Edit Mesin',
            'mesin' => $mesin,
        ]);
    }

    public function update(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to('/admin/mesin')->with('error', 'Mesin tidak ditemukan.');
        }

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'no_mesin'     => $this->request->getPost('no_mesin'),
            'type_mesin'   => $this->request->getPost('type_mesin'),
            'serial_nomor' => $this->request->getPost('serial_nomor'),
            'lokasi'       => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/admin/mesin')->with('success', 'Mesin berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to('/admin/mesin')->with('error', 'Mesin tidak ditemukan.');
        }

        $this->model->delete($id);
        return redirect()->to('/admin/mesin')->with('success', 'Mesin berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'no_mesin'     => 'required|max_length[50]',
            'type_mesin'   => 'required|max_length[100]',
            'serial_nomor' => 'required|max_length[100]',
            'lokasi'       => 'required|in_list[MFG 1,MFG 2]',
        ];
    }
}
