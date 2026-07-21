<?= view('layout/header', ['title' => $title]) ?>

<div class="page-header d-flex align-items-center mb-4">
  <a href="<?= site_url('abnormal?view=summary') ?>" class="btn btn-outline-secondary btn-sm me-3 shadow-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
  <div>
    <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Laporan Abnormal Condition</h5>
    <p class="text-muted small mb-0">Area: <?= esc($lokasiFilter) ?> | Kategori: <?= esc($kategoriFilter) ?> | Bulan: <?= esc($bulanFilter) ?></p>
  </div>
</div>



<!-- ABNORMAL TABLE CARD -->
<div class="card border-0 shadow-sm bg-white overflow-hidden mb-4">
  <div class="card-body p-0">
    <div class="table-responsive" style="border: 2px solid #cbd5e1 !important; border-radius: 8px;">
      <table class="table align-middle text-center mb-0 abnormal-table" style="font-size: 0.8rem; border-collapse: collapse;">
        <thead>
          <tr class="table-light">
            <th rowspan="3" style="width: 3%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">NO</th>
            <th rowspan="3" style="width: 15%; font-weight:800; text-align: left; border-bottom: 2px solid #cbd5e1 !important;" class="ps-3">MESIN</th>
            <th rowspan="3" style="width: 12%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">POINT CHECK</th>
            <th rowspan="3" style="width: 15%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">ABNORMAL CONDITION</th>
            <th rowspan="3" style="width: 10%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">TYPE SPAREPART</th>
            <th colspan="2" style="width: 12%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">PENGECEKAN</th>
            <th colspan="4" style="width: 25%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">RENCANA PERBAIKAN</th>
            <th rowspan="3" style="width: 8%; font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">KETERANGAN</th>
          </tr>
          <tr class="table-light">
            <th rowspan="2" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">TANGGAL</th>
            <th rowspan="2" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">PIC</th>
            <th colspan="2" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">PROGRES</th>
            <th rowspan="2" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">ACTION</th>
            <th rowspan="2" style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">PIC</th>
          </tr>
          <tr class="table-light">
            <th style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">STOCK</th>
            <th style="font-weight:800; border-bottom: 2px solid #cbd5e1 !important;">TANGGAL</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($reports)): ?>
            <tr>
              <td colspan="12" class="p-5 text-muted">
                <i class="bi bi-shield-check text-success" style="font-size: 2.5rem; display:block; margin-bottom:0.5rem;"></i>
                Tidak ada temuan kondisi abnormal yang tercatat.
              </td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($reports as $r): ?>
              <?php 
                $canEdit = in_array(session()->get('role'), ['member', 'sheadprd', 'sheadmtc', 'admin'], true);
                $rowClass = $canEdit ? 'row-editable' : '';
              ?>
              <tr class="<?= $rowClass ?>" 
                  style="<?= $canEdit ? 'cursor: pointer;' : '' ?> transition: background-color 0.15s;"
                  data-id-abnormal="<?= $r['id_abnormal'] ?>"
                  data-mesin="<?= esc($r['no_mesin'] . ' - ' . $r['type_mesin'] . ' (' . $r['lokasi'] . ')') ?>"
                  data-point-check="<?= esc($r['point_check']) ?>"
                  data-abnormal-condition="<?= esc($r['abnormal_condition']) ?>"
                  data-type-sparepart="<?= esc($r['type_sparepart'] ?? '') ?>"
                  data-progres-stock="<?= esc($r['progres_stock'] ?? '') ?>"
                  data-progres-tanggal="<?= esc($r['progres_tanggal'] ?? '') ?>"
                  data-action="<?= esc($r['action'] ?? '') ?>"
                  data-repair-pic="<?= esc($r['repair_pic'] ?? '') ?>"
                  data-keterangan="<?= esc($r['keterangan'] ?? '') ?>">
                
                <td class="fw-bold font-monospace text-secondary" style="background-color: #f8fafc;"><?= $no++ ?></td>
                <td class="text-start fw-bold text-dark ps-3"><?= esc($r['no_mesin']) ?> - <?= esc($r['type_mesin']) ?></td>
                <td><?= esc($r['point_check']) ?></td>
                <td class="text-danger fw-semibold"><?= esc($r['abnormal_condition']) ?></td>
                <td><?= esc($r['type_sparepart']) ?: '<span class="text-muted small">-</span>' ?></td>
                
                <!-- Pengecekan -->
                <td class="font-monospace"><?= date('d-m-Y', strtotime($r['pengecekan_tanggal'])) ?></td>
                <td><span class="fw-semibold text-dark"><?= esc($r['pengecekan_pic']) ?></span></td>
                
                <!-- Rencana Perbaikan -->
                <td>
                  <?php if ($r['progres_stock'] === 'Ready'): ?>
                    <span class="badge bg-success">Ready</span>
                  <?php elseif ($r['progres_stock'] === 'Indent'): ?>
                    <span class="badge bg-warning text-dark">Indent</span>
                  <?php elseif ($r['progres_stock'] === 'Not Available'): ?>
                    <span class="badge bg-danger">Not Available</span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td class="font-monospace"><?= $r['progres_tanggal'] ? date('d-m-Y', strtotime($r['progres_tanggal'])) : '<span class="text-muted">-</span>' ?></td>
                <td class="text-start"><?= esc($r['action']) ?: '<span class="text-muted">-</span>' ?></td>
                <td><span class="fw-semibold text-dark"><?= esc($r['repair_pic']) ?: '<span class="text-muted">-</span>' ?></span></td>
                
                <td><?= esc($r['keterangan']) ?: '<span class="text-muted">-</span>' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- CSS Border & Hover Guidelines -->
