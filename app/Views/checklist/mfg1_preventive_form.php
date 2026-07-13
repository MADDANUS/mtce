<?= view('layout/header', ['title' => $title]) ?>

<style>
  .form-header-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box table td { padding:.25rem .5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Pengecekan Preventive - <?= esc($categoryName) ?></h5>
  <div>
    <a href="<?= site_url('checklist/mfg1-preventive') ?>" class="btn btn-sm btn-outline-secondary me-2">&laquo; Pilih Kategori</a>
    <a href="<?= site_url('riwayat/kategori/' . esc($categorySlug)) ?>" class="btn btn-sm btn-outline-primary">Lihat Riwayat</a>
  </div>
</div>

<form action="<?= site_url('checklist/mfg1-preventive/store') ?>" method="post">
  <?= csrf_field() ?>

  <!-- HEADER FORM: Mesin, Staff, Waktu Mulai -->
  <div class="form-header-box p-3 mb-3">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Pilih Mesin</label>
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
    </div>
  </div>

  <div class="row g-3">
    <!-- TABEL CHECKLIST -->
    <div class="col-lg-9">
      <table class="table table-bordered align-middle checklist-table bg-white">
        <thead>
          <tr>
            <th style="width:16%;">BAGIAN CHECK</th>
            <th style="width:16%;">POINT CHECK</th>
            <th style="width:16%;">STANDARD CHECK</th>
            <th style="width:22%;">CHECK LIST</th>
            <th>ULASAN</th>
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
                           id="v_<?= (int) $r['id_parameter'] ?>" value="V">
                    <label class="form-check-label" for="v_<?= (int) $r['id_parameter'] ?>">V</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio"
                           name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                           id="d_<?= (int) $r['id_parameter'] ?>" value="Δ">
                    <label class="form-check-label" for="d_<?= (int) $r['id_parameter'] ?>">Δ</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio"
                           name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                           id="x_<?= (int) $r['id_parameter'] ?>" value="X">
                    <label class="form-check-label" for="x_<?= (int) $r['id_parameter'] ?>">X</label>
                  </div>
                </div>
              </td>

              <td>
                <input type="text" class="form-control form-control-sm"
                       name="ulasan[<?= (int) $r['id_parameter'] ?>]" placeholder="Ulasan...">
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- KETERANGAN CHECK LIST -->
    <div class="col-lg-3">
      <div class="keterangan-box p-3">
        <div class="fw-semibold mb-2">KETERANGAN CHECK LIST</div>
        <table class="table table-sm mb-0">
          <tr><td class="fw-bold">V</td><td>:</td><td>OK</td></tr>
          <tr><td class="fw-bold">Δ</td><td>:</td><td>PERLU TINDAKAN</td></tr>
          <tr><td class="fw-bold">X</td><td>:</td><td>TIDAK ADA</td></tr>
        </table>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end mt-3 mb-5">
    <button type="submit" class="btn btn-primary px-4">Submit Pengecekan</button>
  </div>
</form>

<?= view('layout/footer') ?>
