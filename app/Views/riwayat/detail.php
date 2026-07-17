<?= view('layout/header', ['title' => $title]) ?>

<div class="page-header">
  <h5><i class="bi bi-clipboard-check me-2 text-primary"></i>Detail Pengecekan <span class="badge bg-primary ms-1">#<?= (int) $header['id_transaksi'] ?></span></h5>
  <a href="<?= site_url('riwayat') ?>" class="btn btn-sm btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<div class="card-stat p-3 mb-3">
  <div class="row g-3 align-items-center">
    <div class="col-md-2">
      <div class="text-muted small">Staff / PIC</div>
      <div class="fw-semibold"><?= esc($header['nama_pic'] ?: $header['nama_staff']) ?></div>
    </div>
    <div class="col-md-3">
      <div class="text-muted small">Mesin</div>
      <div class="fw-semibold"><?= esc($header['no_mesin']) ?> - <?= esc($header['type_mesin']) ?></div>
    </div>
    <div class="col-md-2">
      <div class="text-muted small">Lokasi / Jenis</div>
      <div class="fw-semibold"><?= esc($header['lokasi_check']) ?> / <?= esc($header['jenis_check'] === 'Preventive' ? 'Checklist Report' : $header['jenis_check']) ?></div>
    </div>
    <div class="col-md-2">
      <div class="text-muted small">Waktu Mulai</div>
      <div class="fw-semibold"><?= esc($header['waktu_mulai']) ?></div>
    </div>
    <div class="col-md-1">
      <div class="text-muted small">Durasi</div>
      <div class="fw-semibold"><?= $durasiDetik !== null ? gmdate('i:s', $durasiDetik) : '-' ?></div>
    </div>
    <div class="col-md-2 text-md-end">
      <div class="text-muted small mb-1">Status</div>
      <?php if ($header['status'] === 'Approved'): ?>
        <span class="badge bg-success px-3 py-2">Approved</span>
      <?php else: ?>
        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
      <?php endif; ?>
    </div>
  </div>
  
  <?php if (!empty($header['bar_feeder_type']) || !empty($header['support_pic'])): ?>
    <div class="row g-3 mt-2 border-top pt-2">
      <?php if (!empty($header['bar_feeder_type'])): ?>
        <div class="col-md-6">
          <span class="text-muted small">Bar Feeder Type: </span>
          <span class="fw-semibold text-primary"><?= esc($header['bar_feeder_type']) ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($header['support_pic'])): ?>
        <div class="col-md-6">
          <span class="text-muted small">Support PIC: </span>
          <span class="fw-semibold text-primary"><?= esc($header['support_pic']) ?></span>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php 
  $status = $header['status'] ?? 'Pending';
  $role = session()->get('role');
?>

<?php if ($status === 'Approved'): ?>
  <div class="alert alert-success d-flex align-items-center shadow-sm border-0 mb-3" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-patch-check-fill me-2" viewBox="0 0 16 16">
      <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
    </svg>
    <div>
      Disetujui Final oleh <strong><?= esc($header['approver_nama'] ?? 'System') ?></strong> pada <strong><?= esc($header['approved_at']) ?></strong>
    </div>
  </div>
<?php endif; ?>

