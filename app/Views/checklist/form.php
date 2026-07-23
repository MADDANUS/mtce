<?= view('layout/header', ['title' => $title]) ?>

<style>
  .form-header-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; }
  .keterangan-box table td { padding:.25rem .5rem; }
</style>

<div class="page-header d-flex align-items-center">
  <div class="d-flex align-items-center gap-3">
    <?php
      $backUrl = strtolower($jenisSlug) === 'overhaul' 
          ? site_url("checklist") 
          : site_url("checklist/{$lokasiSlug}/{$jenisSlug}");
    ?>
    <a href="<?= $backUrl ?>" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h5 class="mb-0">
      <i class="bi bi-clipboard-check me-2" style="color:var(--accent);"></i>Pengecekan <?= esc($jenisName) ?> — <strong><?= esc($categoryName) ?></strong> <span class="badge bg-secondary ms-1" style="font-size:0.7rem;"><?= esc($lokasiName) ?></span>
    </h5>
  </div>
</div>

<?php
$isEdit = $isEdit ?? false;
$editUrl = $isEdit ? site_url("riwayat/update/{$idTransaksi}") : site_url("checklist/{$lokasiSlug}/{$jenisSlug}/store");
?>

<form action="<?= $editUrl ?>" method="post">
  <?= csrf_field() ?>

  <!-- HEADER FORM: Mesin, Staff, Waktu Mulai -->
  <div class="form-header-box p-3 mb-3 shadow-sm border-0 bg-white">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold">No Mesin (<?= esc($lokasiName) ?>)</label>
        <select name="id_mesin" id="id_mesin" class="form-select searchable-select" required <?= !empty($idMesin) ? 'disabled' : '' ?>>
          <option value="">-- Cari Mesin --</option>
          <?php foreach ($daftarMesin as $m): ?>
            <option value="<?= esc($m['id_mesin']) ?>" data-bar-feeder="<?= esc($m['bar_feeder_type'] ?? '') ?>" <?= (!empty($idMesin) && (int)$idMesin === (int)$m['id_mesin']) ? 'selected' : '' ?>>
              <?= esc($m['no_mesin']) ?> - <?= esc($m['type_mesin']) ?> - <?= esc($m['serial_nomor']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (!empty($idMesin)): ?>
          <input type="hidden" name="id_mesin" value="<?= (int)$idMesin ?>">
        <?php endif; ?>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">PIC</label>
        <select name="nama_pic" class="form-select searchable-select" required>
          <option value="">-- Cari PIC --</option>
          <?php if (isset($masterPic) && !empty($masterPic)): ?>
            <?php foreach ($masterPic as $pic): ?>
              <?php $picVal = esc($pic['id_pic'] . ' - ' . $pic['nama_pic']); ?>
              <option value="<?= $picVal ?>" <?= (isset($namaPic) && $namaPic === $picVal) ? 'selected' : '' ?>><?= $picVal ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Waktu Mulai</label>
        <input type="text" class="form-control" value="<?= esc($waktuMulaiDisplay) ?>" readonly>
        <!-- waktu_mulai dikirim apa adanya ke Controller store() saat submit -->
        <input type="hidden" name="waktu_mulai" value="<?= esc($waktuMulai) ?>">
        <input type="hidden" name="kategori" value="<?= esc($categoryName) ?>">
      </div>
      
      <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
        <div id="overhaulAdditionalFields" class="col-12 p-0 m-0 d-none mt-3">
          <div class="row g-3 mt-0">
            <?php if (strtolower($lokasiSlug) === 'mfg1'): ?>
              <div class="col-md-6">
                <label class="form-label fw-semibold text-primary">Bar Feeder Type</label>
                <input type="text" name="bar_feeder_type" id="barFeederInput" class="form-control border-primary bg-primary bg-opacity-10" placeholder="Otomatis terisi dari master mesin..." value="<?= esc($barFeederType ?? '') ?>" readonly>
              </div>
            <?php endif; ?>
            <div class="col-md-<?= strtolower($lokasiSlug) === 'mfg1' ? '6' : '12' ?>">
              <label class="form-label fw-semibold text-primary">Support PIC (Maksimal 4 Orang)</label>
              <?php 
                $arrSupport = array_filter(array_map('trim', explode(',', $supportPic ?? '')));
              ?>
              <div class="col-12">
                <select name="support_pic[]" class="form-select searchable-select border-primary bg-primary bg-opacity-10" multiple data-max-items="4" data-placeholder="Pilih maksimal 4 PIC Support...">
                  <?php foreach ($masterPic as $pic): ?>
                    <?php $selected = in_array($pic['nama_pic'], $arrSupport) ? 'selected' : ''; ?>
                    <option value="<?= esc($pic['nama_pic']) ?>" <?= $selected ?>>
                      <?= esc($pic['nama_pic']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectMesin = document.getElementById('id_mesin');
            const inputBarFeeder = document.getElementById('barFeederInput');
            const additionalFields = document.getElementById('overhaulAdditionalFields');
            
            function updateFields() {
                if (selectMesin.value && selectMesin.value !== "") {
                    additionalFields.classList.remove('d-none');
                    if(inputBarFeeder && selectMesin.selectedIndex > 0) {
                        const selectedOption = selectMesin.options[selectMesin.selectedIndex];
                        const barFeeder = selectedOption.getAttribute('data-bar-feeder');
                        inputBarFeeder.value = barFeeder || '';
                    }
                } else {
                    additionalFields.classList.add('d-none');
                    if(inputBarFeeder) inputBarFeeder.value = '';
                }
            }

            selectMesin.addEventListener('change', updateFields);
            
            if (selectMesin.value) {
                updateFields();
            }
        });
        </script>
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
                <?php if (strtolower($lokasiSlug) !== 'mfg2'): ?>
                  <th style="width:15%;">STANDAR ITEM</th>
                <?php endif; ?>
                <th style="width:12%;">CHECK LIST</th>
                <th style="<?= strtolower($lokasiSlug) === 'mfg2' ? 'width:33%;' : 'width:18%;' ?>">REMARK</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $itemIndex = 0;
                $perPage = 49;
              ?>
              <?php foreach ($rows as $r): ?>
                <?php 
                  $itemIndex++;
                  if (strtolower($categorySlug) === 'kasahara-tapping') {
                      if ($itemIndex <= 32) $pageNo = 1;
                      elseif ($itemIndex <= 68) $pageNo = 2;
                      else $pageNo = 3;
                  } elseif (strtolower($categorySlug) === 'double-milling') {
                      if ($itemIndex <= 36) $pageNo = 1;
                      else $pageNo = 2;
                  } elseif (strtolower($categorySlug) === 'double-center-drill') {
                      if ($itemIndex <= 40) $pageNo = 1;
                      else $pageNo = 2;
                  } elseif (strtolower($categorySlug) === 'centering-grinding') {
                      if ($itemIndex <= 32) $pageNo = 1;
                      elseif ($itemIndex <= 72) $pageNo = 2;
                      else $pageNo = 3;
                  } else {
                      $pageNo = ceil($itemIndex / $perPage);
                  }
                  $rowCategory = $r['kategori'] ?? ''; 
                ?>
                <?php if ($r['is_section_start']): ?>
                  <tr class="section-header page-row-mfg2" data-page="<?= $pageNo ?>" data-kategori="<?= esc($rowCategory) ?>" style="background-color: #ffffff; font-weight: 700;">
                    <td colspan="7" class="py-2 px-3" style="color: #000000; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">
                      <?= esc($r['dynamic_section_header']) ?>
                    </td>
                  </tr>
                <?php endif; ?>
                <tr class="page-row-mfg2" data-page="<?= $pageNo ?>" data-kategori="<?= esc($rowCategory) ?>">
                  <?php if ($r['show_no']): ?>
                    <td class="text-center fw-semibold text-muted" rowspan="<?= (int) $r['no_rowspan'] ?>"><?= esc($r['dynamic_no']) ?></td>
                  <?php endif; ?>

                  <?php if ($r['sub_item_check']): ?>
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

                  <?php if (strtolower($lokasiSlug) !== 'mfg2'): ?>
                    <?php if ($r['show_standard']): ?>
                      <td rowspan="<?= (int) $r['standard_rowspan'] ?>"><?= nl2br(esc($r['standard_check'])) ?></td>
                    <?php endif; ?>
                  <?php endif; ?>

                  <td>
                    <?php
                    $h = $detailsMap[$r['id_parameter']]['hasil_check'] ?? '';
                    $u = $detailsMap[$r['id_parameter']]['ulasan'] ?? '';
                    ?>
                    <div class="d-flex">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="v_<?= (int) $r['id_parameter'] ?>" value="V" <?= $h === 'V' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-success fw-bold" for="v_<?= (int) $r['id_parameter'] ?>">V</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="d_<?= (int) $r['id_parameter'] ?>" value="Δ" <?= $h === 'Δ' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-warning fw-bold" for="d_<?= (int) $r['id_parameter'] ?>">Δ</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="x_<?= (int) $r['id_parameter'] ?>" value="X" <?= $h === 'X' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-danger fw-bold" for="x_<?= (int) $r['id_parameter'] ?>">X</label>
                      </div>
                    </div>
                  </td>

                  <td>
                    <textarea class="form-control form-control-sm"
                              name="ulasan[<?= (int) $r['id_parameter'] ?>]"
                              placeholder="Tulis ulasan/keterangan..."
                              rows="1"
                              style="min-height: 38px; resize: vertical; font-size: 0.85rem;"><?= esc($u) ?></textarea>
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
                    <?php
                    $h = $detailsMap[$r['id_parameter']]['hasil_check'] ?? '';
                    $u = $detailsMap[$r['id_parameter']]['ulasan'] ?? '';
                    ?>
                    <div class="d-flex">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="v_<?= (int) $r['id_parameter'] ?>" value="V" <?= $h === 'V' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-success fw-bold" for="v_<?= (int) $r['id_parameter'] ?>">V</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="d_<?= (int) $r['id_parameter'] ?>" value="Δ" <?= $h === 'Δ' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-warning fw-bold" for="d_<?= (int) $r['id_parameter'] ?>">Δ</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="hasil_check[<?= (int) $r['id_parameter'] ?>]"
                               id="x_<?= (int) $r['id_parameter'] ?>" value="X" <?= $h === 'X' ? 'checked' : '' ?> required>
                        <label class="form-check-label text-danger fw-bold" for="x_<?= (int) $r['id_parameter'] ?>">X</label>
                      </div>
                    </div>
                  </td>

                  <td>
                    <textarea class="form-control form-control-sm"
                              name="ulasan[<?= (int) $r['id_parameter'] ?>]"
                              placeholder="Tulis ulasan/keterangan..."
                              rows="1"
                              style="min-height: 38px; resize: vertical; font-size: 0.85rem;"><?= esc($u) ?></textarea>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      <?php endif; ?>

      <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
        <div class="mt-4 border rounded p-3 bg-light shadow-sm">
          <label class="form-label fw-bold text-secondary mb-2" style="letter-spacing: 0.5px;">NOTE AND RECOMMENDATION</label>
          <textarea name="note_recommendation" class="form-control" rows="4" placeholder="Ketikkan catatan atau rekomendasi di sini..."><?= esc($noteRecommendation ?? '') ?></textarea>
        </div>
      <?php endif; ?>
    </div>

    <!-- KETERANGAN CHECK LIST -->
    <div class="col-lg-3">
      <div class="keterangan-box p-3 shadow-sm mb-3">
        <div class="fw-semibold mb-2 text-dark border-bottom pb-2">KETERANGAN CHECK LIST</div>
        <table class="table table-sm mb-0">
          <tr><td class="fw-bold text-success">V</td><td>:</td><td>OK</td></tr>
          <tr><td class="fw-bold text-warning">Δ</td><td>:</td><td>PERLU TINDAKAN</td></tr>
          <tr><td class="fw-bold text-danger">X</td><td>:</td><td>TIDAK ADA</td></tr>
        </table>
      </div>
      
      <?php if (strtolower($jenisSlug) === 'overhaul' && strtolower($lokasiSlug) === 'mfg1'): ?>
        <div class="card bg-light border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">Navigasi Form</h6>
                <div class="d-grid gap-2">
                    <button type="button" id="btnMesinCnc" class="btn btn-outline-primary active">1. Mesin CNC</button>
                    <button type="button" id="btnBarFeeder" class="btn btn-outline-primary">2. Bar Feeder CNC</button>
                </div>
            </div>
        </div>

      <?php elseif (strtolower($jenisSlug) === 'overhaul' && strtolower($lokasiSlug) === 'mfg2' && $itemIndex > $perPage): ?>
        <?php 
          if (strtolower($categorySlug) === 'kasahara-tapping') {
              $totalPages = 3;
          } elseif (strtolower($categorySlug) === 'double-milling') {
              $totalPages = 2;
          } elseif (strtolower($categorySlug) === 'double-center-drill') {
              $totalPages = 2;
          } elseif (strtolower($categorySlug) === 'centering-grinding') {
              $totalPages = 3;
          } else {
              $totalPages = ceil($itemIndex / $perPage); 
          }
        ?>
        <div class="card bg-light border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">Navigasi Halaman</h6>
                <div class="d-grid gap-2" id="navPageContainer">
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <button type="button" class="btn btn-outline-primary btn-nav-page <?= $p === 1 ? 'active' : '' ?>" data-target="<?= $p ?>">Halaman <?= $p ?></button>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Checklist Control is automatically populated in the background upon submission -->

  <?php if (!empty($rows)): ?>
    <div class="d-flex justify-content-end mt-4 mb-5 gap-3">
      <?php if (strtolower($jenisSlug) === 'overhaul' && strtolower($lokasiSlug) === 'mfg1'): ?>
        <button type="button" id="btnNext" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">Lanjut ke Bar Feeder <i class="bi bi-arrow-right ms-2"></i></button>
        <button type="button" id="btnPrev" class="btn btn-secondary px-4 py-2 fw-semibold shadow-sm" style="display:none;"><i class="bi bi-arrow-left me-2"></i> Kembali</button>
        <button type="submit" id="btnSubmit" class="btn btn-success px-5 py-2 fw-semibold shadow-sm" style="display:none;">Submit Pengecekan</button>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tr[data-kategori]');
            const btnNext = document.getElementById('btnNext');
            const btnPrev = document.getElementById('btnPrev');
            const btnSubmit = document.getElementById('btnSubmit');
            const navMesin = document.getElementById('btnMesinCnc');
            const navBarFeeder = document.getElementById('btnBarFeeder');

            let currentView = 'Mesin CNC';

            function updateView() {
                rows.forEach(row => {
                    if (row.getAttribute('data-kategori') === currentView || row.getAttribute('data-kategori') === '') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (currentView === 'Mesin CNC') {
                    btnNext.style.display = '';
                    btnPrev.style.display = 'none';
                    btnSubmit.style.display = 'none';
                    if(navMesin) navMesin.classList.add('active');
                    if(navBarFeeder) navBarFeeder.classList.remove('active');
                } else {
                    btnNext.style.display = 'none';
                    btnPrev.style.display = '';
                    btnSubmit.style.display = '';
                    if(navMesin) navMesin.classList.remove('active');
                    if(navBarFeeder) navBarFeeder.classList.add('active');
                }
            }

            function validateCurrentView() {
                let isValid = true;
                let firstUnchecked = null;
                let missingItems = [];
                let currentNo = '';
                let currentBagian = '';
                
                rows.forEach(row => {
                    if (row.getAttribute('data-kategori') === currentView) {
                        const noCell = row.querySelector('.text-muted');
                        if (noCell) currentNo = noCell.innerText.trim();
                        
                        const bagianCell = row.querySelector('.bagian-cell');
                        if (bagianCell) currentBagian = bagianCell.innerText.trim();
                        
                        const radios = row.querySelectorAll('input[type="radio"]');
                        if (radios.length > 0) {
                            const isChecked = row.querySelector('input[type="radio"]:checked');
                            if (!isChecked) {
                                isValid = false;
                                row.classList.add('table-danger');
                                if (!firstUnchecked) firstUnchecked = row;
                                
                                let itemName = currentNo;
                                if (currentBagian) itemName += ' ' + currentBagian;
                                missingItems.push(itemName.trim() || 'Item tanpa nama');
                            } else {
                                row.classList.remove('table-danger');
                            }
                        }
                    }
                });
                
                if (!isValid && firstUnchecked) {
                    let uniqueMissing = [...new Set(missingItems)];
                    let missingHtml = '<ul class="text-start" style="max-height: 200px; overflow-y: auto; font-size: 0.9rem;">';
                    uniqueMissing.forEach(item => {
                        missingHtml += '<li>' + item + '</li>';
                    });
                    missingHtml += '</ul>';
                    
                    if (typeof Swal !== 'undefined') {
                        firstUnchecked.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap!',
                            html: '<p>Terdapat isian yang belum diisi pada bagian <b>' + currentView + '</b>:</p>' + missingHtml,
                            confirmButtonText: 'Tutup',
                            returnFocus: false
                        });
                    } else {
                        firstUnchecked.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        alert('Mohon lengkapi poin pengecekan berikut pada ' + currentView + ':\n\n' + uniqueMissing.join('\n'));
                    }
                }
                
                return isValid;
            }

            function validateHeader() {
                let missingHeader = [];
                const idMesin = document.getElementById('id_mesin');
                const namaPic = document.querySelector('select[name="nama_pic"]');

                if (idMesin && !idMesin.value) missingHeader.push('No Mesin');
                if (namaPic && !namaPic.value) missingHeader.push('PIC');

                if (missingHeader.length > 0) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap!',
                            text: 'Mohon isi ' + missingHeader.join(' dan ') + ' terlebih dahulu di bagian atas form.',
                            confirmButtonText: 'Tutup',
                            returnFocus: false
                        }).then(() => {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                    } else {
                        alert('Mohon isi ' + missingHeader.join(' dan ') + ' terlebih dahulu di bagian atas form.');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    return false;
                }
                return true;
            }

            if (rows.length > 0) {
                updateView();

                btnNext.addEventListener('click', () => {
                    if (!validateHeader()) return;
                    if (!validateCurrentView()) return;
                    currentView = 'Bar Feeder CNC';
                    updateView();
                    window.scrollTo(0, 0);
                });

                btnPrev.addEventListener('click', () => {
                    currentView = 'Mesin CNC';
                    updateView();
                    window.scrollTo(0, 0);
                });
                
                if(navMesin) navMesin.addEventListener('click', () => {
                    currentView = 'Mesin CNC';
                    updateView();
                });
                
                if(navBarFeeder) navBarFeeder.addEventListener('click', () => {
                    if (currentView === 'Mesin CNC') {
                        if (!validateHeader()) return;
                        if (!validateCurrentView()) return;
                    }
                    currentView = 'Bar Feeder CNC';
                    updateView();
                });
            } else {
                btnSubmit.style.display = '';
                btnNext.style.display = 'none';
            }
        });
        </script>
      <?php elseif (strtolower($jenisSlug) === 'overhaul' && strtolower($lokasiSlug) === 'mfg2' && $itemIndex > $perPage): ?>
        <button type="button" id="btnPrevPage" class="btn btn-secondary px-4 py-2 fw-semibold shadow-sm" style="display:none;"><i class="bi bi-arrow-left me-2"></i> Halaman Sebelumnya</button>
        <button type="button" id="btnNextPage" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">Halaman Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
        <button type="submit" id="btnSubmitPage" class="btn btn-success px-5 py-2 fw-semibold shadow-sm" style="display:none;">Submit Pengecekan</button>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mfg2Rows = document.querySelectorAll('.page-row-mfg2');
            if (mfg2Rows.length === 0) return;

            const btnNext = document.getElementById('btnNextPage');
            const btnPrev = document.getElementById('btnPrevPage');
            const btnSubmit = document.getElementById('btnSubmitPage');
            const navButtons = document.querySelectorAll('.btn-nav-page');
            const totalPages = <?= $totalPages ?>;
            let currentPage = 1;

            function updatePageView() {
                mfg2Rows.forEach(row => {
                    if (parseInt(row.getAttribute('data-page')) === currentPage) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                navButtons.forEach(btn => {
                    if (parseInt(btn.getAttribute('data-target')) === currentPage) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });

                if (currentPage === 1) {
                    btnPrev.style.display = 'none';
                    btnNext.style.display = '';
                    btnSubmit.style.display = 'none';
                } else if (currentPage === totalPages) {
                    btnPrev.style.display = '';
                    btnNext.style.display = 'none';
                    btnSubmit.style.display = '';
                } else {
                    btnPrev.style.display = '';
                    btnNext.style.display = '';
                    btnSubmit.style.display = 'none';
                }
            }

            function validateCurrentPage() {
                let isValid = true;
                let firstUnchecked = null;
                let missingItems = [];
                let currentBagian = '';
                
                mfg2Rows.forEach(row => {
                    if (parseInt(row.getAttribute('data-page')) === currentPage) {
                        const bagianCell = row.querySelector('.bagian-cell');
                        if (bagianCell) currentBagian = bagianCell.innerText.trim();
                        
                        const radios = row.querySelectorAll('input[type="radio"]');
                        if (radios.length > 0) {
                            const isChecked = row.querySelector('input[type="radio"]:checked');
                            if (!isChecked) {
                                isValid = false;
                                row.classList.add('table-danger');
                                if (!firstUnchecked) firstUnchecked = row;
                                
                                missingItems.push(currentBagian || 'Item tanpa nama');
                            } else {
                                row.classList.remove('table-danger');
                            }
                        }
                    }
                });
                
                if (!isValid && firstUnchecked) {
                    let uniqueMissing = [...new Set(missingItems)];
                    let missingHtml = '<ul class="text-start" style="max-height: 200px; overflow-y: auto; font-size: 0.9rem;">';
                    uniqueMissing.forEach(item => {
                        missingHtml += '<li>' + item + '</li>';
                    });
                    missingHtml += '</ul>';
                    
                    if (typeof Swal !== 'undefined') {
                        firstUnchecked.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap!',
                            html: '<p>Terdapat isian yang belum diisi pada <b>Halaman ' + currentPage + '</b>:</p>' + missingHtml,
                            confirmButtonText: 'Tutup',
                            returnFocus: false
                        });
                    } else {
                        firstUnchecked.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        alert('Mohon lengkapi poin pengecekan berikut pada Halaman ' + currentPage + ':\n\n' + uniqueMissing.join('\n'));
                    }
                }
                
                return isValid;
            }

            function validateHeader() {
                let missingHeader = [];
                const idMesin = document.getElementById('id_mesin');
                const namaPic = document.querySelector('select[name="nama_pic"]');

                if (idMesin && !idMesin.value) missingHeader.push('No Mesin');
                if (namaPic && !namaPic.value) missingHeader.push('PIC');

                if (missingHeader.length > 0) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap!',
                            text: 'Mohon isi ' + missingHeader.join(' dan ') + ' terlebih dahulu di bagian atas form.',
                            confirmButtonText: 'Tutup',
                            returnFocus: false
                        }).then(() => {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                    } else {
                        alert('Mohon isi ' + missingHeader.join(' dan ') + ' terlebih dahulu di bagian atas form.');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    return false;
                }
                return true;
            }

            updatePageView();

            btnNext.addEventListener('click', () => {
                if (!validateHeader()) return;
                if (!validateCurrentPage()) return;
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePageView();
                    window.scrollTo(0, 0);
                }
            });

            btnPrev.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePageView();
                    window.scrollTo(0, 0);
                }
            });

            navButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    let targetPage = parseInt(btn.getAttribute('data-target'));
                    if (targetPage > currentPage) {
                        if (!validateHeader()) return;
                        if (!validateCurrentPage()) return;
                    }
                    currentPage = targetPage;
                    updatePageView();
                    window.scrollTo(0, 0);
                });
            });
        });
        </script>
      <?php else: ?>
        <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">Submit Pengecekan</button>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</form>

<?= view('layout/footer') ?>

