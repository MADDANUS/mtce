<?= view('layout/header', ['title' => $title]) ?>



<div class="d-flex align-items-center mb-3">
  <a href="<?= site_url('kontrol?view=summary') ?>" class="btn btn-outline-secondary btn-sm me-3 shadow-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
  <div class="ms-auto">
    <a href="<?= site_url('kontrol/pdf?lokasi=' . urlencode($lokasi) . '&kategori=' . urlencode($kategori) . '&bulan=' . urlencode($bulan) . '&line=' . urlencode($line)) ?>" target="_blank" class="btn btn-sm btn-outline-danger fw-semibold shadow-sm">
      <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download PDF
    </a>
  </div>
</div>

<table class="kop-table text-center shadow-sm">
  <tr>
    <td colspan="6" class="kop-table-title" style="padding: 10px;">CHECKLIST CONTROL - <?= strtoupper(esc($kategori)) ?></td>
  </tr>
  <tr>
    <td class="kop-label text-start">AREA</td>
    <td class="kop-val text-start"><?= esc($lokasi) ?> <?= $line ? '/ ' . esc($line) : '' ?></td>
    <td class="kop-label text-start">KATEGORI</td>
    <td class="kop-val text-start"><?= esc($kategori) ?></td>
    <td class="kop-label text-start">BULAN</td>
    <td class="kop-val text-start"><?= esc($bulanList[$bulan] ?? $bulan) ?></td>
  </tr>
</table>

