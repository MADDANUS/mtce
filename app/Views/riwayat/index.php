<?= view('layout/header', ['title' => $title]) ?>

<?php
// Helper functions for column sorting
$getSortUrl = function(string $column) use ($selectedFilters, $lokasiSlug) {
    $params = $selectedFilters;
    unset($params['lokasi']); // Remove lokasi from query parameters as it's part of the route URL

    $currentSort = $selectedFilters['sort_by'] ?? 'id_transaksi';
    $currentOrder = $selectedFilters['order'] ?? 'desc';

    if ($currentSort === $column) {
        $params['order'] = ($currentOrder === 'asc') ? 'desc' : 'asc';
    } else {
        $params['sort_by'] = $column;
        $params['order'] = 'asc';
    }

    return site_url("riwayat/lokasi/{$lokasiSlug}") . '?' . http_build_query($params);
};

$getSortIcon = function(string $column) use ($selectedFilters) {
    $currentSort = $selectedFilters['sort_by'] ?? 'id_transaksi';
    $currentOrder = strtolower($selectedFilters['order'] ?? 'desc');

    if ($currentSort !== $column) {
        return '<i class="bi bi-arrow-down-up text-muted ms-1" style="font-size:0.75rem;"></i>';
    }

    return ($currentOrder === 'asc')
        ? '<i class="bi bi-sort-up text-primary ms-1" style="font-size:0.85rem;"></i>'
        : '<i class="bi bi-sort-down text-primary ms-1" style="font-size:0.85rem;"></i>';
};
?>

<div class="page-header">
  <div>
    <a href="<?= site_url('riwayat') ?>" class="btn btn-sm btn-outline-secondary mb-2">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h5 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat <?= esc($jenisLabel ?? 'Pengecekan') ?> — <strong><?= esc($lokasiName) ?></strong></h5>
  </div>
  <?php if (in_array(session()->get('role'), ['staff', 'admin'], true)): ?>
    <div>
      <a href="<?= site_url('checklist') ?>" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Baru
      </a>
    </div>
  <?php endif; ?>
</div>