<div class="card-stat p-3">
  <?php if (strtolower($header['jenis_check']) === 'overhaul'): ?>
    <!-- OVERHAUL DETAIL TABLE -->
    <table class="table table-bordered align-middle checklist-table bg-white">
      <thead>
        <tr>
          <th style="width:5%;">NO</th>
          <th colspan="2" style="width:30%;">ITEM CHECK</th>
          <th style="width:20%;">POINT CHECK</th>
          <th style="width:15%;">STANDAR ITEM</th>
          <th style="width:10%;">HASIL</th>
          <th style="width:20%;">ULASAN</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($details as $d): ?>
          <?php if ($d['is_section_start']): ?>
            <tr class="section-header">
              <td colspan="7"><?= esc($d['dynamic_section_header']) ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <?php if ($d['show_no']): ?>
              <td class="text-center fw-semibold text-muted" rowspan="<?= (int) $d['no_rowspan'] ?>"><?= esc($d['dynamic_no']) ?></td>
            <?php endif; ?>

            <?php if ($d['sub_item_check'] !== null && $d['sub_item_check'] !== ''): ?>
              <?php if ($d['show_bagian']): ?>
                <td class="bagian-cell" rowspan="<?= (int) $d['bagian_rowspan'] ?>"><?= esc($d['bagian_check']) ?></td>
              <?php endif; ?>
              <td><?= esc($d['sub_item_check']) ?></td>
            <?php else: ?>
              <td class="bagian-cell" colspan="2"><?= esc($d['bagian_check']) ?></td>
            <?php endif; ?>

            <?php if ($d['show_point']): ?>
              <td rowspan="<?= (int) $d['point_rowspan'] ?>"><?= esc($d['point_check']) ?></td>
            <?php endif; ?>

            <?php if ($d['show_standard']): ?>
              <td rowspan="<?= (int) $d['standard_rowspan'] ?>"><?= nl2br(esc($d['standard_check'])) ?></td>
            <?php endif; ?>

            <td class="text-center">
              <?php if ($d['hasil_check'] === 'V'): ?>
                <span class="text-success fw-bold">V</span>
              <?php elseif ($d['hasil_check'] === 'Δ'): ?>
                <span class="text-warning fw-bold">Δ</span>
              <?php elseif ($d['hasil_check'] === 'X'): ?>
                <span class="text-danger fw-bold">X</span>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
            <td><?= esc($d['ulasan'] ?? '-') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <!-- PREVENTIVE DETAIL TABLE -->
    <table class="table table-bordered align-middle checklist-table bg-white">
      <thead>
        <tr>
          <th>BAGIAN CHECK</th>
          <th>POINT CHECK</th>
          <th>STANDARD CHECK</th>
          <th style="width:10%;">HASIL</th>
          <th>ULASAN</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($details as $d): ?>
          <tr>
            <?php if ($d['show_bagian']): ?>
              <td class="bagian-cell" rowspan="<?= (int) $d['bagian_rowspan'] ?>"><?= esc($d['bagian_check']) ?></td>
            <?php endif; ?>

            <?php if ($d['show_point']): ?>
              <td rowspan="<?= (int) $d['point_rowspan'] ?>"><?= esc($d['point_check']) ?></td>
            <?php endif; ?>

            <td><?= esc($d['standard_check']) ?></td>
            <td class="text-center">
              <?php if ($d['hasil_check'] === 'V'): ?>
                <span class="text-success fw-bold">V</span>
              <?php elseif ($d['hasil_check'] === 'Δ'): ?>
                <span class="text-warning fw-bold">Δ</span>
              <?php elseif ($d['hasil_check'] === 'X'): ?>
                <span class="text-danger fw-bold">X</span>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
            <td><?= esc($d['ulasan'] ?? '-') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<!-- KOTAK TANDA TANGAN (SIGNATURE BLOCK) -->
