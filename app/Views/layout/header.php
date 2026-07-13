<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title><?= esc($title ?? 'MTCE') ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Google Fonts (Inter) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    :root {
        --sidebar-bg: #0f172a;
        --sidebar-color: #94a3b8;
        --sidebar-active-color: #ffffff;
        --sidebar-active-bg: #1e293b;
        --primary-color: #4f46e5;
        --body-bg: #f8fafc;
        --card-border: #e2e8f0;
    }
    body {
        font-family: 'Inter', sans-serif;
        background: var(--body-bg);
        color: #1e293b;
        overflow-x: hidden;
        font-size: 0.975rem;
    }
    
    /* Layout */
    .app-container {
        display: flex;
        min-height: 100vh;
    }
    
    /* Sidebar */
    .sidebar {
        width: 260px;
        background: var(--sidebar-bg);
        color: var(--sidebar-color);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        transition: all 0.3s;
        border-right: 1px solid rgba(255,255,255,0.05);
    }
    .sidebar-brand {
        height: 70px;
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        font-weight: 700;
        font-size: 1.25rem;
        color: #ffffff;
        text-decoration: none;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .sidebar-menu {
        flex: 1;
        padding: 1.5rem 0;
        overflow-y: auto;
    }
    .menu-label {
        font-size: 0.825rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1.5rem 1.5rem 0.5rem;
        color: #475569;
        display: block;
    }
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: var(--sidebar-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.975rem;
        border-left: 3px solid transparent;
        transition: all 0.2s;
    }
    .menu-item i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }
    .menu-item:hover {
        color: var(--sidebar-active-color);
        background: var(--sidebar-active-bg);
    }
    .menu-item.active {
        color: var(--sidebar-active-color);
        background: var(--sidebar-active-bg);
        border-left-color: var(--primary-color);
    }
    .sidebar-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.05);
    }
    
    /* Main Content */
    .main-wrapper {
        margin-left: 260px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    
    /* Topbar */
    .topbar {
        height: 70px;
        background: #ffffff;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2rem;
        position: sticky;
        top: 0;
        z-index: 99;
    }
    .topbar-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        color: #0f172a;
    }
    
    /* Content Area */
    .content-area {
        padding: 2rem;
        flex: 1;
    }
    
    /* Modern Card & Stat Box styles */
    .card, .card-stat {
        background: #ffffff !important;
        border: 1px solid var(--card-border) !important;
        border-radius: 0.75rem !important;
        padding: 1.5rem !important;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.05), 0 1px 2px -1px rgb(0 0 0 / 0.05) !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-stat .value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
        margin-top: 0.25rem;
    }
    .card-stat .text-muted {
        font-size: 0.825rem;
        font-weight: 500;
        color: #64748b !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -8px rgba(0,0,0,0.08), 0 4px 12px -2px rgba(0,0,0,0.03) !important;
        border-color: #cbd5e1 !important;
    }
    
    /* Form inputs */
    .form-control, .form-select {
        border-radius: 0.5rem;
        border-color: #cbd5e1;
        padding: 0.65rem 0.9rem;
        font-size: 0.975rem;
        color: #1e293b;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        color: #0f172a;
    }
    .form-control:read-only {
        background-color: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }
    .btn {
        border-radius: 0.5rem;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #4338ca;
        border-color: #4338ca;
    }
    .btn-success {
        background-color: #10b981;
        border-color: #10b981;
    }
    .btn-success:hover, .btn-success:focus {
        background-color: #059669;
        border-color: #059669;
    }
    
    /* Badges */
    .badge {
        font-weight: 600;
        padding: 0.35em 0.65em;
        border-radius: 0.375rem;
    }
    .badge.bg-success {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }
    .badge.bg-warning {
        background-color: #fef3c7 !important;
        color: #92400e !important;
    }
    .badge.bg-secondary {
        background-color: #e2e8f0 !important;
        color: #475569 !important;
    }
    .badge.bg-danger {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
    }
    
    /* General Tables & Checklist Tables Overrides */
    .table-responsive {
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid var(--card-border);
    }
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .table th {
        font-weight: 700 !important;
        font-size: 0.875rem !important;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #475569;
        background-color: #f8fafc !important;
        padding: 1.1rem 1.25rem;
        border: none !important;
        border-bottom: 2px solid #e2e8f0 !important;
        vertical-align: middle;
    }
    .table td {
        padding: 1.1rem 1.25rem !important;
        border: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle;
        font-size: 0.975rem !important;
        color: #334155;
    }
    .table tbody tr:hover td {
        background-color: #f8fafc !important;
    }
    table.checklist-table td.bagian-cell {
        font-weight: 700;
        color: #0f172a;
        background-color: #f8fafc !important;
        border-right: 1px solid #e2e8f0 !important;
    }

    /* Radio Segmented Control - Modern style buttons instead of browser defaults */
    .form-check-inline {
        margin-right: 0.5rem;
        display: inline-block;
    }
    .form-check-input[type="radio"] {
        display: none !important; /* Sembunyikan default input radio bulat */
    }
    .form-check-label {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50% !important;
        border: 2px solid #cbd5e1;
        font-size: 0.95rem;
        font-weight: 700 !important;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        user-select: none;
    }
    /* V Label (OK/Centang) */
    .form-check-input[value="V"] + .form-check-label {
        color: #10b981 !important;
        border-color: #a7f3d0;
        background-color: #ecfdf5;
    }
    .form-check-input[value="V"]:checked + .form-check-label {
        color: #ffffff !important;
        border-color: #10b981;
        background-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        transform: scale(1.05);
    }
    /* Δ Label (Tindakan) */
    .form-check-input[value="Δ"] + .form-check-label {
        color: #f59e0b !important;
        border-color: #fde68a;
        background-color: #fffbeb;
    }
    .form-check-input[value="Δ"]:checked + .form-check-label {
        color: #ffffff !important;
        border-color: #f59e0b;
        background-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25);
        transform: scale(1.05);
    }
    /* X Label (Problem) */
    .form-check-input[value="X"] + .form-check-label {
        color: #f43f5e !important;
        border-color: #fecdd3;
        background-color: #fff1f2;
    }
    .form-check-input[value="X"]:checked + .form-check-label {
        color: #ffffff !important;
        border-color: #f43f5e;
        background-color: #f43f5e;
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.25);
        transform: scale(1.05);
    }
    
    /* Alerts */
    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.02), 0 2px 4px -2px rgb(0 0 0 / 0.02);
    }
    
    /* Scrollbars */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Responsive layout toggles */
    @media (max-width: 991.98px) {
        .sidebar {
            left: -260px;
        }
        .sidebar.show {
            left: 0;
        }
        .main-wrapper {
            margin-left: 0;
        }
    }
