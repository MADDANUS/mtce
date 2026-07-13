<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('admin/user/index', [
            'title'  => 'Master User',
            'daftar' => $this->model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/user/form', [
            'title' => 'Tambah User',
            'user'  => null,
        ]);
    }

    public function store()
    {
        $rules = $this->rules();
        $rules['username']   = 'required|max_length[50]|is_unique[users.username]';
        $rules['password']   = 'required|min_length[6]';

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->model->find($id);
        if (! $user) {
            return redirect()->to('/admin/user')->with('error', 'User tidak ditemukan.');
        }

        return view('admin/user/form', [
            'title' => 'Edit User',
            'user'  => $user,
        ]);
    }

    public function update(int $id)
    {
        $existing = $this->model->find($id);
        if (! $existing) {
            return redirect()->to('/admin/user')->with('error', 'User tidak ditemukan.');
        }

        $rules = $this->rules();
        $rules['username'] = "required|max_length[50]|is_unique[users.username,id,{$id}]";
        // password opsional saat edit (kosong = tidak diubah)
        if ($this->request->getPost('password') !== '') {
            $rules['password'] = 'min_length[6]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password') !== '') {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->model->update($id, $data);

        return redirect()->to('/admin/user')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ((int) $id === (int) session()->get('user_id')) {
            return redirect()->to('/admin/user')->with('error', 'Tidak bisa menghapus akun yang sedang login.');
        }

        if (! $this->model->find($id)) {
            return redirect()->to('/admin/user')->with('error', 'User tidak ditemukan.');
        }

        $this->model->delete($id);
        return redirect()->to('/admin/user')->with('success', 'User berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama' => 'required|max_length[100]',
            'role' => 'required|in_list[admin,leader,staff]',
        ];
    }
}