<!-- GRID TABEL KONTROL -->
<div class="card border-0 shadow-sm bg-white overflow-hidden mb-4">
  

  <div class="card-body p-0">
    <div class="table-responsive" style="border: 1px solid var(--border-strong) !important; border-radius: var(--radius);">
      <table class="table align-middle text-center mb-0 kontrol-table" style="font-size: 0.85rem; border-collapse: collapse !important;">
        <thead>
          <tr>
            <th rowspan="3" style="width: 5%; font-weight:700; vertical-align: middle;">NO</th>
            <th rowspan="3" style="width: 25%; font-weight:700; vertical-align: middle; text-align: left;" class="ps-4">MESIN</th>
            <th colspan="5" style="width: 35%; font-weight:700;">WAKTU</th>
            <th rowspan="3" style="width: 15%; font-weight:700; vertical-align: middle;">OUT OF PLAN</th>
            <th rowspan="3" style="width: 20%; font-weight:700; vertical-align: middle; text-align: left;" class="ps-4">ULASAN</th>
          </tr>
          <tr>
            <th colspan="5" style="font-weight:700; text-transform: uppercase;">
              <?= isset($bulanList[$bulan]) ? strtoupper($bulanList[$bulan]) : strtoupper($bulan) ?>
            </th>
          </tr>
          <tr>
          <?php for ($col = 1; $col <= 5; $col++): ?>
            <th style="width: 7%; font-weight:700; font-size: 0.8rem; vertical-align: middle;">
              <?php if ($hasSchedule && !empty($columnDates[$col])): ?>
                <span class="d-block fw-bolder" style="color: #fef08a !important; font-size: 0.95rem;"><?= date('d', strtotime($columnDates[$col])) ?></span>
              <?php else: ?>
                P<?= $col ?>
              <?php endif; ?>
            </th>
          <?php endfor; ?>
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
                <td rowspan="2" class="fw-bold font-monospace text-secondary" style="background-color: #faf9f6; border-bottom: 2px solid #d6d3d1 !important; vertical-align: middle !important;"><?= $no++ ?></td>
                <td class="text-start fw-bold text-dark ps-4 py-2" style="border-bottom: 1px solid #e7e5e4 !important; background-color: #fff;">
                  <?= esc($m['jenis']) ?> <?= esc($m['no_mesin']) ?>
                </td>
                
                <!-- Periode 1 s.d 5 Cells (Status Check) -->
                <?php for ($p = 1; $p <= 5; $p++): ?>
                  <?php 
                    $cell = $row['periodes'][$p]; 
                    $status = $cell ? $cell['status_check'] : '';
                    $badgeClass = '';
                    
                    if ($status === 'V') $badgeClass = 'bg-success';
                    elseif ($status === 'Δ') $badgeClass = 'bg-warning text-dark';
                    elseif ($status === 'X') $badgeClass = 'bg-danger';
                  ?>
                  <td class="p-1" style="transition: background-color 0.15s; border-bottom: 1px solid #e7e5e4 !important;"
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
                <td class="font-monospace text-center py-2" style="font-size: 0.75rem; border-bottom: 1px solid #e7e5e4 !important; background-color: #fff;">
                  <?php if (!empty($row['out_of_plan'])): ?>
                    <span class="text-danger fw-bold d-block" style="font-size: 0.7rem;">Out of Plan</span>
                    <span class="text-secondary fw-semibold" style="font-size: 0.65rem;"><?= date('d-m-Y', strtotime($row['out_of_plan'])) ?></span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>

                <!-- Ulasan (Top cell) -->
                <td class="text-start ps-4 py-2 text-muted text-truncate" style="max-width: 150px; border-bottom: 1px solid #e7e5e4 !important; background-color: #fff;" title="<?= esc($row['ulasan']) ?>">
                  <?= esc($row['ulasan']) ?: '-' ?>
                </td>
              </tr>

              <!-- BARIS PIC -->
              <tr>
                <td class="text-start text-secondary ps-4 py-1.5" style="font-size: 0.75rem; background-color: #faf9f6; border-bottom: 2px solid #d6d3d1 !important; border-top: 0 !important;">
                  <span class="fw-bold text-muted text-uppercase me-1.5" style="font-size:0.625rem; letter-spacing: 0.05em;">PIC</span>
                </td>
                
                <!-- Periode 1 s.d 5 Cells (PIC Nama) -->
                <?php for ($p = 1; $p <= 5; $p++): ?>
                  <?php 
                    $cell = $row['periodes'][$p]; 
                    $status = $cell ? $cell['status_check'] : '';
                    $pic = $cell ? $cell['pic_nama'] : '';
                  ?>
                  <td class="py-1.5 px-1 font-monospace" style="font-size: 0.68rem; transition: background-color 0.15s; border-bottom: 2px solid #d6d3d1 !important; background-color: #faf9f6;"
                      data-id-kontrol="<?= $cell ? $cell['id_kontrol'] : '0' ?>"
                      data-id-mesin="<?= $idMesin ?>"
                      data-no-mesin="<?= esc($m['no_mesin']) ?>"
                      data-periode="<?= $p ?>"
                      data-status="<?= $status ?>"
                      data-pic="<?= esc($pic) ?>"
                      data-out-of-plan="<?= $cell ? esc($cell['out_of_plan']) : '' ?>"
                      data-ulasan="<?= $cell ? esc($cell['ulasan']) : '' ?>">
                    <?php
                      $picParts = explode(' - ', $pic);
                      $picOnly = end($picParts);
                    ?>
                    <span class="fw-semibold text-dark"><?= esc($picOnly) ?: '-' ?></span>
                  </td>
                <?php endfor; ?>

                <!-- Out of Plan (Bottom Cell - Empty) -->
                <td style="border-bottom: 2px solid #d6d3d1 !important; background-color: #faf9f6;"></td>

                <!-- Ulasan (Bottom Cell - Empty) -->
                <td style="border-bottom: 2px solid #d6d3d1 !important; background-color: #faf9f6;"></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- KOTAK TANDA TANGAN (SIGNATURE BLOCK) -->
