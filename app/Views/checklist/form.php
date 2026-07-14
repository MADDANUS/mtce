<?= view('layout/header', ['title' => $title]) ?>

<style>
  .form-header-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box table td { padding:.25rem .5rem; }
</style>

<div class="page-header">
  <h5><i class="bi bi-clipboard-check me-2" style="color:var(--accent);"></i>Pengecekan <?= esc($jenisName) ?> — <strong><?= esc($categoryName) ?></strong> <span class="badge bg-secondary ms-1" style="font-size:0.7rem;"><?= esc($lokasiName) ?></span></h5>
  <div class="d-flex gap-2">
    <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}") ?>" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Pilih Kategori
    </a>
    <a href="<?= site_url("riwayat/lokasi/{$lokasiSlug}?kategori=" . urlencode($categoryName)) ?>" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-clock-history"></i> Lihat Riwayat
    </a>
  </div>
</div>


<form action="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/store") ?>" method="post">
  <?= csrf_field() ?>

  <!-- HEADER FORM: Mesin, Staff, Waktu Mulai -->
  <div class="form-header-box p-3 mb-3 shadow-sm border-0 bg-white">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Pilih Mesin (<?= esc($lokasiName) ?>)</label>
        <select name="id_mesin" class="form-select" required <?= !empty($idMesin) ? 'disabled' : '' ?>>
          <option value="">-- Pilih Mesin --</option>
          <?php foreach ($daftarMesin as $m): ?>
            <option value="<?= esc($m['id_mesin']) ?>" <?= (!empty($idMesin) && (int)$idMesin === (int)$m['id_mesin']) ? 'selected' : '' ?>>
              <?= esc($m['no_mesin']) ?> - <?= esc($m['type_mesin']) ?> - <?= esc($m['serial_nomor']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (!empty($idMesin)): ?>
          <input type="hidden" name="id_mesin" value="<?= (int)$idMesin ?>">
        <?php endif; ?>
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
        <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
          <!-- OVERHAUL TABLE -->
          <table class="table table-bordered align-middle checklist-table bg-white shadow-sm rounded">
            <thead>
              <tr>
                <th style="width:5%;">NO</th>
                <th colspan="2" style="width:30%;">ITEM CHECK</th>
                <th style="width:20%;">POINT CHECK</th>
                <th style="width:15%;">STANDAR ITEM</th>
                <th style="width:12%;">CHECK LIST</th>
                <th style="width:18%;">REMARK</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r): ?>
                <?php if ($r['is_section_start']): ?>
                  <tr class="section-header">
                    <td colspan="7"><?= esc($r['dynamic_section_header']) ?></td>
                  </tr>
                <?php endif; ?>
                <tr>
                  <?php if ($r['show_no']): ?>
                    <td class="text-center fw-semibold text-muted" rowspan="<?= (int) $r['no_rowspan'] ?>"><?= esc($r['dynamic_no']) ?></td>
                  <?php endif; ?>

                  <?php if ($r['sub_item_check'] !== null && $r['sub_item_check'] !== ''): ?>
                    <?php if ($r['show_bagian']): ?>
                      <td class="bagian-cell" rowspan="<?= (int) $r['bagian_rowspan'] ?>"><?= esc($r['bagian_check']) ?></td>
                    <?php endif; ?>
                    <td><?= esc($r['sub_item_check']) ?></td>
                  <?php else: ?>
                    <td class="bagian-cell" colspan="2"><?= esc($r['bagian_check']) ?></td>
                  <?php endif; ?>

                  <?php if ($r['show_point']): ?>
                    <td rowspan="<?= (int) $r['point_rowspan'] ?>"><?= esc($r['point_check']) ?></td>
                  <?php endif; ?>

                  <?php if ($r['show_standard']): ?>
                    <td rowspan="<?= (int) $r['standard_rowspan'] ?>"><?= nl2br(esc($r['standard_check'])) ?></td>
                  <?php endif; ?>

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
        <?php else: ?>
          <!-- PREVENTIVE TABLE -->
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

  <?php if (strtolower($jenisSlug) === 'preventive' && !empty($rows)): ?>
    <div class="card border-0 shadow-sm bg-white p-4 mt-4 mb-3">
      <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
        <i class="bi bi-file-earmark-check"></i> Data Ceklis Kontrol Bulanan
      </h6>
      <div class="row g-3">
        <!-- PIC Nama -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Nama PIC <span class="text-danger">*</span></label>
          <input type="text" name="pic_nama" class="form-control" placeholder="Ketik nama PIC fisik penanggung jawab" required>
          <div class="form-text">Nama orang fisik (bukan nama akun staff).</div>
        </div>

        <!-- Out of Plan Checkbox & Date -->
        <div class="col-md-4">
          <div class="mb-2">
            <label class="form-label fw-semibold d-block">Pengecekan Out of Plan?</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="is_out_of_plan" id="isOutOfPlanCheck" value="1">
              <label class="form-check-label text-muted" for="isOutOfPlanCheck">Ya, di luar rencana</label>
            </div>
          </div>
          <div id="outOfPlanDateWrapper" style="display: none;">
            <label class="form-label fw-semibold text-danger">Tanggal Realita <span class="text-danger">*</span></label>
            <input type="date" name="out_of_plan_date" id="outOfPlanDateInput" class="form-control border-danger" value="<?= date('Y-m-d') ?>">
            <div class="form-text text-danger">Masukkan tanggal aktual pengecekan.</div>
          </div>
        </div>

        <!-- Ulasan Kontrol -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Ulasan Kontrol (Opsional)</label>
          <input type="text" name="ulasan_kontrol" class="form-control" placeholder="Ketik ulasan ringkas kontrol">
          <div class="form-text">Keterangan tambahan untuk baris bulan ini.</div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const isOutOfPlanCheck = document.getElementById("isOutOfPlanCheck");
        const outOfPlanDateWrapper = document.getElementById("outOfPlanDateWrapper");
        const outOfPlanDateInput = document.getElementById("outOfPlanDateInput");

        function toggleOutOfPlan() {
          if (isOutOfPlanCheck.checked) {
            outOfPlanDateWrapper.style.display = "block";
            outOfPlanDateInput.setAttribute("required", "required");
          } else {
            outOfPlanDateWrapper.style.display = "none";
            outOfPlanDateInput.removeAttribute("required");
            outOfPlanDateInput.value = "<?= date('Y-m-d') ?>";
          }
        }

        isOutOfPlanCheck.addEventListener("change", toggleOutOfPlan);
      });
    </script>
  <?php endif; ?>

  <?php if (!empty($rows)): ?>
    <div class="d-flex justify-content-end mt-3 mb-5">
      <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">Submit Pengecekan</button>
    </div>
  <?php endif; ?>
</form>

<?= view('layout/footer') ?>
