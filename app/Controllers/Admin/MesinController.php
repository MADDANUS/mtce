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

    public function export()
    {
        $mesin = $this->model->orderBy('lokasi', 'ASC')->orderBy('no_mesin', 'ASC')->findAll();
        
        $filename = 'mesin_export_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // CSV Header
        fputcsv($output, ['No Mesin', 'Type Mesin', 'Serial Nomor', 'Lokasi']);
        
        foreach ($mesin as $m) {
            fputcsv($output, [
                $m['no_mesin'],
                $m['type_mesin'],
                $m['serial_nomor'],
                $m['lokasi']
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function import()
    {
        $file = $this->request->getFile('file_csv');
        if (! $file || ! $file->isValid() || $file->getExtension() !== 'csv') {
            return redirect()->to('/admin/mesin')->with('error', 'Silakan pilih file CSV yang valid.');
        }
        
        $filePath = $file->getTempName();
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lewati header
            fgetcsv($handle);
            
            $successInsert = 0;
            $successUpdate = 0;
            $errors = [];
            $rowNum = 1;
            
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;
                if (count($row) < 4) {
                    $errors[] = "Baris {$rowNum}: Kolom kurang lengkap. Harus memuat No Mesin, Type Mesin, Serial Nomor, dan Lokasi.";
                    continue;
                }
                
                $noMesin     = trim($row[0]);
                $typeMesin   = trim($row[1]);
                $serialNomor = trim($row[2]);
                $lokasi      = trim($row[3]);
                
                if (empty($noMesin) || empty($typeMesin) || empty($serialNomor) || empty($lokasi)) {
                    $errors[] = "Baris {$rowNum}: Seluruh kolom wajib diisi.";
                    continue;
                }
                
                if (! in_array($lokasi, ['MFG 1', 'MFG 2'], true)) {
                    $errors[] = "Baris {$rowNum}: Lokasi '{$lokasi}' tidak valid. Harus 'MFG 1' atau 'MFG 2'.";
                    continue;
                }
                
                $existing = $this->model->where('no_mesin', $noMesin)->first();
                
                if ($existing) {
                    $this->model->update($existing['id_mesin'], [
                        'type_mesin'   => $typeMesin,
                        'serial_nomor' => $serialNomor,
                        'lokasi'       => $lokasi,
                    ]);
                    $successUpdate++;
                } else {
                    $this->model->insert([
                        'no_mesin'     => $noMesin,
                        'type_mesin'   => $typeMesin,
                        'serial_nomor' => $serialNomor,
                        'lokasi'       => $lokasi,
                    ]);
                    $successInsert++;
                }
            }
            
            fclose($handle);
            
            $msg = "Impor selesai. Ditambahkan: {$successInsert}, Diperbarui: {$successUpdate}.";
            if (! empty($errors)) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", $errors);
                return redirect()->to('/admin/mesin')->with('error', $msg);
            }
            
            return redirect()->to('/admin/mesin')->with('success', $msg);
        }
        
        return redirect()->to('/admin/mesin')->with('error', 'Gagal membuka file CSV.');
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
