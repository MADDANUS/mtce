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
      <div class="text-muted small">Staff</div>
      <div class="fw-semibold"><?= esc($header['nama_staff']) ?></div>
    </div>
    <div class="col-md-3">
      <div class="text-muted small">Mesin</div>
      <div class="fw-semibold"><?= esc($header['no_mesin']) ?> - <?= esc($header['type_mesin']) ?></div>
    </div>
    <div class="col-md-2">
      <div class="text-muted small">Lokasi / Jenis</div>
      <div class="fw-semibold"><?= esc($header['lokasi_check']) ?> / <?= esc($header['jenis_check']) ?></div>
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

<?php if ($header['status'] === 'Approved'): ?>
  <div class="alert alert-success d-flex align-items-center shadow-sm border-0 mb-3" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-patch-check-fill me-2" viewBox="0 0 16 16">
      <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
    </svg>
    <div>
      Disetujui oleh <strong><?= esc($header['approver_nama'] ?? 'System') ?></strong> pada <strong><?= esc($header['approved_at']) ?></strong>
    </div>
  </div>
<?php elseif (in_array(session()->get('role'), ['leader', 'admin'], true)): ?>
  <div class="card border-warning mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between align-items-center p-3">
      <div>
        <h6 class="mb-1 text-dark fw-bold">Menunggu Persetujuan Leader</h6>
        <p class="text-muted small mb-0">Klik tombol di sebelah kanan jika semua point check sudah diperiksa dengan benar.</p>
      </div>
      <form action="<?= site_url('riwayat/approve/' . (int) $header['id_transaksi']) ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </svg>
          Setujui Pengecekan
        </button>
      </form>
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

<?= view('layout/footer') ?>
