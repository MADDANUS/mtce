<?= view('layout/header', ['title' => $title]) ?>

<h3 class="fw-bold mb-3">Laporan Durasi Pengecekan (Efisiensi)</h3>

<div class="card-stat p-3 mb-3" style="max-width:320px;">
  <div class="text-muted small">Rata-rata Durasi Semua Transaksi</div>
  <div class="value"><?= gmdate('i \m\e\n\i\t s \d\e\t\i\k', $rataDetik) ?></div>
</div>

<div class="card-stat p-3">
  <?php if (empty($laporan)): ?>
    <p class="text-muted mb-0">Belum ada data transaksi.</p>
  <?php else: ?>
    <div class="table-responsive text-nowrap">
      <table class="table table-sm align-middle table-hover">
        <thead>
          <tr>
            <th class="text-center">NO</th>
            <th>PIC</th>
            <th>Mesin</th>
            <th>Lokasi / Line</th>
            <th>Jenis Pengecekan</th>
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
              <?php 
                $rawNamaDurasi = $l['nama_pic'] ?: $l['nama_staff'];
                $namaDurasiParts = explode(' - ', $rawNamaDurasi);
                $namaDurasiOnly = end($namaDurasiParts);
              ?>
              <td><?= esc($namaDurasiOnly) ?></td>
              <td><?= esc($l['no_mesin']) ?> - <?= esc($l['type_mesin']) ?></td>
              <td><?= esc($l['lokasi_check']) ?> / <?= esc($l['line'] ?? '-') ?></td>
              <td>
                <?php if (strtolower($l['jenis_check']) === 'overhaul'): ?>
                  <span class="badge bg-primary">Inspection Report</span>
                <?php else: ?>
                  <span class="badge bg-info text-dark">Checklist Report</span>
                <?php endif; ?>
              </td>
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
