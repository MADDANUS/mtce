<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'mtce_db');
$res = $mysqli->query('SELECT id_transaksi, nama_pic, id_user FROM transaksi_check ORDER BY id_transaksi DESC LIMIT 3');
while($row = $res->fetch_assoc()) { print_r($row); }
