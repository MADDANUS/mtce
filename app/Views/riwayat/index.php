<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Riwayat Pengecekan - <?= esc($categoryName) ?></h5>
  <div>
    <a href="<?= site_url('riwayat') ?>" class="btn btn-sm btn-outline-secondary me-2">&laquo; Pilih Kategori</a>
    <?php if (in_array(session()->get('role'), ['staff', 'admin'], true)): ?>
      <a href="<?= site_url('checklist') ?>" class="btn btn-sm btn-primary">+ Buat Baru</a>
    <?php endif; ?>
  </div>
</div>

<div class="card-stat p-3">
  <?php if (empty($riwayat)): ?>
    <p class="text-muted mb-0">Belum ada riwayat pengecekan.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle table-hover">
        <thead>
          <tr>
            <th>#</th>
            <?php if (session()->get('role') !== 'staff'): ?><th>Staff</th><?php endif; ?>
            <th>Mesin</th>
            <th>Lokasi / Jenis</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Durasi</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayat as $r): ?>
            <?php
              $durasi = '-';
              if (! empty($r['waktu_mulai']) && ! empty($r['waktu_selesai'])) {
                  $durasi = gmdate('i:s', strtotime($r['waktu_selesai']) - strtotime($r['waktu_mulai']));
              }
            ?>
            <tr>
              <td><?= (int) $r['id_transaksi'] ?></td>
              <?php if (session()->get('role') !== 'staff'): ?><td><?= esc($r['nama_staff']) ?></td><?php endif; ?>
              <td><?= esc($r['no_mesin']) ?> - <?= esc($r['type_mesin']) ?></td>
              <td><?= esc($r['lokasi_check']) ?> / <?= esc($r['jenis_check']) ?></td>
              <td><?= esc($r['waktu_mulai']) ?></td>
              <td><?= esc($r['waktu_selesai'] ?? '-') ?></td>
              <td><?= $durasi ?></td>
              <td>
                <?php if (($r['status'] ?? 'Pending') === 'Approved'): ?>
                  <span class="badge bg-success">Approved</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php endif; ?>
              </td>
              <td><a href="<?= site_url('riwayat/' . $r['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
