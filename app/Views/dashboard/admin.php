<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3">Dashboard Admin</h5>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card-stat p-3">
      <div class="text-muted small">Total User</div>
      <div class="value"><?= (int) $totalUser ?></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-stat p-3">
      <div class="text-muted small">Total Mesin</div>
      <div class="value"><?= (int) $totalMesin ?></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-stat p-3">
      <div class="text-muted small">Total Parameter Check</div>
      <div class="value"><?= (int) $totalParam ?></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-stat p-3">
      <div class="text-muted small">Total Transaksi</div>
      <div class="value"><?= (int) $totalTrans ?></div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="fw-semibold mb-2">Master Mesin</div>
      <p class="text-muted small">Kelola daftar mesin di setiap lokasi.</p>
      <a href="<?= site_url('admin/mesin') ?>" class="btn btn-sm btn-primary">Kelola Mesin</a>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="fw-semibold mb-2">Master User</div>
      <p class="text-muted small">Kelola akun Staff, Leader, dan Admin.</p>
      <a href="<?= site_url('admin/user') ?>" class="btn btn-sm btn-primary">Kelola User</a>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="fw-semibold mb-2">Master Parameter Check</div>
      <p class="text-muted small">Kelola baris pertanyaan form pengecekan.</p>
      <a href="<?= site_url('admin/parameter') ?>" class="btn btn-sm btn-primary">Kelola Parameter</a>
    </div>
  </div>
</div>

<?= view('layout/footer') ?>
