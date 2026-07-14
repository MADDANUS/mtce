<?= view('layout/header', ['title' => $title]) ?>

<div class="page-header">
  <div>
    <h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Ceklis Kontrol Bulanan</h5>
    <p class="text-muted small mb-0">Pantau ringkasan hasil pemeriksaan preventive bulanan per mesin dan per kategori.</p>
  </div>
</div>

<?php if (service('request')->getGet('auto') == 1): ?>
  <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2">
    <div class="spinner-border spinner-border-sm text-info" role="status"></div>
    <div>
      <strong>Sistem Otomatis:</strong> Data tersimpan di Ceklis Kontrol. Mengalihkan ke halaman Laporan Abnormal Condition dalam 1.5 detik...
    </div>
  </div>
<?php endif; ?>

<!-- FILTER CARD -->
<div class="card border-0 shadow-sm bg-white p-3 mb-4">
  <form id="filterForm" method="get" action="<?= site_url('kontrol') ?>">
    <div class="row g-3 align-items-center">
      <!-- Lokasi Switcher -->
      <div class="col-md-3">
        <label class="form-label small fw-semibold text-muted mb-1.5">Lokasi MFG</label>
        <div class="d-flex gap-1 bg-light p-1 rounded-3">
          <a href="<?= site_url('kontrol?lokasi=MFG+1&kategori=' . urlencode($kategori) . '&bulan=' . urlencode($bulan)) ?>" 
             class="btn btn-xs w-50 py-1.5 fw-semibold rounded-2 <?= $lokasi === 'MFG 1' ? 'btn-white shadow-sm' : 'text-secondary' ?>" style="font-size:0.75rem;">MFG 1</a>
          <a href="<?= site_url('kontrol?lokasi=MFG+2&kategori=' . urlencode($kategori) . '&bulan=' . urlencode($bulan)) ?>" 
             class="btn btn-xs w-50 py-1.5 fw-semibold rounded-2 <?= $lokasi === 'MFG 2' ? 'btn-white shadow-sm' : 'text-secondary' ?>" style="font-size:0.75rem;">MFG 2</a>
        </div>
        <input type="hidden" name="lokasi" value="<?= esc($lokasi) ?>">
      </div>

      <!-- Kategori Select -->
      <div class="col-md-4">
        <label class="form-label small fw-semibold text-muted mb-1.5">Kategori Preventive</label>
        <select name="kategori" class="form-select form-select-sm rounded-3 py-1.5" onchange="document.getElementById('filterForm').submit()">
          <?php foreach ($categories as $kKey => $kVal): ?>
            <option value="<?= esc($kKey) ?>" <?= $kategori === $kKey ? 'selected' : '' ?>><?= esc($kVal) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Bulan & Tahun Select -->
      <div class="col-md-4">
        <label class="form-label small fw-semibold text-muted mb-1.5">Pilih Bulan & Tahun</label>
        <select name="bulan" class="form-select form-select-sm rounded-3 py-1.5" onchange="document.getElementById('filterForm').submit()">
          <?php foreach ($bulanList as $bVal => $bLabel): ?>
            <option value="<?= esc($bVal) ?>" <?= $bulan === $bVal ? 'selected' : '' ?>><?= esc($bLabel) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </form>
</div>

