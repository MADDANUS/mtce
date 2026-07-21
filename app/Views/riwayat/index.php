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
    <h3 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat <?= esc($jenisLabel ?? 'Pengecekan') ?> — <strong><?= esc($lokasiName) ?></strong></h3>
  </div>
  <?php if (in_array(session()->get('role'), ['staff', 'admin'], true)): ?>
    <div>
      <a href="<?= site_url('checklist') ?>" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Baru
      </a>
    </div>
  <?php endif; ?>
</div>


<!-- KARTU TABEL DAFTAR RIWAYAT -->
<form action="<?= site_url("riwayat/lokasi/{$lokasiSlug}") ?>" method="get" id="filterForm">
  <!-- Keep sorting parameters when changing filters -->
  <input type="hidden" name="sort_by" value="<?= esc($selectedFilters['sort_by'] ?? 'id_transaksi') ?>">
  <input type="hidden" name="order" value="<?= esc($selectedFilters['order'] ?? 'desc') ?>">
  <input type="hidden" name="jenis_check" value="<?= esc($selectedFilters['jenis_check'] ?? '') ?>">

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-auto text-muted fw-bold ms-2 me-3 mb-2 mb-md-0">
                <i class="bi bi-funnel-fill me-1"></i> Filter:
            </div>
            <div class="col-12 col-md">
                <select class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white" onchange="window.location.href='<?= site_url('riwayat/lokasi/') ?>' + this.value + '?jenis_check=<?= urlencode($selectedFilters['jenis_check'] ?? '') ?>'">
                    <option value="mfg1" <?= $lokasiSlug === 'mfg1' ? 'selected' : '' ?>>MFG 1</option>
                    <option value="mfg2" <?= $lokasiSlug === 'mfg2' ? 'selected' : '' ?>>MFG 2</option>
                </select>
            </div>
            <div class="col-12 col-md">
              <?php if (!empty($userLine)): ?>
                <input type="text" class="form-control form-control-sm border-0 bg-light fw-bold text-uppercase px-2" value="<?= esc($userLine) ?>" readonly disabled>
                <input type="hidden" name="line" value="<?= esc($userLine) ?>">
              <?php else: ?>
                <select name="line" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white" onchange="this.form.submit()">
                  <option value="">-- SEMUA LINE --</option>
                  <?php foreach ($availableLines as $l): ?>
                    <option value="<?= esc($l) ?>" <?= isset($selectedFilters['line']) && $selectedFilters['line'] === $l ? 'selected' : '' ?>>
                      <?= esc($l) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>
            <div class="col-12 col-md">
              <select name="id_mesin" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white" onchange="this.form.submit()">
                <option value="">-- SEMUA MESIN --</option>
                <?php foreach ($daftarMesin as $m): ?>
                  <option value="<?= esc($m['id_mesin']) ?>" <?= isset($selectedFilters['id_mesin']) && (int)$selectedFilters['id_mesin'] === (int)$m['id_mesin'] ? 'selected' : '' ?>>
                    <?= esc($m['no_mesin']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 col-md">
              <select name="kategori" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white" onchange="this.form.submit()">
                <option value="">-- SEMUA KATEGORI --</option>
                <?php foreach ($categories as $slug => $name): ?>
                  <option value="<?= esc($name) ?>" <?= isset($selectedFilters['kategori']) && $selectedFilters['kategori'] === $name ? 'selected' : '' ?>>
                    <?= esc($name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 col-md">
              <input type="date" name="tanggal" class="form-control form-control-sm fw-bold text-uppercase border-1 bg-white" value="<?= esc($selectedFilters['tanggal'] ?? '') ?>" onchange="this.form.submit()">
            </div>
            <div class="col-12 col-md">
              <select name="status" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white" onchange="this.form.submit()">
                <option value="">-- SEMUA STATUS --</option>
                <option value="Pending" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Approved L1" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Approved L1' ? 'selected' : '' ?>>Approved L1</option>
                <option value="Approved L2" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Approved L2' ? 'selected' : '' ?>>Approved L2</option>
                <option value="Approved" <?= isset($selectedFilters['status']) && $selectedFilters['status'] === 'Approved' ? 'selected' : '' ?>>Approved (Final)</option>
              </select>
            </div>
            <div class="col-12 col-md-auto ms-auto pe-2">
                <?php 
                  $resetUrl = site_url("riwayat/lokasi/{$lokasiSlug}");
                  if (!empty($selectedFilters['jenis_check'])) {
                      $resetUrl .= '?jenis_check=' . urlencode($selectedFilters['jenis_check']);
                  }
                ?>
                <a href="<?= $resetUrl ?>" class="btn btn-sm btn-outline-secondary px-3" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </div>
    </div>
</div>
</form>

<div class="card border-0 shadow-sm bg-white mb-4">
  <?php if (empty($riwayat)): ?>
    <div class="text-center py-4">
      <i class="bi bi-clipboard-x text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;"></i>
      <p class="text-muted mb-0">Belum ada data riwayat pengecekan yang sesuai dengan filter.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive text-nowrap">
      <table class="table align-middle table-hover">
                <thead class="table-light">
                    <!-- Baris Kolom dan Sorting -->
          <tr>
            <th style="width: 5%;" class="text-center align-middle">
              <a href="<?= $getSortUrl('id_transaksi') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                NO <?= $getSortIcon('id_transaksi') ?>
              </a>
            </th>
            <th style="width: 12%;" class="align-middle">
              <a href="<?= $getSortUrl('nama_staff') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                PIC <?= $getSortIcon('nama_staff') ?>
              </a>
            </th>
            <th style="width: 13%;" class="align-middle">
              <a href="<?= $getSortUrl('line') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                LINE <?= $getSortIcon('line') ?>
              </a>
            </th>
            <th style="width: 15%;" class="align-middle">
              <a href="<?= $getSortUrl('no_mesin') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                MESIN <?= $getSortIcon('no_mesin') ?>
              </a>
            </th>
            <th style="width: 15%;" class="align-middle">
              <a href="<?= $getSortUrl('kategori') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                KATEGORI <?= $getSortIcon('kategori') ?>
              </a>
            </th>
            <th style="width: 15%;" class="align-middle">
              <a href="<?= $getSortUrl('waktu_mulai') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                TANGGAL <?= $getSortIcon('waktu_mulai') ?>
              </a>
            </th>
            <th style="width: 8%;" class="align-middle">
              <a href="<?= $getSortUrl('durasi') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                DURASI <?= $getSortIcon('durasi') ?>
              </a>
            </th>
            <th style="width: 12%;" class="align-middle">
              <a href="<?= $getSortUrl('status') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                STATUS <?= $getSortIcon('status') ?>
              </a>
            </th>
            <th style="width: 5%;" class="fw-bold text-uppercase text-secondary align-middle" style="font-size: 0.72rem; letter-spacing: 0.08em;">Aksi</th>
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
              <td class="text-muted" style="font-size: 0.85rem;"><?= esc($r['nama_pic']) ?></td>
              <td class="fw-medium text-dark" style="font-size: 0.85rem; text-center"><?= esc($r['line'] ?? '-') ?></td>
              <td>
                <div class="fw-semibold text-dark" style="font-size: 0.85rem;"><?= esc($r['no_mesin']) ?></div>
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