</style>
</head>
<body>
<?php 
$role = session()->get('role'); 
$uri = service('uri');
$seg1 = $uri->getSegment(1);
$seg2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
$seg3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : '';
?>
<div class="app-container">
  <!-- Left Sidebar -->
  <aside class="sidebar">
    <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
      <i class="bi bi-shield-fill-check text-primary me-2"></i>MTCE SYSTEM
    </a>
    
    <div class="sidebar-menu">
      <a href="<?= site_url('dashboard') ?>" class="menu-item <?= $seg1 === 'dashboard' ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2-fill"></i>Dashboard
      </a>
      
      <?php if (in_array($role, ['staff', 'admin'], true)): ?>
        <a href="<?= site_url('checklist') ?>" class="menu-item <?= $seg1 === 'checklist' ? 'active' : '' ?>">
          <i class="bi bi-check2-square"></i>Buat Pengecekan
        </a>
      <?php endif; ?>
      
      <a href="<?= site_url('riwayat') ?>" class="menu-item <?= $seg1 === 'riwayat' ? 'active' : '' ?>">
        <i class="bi bi-clock-history"></i>Riwayat Pengecekan
      </a>

      <?php if (in_array($role, ['leader', 'admin'], true)): ?>
        <a href="<?= site_url('laporan/durasi') ?>" class="menu-item <?= $seg1 === 'laporan' ? 'active' : '' ?>">
          <i class="bi bi-bar-chart-line"></i>Laporan Durasi
        </a>
      <?php endif; ?>

      <?php if ($role === 'admin'): ?>
        <span class="menu-label">Master Data</span>
        <a href="<?= site_url('admin/mesin') ?>" class="menu-item <?= $seg2 === 'mesin' ? 'active' : '' ?>">
          <i class="bi bi-gear-wide-connected"></i>Master Mesin
        </a>
        <a href="<?= site_url('admin/user') ?>" class="menu-item <?= $seg2 === 'user' ? 'active' : '' ?>">
          <i class="bi bi-people"></i>Master User
        </a>
        <a href="<?= site_url('admin/parameter') ?>" class="menu-item <?= $seg2 === 'parameter' ? 'active' : '' ?>">
          <i class="bi bi-sliders"></i>Master Parameter
        </a>
      <?php endif; ?>
    </div>
    
    <div class="sidebar-footer">
      <div class="d-flex align-items-center">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
          <i class="bi bi-person-fill"></i>
        </div>
        <div class="overflow-hidden">
          <h6 class="mb-0 text-white text-truncate" style="font-size:0.85rem;"><?= esc(session()->get('nama')) ?></h6>
          <small class="text-uppercase text-muted" style="font-size:0.7rem; font-weight:600;"><?= esc($role) ?></small>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Header Topbar -->
    <header class="topbar shadow-sm">
      <div class="d-flex align-items-center">
        <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <h1 class="topbar-title"><?= esc($title ?? 'Dashboard') ?></h1>
      </div>
      <div>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
          <i class="bi bi-box-arrow-right"></i>Logout
        </a>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="content-area">
      <!-- Flash Alerts -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <?php if (isset($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <ul class="mb-0 ps-3">
            <?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
