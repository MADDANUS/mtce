<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3"><?= esc($title) ?></h5>

<div class="card-stat p-3" style="max-width:700px;">
  <form action="<?= $parameter ? site_url('admin/parameter/update/' . $parameter['id_parameter']) : site_url('admin/parameter/store') ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <?php $lokasiVal = old('lokasi', $parameter['lokasi'] ?? 'MFG 1'); ?>
        <select name="lokasi" class="form-select" required>
          <option value="MFG 1" <?= $lokasiVal === 'MFG 1' ? 'selected' : '' ?>>MFG 1</option>
          <option value="MFG 2" <?= $lokasiVal === 'MFG 2' ? 'selected' : '' ?>>MFG 2</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Jenis Check</label>
        <?php $jenisVal = old('jenis_check', $parameter['jenis_check'] ?? 'Preventive'); ?>
        <select name="jenis_check" class="form-select" required>
          <option value="Preventive" <?= $jenisVal === 'Preventive' ? 'selected' : '' ?>>Preventive</option>
          <option value="Overhaul" <?= $jenisVal === 'Overhaul' ? 'selected' : '' ?>>Overhaul</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control" required placeholder="Contoh: Penerangan"
             value="<?= esc(old('kategori', $parameter['kategori'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Bagian Check</label>
      <input type="text" name="bagian_check" class="form-control" required placeholder="Contoh: Lampu Sorot"
             value="<?= esc(old('bagian_check', $parameter['bagian_check'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Point Check</label>
      <input type="text" name="point_check" class="form-control" required placeholder="Contoh: Fungsi"
             value="<?= esc(old('point_check', $parameter['point_check'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Standard Check</label>
      <input type="text" name="standard_check" class="form-control" required placeholder="Contoh: Nyala"
             value="<?= esc(old('standard_check', $parameter['standard_check'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Urutan</label>
      <input type="number" name="urutan" class="form-control" required min="0"
             value="<?= esc(old('urutan', $parameter['urutan'] ?? '0')) ?>">
      <div class="form-text">Menentukan urutan baris di form dan pengelompokan rowspan BAGIAN CHECK / POINT CHECK.</div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/parameter') ?>" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>

<?= view('layout/footer') ?>
