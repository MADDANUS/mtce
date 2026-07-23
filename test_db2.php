<?php
require 'system/bootstrap.php';
$model = new \App\Models\ParameterCheckModel();
$rows = $model->getFormRows('MFG 1', 'Overhaul', 'Mesin CNC & Bar Feeder');
echo 'Total rows: ' . count($rows) . "\n";
if(count($rows) > 0) {
  echo 'First row kategori: ' . $rows[0]['kategori'] . "\n";
  echo 'First row section: ' . $rows[0]['section_check'] . "\n";
  echo 'Row 50 kategori: ' . $rows[50]['kategori'] . "\n";
  echo 'Row 50 section: ' . $rows[50]['section_check'] . "\n";
}
