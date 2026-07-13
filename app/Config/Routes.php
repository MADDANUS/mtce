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

// Checklist MFG 1 - Preventive (semua role login, dipraktikkan oleh Staff/Admin)
$routes->group('checklist/mfg1-preventive', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'ChecklistController::index');
    $routes->get('create/(:segment)', 'ChecklistController::createMfg1Preventive/$1');
    $routes->post('store', 'ChecklistController::storeMfg1Preventive');
});

// Riwayat & Detail Transaksi (semua role login, scoping data ditangani di controller)
$routes->group('riwayat', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'RiwayatController::index');
    $routes->get('kategori/(:segment)', 'RiwayatController::kategori/$1');
    $routes->get('(:num)', 'RiwayatController::detail/$1');
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
});

// Admin - Master User
$routes->group('admin/user', ['filter' => 'role:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->get('delete/(:num)', 'UserController::delete/$1');
});

// Admin - Master Parameter Check
$routes->group('admin/parameter', ['filter' => 'role:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'ParameterController::index');
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
