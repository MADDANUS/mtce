<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3"><?= esc($title) ?></h5>

<div class="card-stat p-3" style="max-width:600px;">
  <form action="<?= $user ? site_url('admin/user/update/' . $user['id']) : site_url('admin/user/store') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" required
             value="<?= esc(old('nama', $user['nama'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required
             value="<?= esc(old('username', $user['username'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">
        Password <?= $user ? '<span class="text-muted small">(kosongkan jika tidak diubah)</span>' : '' ?>
      </label>
      <input type="password" name="password" class="form-control" <?= $user ? '' : 'required' ?>>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <?php $roleVal = old('role', $user['role'] ?? 'staff'); ?>
      <select name="role" class="form-select" required>
        <option value="staff" <?= $roleVal === 'staff' ? 'selected' : '' ?>>Staff</option>
        <option value="leader" <?= $roleVal === 'leader' ? 'selected' : '' ?>>Leader</option>
        <option value="admin" <?= $roleVal === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/user') ?>" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>

<?= view('layout/footer') ?>
