<?= view('layout/header', ['title' => $title]) ?>

<div class="dashboard-header mb-4">
    <div class="d-flex align-items-center justify-content-between position-relative" style="z-index: 2;">
        <div>
            <h2 class="fw-bold mb-1">Halo, <?= esc(ucwords(session('nama'))) ?>! 👋</h2>
            <p class="mb-0 opacity-75">Pantau kinerja maintenance dan status pengecekan dari seluruh PIC hari ini.</p>
        </div>
        <div class="d-none d-md-block text-white opacity-50">
            <i class="bi bi-graph-up-arrow" style="font-size: 4rem;"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
  <div class="col-md-4">
    <div class="card-stat-premium grad-cyan p-4">
      <div class="text-white-50 small fw-bold text-uppercase tracking-wider mb-2">Total Pengecekan</div>
      <div class="value display-5 fw-bolder mb-0"><?= (int) $totalTransaksi ?></div>
      <i class="bi bi-file-earmark-bar-graph-fill watermark-icon"></i>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat-premium grad-emerald p-4">
      <div class="text-white-50 small fw-bold text-uppercase tracking-wider mb-2">Rata-rata Durasi</div>
      <div class="value fs-3 fw-bolder mb-0 mt-2"><?= gmdate('i \m\e\n\i\t s \d\e\t\i\k', $rataDetik) ?></div>
      <i class="bi bi-stopwatch-fill watermark-icon"></i>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat-premium grad-rose p-4 border-0">
      <div class="text-white-50 small fw-bold text-uppercase tracking-wider mb-2">Temuan Perlu Tindakan</div>
      <div class="value display-5 fw-bolder mb-0"><?= (int) $perluTindakan ?></div>
      <i class="bi bi-exclamation-triangle-fill watermark-icon"></i>
    </div>
  </div>
</div>

<?php if (isset($pendingKontrol) && !empty($pendingKontrol)): ?>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 border-start border-warning border-4" style="border-left-width: 4px !important;">
  <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>Menunggu Persetujuan Anda (Ceklis Kontrol Bulanan)</h5>
  </div>
  <div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Lokasi</th>
            <th>Line</th>
            <th>Kategori</th>
            <th>Bulan</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="border-top-0">
          <?php foreach ($pendingKontrol as $pk): ?>
            <tr>
              <td class="ps-4 fw-semibold text-secondary"><?= esc($pk['lokasi']) ?></td>
              <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25"><?= esc($pk['line'] ?? '-') ?></span></td>
              <td class="fw-medium text-dark"><?= esc($pk['kategori']) ?></td>
              <td class="fw-medium"><?= date('F Y', strtotime($pk['bulan_tahun'] . '-01')) ?></td>
              <td>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2"><?= esc($pk['status']) ?></span>
              </td>
              <td class="pe-4 text-end">
                <a href="<?= site_url('kontrol?lokasi=' . urlencode($pk['lokasi']) . '&line=' . urlencode($pk['line']) . '&kategori=' . urlencode($pk['kategori']) . '&bulan=' . urlencode($pk['bulan_tahun'])) ?>" class="btn btn-sm btn-primary fw-bold rounded-pill px-3"><i class="bi bi-search me-1"></i> Periksa</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if (isset($pendingOverhaul) && !empty($pendingOverhaul)): ?>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 border-start border-danger border-4" style="border-left-width: 4px !important;">
  <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>Menunggu Persetujuan Anda (Inspection Report)</h5>
  </div>
  <div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Transaksi</th>
            <th>Mesin</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="border-top-0">
          <?php foreach ($pendingOverhaul as $po): ?>
            <tr>
              <td class="ps-4 fw-semibold text-secondary">#<?= esc($po['id_transaksi']) ?></td>
              <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25"><?= esc($po['id_mesin']) ?></span></td>
              <td class="fw-medium text-dark"><?= esc($po['kategori']) ?></td>
              <td class="fw-medium"><?= date('d-m-Y H:i', strtotime($po['waktu_mulai'])) ?></td>
              <td>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2"><?= esc($po['status']) ?></span>
              </td>
              <td class="pe-4 text-end">
                <a href="<?= site_url('riwayat/' . $po['id_transaksi']) ?>" class="btn btn-sm btn-primary fw-bold rounded-pill px-3"><i class="bi bi-search me-1"></i> Periksa</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
  <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Pengecekan Terbaru (Semua PIC)</h5>
    <a href="<?= site_url('laporan/durasi') ?>" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3">Lihat Laporan Lengkap</a>
  </div>
  <div class="card-body px-0 pt-0 pb-2">
    <?php if (empty($terbaru)): ?>
      <div class="text-center py-5">
        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
        <p class="text-muted mt-3 mb-0">Belum ada pengecekan.</p>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 5%;" class="ps-4 text-center">NO</th>
              <th>PIC</th>
              <th>MESIN</th>
              <th>JENIS</th>
              <th>WAKTU MULAI</th>
              <th>Durasi</th>
              <th>Status</th>
              <th class="pe-4 text-end">Aksi</th>
            </tr>
          </thead>
          <tbody class="border-top-0">
            <?php $no = 1; ?>
            <?php foreach ($terbaru as $t): ?>
              <tr>
                <td class="ps-4 fw-semibold text-secondary text-center"><?= $no++ ?></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle me-2 bg-primary bg-opacity-10 text-primary fw-bold" style="width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem;">
                      <?= strtoupper(substr($t['nama_pic'] ?: $t['nama_staff'], 0, 1)) ?>
                    </div>
                    <span class="fw-medium text-dark"><?= esc($t['nama_pic'] ?: $t['nama_staff']) ?></span>
                  </div>
                </td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25"><?= esc($t['no_mesin']) ?></span></td>
                <td>
                  <?php if (strtolower($t['jenis_check']) === 'overhaul'): ?>
                    <span class="badge bg-primary">Inspection Report</span>
                  <?php else: ?>
                    <span class="badge bg-info text-dark">Checklist Report</span>
                  <?php endif; ?>
                </td>
                <td class="text-muted small"><?= date('d M Y, H:i', strtotime($t['waktu_mulai'])) ?></td>
                <td class="fw-medium"><?= $t['durasi_detik'] !== null ? gmdate('i:s', (int) $t['durasi_detik']) . ' m' : '-' ?></td>
                <td>
                  <?php if (($t['status'] ?? 'Pending') === 'Approved'): ?>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Approved</span>
                  <?php else: ?>
                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">Pending</span>
                  <?php endif; ?>
                </td>
                <td class="pe-4 text-end">
                  <a href="<?= site_url('riwayat/' . $t['id_transaksi']) ?>" class="btn btn-sm btn-light text-primary border-0 bg-primary bg-opacity-10 fw-bold rounded-pill px-3">Detail</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?= view('layout/footer') ?>
