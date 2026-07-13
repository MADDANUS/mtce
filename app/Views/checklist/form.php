<?= view('layout/header', ['title' => $title]) ?>

<style>
  .form-header-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box table td { padding:.25rem .5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Pengecekan <?= esc($jenisName) ?> - <?= esc($categoryName) ?> (<?= esc($lokasiName) ?>)</h5>
  <div>
    <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}") ?>" class="btn btn-sm btn-outline-secondary me-2">&laquo; Pilih Kategori</a>
    <a href="<?= site_url('riwayat/kategori/' . esc($categorySlug)) ?>" class="btn btn-sm btn-outline-primary">Lihat Riwayat</a>
  </div>
</div>

<form action="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/store") ?>" method="post">
  <?= csrf_field() ?>

  <!-- HEADER FORM: Mesin, Staff, Waktu Mulai -->
  <div class="form-header-box p-3 mb-3 shadow-sm border-0 bg-white">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Pilih Mesin (<?= esc($lokasiName) ?>)</label>
        <select name="id_mesin" class="form-select" required>
          <option value="">-- Pilih Mesin --</option>
          <?php foreach ($daftarMesin as $m): ?>
            <option value="<?= esc($m['id_mesin']) ?>">
              <?= esc($m['no_mesin']) ?> - <?= esc($m['type_mesin']) ?> - <?= esc($m['serial_nomor']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Nama Staff</label>
        <input type="text" class="form-control" value="<?= esc($namaStaff) ?>" readonly>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Waktu Mulai</label>
        <input type="text" class="form-control" value="<?= esc($waktuMulaiDisplay) ?>" readonly>
        <!-- waktu_mulai dikirim apa adanya ke Controller store() saat submit -->
        <input type="hidden" name="waktu_mulai" value="<?= esc($waktuMulai) ?>">
        <input type="hidden" name="kategori" value="<?= esc($categoryName) ?>">
      </div>
      
      <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-primary">Bar Feeder Type</label>
          <input type="text" name="bar_feeder_type" class="form-control border-primary bg-primary bg-opacity-10" placeholder="Masukkan tipe Bar Feeder...">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-primary">Support PIC</label>
          <input type="text" name="support_pic" class="form-control border-primary bg-primary bg-opacity-10" placeholder="Masukkan rekan kerja pendukung...">
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="row g-3">
    <!-- TABEL CHECKLIST -->
    <div class="col-lg-9">
      <?php if (empty($rows)): ?>
        <div class="alert alert-info">Belum ada parameter check yang didefinisikan untuk kategori ini.</div>
      <?php else: ?>
        <table class="table table-bordered align-middle checklist-table bg-white shadow-sm rounded">
          <thead>
            <tr>
              <th style="width:15%;">BAGIAN CHECK</th>
              <th style="width:20%;">POINT CHECK</th>
              <th style="width:20%;">STANDARD CHECK</th>
              <th style="width:15%;">CHECK LIST</th>
              <th style="width:30%;">ULASAN</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <?php if ($r['show_bagian']): ?>
                  <td class="bagian-cell" rowspan="<?= (int) $r['bagian_rowspan'] ?>"><?= esc($r['bagian_check']) ?></td>
                <?php endif; ?>

                <?php if ($r['show_point']): ?>
                  <td rowspan="<?= (int) $r['point_rowspan'] ?>"><?= esc($r['point_check']) ?></td>
                <?php endif; ?>

                <td><?= esc($r['standard_check']) ?></td>

                <td>
                  <div class="d-flex">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio"
                             name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                             id="v_<?= (int) $r['id_parameter'] ?>" value="V" required>
                      <label class="form-check-label text-success fw-bold" for="v_<?= (int) $r['id_parameter'] ?>">V</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio"
                             name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                             id="d_<?= (int) $r['id_parameter'] ?>" value="Δ" required>
                      <label class="form-check-label text-warning fw-bold" for="d_<?= (int) $r['id_parameter'] ?>">Δ</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio"
                             name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                             id="x_<?= (int) $r['id_parameter'] ?>" value="X" required>
                      <label class="form-check-label text-danger fw-bold" for="x_<?= (int) $r['id_parameter'] ?>">X</label>
                    </div>
                  </div>
                </td>

                <td>
                  <textarea class="form-control form-control-sm"
                            name="ulasan[<?= (int) $r['id_parameter'] ?>]"
                            placeholder="Tulis ulasan/keterangan..."
                            rows="1"
                            style="min-height: 38px; resize: vertical; font-size: 0.85rem;"></textarea>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <!-- KETERANGAN CHECK LIST -->
    <div class="col-lg-3">
      <div class="keterangan-box p-3 shadow-sm">
        <div class="fw-semibold mb-2 text-dark border-bottom pb-2">KETERANGAN CHECK LIST</div>
        <table class="table table-sm mb-0">
          <tr><td class="fw-bold text-success">V</td><td>:</td><td>OK</td></tr>
          <tr><td class="fw-bold text-warning">Δ</td><td>:</td><td>PERLU TINDAKAN</td></tr>
          <tr><td class="fw-bold text-danger">X</td><td>:</td><td>TIDAK ADA</td></tr>
        </table>
      </div>
    </div>
  </div>

  <?php if (!empty($rows)): ?>
    <div class="d-flex justify-content-end mt-3 mb-5">
      <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">Submit Pengecekan</button>
    </div>
  <?php endif; ?>
</form>

<?= view('layout/footer') ?>
