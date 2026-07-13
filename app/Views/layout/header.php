<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title><?= esc($title ?? 'MTCE') ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background:#f4f5f7; }
    .navbar-brand { font-weight:700; letter-spacing:.5px; }
    .card-stat { border:1px solid #dee2e6; border-radius:.6rem; background:#fff; }
    .card-stat .value { font-size:1.6rem; font-weight:700; }
    table.checklist-table th { background:#eef1f4; text-align:center; vertical-align:middle; font-size:.85rem; }
    table.checklist-table td { vertical-align:middle; font-size:.85rem; }
    table.checklist-table td.bagian-cell { font-weight:600; background:#fafafa; }
    .badge-v { background:#198754; }
    .badge-d { background:#fd7e14; }
    .badge-x { background:#dc3545; }
</style>
</head>
<body>
<?php $role = session()->get('role'); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid" style="max-width:1300px;">
    <a class="navbar-brand" href="<?= site_url('dashboard') ?>">MTCE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard') ?>">Dashboard</a></li>

        <?php if (in_array($role, ['staff', 'admin'], true)): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Buat Pengecekan</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= site_url('checklist/mfg1-preventive/create/penerangan') ?>">Penerangan</a></li>
              <li><a class="dropdown-item" href="<?= site_url('checklist/mfg1-preventive/create/kabel-dan-pipa') ?>">Kabel & Pipa</a></li>
              <li><a class="dropdown-item" href="<?= site_url('checklist/mfg1-preventive/create/angin-bocor') ?>">Angin Bocor</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= site_url('checklist/mfg1-preventive') ?>">Pilih Kategori</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Riwayat Pengecekan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= site_url('riwayat/kategori/penerangan') ?>">Penerangan</a></li>
            <li><a class="dropdown-item" href="<?= site_url('riwayat/kategori/kabel-dan-pipa') ?>">Kabel & Pipa</a></li>
            <li><a class="dropdown-item" href="<?= site_url('riwayat/kategori/angin-bocor') ?>">Angin Bocor</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= site_url('riwayat') ?>">Pilih Kategori</a></li>
          </ul>
        </li>

        <?php if (in_array($role, ['leader', 'admin'], true)): ?>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('laporan/durasi') ?>">Laporan Durasi</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Master Data</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= site_url('admin/mesin') ?>">Mesin</a></li>
              <li><a class="dropdown-item" href="<?= site_url('admin/user') ?>">User</a></li>
              <li><a class="dropdown-item" href="<?= site_url('admin/parameter') ?>">Parameter Check</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
      <span class="navbar-text text-white me-3">
        <?= esc(session()->get('nama')) ?> <span class="badge bg-secondary text-uppercase"><?= esc($role) ?></span>
      </span>
      <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container-fluid pb-5" style="max-width:1300px;">
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>
  <?php if (isset($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
    </div>
  <?php endif; ?>