<div class="card p-3 mb-4 border-0 shadow-sm bg-white">
  <form action="<?= site_url("riwayat/lokasi/{$lokasiSlug}") ?>" method="get" id="filterForm">
    <!-- Keep sorting parameters when changing filters -->
    <input type="hidden" name="sort_by" value="<?= esc($selectedFilters['sort_by'] ?? 'id_transaksi') ?>">
    <input type="hidden" name="order" value="<?= esc($selectedFilters['order'] ?? 'desc') ?>">
    <input type="hidden" name="jenis_check" value="<?= esc($selectedFilters['jenis_check'] ?? '') ?>">

    <div class="mb-4">
      <label class="form-label text-uppercase" style="font-size: 0.72rem; font-weight: 700; color: var(--text-secondary); letter-spacing: 0.05em;">Lokasi MFG</label>
      <div class="d-flex bg-light rounded-3 p-1 border" style="max-width: 300px;">
        <a href="<?= site_url('riwayat/lokasi/mfg1?jenis_check=' . urlencode($selectedFilters['jenis_check'] ?? '')) ?>" class="btn btn-sm w-50 <?= $lokasiSlug === 'mfg1' ? 'bg-white shadow-sm text-dark' : 'text-muted' ?> fw-semibold border-0 rounded-2">MFG 1</a>
        <a href="<?= site_url('riwayat/lokasi/mfg2?jenis_check=' . urlencode($selectedFilters['jenis_check'] ?? '')) ?>" class="btn btn-sm w-50 <?= $lokasiSlug === 'mfg2' ? 'bg-white shadow-sm text-dark' : 'text-muted' ?> fw-semibold border-0 rounded-2">MFG 2</a>
      </div>
    </div>

    <div class="row g-3 align-items-end border-top pt-3">
      <!-- Filter Mesin -->
      <div class="col-md-3">
        <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: var(--text-secondary);">Mesin</label>
        <select name="id_mesin" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">-- Semua Mesin --</option>
          <?php foreach ($daftarMesin as $m): ?>
            <option value="<?= esc($m['id_mesin']) ?>" <?= isset($selectedFilters['id_mesin']) && (int)$selectedFilters['id_mesin'] === (int)$m['id_mesin'] ? 'selected' : '' ?>>
              <?= esc($m['no_mesin']) ?> - <?= esc($m['type_mesin']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Filter Kategori -->
      <div class="col-md-3">
        <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: var(--text-secondary);">Kategori</label>
        <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          <?php foreach ($categories as $slug => $name): ?>
            <option value="<?= esc($name) ?>" <?= isset($selectedFilters['kategori']) && $selectedFilters['kategori'] === $name ? 'selected' : '' ?>>
              <?= esc($name) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Filter Tanggal -->
      <div class="col-md-2">
        <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: var(--text-secondary);">Tanggal</label>
        <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= esc($selectedFilters['tanggal'] ?? '') ?>" onchange="this.form.submit()">
      </div>

      <!-- Filter Status -->
      <div class="col-md-2">
        <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: var(--text-secondary);">Status</label>
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="Pending" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option value="Approved" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
        </select>
      </div>

      <!-- Tombol Aksi -->
      <div class="col-md-2">
        <?php 
          $resetUrl = site_url("riwayat/lokasi/{$lokasiSlug}");
          if (!empty($selectedFilters['jenis_check'])) {
              $resetUrl .= '?jenis_check=' . urlencode($selectedFilters['jenis_check']);
          }
        ?>
        <a href="<?= $resetUrl ?>" class="btn btn-sm btn-outline-secondary w-100 py-2">
          <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
        </a>
      </div>
    </div>
  </form>
</div>

<!-- KARTU TABEL DAFTAR RIWAYAT -->
<div class="card p-3 border-0 shadow-sm bg-white">
  <?php if (empty($riwayat)): ?>
    <div class="text-center py-4">
      <i class="bi bi-clipboard-x text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;"></i>
      <p class="text-muted mb-0">Belum ada data riwayat pengecekan yang sesuai dengan filter.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead>
          <tr>
            <th style="width: 5%;" class="text-center">
              <a href="<?= $getSortUrl('id_transaksi') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                NO <?= $getSortIcon('id_transaksi') ?>
              </a>
            </th>
            <th style="width: 15%;">
              <a href="<?= $getSortUrl('nama_staff') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                PIC <?= $getSortIcon('nama_staff') ?>
              </a>
            </th>
            <th style="width: 20%;">
              <a href="<?= $getSortUrl('no_mesin') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                Mesin <?= $getSortIcon('no_mesin') ?>
              </a>
            </th>
            <th style="width: 25%;">
              <a href="<?= $getSortUrl('kategori') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                Kategori / Jenis <?= $getSortIcon('kategori') ?>
              </a>
            </th>
            <th style="width: 17%;">
              <a href="<?= $getSortUrl('waktu_mulai') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                Waktu Mulai <?= $getSortIcon('waktu_mulai') ?>
              </a>
            </th>
            <th style="width: 10%;">
              <a href="<?= $getSortUrl('durasi') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                Durasi <?= $getSortIcon('durasi') ?>
              </a>
            </th>
            <th style="width: 10%;">
              <a href="<?= $getSortUrl('status') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                Status <?= $getSortIcon('status') ?>
              </a>
            </th>
            <th style="width: 5%;" class="fw-bold text-uppercase text-secondary" style="font-size: 0.72rem; letter-spacing: 0.08em;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($riwayat as $r): ?>
            <?php
              $durasi = '-';
              if (! empty($r['waktu_mulai']) && ! empty($r['waktu_selesai'])) {
                  $durasi = gmdate('i:s', strtotime($r['waktu_selesai']) - strtotime($r['waktu_mulai'])) . ' m';
              }
            ?>
            <tr>
              <td class="fw-semibold text-muted text-center"><?= $no++ ?></td>
            <td class="fw-semibold"><?= esc($r['nama_pic'] ?: $r['nama_staff']) ?></td>
              <td>
                <div class="fw-semibold text-dark"><?= esc($r['no_mesin']) ?></div>
                <div class="text-muted small" style="font-size: 0.75rem;"><?= esc($r['type_mesin']) ?></div>
              </td>
              <td>
                <span class="badge bg-primary"><?= esc($r['kategori']) ?></span>
                <span class="badge bg-secondary text-capitalize"><?= esc($r['jenis_check'] === 'Preventive' ? 'Checklist Report' : $r['jenis_check']) ?></span>
              </td>
              <td style="font-size: 0.8rem; color: var(--text-secondary);">
                <?= esc(date('d M Y, H:i', strtotime($r['waktu_mulai']))) ?>
              </td>
              <td class="fw-medium" style="font-size: 0.825rem; color: var(--text-secondary);"><?= $durasi ?></td>
              <td>
                <?php $status = $r['status'] ?? 'Pending'; ?>
                <?php if ($status === 'Approved'): ?>
                  <span class="badge bg-success">Approved</span>
                <?php elseif ($status === 'Approved L1'): ?>
                  <span class="badge bg-info text-dark">Approved L1</span>
                <?php elseif ($status === 'Approved L2'): ?>
                  <span class="badge bg-primary">Approved L2</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="<?= site_url('riwayat/' . $r['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary py-1 px-2">
                    Detail
                  </a>
                  <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= site_url('riwayat/edit/' . $r['id_transaksi']) ?>" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Edit Riwayat">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" onclick="confirmDelete(<?= $r['id_transaksi'] ?>)" title="Hapus Riwayat">
                      <i class="bi bi-trash"></i>
                    </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php if (session()->get('role') === 'admin'): ?>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
        <h6 class="modal-title fw-bold text-danger"><i class="bi bi-trash3 me-1.5"></i>Hapus Riwayat Pengecekan</h6>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <form id="deleteForm" method="post" action="">
        <?= csrf_field() ?>
        <div class="modal-body px-4 pt-3 pb-2">
          <p class="text-muted mb-0" style="font-size:0.88rem;">Apakah Anda yakin ingin menghapus riwayat pengecekan ini? Data detail pengecekan dan laporan abnormal yang terkait juga akan dihapus secara permanen.</p>
        </div>
        <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-4 rounded-3">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function confirmDelete(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('deleteForm').action = '<?= site_url("riwayat/delete/") ?>' + id;
    modal.show();
}
</script>
<?php endif; ?>

<?= view('layout/footer') ?>
