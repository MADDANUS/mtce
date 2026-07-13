<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Master Parameter Check</h5>
  <a href="<?= site_url('admin/parameter/create') ?>" class="btn btn-primary btn-sm">+ Tambah Parameter</a>
</div>

<div class="card-stat p-3">
  <?php if (empty($daftar)): ?>
    <p class="text-muted mb-0">Belum ada data parameter.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Lokasi</th>
            <th>Jenis</th>
            <th>Kategori</th>
            <th>Bagian Check</th>
            <th>Point Check</th>
            <th>Standard Check</th>
            <th>Urutan</th>
            <th style="width:160px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($daftar as $p): ?>
            <tr>
              <td><?= (int) $p['id_parameter'] ?></td>
              <td><span class="badge bg-secondary"><?= esc($p['lokasi']) ?></span></td>
              <td><?= esc($p['jenis_check']) ?></td>
              <td><?= esc($p['kategori']) ?></td>
              <td><?= esc($p['bagian_check']) ?></td>
              <td><?= esc($p['point_check']) ?></td>
              <td><?= esc($p['standard_check']) ?></td>
              <td><?= (int) $p['urutan'] ?></td>
              <td>
                <a href="<?= site_url('admin/parameter/edit/' . $p['id_parameter']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                <a href="<?= site_url('admin/parameter/delete/' . $p['id_parameter']) ?>" class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Hapus parameter ini?');">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
