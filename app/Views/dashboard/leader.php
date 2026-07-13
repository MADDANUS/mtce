<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3">Dashboard Leader</h5>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="text-muted small">Total Transaksi Pengecekan</div>
      <div class="value"><?= (int) $totalTransaksi ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="text-muted small">Rata-rata Durasi Pengecekan</div>
      <div class="value"><?= gmdate('i \m\e\n\i\t s \d\e\t\i\k', $rataDetik) ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="text-muted small">Temuan Perlu Tindakan (Δ / X)</div>
      <div class="value text-danger"><?= (int) $perluTindakan ?></div>
    </div>
  </div>
</div>

<div class="card-stat p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="fw-semibold">Transaksi Terbaru (Semua Staff)</div>
    <a href="<?= site_url('laporan/durasi') ?>" class="btn btn-sm btn-outline-primary">Lihat Laporan Durasi Lengkap</a>
  </div>
  <?php if (empty($terbaru)): ?>
    <p class="text-muted mb-0">Belum ada transaksi pengecekan.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Staff</th>
            <th>Mesin</th>
            <th>Waktu Mulai</th>
            <th>Durasi</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($terbaru as $t): ?>
            <tr>
              <td><?= (int) $t['id_transaksi'] ?></td>
              <td><?= esc($t['nama_staff']) ?></td>
              <td><?= esc($t['no_mesin']) ?></td>
              <td><?= esc($t['waktu_mulai']) ?></td>
              <td><?= $t['durasi_detik'] !== null ? gmdate('i:s', (int) $t['durasi_detik']) : '-' ?></td>
              <td><a href="<?= site_url('riwayat/' . $t['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