<div class="card border-0 shadow-sm bg-white mt-3 mb-4">
  <div class="card-body p-4">
    <?php
      $isOverhaul = (strtolower(str_replace(' ', '-', $header['jenis_check'])) === 'overhaul');
    ?>

    <?php if ($isOverhaul): ?>
    <div class="row text-center align-items-end" style="min-height: 120px;">
      <!-- 1. Dibuat Oleh (Member) -->
      <div class="col-3 border-end">
        <p class="mb-2 fw-semibold text-muted small">Dibuat Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (!empty($header['waktu_selesai'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline" style="font-size:0.9rem;"><?= esc($header['nama_staff'] ?? 'MEMBER') ?></h6>
        <span class="small text-muted" style="font-size:0.75rem;">Tgl: <?= !empty($header['waktu_selesai']) ? date('d-m-Y H:i', strtotime($header['waktu_selesai'])) : '-' ?></span>
      </div>

      <!-- 2. Diperiksa Oleh (Leader) -->
      <div class="col-3 border-end">
        <p class="mb-2 fw-semibold text-muted small">Diperiksa Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (!empty($header['approval_l1_by'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Diperiksa</span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline" style="font-size:0.9rem;"><?= esc($header['approver_l1_nama'] ?? 'LEADER PRODUKSI') ?></h6>
        <span class="small text-muted" style="font-size:0.75rem;">Tgl: <?= !empty($header['approval_l1_at']) ? date('d-m-Y H:i', strtotime($header['approval_l1_at'])) : '-' ?></span>
      </div>

      <!-- 3. Disetujui Oleh (SHead Produksi) -->
      <div class="col-3 border-end">
        <p class="mb-2 fw-semibold text-muted small">Disetujui Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (!empty($header['approval_l2_by'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Disetujui</span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline" style="font-size:0.9rem;"><?= esc($header['approver_l2_nama'] ?? 'S. HEAD PRODUKSI') ?></h6>
        <span class="small text-muted" style="font-size:0.75rem;">Tgl: <?= !empty($header['approval_l2_at']) ? date('d-m-Y H:i', strtotime($header['approval_l2_at'])) : '-' ?></span>
      </div>

      <!-- 4. Disetujui Oleh (SHead MTC) -->
      <div class="col-3">
        <p class="mb-2 fw-semibold text-muted small">Disetujui Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if ($header['status'] === 'Approved'): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Disetujui</span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline" style="font-size:0.9rem;"><?= esc($header['approver_nama'] ?? 'S. HEAD MTC') ?></h6>
        <span class="small text-muted" style="font-size:0.75rem;">Tgl: <?= !empty($header['approved_at']) ? date('d-m-Y H:i', strtotime($header['approved_at'])) : '-' ?></span>
      </div>
    </div>
    
    <?php else: ?>
    <!-- SIGNATURE BLOCK PREVENTIVE (SINGLE-LEVEL) -->
    <div class="row text-center align-items-end" style="min-height: 120px;">
      <!-- Dibuat Oleh (Creator) -->
      <div class="col-6 border-end">
        <p class="mb-2 fw-semibold text-muted small">Dibuat Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if (!empty($header['waktu_selesai'])): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Selesai
            </span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline"><?= esc($header['nama_staff'] ?? 'MEMBER') ?></h6>
        <span class="small text-muted">Tanggal: <?= !empty($header['waktu_selesai']) ? date('d-m-Y H:i', strtotime($header['waktu_selesai'])) : '-' ?></span>
      </div>

      <!-- Disetujui Oleh (Approver) -->
      <div class="col-6">
        <p class="mb-2 fw-semibold text-muted small">Disetujui Oleh</p>
        <div class="mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center;">
          <?php if ($header['status'] === 'Approved'): ?>
            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Disetujui
            </span>
          <?php else: ?>
            <span class="text-muted opacity-50"><i class="bi bi-dash-lg"></i></span>
          <?php endif; ?>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-decoration-underline"><?= esc($header['approver_nama'] ?? 'LEADER / ADMIN') ?></h6>
        <span class="small text-muted">Tanggal: <?= !empty($header['approved_at']) ? date('d-m-Y H:i', strtotime($header['approved_at'])) : '-' ?></span>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php 
  // LOGIKA MENAMPILKAN TOMBOL APPROVE
  $canApprove = false;
  $statusLaporan = $header['status'];
  if ($isOverhaul) {
      if ($role === 'admin' && $statusLaporan !== 'Approved') $canApprove = true;
      elseif ($role === 'leader' && $statusLaporan === 'Pending') $canApprove = true;
      elseif ($role === 'sheadprd' && $statusLaporan === 'Approved L1') $canApprove = true;
      elseif ($role === 'sheadmtc' && $statusLaporan === 'Approved L2') $canApprove = true;
  } else {
      if (in_array($role, ['leader', 'admin']) && $statusLaporan === 'Pending') {
          $canApprove = true;
      }
  }
?>

<?php if ($canApprove): ?>
<div class="card border-success mt-4 mb-3 shadow-sm">
  <div class="card-body d-flex justify-content-between align-items-center p-3">
    <div>
      <h6 class="mb-1 text-dark fw-bold">Setujui Laporan Pengecekan</h6>
      <p class="text-muted small mb-0">Klik tombol Approve jika laporan ini sudah diperiksa dan valid.</p>
    </div>
    <form action="<?= site_url('riwayat/approve/' . (int) $header['id_transaksi']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui laporan ini?');">
      <?= csrf_field() ?>
      <button type="submit" class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> Approve (<?= esc($role) ?>)
      </button>
    </form>
  </div>
</div>
<?php endif; ?>

<?= view('layout/footer') ?>