<div class="card border-0 shadow-sm bg-white mb-4">
  <div class="card-body p-4">
    <div class="row text-center align-items-end" style="min-height: 120px;">
      
      <!-- Dibuat Oleh (PIC LINE) -->
      <div class="col-4 border-end">
        <p class="mb-0 fw-semibold text-muted small">Dibuat Oleh</p>
        <p class="mb-2 fw-bold text-dark small">PIC LINE</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (isset($approvalData['approved_l1_by'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Disetujui
            </span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark">
          <?php if (isset($approvalData['approved_l1_by'])): ?>
            <span class="text-decoration-underline"><?= esc($approvalData['pic_line_nama'] ?? $approvalData['l1_name']) ?></span>
          <?php else: ?>
            <span class="text-muted">( ........................................ )</span>
          <?php endif; ?>
        </h6>
        <span class="small text-muted">
          <?php if (isset($approvalData['approved_l1_at'])): ?>
            Tanggal: <?= date('d-m-Y H:i', strtotime($approvalData['approved_l1_at'])) ?>
          <?php else: ?>
            Tanggal: ( ......................... )
          <?php endif; ?>
        </span>
      </div>

      <!-- Disetujui Oleh (Leader/SHead Produksi) -->
      <div class="col-4 border-end">
        <p class="mb-0 fw-semibold text-muted small">Disetujui Oleh</p>
        <p class="mb-2 fw-bold text-dark small">SECTION HEAD PRODUKSI</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (isset($approvalData['approved_l2_by'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Disetujui
            </span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark">
          <?php if (isset($approvalData['approved_l2_by'])): ?>
            <span class="text-decoration-underline">Mr. Rohmad</span>
          <?php else: ?>
            <span class="text-muted">( Mr. Rohmad )</span>
          <?php endif; ?>
        </h6>
        <span class="small text-muted">
          <?php if (isset($approvalData['approved_l2_at'])): ?>
            Tanggal: <?= date('d-m-Y H:i', strtotime($approvalData['approved_l2_at'])) ?>
          <?php else: ?>
            Tanggal: ( ......................... )
          <?php endif; ?>
        </span>
      </div>

      <!-- Disetujui Oleh (SHead MTC) -->
      <div class="col-4">
        <p class="mb-0 fw-semibold text-muted small">Disetujui Oleh</p>
        <p class="mb-2 fw-bold text-dark small">SECTION HEAD MTC</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (isset($approvalData['approved_final_by'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Disetujui
            </span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark">
          <?php if (isset($approvalData['approved_final_by'])): ?>
            <span class="text-decoration-underline">Mr. Royadi</span>
          <?php else: ?>
            <span class="text-muted">( Mr. Royadi )</span>
          <?php endif; ?>
        </h6>
        <span class="small text-muted">
          <?php if (isset($approvalData['approved_final_at'])): ?>
            Tanggal: <?= date('d-m-Y H:i', strtotime($approvalData['approved_final_at'])) ?>
          <?php else: ?>
            Tanggal: ( ......................... )
          <?php endif; ?>
        </span>
      </div>

    </div>
  </div>
</div>

<!-- CSS Hover Effects & Strict Borders -->
<style>
  .kontrol-table {
    border-collapse: collapse !important;
    width: 100% !important;
    font-family: 'Inter', sans-serif !important;
  }
  .kontrol-table th, .kontrol-table td {
    border: 1px solid #e7e5e4 !important;
    vertical-align: middle !important;
  }
  .kontrol-table th {
    background: linear-gradient(135deg, #0f766e 0%, #115e59 100%) !important;
    color: #ffffff !important;
    padding: 0.85rem 1rem !important;
    border: 1px solid #134e4a !important;
    font-size: 0.82rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }
  .kontrol-table td {
    padding: 0.85rem 1rem !important;
    font-size: 0.875rem !important;
  }
  .bg-success {
    background-color: #0d9488 !important;
    color: #ffffff !important;
  }
  .bg-warning {
    background-color: #f59e0b !important;
    color: #ffffff !important;
  }
  .bg-danger {
    background-color: #dc2626 !important;
    color: #ffffff !important;
  }
</style>



<?php if (service('request')->getGet('auto') == 1): ?>
<script>
  setTimeout(function() {
    window.location.href = "<?= site_url('abnormal') ?>";
  }, 1500);
</script>
<?php endif; ?>

<?= view('layout/footer') ?>






