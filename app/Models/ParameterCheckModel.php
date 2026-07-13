<?php

namespace App\Models;

use CodeIgniter\Model;

class ParameterCheckModel extends Model
{
    protected $table         = 'master_parameter_check';
    protected $primaryKey    = 'id_parameter';
    protected $allowedFields = [
        'lokasi', 'jenis_check', 'kategori', 'bagian_check',
        'point_check', 'standard_check', 'urutan',
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Ambil semua baris parameter untuk kombinasi lokasi + jenis_check,
     * lalu tambahkan info rowspan untuk kolom BAGIAN CHECK dan POINT CHECK
     * supaya tabel di View bisa persis meniru layout form kertas
     * (BAGIAN CHECK dan POINT CHECK yang sama digabung vertikal).
     */
    public function getFormRows(string $lokasi, string $jenisCheck, ?string $kategori = null): array
    {
        $builder = $this->where('lokasi', $lokasi)
                        ->where('jenis_check', $jenisCheck);

        if ($kategori !== null) {
            $builder->where('kategori', $kategori);
        }

        $rows = $builder->orderBy('urutan', 'ASC')
                        ->orderBy('id_parameter', 'ASC')
                        ->findAll();

        $total = count($rows);

        // Hitung rowspan BAGIAN CHECK: jumlah baris berturut-turut dengan
        // bagian_check yang sama.
        for ($i = 0; $i < $total; $i++) {
            if ($i > 0 && $rows[$i]['bagian_check'] === $rows[$i - 1]['bagian_check']) {
                $rows[$i]['show_bagian'] = false;
            } else {
                $span = 1;
                for ($j = $i + 1; $j < $total; $j++) {
                    if ($rows[$j]['bagian_check'] === $rows[$i]['bagian_check']) {
                        $span++;
                    } else {
                        break;
                    }
                }
                $rows[$i]['show_bagian']    = true;
                $rows[$i]['bagian_rowspan'] = $span;
            }
        }

        // Hitung rowspan POINT CHECK: jumlah baris berturut-turut (dalam
        // bagian_check yang sama) dengan point_check yang sama.
        for ($i = 0; $i < $total; $i++) {
            if (
                $i > 0
                && $rows[$i]['point_check'] === $rows[$i - 1]['point_check']
                && $rows[$i]['bagian_check'] === $rows[$i - 1]['bagian_check']
            ) {
                $rows[$i]['show_point'] = false;
            } else {
                $span = 1;
                for ($j = $i + 1; $j < $total; $j++) {
                    if (
                        $rows[$j]['point_check'] === $rows[$i]['point_check']
                        && $rows[$j]['bagian_check'] === $rows[$i]['bagian_check']
                    ) {
                        $span++;
                    } else {
                        break;
                    }
                }
                $rows[$i]['show_point']    = true;
                $rows[$i]['point_rowspan'] = $span;
            }
        }

        return $rows;
    }
}
