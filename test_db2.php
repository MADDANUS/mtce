<?php
define('ENVIRONMENT', 'development');
require 'system/bootstrap.php';
 = \Config\Services::request();
 = \Config\Database::connect();
 = ->table('transaksi_check')
            ->where('id_mesin', 4)
            ->where('jenis_check', 'Preventive')
            ->where("DATE_FORMAT(created_at, '%Y-%m')", '2026-07')
            ->where('kategori', 'Penerangan');
echo "Count: " . ->countAllResults();
