<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Master User</h5>
  <a href="<?= site_url('admin/user/create') ?>" class="btn btn-primary btn-sm">+ Tambah User</a>
</div>

<div class="card-stat p-3">
  <?php if (empty($daftar)): ?>
    <p class="text-muted mb-0">Belum ada data user.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th style="width:160px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($daftar as $u): ?>
            <tr>
              <td><?= esc($u['nama']) ?></td>
              <td><?= esc($u['username']) ?></td>
              <td><span class="badge bg-secondary text-uppercase"><?= esc($u['role']) ?></span></td>
              <td>
                <a href="<?= site_url('admin/user/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                <?php if ((int) $u['id'] !== (int) session()->get('user_id')): ?>
                  <a href="<?= site_url('admin/user/delete/' . $u['id']) ?>" class="btn btn-sm btn-outline-danger"
                     onclick="return confirm('Hapus user <?= esc($u['nama'], 'js') ?>?');">Hapus</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
