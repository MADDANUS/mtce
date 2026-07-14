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
    /* ============================================================
       GLOBAL DESIGN SYSTEM - MTCE (Modern Minimalist)
       Font: Inter | Palette: Slate + Indigo accent
    ============================================================ */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    :root {
        --sidebar-w: 240px;
        --sidebar-bg: #111827;
        --sidebar-item: #9ca3af;
        --sidebar-active: #ffffff;
        --sidebar-active-bg: rgba(255,255,255,0.08);
        --sidebar-border: rgba(255,255,255,0.06);
        --accent: #4f46e5;
        --accent-hover: #4338ca;
        --accent-light: #eef2ff;
        --body-bg: #f3f4f6;
        --white: #ffffff;
        --border: #e5e7eb;
        --border-strong: #d1d5db;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --text-muted: #9ca3af;
        --success: #059669;
        --success-bg: #d1fae5;
        --warning: #d97706;
        --warning-bg: #fef3c7;
        --danger: #dc2626;
        --danger-bg: #fee2e2;
        --radius-sm: 6px;
        --radius: 10px;
        --radius-lg: 14px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.07);
        --shadow: 0 4px 12px rgba(0,0,0,0.07);
    }

    *, *::before, *::after { box-sizing: border-box; }

    html { font-size: 14px; }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--body-bg);
        color: var(--text-primary);
        overflow-x: hidden;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    /* ---- LAYOUT ---- */
    .app-container { display: flex; min-height: 100vh; }

    /* ---- SIDEBAR ---- */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--sidebar-bg);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 200;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--sidebar-border);
        transition: left 0.25s ease;
    }
    .sidebar-brand {
        height: 64px;
        display: flex;
        align-items: center;
        padding: 0 1.25rem;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: -0.01em;
        color: #ffffff;
        text-decoration: none;
        border-bottom: 1px solid var(--sidebar-border);
        gap: 0.6rem;
    }
    .sidebar-brand .brand-icon {
        width: 32px; height: 32px;
        background: var(--accent);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0;
    }
    .sidebar-menu { flex: 1; padding: 1rem 0; overflow-y: auto; }
    .menu-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--text-muted);
        padding: 1.25rem 1.25rem 0.4rem;
        display: block;
    }
    .menu-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.62rem 1.25rem;
        color: var(--sidebar-item);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0;
        border-left: 3px solid transparent;
        transition: color 0.15s, background 0.15s;
        margin: 1px 0;
    }
    .menu-item i { font-size: 1rem; flex-shrink: 0; }
    .menu-item:hover {
        color: var(--sidebar-active);
        background: var(--sidebar-active-bg);
    }
    .menu-item.active {
        color: var(--sidebar-active);
        background: var(--sidebar-active-bg);
        border-left-color: var(--accent);
    }
    .sidebar-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--sidebar-border);
        display: flex; align-items: center; gap: 0.75rem;
    }
    .sidebar-footer .user-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--accent);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .sidebar-footer .user-name {
        font-size: 0.825rem; font-weight: 600; color: #e5e7eb;
        line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sidebar-footer .user-role {
        font-size: 0.68rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: var(--text-muted);
    }

    /* ---- MAIN WRAPPER ---- */
    .main-wrapper {
        margin-left: var(--sidebar-w);
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    /* ---- TOPBAR ---- */
    .topbar {
        height: 64px;
        background: var(--white);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.75rem;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: var(--shadow-sm);
    }
    .topbar-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.01em;
    }

    /* ---- CONTENT ---- */
    .content-area { padding: 1.75rem; flex: 1; }

    /* ---- PAGE HEADER utility ---- */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .page-header h1, .page-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.01em;
    }

    /* ---- CARDS ---- */
    .card, .card-stat {
        background: var(--white) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-sm) !important;
        transition: box-shadow 0.2s;
    }
    .card-stat { padding: 1.25rem !important; }
    .card-hover:hover {
        box-shadow: var(--shadow) !important;
        border-color: var(--border-strong) !important;
    }
    .card-stat .label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-secondary);
    }
    .card-stat .value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    /* ---- BUTTONS ---- */
    .btn {
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.01em;
        padding: 0.5rem 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.15s;
        border: 1.5px solid transparent;
        line-height: 1.4;
    }
    .btn-sm { padding: 0.38rem 0.8rem; font-size: 0.775rem; }
    .btn-lg { padding: 0.65rem 1.5rem; font-size: 0.875rem; }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }
    .btn-primary:hover, .btn-primary:focus {
        background: var(--accent-hover);
        border-color: var(--accent-hover);
        color: #fff;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
    }
    .btn-success {
        background: var(--success);
        border-color: var(--success);
        color: #fff;
    }
    .btn-success:hover {
        background: #047857;
        border-color: #047857;
        color: #fff;
        box-shadow: 0 0 0 3px rgba(5,150,105,0.2);
    }
    .btn-danger {
        background: var(--danger);
        border-color: var(--danger);
        color: #fff;
    }
    .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }

    .btn-outline-secondary {
        background: transparent;
        border-color: var(--border-strong);
        color: var(--text-secondary);
    }
    .btn-outline-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: var(--text-primary);
    }
    .btn-outline-primary {
        background: transparent;
        border-color: var(--accent);
        color: var(--accent);
    }
    .btn-outline-primary:hover {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
    }
    .btn-outline-danger {
        background: transparent;
        border-color: var(--danger);
        color: var(--danger);
    }
    .btn-outline-danger:hover { background: var(--danger); color: #fff; }

    /* ---- BADGES ---- */
    .badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.3em 0.7em;
        border-radius: 100px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .badge.bg-success { background: var(--success-bg) !important; color: var(--success) !important; }
    .badge.bg-warning { background: var(--warning-bg) !important; color: var(--warning) !important; }
    .badge.bg-danger  { background: var(--danger-bg)  !important; color: var(--danger)  !important; }
    .badge.bg-secondary { background: #f3f4f6 !important; color: #6b7280 !important; }
    .badge.bg-primary { background: var(--accent-light) !important; color: var(--accent) !important; }

    /* ---- TABLES ---- */
    .table-responsive {
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: collapse;
    }
    .table th {
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--text-secondary) !important;
        background: #f9fafb !important;
        padding: 0.85rem 1rem !important;
        border-bottom: 1.5px solid var(--border) !important;
        border-right: none !important;
        border-left: none !important;
        border-top: none !important;
        white-space: nowrap;
        vertical-align: middle;
    }
    .table td {
        padding: 0.85rem 1rem !important;
        border-bottom: 1px solid #f3f4f6 !important;
        border-right: none !important;
        border-left: none !important;
        border-top: none !important;
        font-size: 0.875rem !important;
        color: var(--text-primary) !important;
        vertical-align: middle;
    }
    .table tbody tr:last-child td { border-bottom: none !important; }
    .table tbody tr:hover td { background: #fafafa !important; }

    /* Checklist specific table */
    .checklist-table { border: none !important; }
    .checklist-table th {
        background: #f9fafb !important;
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        color: var(--text-secondary) !important;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        padding: 0.8rem 0.9rem !important;
        border: 1px solid var(--border) !important;
    }
    .checklist-table td {
        padding: 0.75rem 0.9rem !important;
        border: 1px solid #f0f0f0 !important;
        font-size: 0.83rem !important;
        vertical-align: middle;
        color: var(--text-primary) !important;
    }
    .checklist-table td.bagian-cell {
        font-weight: 700;
        color: var(--text-primary) !important;
        background: #f9fafb !important;
        border-right: 2px solid var(--border) !important;
        font-size: 0.82rem !important;
    }
    .checklist-table tr.section-header td {
        background: #1e293b !important;
        color: #ffffff !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.6rem 0.9rem !important;
    }

    /* ---- FORMS ---- */
    .form-control, .form-select {
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        padding: 0.55rem 0.85rem;
        font-size: 0.875rem;
        color: var(--text-primary);
        background: var(--white);
        transition: border-color 0.15s, box-shadow 0.15s;
        line-height: 1.5;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        color: var(--text-primary);
        outline: none;
    }
    .form-control:read-only {
        background: #f9fafb;
        color: var(--text-secondary);
        border-color: var(--border);
    }
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ---- RADIO BUTTONS (Checklist V/Δ/X) ---- */
    .form-check-inline { margin-right: 0.4rem; }
    .form-check-input[type="radio"] { display: none !important; }
    .form-check-label {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 36px; height: 36px;
        border-radius: 50% !important;
        border: 2px solid var(--border);
        font-size: 0.85rem;
        font-weight: 700 !important;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
        background: var(--white);
        color: var(--text-muted);
    }
    /* V Label */
    .form-check-input[value="V"] + .form-check-label {
        color: var(--success) !important;
        border-color: #6ee7b7;
        background: #f0fdf4;
    }
    .form-check-input[value="V"]:checked + .form-check-label {
        color: #fff !important;
        border-color: var(--success);
        background: var(--success);
        box-shadow: 0 0 0 3px rgba(5,150,105,0.2);
    }
    /* Δ Label */
    .form-check-input[value="Δ"] + .form-check-label {
        color: var(--warning) !important;
        border-color: #fcd34d;
        background: #fffbeb;
    }
    .form-check-input[value="Δ"]:checked + .form-check-label {
        color: #fff !important;
        border-color: var(--warning);
        background: var(--warning);
        box-shadow: 0 0 0 3px rgba(217,119,6,0.2);
    }
    /* X Label */
    .form-check-input[value="X"] + .form-check-label {
        color: var(--danger) !important;
        border-color: #fca5a5;
        background: #fff5f5;
    }
    .form-check-input[value="X"]:checked + .form-check-label {
        color: #fff !important;
        border-color: var(--danger);
        background: var(--danger);
        box-shadow: 0 0 0 3px rgba(220,38,38,0.2);
    }

    /* ---- ALERTS ---- */
    .alert {
        border-radius: var(--radius);
        border: none;
        padding: 0.85rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .alert-success { background: var(--success-bg); color: var(--success); }
    .alert-danger { background: var(--danger-bg); color: var(--danger); }
    .alert-warning { background: var(--warning-bg); color: var(--warning); }

    /* ---- SCROLLBAR ---- */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 991.98px) {
        .sidebar { left: calc(-1 * var(--sidebar-w)); }
        .sidebar.show { left: 0; }
        .main-wrapper { margin-left: 0; }
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
      <div class="brand-icon"><i class="bi bi-shield-fill-check text-white"></i></div>
      MTCE SYSTEM
    </a>
    
    <div class="sidebar-menu">
      <a href="<?= site_url('dashboard') ?>" class="menu-item <?= $seg1 === 'dashboard' ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2-fill"></i>Dashboard
      </a>
      
      <?php if (in_array($role, ['staff', 'admin'], true)): ?>
        <a href="<?= site_url('checklist') ?>" class="menu-item <?= $seg1 === 'checklist' ? 'active' : '' ?>">
          <i class="bi bi-check2-square"></i>Buat Pengecekan
        </a>
        <a href="<?= site_url('scan') ?>" class="menu-item <?= $seg1 === 'scan' ? 'active' : '' ?>">
          <i class="bi bi-qr-code-scan"></i>Scan QR Mesin
        </a>
      <?php endif; ?>
      
      <a href="<?= site_url('riwayat') ?>" class="menu-item <?= $seg1 === 'riwayat' ? 'active' : '' ?>">
        <i class="bi bi-clock-history"></i>Riwayat Pengecekan
      </a>
      <a href="<?= site_url('kontrol') ?>" class="menu-item <?= $seg1 === 'kontrol' ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i>Ceklis Kontrol
      </a>
      <a href="<?= site_url('abnormal') ?>" class="menu-item <?= $seg1 === 'abnormal' ? 'active' : '' ?>">
        <i class="bi bi-exclamation-triangle"></i>Laporan Abnormal
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
      <div class="user-avatar"><?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?></div>
      <div class="overflow-hidden">
        <div class="user-name"><?= esc(session()->get('nama')) ?></div>
        <div class="user-role"><?= esc($role) ?></div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Header Topbar -->
    <header class="topbar">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle" style="padding:0.35rem 0.6rem;">
          <i class="bi bi-list"></i>
        </button>
        <h1 class="topbar-title"><?= esc($title ?? 'Dashboard') ?></h1>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-secondary" style="color:var(--danger); border-color:var(--danger);">
          <i class="bi bi-box-arrow-right"></i> Keluar
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
