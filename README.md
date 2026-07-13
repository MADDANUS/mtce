# MTCE - Aplikasi Pengecekan Bengkel (Web Lengkap, Fase 1 MVP scope MFG 1 Preventive)

## Isi Paket

```
app/Database/Migrations/   -> 5 migration (users, master_mesin,
                               master_parameter_check, transaksi_check,
                               transaksi_check_detail)
app/Database/Seeds/        -> DatabaseSeeder + seeder 43 baris parameter
                               MFG 1 Preventive (disalin dari 3 foto form)
app/Models/                -> UserModel, MesinModel, ParameterCheckModel,
                               TransaksiCheckModel, TransaksiCheckDetailModel
app/Controllers/           -> Auth, DashboardController, ChecklistController,
                               RiwayatController, LaporanController
app/Controllers/Admin/     -> MesinController, UserController, ParameterController (CRUD)
app/Filters/                -> AuthFilter (cek login), RoleFilter (cek role)
app/Views/layout/          -> header.php (navbar per-role) & footer.php
app/Views/auth/            -> login.php
app/Views/checklist/       -> mfg1_preventive_form.php
app/Views/dashboard/       -> staff.php, leader.php, admin.php
app/Views/riwayat/         -> index.php, detail.php
app/Views/laporan/         -> durasi.php
app/Views/admin/mesin/     -> index.php, form.php
app/Views/admin/user/      -> index.php, form.php
app/Views/admin/parameter/ -> index.php, form.php
app/Config/Routes_snippet.php -> baris route yang perlu ditambahkan manual
```

Paket ini berisi **file-file aplikasi (app/)** saja, bukan skeleton CI4
lengkap (environment saya tidak bisa akses Packagist untuk composer).

## Fitur per Role

**Staff**

- Dashboard: jumlah pengecekan hari ini & 7 hari terakhir, riwayat terbaru.
- Buat Pengecekan Preventive MFG 1 (waktu otomatis, lihat detail sebelumnya).
- Riwayat Pengecekan: hanya melihat transaksi miliknya sendiri + detail
  hasil per parameter (badge V/Δ/X).

**Leader**

- Dashboard: total transaksi, rata-rata durasi, jumlah temuan Δ/X yang
  perlu tindakan, tabel transaksi terbaru semua staff.
- Riwayat Pengecekan: melihat semua transaksi semua staff + detail.
- Laporan Durasi: tabel semua transaksi dengan durasi pengerjaan, untuk
  analisis efisiensi.

**Admin**

- Dashboard: ringkasan jumlah user, mesin, parameter, transaksi + link
  cepat ke Master Data.
- CRUD Master Mesin (no mesin, type, serial, lokasi MFG 1/MFG 2).
- CRUD Master User (nama, username, password, role admin/leader/staff).
- CRUD Master Parameter Check (kategori, bagian check, point check,
  standard check, urutan) -- ini yang menentukan isi & urutan tabel di
  form pengecekan, termasuk pengelompokan rowspan BAGIAN CHECK/POINT CHECK.
- Juga bisa mengakses Laporan Durasi & Buat Pengecekan.

## Cara Pasang

### 1. Buat project CodeIgniter 4 (jika belum ada)

```bash
composer create-project codeigniter4/appstarter mtce
```

### 2. Salin isi folder `app/` di paket ini ke `app/` project Anda

Timpa/merge folder Migrations, Seeds, Models, Controllers, Filters, Views
sesuai struktur di atas.

### 3. Set koneksi database (`.env`)

```
database.default.hostname = localhost
database.default.database = mtce_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.charset  = utf8mb4
database.default.DBCollat = utf8mb4_general_ci
```

> **Penting:** gunakan charset **utf8mb4**, karena kolom `hasil_check`
> menyimpan karakter `Δ` (Delta) sebagai salah satu nilai ENUM.

### 4. Jalankan migration & seeder

```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

Seeder membuat:

- 3 akun demo: `panji` (staff), `leader1` (leader), `admin` (admin) —
  password semua akun demo: `password123`
- 2 mesin contoh di MFG 1
- 43 baris `master_parameter_check` untuk MFG 1 Preventive, sesuai 3
  foto form kertas (Penerangan, Angin Bocor, Kabel dan Pipa).

### 5. Tambahkan routes & filter alias

Salin isi `app/Config/Routes_snippet.php` ke `app/Config/Routes.php`,
lalu daftarkan alias filter `auth` dan `role` di `app/Config/Filters.php`
(lihat komentar di bagian bawah file snippet):

```php
public array $aliases = [
    ...
    'auth' => \App\Filters\AuthFilter::class,
    'role' => \App\Filters\RoleFilter::class,
];
```

### 6. Jalankan

```bash
php spark serve
```

Buka `http://localhost:8080/`, login sebagai salah satu akun demo di
atas -> otomatis diarahkan ke Dashboard sesuai role.

## Catatan Teknis

- Waktu `waktu_mulai` ditangkap otomatis saat form dibuka, `waktu_selesai`
  ditangkap otomatis saat submit -- tidak ada input waktu manual sama
  sekali (lihat `ChecklistController`).
- Rowspan BAGIAN CHECK / POINT CHECK di tabel form dihitung otomatis di
  `ParameterCheckModel::getFormRows()` dari data `master_parameter_check`,
  bukan hardcode di View -- jadi kalau Admin ubah data parameter lewat
  CRUD, tampilan form ikut menyesuaikan.
- Kolom **PIC** dan **PIC LINE** dari form fisik sengaja **tidak**
  diimplementasikan, sesuai batasan Fase 1 di spesifikasi awal.
- Scope saat ini tetap **MFG 1 Preventive** saja (MFG 2 & Overhaul belum
  dibuat, sesuai keputusan terakhir), tapi struktur tabel & CRUD Parameter
  Check sudah mendukung kalau nanti mau ditambah lokasi/jenis lain --
  tinggal tambah data di Master Parameter Check dan controller/route baru
  yang serupa `ChecklistController`.
