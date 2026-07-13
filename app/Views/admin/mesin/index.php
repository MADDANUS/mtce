<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Master Mesin</h5>
  <a href="<?= site_url('admin/mesin/create') ?>" class="btn btn-primary btn-sm">+ Tambah Mesin</a>
</div>

<div class="card-stat p-3">
  <?php if (empty($daftar)): ?>
    <p class="text-muted mb-0">Belum ada data mesin.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>No Mesin</th>
            <th>Type</th>
            <th>Serial Nomor</th>
            <th>Lokasi</th>
            <th style="width:160px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($daftar as $m): ?>
            <tr>
              <td><?= esc($m['no_mesin']) ?></td>
              <td><?= esc($m['type_mesin']) ?></td>
              <td><?= esc($m['serial_nomor']) ?></td>
              <td><span class="badge bg-secondary"><?= esc($m['lokasi']) ?></span></td>
              <td>
                <a href="<?= site_url('admin/mesin/edit/' . $m['id_mesin']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                <a href="<?= site_url('admin/mesin/delete/' . $m['id_mesin']) ?>" class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Hapus mesin <?= esc($m['no_mesin'], 'js') ?>?');">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
