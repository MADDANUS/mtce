<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-3"><?= esc($title) ?></h5>

<div class="card-stat p-3" style="max-width:600px;">
  <form action="<?= $mesin ? site_url('admin/mesin/update/' . $mesin['id_mesin']) : site_url('admin/mesin/store') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">No Mesin</label>
      <input type="text" name="no_mesin" class="form-control" required
             value="<?= esc(old('no_mesin', $mesin['no_mesin'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Type Mesin</label>
      <input type="text" name="type_mesin" class="form-control" required
             value="<?= esc(old('type_mesin', $mesin['type_mesin'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Serial Nomor</label>
      <input type="text" name="serial_nomor" class="form-control" required
             value="<?= esc(old('serial_nomor', $mesin['serial_nomor'] ?? '')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Lokasi</label>
      <?php $lokasiVal = old('lokasi', $mesin['lokasi'] ?? 'MFG 1'); ?>
      <select name="lokasi" class="form-select" required>
        <option value="MFG 1" <?= $lokasiVal === 'MFG 1' ? 'selected' : '' ?>>MFG 1</option>
        <option value="MFG 2" <?= $lokasiVal === 'MFG 2' ? 'selected' : '' ?>>MFG 2</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="form-label text-primary fw-semibold">Bar Feeder Type (Opsional)</label>
      <input type="text" name="bar_feeder_type" class="form-control border-primary bg-primary bg-opacity-10" placeholder="Contoh: Iemca Boss 332" 
             value="<?= esc(old('bar_feeder_type', $mesin['bar_feeder_type'] ?? '')) ?>">
      <div class="form-text small">Diperlukan untuk otomatisasi form Overhaul. Biarkan kosong jika tidak memiliki Bar Feeder.</div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/mesin') ?>" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>

<?= view('layout/footer') ?>
