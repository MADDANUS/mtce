<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3">Laporan Durasi Pengecekan (Efisiensi)</h5>

<div class="card-stat p-3 mb-3" style="max-width:320px;">
  <div class="text-muted small">Rata-rata Durasi Semua Transaksi</div>
  <div class="value"><?= gmdate('i \m\e\n\i\t s \d\e\t\i\k', $rataDetik) ?></div>
</div>

<div class="card-stat p-3">
  <?php if (empty($laporan)): ?>
    <p class="text-muted mb-0">Belum ada data transaksi.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle table-hover">
        <thead>
          <tr>
            <th class="text-center">NO</th>
            <th>PIC</th>
            <th>Mesin</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Durasi</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($laporan as $l): ?>
            <tr>
              <td class="text-center fw-semibold text-muted"><?= $no++ ?></td>
              <td><?= esc($l['nama_pic'] ?: $l['nama_staff']) ?></td>
              <td><?= esc($l['no_mesin']) ?> - <?= esc($l['type_mesin']) ?></td>
              <td><?= esc($l['waktu_mulai']) ?></td>
              <td><?= esc($l['waktu_selesai'] ?? '-') ?></td>
              <td>
                <?php if ($l['durasi_detik'] !== null): ?>
                  <?= gmdate('i:s', (int) $l['durasi_detik']) ?>
                <?php else: ?>
                  -
                <?php endif; ?>
              </td>
              <td><a href="<?= site_url('riwayat/' . $l['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