<!-- GRID TABEL KONTROL -->
<div class="card border-0 shadow-sm bg-white overflow-hidden mb-4">
  <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
      <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Grid Ceklis Kontrol — <?= esc($kategori) ?> (<?= esc($lokasi) ?>)
    </h6>
    <span class="badge bg-light text-primary fw-semibold border px-2.5 py-1.5" style="font-size: 0.72rem;">
      Bulan: <?= esc($bulanList[$bulan] ?? $bulan) ?>
    </span>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive" style="border: 2px solid #cbd5e1 !important; border-radius: 8px;">
      <table class="table align-middle text-center mb-0 kontrol-table" style="font-size: 0.8rem; border-collapse: collapse;">
        <thead>
          <tr class="table-light">
            <th rowspan="3" style="width: 5%; font-weight:800; vertical-align: middle; border-bottom: 2px solid #cbd5e1 !important;">NO</th>
            <th rowspan="3" style="width: 25%; font-weight:800; vertical-align: middle; text-align: left; border-bottom: 2px solid #cbd5e1 !important;" class="ps-4">MESIN</th>
            <th colspan="5" style="width: 35%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">WAKTU</th>
            <th rowspan="3" style="width: 15%; font-weight:800; vertical-align: middle; border-bottom: 2px solid #cbd5e1 !important;">OUT OF PLAN</th>
            <th rowspan="3" style="width: 20%; font-weight:800; vertical-align: middle; text-align: left; border-bottom: 2px solid #cbd5e1 !important;" class="ps-4">ULASAN</th>
          </tr>
          <tr class="table-light">
            <th colspan="5" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important; text-transform: uppercase;">
              <?= isset($bulanList[$bulan]) ? strtoupper($bulanList[$bulan]) : strtoupper($bulan) ?>
            </th>
          </tr>
          <tr class="table-light">
            <th style="width: 7%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">1</th>
            <th style="width: 7%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">2</th>
            <th style="width: 7%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">3</th>
            <th style="width: 7%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">4</th>
            <th style="width: 7%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">5</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($grid)): ?>
            <tr>
              <td colspan="9" class="p-5 text-muted">
                <i class="bi bi-exclamation-circle text-secondary" style="font-size: 2rem; display:block; margin-bottom:0.5rem;"></i>
                Belum ada data mesin terdaftar di <?= esc($lokasi) ?>.
              </td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($grid as $row): ?>
              <?php 
                $m = $row['mesin']; 
                $idMesin = (int)$m['id_mesin'];
              ?>
              <!-- BARIS NAMA MESIN & STATUS PERIODE -->
              <tr>
                <td rowspan="2" class="fw-bold font-monospace text-secondary" style="background-color: #f8fafc; border-bottom: 2px solid #cbd5e1 !important; vertical-align: middle !important;"><?= $no++ ?></td>
                <td class="text-start fw-bold text-dark ps-4 py-2" style="border-bottom: 1px solid #e2e8f0 !important; background-color: #fff;">
                  <?= esc($m['no_mesin']) ?> - <?= esc($m['type_mesin']) ?>
                </td>
                
                <!-- Periode 1 s.d 5 Cells (Status Check) -->
                <?php for ($p = 1; $p <= 5; $p++): ?>
                  <?php 
                    $cell = $row['periodes'][$p]; 
                    $status = $cell ? $cell['status_check'] : '';
                    $cellClass = 'cell-editable';
                    $badgeClass = '';
                    
                    if ($status === 'V') $badgeClass = 'bg-success';
                    elseif ($status === 'Δ') $badgeClass = 'bg-warning text-dark';
                    elseif ($status === 'X') $badgeClass = 'bg-danger';
                  ?>
                  <td class="<?= $cellClass ?> p-1" style="cursor: pointer; transition: background-color 0.15s; border-bottom: 1px solid #e2e8f0 !important;"
                      data-id-kontrol="<?= $cell ? $cell['id_kontrol'] : '0' ?>"
                      data-id-mesin="<?= $idMesin ?>"
                      data-no-mesin="<?= esc($m['no_mesin']) ?>"
                      data-periode="<?= $p ?>"
                      data-status="<?= $status ?>"
                      data-pic="<?= $cell ? esc($cell['pic_nama']) : '' ?>"
                      data-out-of-plan="<?= $cell ? esc($cell['out_of_plan']) : '' ?>"
                      data-ulasan="<?= $cell ? esc($cell['ulasan']) : '' ?>">
                    <?php if ($status): ?>
                      <span class="badge <?= $badgeClass ?> rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px; font-size: 0.8rem; box-shadow: 0 1px 3px rgba(0,0,0,0.15);">
                        <?= $status ?>
                      </span>
                    <?php else: ?>
                      <span class="text-muted text-opacity-25"><i class="bi bi-plus-lg opacity-25"></i></span>
                    <?php endif; ?>
                  </td>
                <?php endfor; ?>

                <!-- Out of Plan (Top cell) -->
                <td class="font-monospace text-center py-2" style="font-size: 0.75rem; border-bottom: 1px solid #e2e8f0 !important; background-color: #fff;">
                  <?php if (!empty($row['out_of_plan'])): ?>
                    <span class="text-danger fw-bold d-block" style="font-size: 0.7rem;">Out of Plan</span>
                    <span class="text-secondary fw-semibold" style="font-size: 0.65rem;"><?= date('d-m-Y', strtotime($row['out_of_plan'])) ?></span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>

                <!-- Ulasan (Top cell) -->
                <td class="text-start ps-4 py-2 text-muted text-truncate" style="max-width: 150px; border-bottom: 1px solid #e2e8f0 !important; background-color: #fff;" title="<?= esc($row['ulasan']) ?>">
                  <?= esc($row['ulasan']) ?: '-' ?>
                </td>
              </tr>

              <!-- BARIS PIC -->
              <tr>
                <td class="text-start text-secondary ps-4 py-1.5" style="font-size: 0.75rem; background-color: #f8fafc; border-bottom: 2px solid #cbd5e1 !important; border-top: 0 !important;">
                  <span class="fw-bold text-muted text-uppercase me-1.5" style="font-size:0.625rem; letter-spacing: 0.05em;">PIC</span>
                </td>
                
                <!-- Periode 1 s.d 5 Cells (PIC Nama) -->
                <?php for ($p = 1; $p <= 5; $p++): ?>
                  <?php 
                    $cell = $row['periodes'][$p]; 
                    $status = $cell ? $cell['status_check'] : '';
                    $pic = $cell ? $cell['pic_nama'] : '';
                    $cellClass = 'cell-editable';
                  ?>
                  <td class="<?= $cellClass ?> py-1.5 px-1 font-monospace" style="font-size: 0.68rem; cursor: pointer; transition: background-color 0.15s; border-bottom: 2px solid #cbd5e1 !important; background-color: #f8fafc;"
                      data-id-kontrol="<?= $cell ? $cell['id_kontrol'] : '0' ?>"
                      data-id-mesin="<?= $idMesin ?>"
                      data-no-mesin="<?= esc($m['no_mesin']) ?>"
                      data-periode="<?= $p ?>"
                      data-status="<?= $status ?>"
                      data-pic="<?= esc($pic) ?>"
                      data-out-of-plan="<?= $cell ? esc($cell['out_of_plan']) : '' ?>"
                      data-ulasan="<?= $cell ? esc($cell['ulasan']) : '' ?>">
                    <span class="fw-semibold text-dark"><?= esc($pic) ?: '-' ?></span>
                  </td>
                <?php endfor; ?>

                <!-- Out of Plan (Bottom Cell - Empty) -->
                <td style="border-bottom: 2px solid #cbd5e1 !important; background-color: #f8fafc;"></td>

                <!-- Ulasan (Bottom Cell - Empty) -->
                <td style="border-bottom: 2px solid #cbd5e1 !important; background-color: #f8fafc;"></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- CSS Hover Effects & Strict Borders -->