<style>
  .abnormal-table {
    width: 100% !important;
  }
  .abnormal-table th, .abnormal-table td {
    border: 1px solid #cbd5e1 !important;
    vertical-align: middle !important;
  }
  .abnormal-table th {
    background-color: #f1f5f9 !important;
    color: #1e293b !important;
    padding: 0.75rem 0.5rem !important;
    border-bottom: 2px solid #cbd5e1 !important;
  }
  .abnormal-table td {
    padding: 0.6rem 0.6rem !important;
  }
  .row-editable:hover {
    background-color: #f8fafc !important;
  }
</style>

<!-- MODAL QUICK EDIT ABNORMAL (LEADER & ADMIN ONLY) -->
<?php if (in_array(session()->get('role'), ['member', 'sheadprd', 'sheadmtc', 'admin'], true)): ?>
<div class="modal fade" id="editAbnormalModal" tabindex="-1" aria-labelledby="editAbnormalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
        <h6 class="modal-title fw-bold" id="editAbnormalModalLabel"><i class="bi bi-pencil-square text-primary me-1.5"></i>Tindak Lanjut Abnormal Condition</h6>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= site_url('abnormal/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id_abnormal" id="modalIdAbnormal">

        <div class="modal-body px-4 pt-3">
          <div class="mb-3 bg-light p-3 rounded-3 border">
            <span class="text-muted d-block small fw-bold text-uppercase mb-1">Mesin & Temuan</span>
            <div class="fw-bold text-dark" id="modalMesinLabel">MC-01</div>
            <div class="small text-secondary mt-1">
              <strong class="text-danger">Point Check:</strong> <span id="modalPointCheckLabel"></span>
            </div>
            <div class="small text-secondary mt-0.5">
              <strong class="text-danger">Kondisi:</strong> <span id="modalConditionLabel"></span>
            </div>
          </div>

          <!-- Type Sparepart -->
          <div class="mb-3">
            <label class="form-label small fw-semibold">Type Sparepart</label>
            <input type="text" name="type_sparepart" id="modalTypeSparepart" class="form-control form-control-sm rounded-2" placeholder="Nama/Tipe sparepart">
          </div>

          <div class="row g-3 mb-3">
            <!-- Progres Stock -->
            <div class="col-6">
              <label class="form-label small fw-semibold">Progres Stock</label>
              <select name="progres_stock" id="modalProgresStock" class="form-select form-select-sm rounded-2">
                <option value="">-- Pilih Status --</option>
                <option value="Ready">Ready</option>
                <option value="Indent">Indent</option>
                <option value="Not Available">Not Available</option>
              </select>
            </div>
            <!-- Progres Tanggal -->
            <div class="col-6">
              <label class="form-label small fw-semibold">Rencana Tanggal Perbaikan</label>
              <input type="date" name="progres_tanggal" id="modalProgresTanggal" class="form-control form-control-sm rounded-2">
            </div>
          </div>

          <!-- Action -->
          <div class="mb-3">
            <label class="form-label small fw-semibold">Action (Tindakan Perbaikan)</label>
            <textarea name="action" id="modalAction" class="form-control form-control-sm rounded-2" rows="2" placeholder="Ketik deskripsi perbaikan..."></textarea>
          </div>

          <!-- Repair PIC -->
          <div class="mb-3">
            <label class="form-label small fw-semibold">PIC Perbaikan</label>
            <input type="text" name="repair_pic" id="modalRepairPic" class="form-control form-control-sm rounded-2" placeholder="Nama teknisi / PIC perbaikan">
          </div>

          <!-- Keterangan -->
          <div class="mb-3">
            <label class="form-label small fw-semibold">Keterangan Tambahan</label>
            <textarea name="keterangan" id="modalKeterangan" class="form-control form-control-sm rounded-2" rows="2" placeholder="Keterangan / remarks tambahan..."></textarea>
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

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const editModal = new bootstrap.Modal(document.getElementById("editAbnormalModal"));
    const rows = document.querySelectorAll(".row-editable");

    rows.forEach(row => {
      row.addEventListener("click", function() {
        document.getElementById("modalIdAbnormal").value = this.getAttribute("data-id-abnormal");
        document.getElementById("modalMesinLabel").innerText = this.getAttribute("data-mesin");
        document.getElementById("modalPointCheckLabel").innerText = this.getAttribute("data-point-check");
        document.getElementById("modalConditionLabel").innerText = this.getAttribute("data-abnormal-condition");

        document.getElementById("modalTypeSparepart").value = this.getAttribute("data-type-sparepart");
        document.getElementById("modalProgresStock").value = this.getAttribute("data-progres-stock");
        document.getElementById("modalProgresTanggal").value = this.getAttribute("data-progres-tanggal");
        document.getElementById("modalAction").value = this.getAttribute("data-action");
        document.getElementById("modalRepairPic").value = this.getAttribute("data-repair-pic");
        document.getElementById("modalKeterangan").value = this.getAttribute("data-keterangan");

        editModal.show();
      });
    });
  });
</script>
<?php endif; ?>

<?= view('layout/footer') ?>
