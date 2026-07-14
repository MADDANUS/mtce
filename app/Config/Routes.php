<?php
/**
 * Tambahkan baris-baris di bawah ini ke dalam file app/Config/Routes.php
 * milik project CodeIgniter 4 Anda (jangan replace seluruh file).
 */

// Default route ("/") -> redirect otomatis sesuai status login
$routes->get('/', static function () {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard');
    }
    return redirect()->to('/login');
});

// Auth
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Dashboard (semua role login, konten beda per role di dalam controller)
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);

// Checklist Dinamis (semua role login, dipraktikkan oleh Staff/Admin)
$routes->group('checklist', ['filter' => 'auth'], static function ($routes) {
    // 1. Pilih Lokasi (mfg1 / mfg2)
    $routes->get('/', 'ChecklistController::pilihLokasi');
    
    // 2. Pilih Jenis Pengecekan (preventive / overhaul)
    $routes->get('(:segment)', 'ChecklistController::pilihJenis/$1');
    
    // 3. Pilih Kategori untuk tipe Preventive / Overhaul
    $routes->get('(:segment)/(:segment)', 'ChecklistController::indexKategori/$1/$2');
    
    // 4. Form Checklist (Create)
    $routes->get('(:segment)/(:segment)/create/(:segment)', 'ChecklistController::create/$1/$2/$3');
    
    // 5. Simpan Pengecekan
    $routes->post('(:segment)/(:segment)/store', 'ChecklistController::store/$1/$2');
});

// Riwayat & Detail Transaksi (semua role login, scoping data ditangani di controller)
$routes->group('riwayat', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'RiwayatController::index');
    $routes->get('lokasi/(:segment)', 'RiwayatController::lokasi/$1');
    $routes->get('kategori/(:segment)', 'RiwayatController::kategori/$1');
    $routes->get('(:num)', 'RiwayatController::detail/$1');
    $routes->post('approve/(:num)', 'RiwayatController::approve/$1', ['filter' => 'role:leader,admin']);
});

// Scan QR Code (semua role login)
$routes->group('scan', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'ScanController::index');
    $routes->get('mesin/(:num)', 'ScanController::mesin/$1');
});

// Ceklis Kontrol Bulanan (semua role login)
$routes->group('kontrol', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'KontrolController::index');
    $routes->post('update-cell', 'KontrolController::updateCell');
});

// Laporan Abnormal Condition (semua role login)
$routes->group('abnormal', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'AbnormalController::index');
    $routes->post('update', 'AbnormalController::update');
});

// Laporan Durasi (khusus Leader & Admin)
$routes->get('laporan/durasi', 'LaporanController::durasi', ['filter' => 'role:leader,admin']);

// Admin - Master Mesin
$routes->group('admin/mesin', ['filter' => 'role:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'MesinController::index');
    $routes->get('create', 'MesinController::create');
    $routes->post('store', 'MesinController::store');
    $routes->get('edit/(:num)', 'MesinController::edit/$1');
    $routes->post('update/(:num)', 'MesinController::update/$1');
    $routes->get('delete/(:num)', 'MesinController::delete/$1');
    $routes->get('export', 'MesinController::export');
    $routes->post('import', 'MesinController::import');
});

// Admin - Master User
$routes->group('admin/user', ['filter' => 'role:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->get('delete/(:num)', 'UserController::delete/$1');
    $routes->get('export', 'UserController::export');
    $routes->post('import', 'UserController::import');
});

// Admin - Master Parameter Check
$routes->group('admin/parameter', ['filter' => 'role:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'ParameterController::index');
    $routes->get('fixUrutan', 'ParameterController::fixUrutan');
    $routes->get('create', 'ParameterController::create');
    $routes->post('store', 'ParameterController::store');
    $routes->get('edit/(:num)', 'ParameterController::edit/$1');
    $routes->post('update/(:num)', 'ParameterController::update/$1');
    $routes->get('delete/(:num)', 'ParameterController::delete/$1');
});

/**
 * Daftarkan alias filter berikut di app/Config/Filters.php, di dalam
 * property $aliases:
 *
 *   public array $aliases = [
 *       ...
 *       'auth' => \App\Filters\AuthFilter::class,
 *       'role' => \App\Filters\RoleFilter::class,
 *   ];
 */