<style>
  .kontrol-table {
    border-collapse: collapse !important;
    width: 100% !important;
  }
  .kontrol-table th, .kontrol-table td {
    border: 1px solid #cbd5e1 !important; /* Slate-300 borders */
    vertical-align: middle !important;
  }
  .kontrol-table th {
    background-color: #f1f5f9 !important; /* Slate-100 headers */
    color: #1e293b !important;
    padding: 0.85rem 1rem !important;
    border-bottom: 2px solid #cbd5e1 !important;
  }
  .kontrol-table td {
    padding: 0.65rem 0.85rem !important;
  }
  .cell-editable:hover {
    background-color: #f1f5f9 !important;
  }
  .bg-success {
    background-color: #10b981 !important;
    color: #ffffff !important;
  }
  .bg-warning {
    background-color: #f59e0b !important;
    color: #1e293b !important;
  }
  .bg-danger {
    background-color: #ef4444 !important;
    color: #ffffff !important;
  }
</style>

<!-- MODAL QUICK EDIT -->
<div class="modal fade" id="quickEditModal" tabindex="-1" aria-labelledby="quickEditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
        <h6 class="modal-title fw-bold" id="quickEditModalLabel"><i class="bi bi-pencil-square text-primary me-1.5"></i>Edit Sel Ceklis Kontrol</h6>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= site_url('kontrol/update-cell') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id_kontrol" id="modalIdKontrol" value="0">
        <input type="hidden" name="id_mesin" id="modalIdMesin" value="0">
        <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">
        <input type="hidden" name="bulan_tahun" value="<?= esc($bulan) ?>">
        <input type="hidden" name="periode_ke" id="modalPeriode" value="0">

        <div class="modal-body px-4 pt-3">
          <div class="mb-3 bg-light p-2.5 rounded-3 border">
            <div class="row text-center font-monospace small">
              <div class="col-6 border-end">
                <span class="text-muted d-block" style="font-size: 0.65rem; text-transform: uppercase;">Mesin</span>
                <strong class="text-dark" id="modalNoMesinLabel">MC-001</strong>
              </div>
              <div class="col-6">
                <span class="text-muted d-block" style="font-size: 0.65rem; text-transform: uppercase;">Periode Ke</span>
                <strong class="text-primary" id="modalPeriodeLabel">1</strong>
              </div>
            </div>
          </div>

          <!-- Status Check -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Status Pengecekan</label>
            <select name="status_check" id="modalStatusSelect" class="form-select" required>
              <option value="">-- Pilih Status --</option>
              <option value="V">V (OK)</option>
              <option value="Δ">Δ (Perlu Tindakan)</option>
              <option value="X">X (Tidak Ada)</option>
            </select>
          </div>

          <!-- PIC Nama -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama PIC</label>
            <input type="text" name="pic_nama" id="modalPicInput" class="form-control" placeholder="Ketik nama PIC" required>
          </div>

          <!-- Out of Plan Checkbox & Date -->
          <div class="mb-3">
            <label class="form-label fw-semibold d-block">Pengecekan Out of Plan?</label>
            <div class="form-check form-switch mt-1.5">
              <input class="form-check-input" type="checkbox" id="modalIsOutOfPlan" value="1">
              <label class="form-check-label text-muted small" for="modalIsOutOfPlan">Ya, isi tanggal realita pengecekan</label>
            </div>
            <div id="modalOutOfPlanDateWrapper" class="mt-2" style="display: none;">
              <label class="form-label small fw-semibold text-danger">Tanggal Realita</label>
              <input type="date" name="out_of_plan" id="modalOutOfPlanDateInput" class="form-control border-danger form-control-sm" value="<?= date('Y-m-d') ?>">
            </div>
          </div>

          <!-- Ulasan -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Ulasan</label>
            <textarea name="ulasan" id="modalUlasanInput" class="form-control" rows="2" placeholder="Ketik keterangan tambahan jika diperlukan..."></textarea>
          </div>
        </div>

        <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-4 rounded-3"><i class="bi bi-save me-1"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Javascript Modal Populate -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const cells = document.querySelectorAll(".cell-editable");
    const editModal = new bootstrap.Modal(document.getElementById("quickEditModal"));

    // Modal Form Elements
    const mIdKontrol     = document.getElementById("modalIdKontrol");
    const mIdMesin       = document.getElementById("modalIdMesin");
    const mPeriode       = document.getElementById("modalPeriode");
    const mNoMesinLabel  = document.getElementById("modalNoMesinLabel");
    const mPeriodeLabel  = document.getElementById("modalPeriodeLabel");
    
    const mStatusSelect  = document.getElementById("modalStatusSelect");
    const mPicInput      = document.getElementById("modalPicInput");
    const mIsOutOfPlan   = document.getElementById("modalIsOutOfPlan");
    const mDateWrapper   = document.getElementById("modalOutOfPlanDateWrapper");
    const mDateInput     = document.getElementById("modalOutOfPlanDateInput");
    const mUlasanInput   = document.getElementById("modalUlasanInput");

    // Click handler for table cells
    cells.forEach(cell => {
      cell.addEventListener("click", function() {
        const idKontrol   = this.getAttribute("data-id-kontrol");
        const idMesin     = this.getAttribute("data-id-mesin");
        const noMesin     = this.getAttribute("data-no-mesin");
        const periode     = this.getAttribute("data-periode");
        const status      = this.getAttribute("data-status");
        const pic         = this.getAttribute("data-pic");
        const outOfPlan   = this.getAttribute("data-out-of-plan");
        const ulasan      = this.getAttribute("data-ulasan");

        // Populate Modal Fields
        mIdKontrol.value    = idKontrol;
        mIdMesin.value      = idMesin;
        mPeriode.value      = periode;
        mNoMesinLabel.innerText = noMesin;
        mPeriodeLabel.innerText = "Periode ke-" + periode;

        mStatusSelect.value = status;
        mPicInput.value     = pic || "Staff";
        mUlasanInput.value  = ulasan || "";

        // Check if out of plan is set (reality date)
        if (outOfPlan && outOfPlan !== "") {
          mIsOutOfPlan.checked = true;
          mDateWrapper.style.display = "block";
          mDateInput.value = outOfPlan;
          mDateInput.setAttribute("required", "required");
        } else {
          mIsOutOfPlan.checked = false;
          mDateWrapper.style.display = "none";
          mDateInput.removeAttribute("required");
          mDateInput.value = "<?= date('Y-m-d') ?>";
        }

        editModal.show();
      });
    });

    // Toggle out of plan date picker inside modal
    mIsOutOfPlan.addEventListener("change", function() {
      if (this.checked) {
        mDateWrapper.style.display = "block";
        mDateInput.setAttribute("required", "required");
      } else {
        mDateWrapper.style.display = "none";
        mDateInput.removeAttribute("required");
        mDateInput.value = ""; // clear reality date if unchecked
      }
    });
  });
</script>

<?php if (service('request')->getGet('auto') == 1): ?>
<script>
  setTimeout(function() {
    window.location.href = "<?= site_url('abnormal') ?>";
  }, 1500);
</script>
<?php endif; ?>

<?= view('layout/footer') ?>
