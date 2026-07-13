<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3">Dashboard Staff</h5>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="text-muted small">Pengecekan Hari Ini</div>
      <div class="value"><?= (int) $hariIni ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3">
      <div class="text-muted small">Pengecekan 7 Hari Terakhir</div>
      <div class="value"><?= (int) $minggu ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat p-3 d-flex flex-column justify-content-center">
      <a href="<?= site_url('checklist/mfg1-preventive') ?>" class="btn btn-primary">+ Buat Pengecekan Baru</a>
    </div>
  </div>
</div>

<div class="card-stat p-3">
  <div class="fw-semibold mb-3">Riwayat Terbaru</div>
  <?php if (empty($riwayatTerbaru)): ?>
    <p class="text-muted mb-0">Belum ada riwayat pengecekan.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Mesin</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayatTerbaru as $r): ?>
            <tr>
              <td><?= (int) $r['id_transaksi'] ?></td>
              <td><?= esc($r['no_mesin']) ?> - <?= esc($r['type_mesin']) ?></td>
              <td><?= esc($r['waktu_mulai']) ?></td>
              <td><?= esc($r['waktu_selesai'] ?? '-') ?></td>
              <td><a href="<?= site_url('riwayat/' . $r['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
