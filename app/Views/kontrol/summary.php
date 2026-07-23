<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-table text-primary me-2"></i> Ringkasan Checklist Control</h3>
        <p class="text-muted mb-0">Pantau progres pengisian Checklist Control bulanan di seluruh area.</p>
    </div>
    
    <div class="d-flex gap-2">
        <form method="GET" action="<?= site_url('kontrol') ?>" class="d-flex flex-wrap gap-2 justify-content-end" id="filterForm">
            <input type="hidden" name="view" value="summary">
            <select name="bulan" class="form-select border-0 shadow-sm fw-medium rounded-pill" style="width: auto;" onchange="this.form.submit()">
                <?php foreach ($bulanList as $val => $label): ?>
                    <option value="<?= $val ?>" <?= $val === $bulan ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-auto text-muted fw-bold ms-2 me-3 mb-2 mb-md-0">
                <i class="bi bi-funnel-fill me-1"></i> Filter:
            </div>
            <div class="col-12 col-md-2">
                <select name="filter_lokasi" form="filterForm" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white w-100" onchange="this.form.submit()">
                    <option value="">-- SEMUA LOKASI --</option>
                    <option value="MFG 1" <?= ($filterLokasi ?? '') === 'MFG 1' ? 'selected' : '' ?>>MFG 1</option>
                    <option value="MFG 2" <?= ($filterLokasi ?? '') === 'MFG 2' ? 'selected' : '' ?>>MFG 2</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select name="filter_line" form="filterForm" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white w-100" onchange="this.form.submit()">
                    <option value="">-- SEMUA LINE --</option>
                    <option value="Line 1" <?= ($filterLine ?? '') === 'Line 1' ? 'selected' : '' ?>>Line 1</option>
                    <option value="Line 2" <?= ($filterLine ?? '') === 'Line 2' ? 'selected' : '' ?>>Line 2</option>
                    <option value="Line 3" <?= ($filterLine ?? '') === 'Line 3' ? 'selected' : '' ?>>Line 3</option>
                    <option value="CG" <?= ($filterLine ?? '') === 'CG' ? 'selected' : '' ?>>CG</option>
                    <option value="Second" <?= ($filterLine ?? '') === 'Second' ? 'selected' : '' ?>>Second</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select name="filter_kategori" form="filterForm" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white w-100" onchange="this.form.submit()">
                    <option value="">-- SEMUA KATEGORI --</option>
                    <option value="Penerangan" <?= ($filterKategori ?? '') === 'Penerangan' ? 'selected' : '' ?>>Penerangan</option>
                    <option value="Kabel dan Pipa" <?= ($filterKategori ?? '') === 'Kabel dan Pipa' ? 'selected' : '' ?>>Kabel dan Pipa</option>
                    <option value="Angin Bocor" <?= ($filterKategori ?? '') === 'Angin Bocor' ? 'selected' : '' ?>>Angin Bocor</option>
                    <option value="Bearing Cam" <?= ($filterKategori ?? '') === 'Bearing Cam' ? 'selected' : '' ?>>Bearing Cam</option>
                    <option value="Gearbox" <?= ($filterKategori ?? '') === 'Gearbox' ? 'selected' : '' ?>>Gearbox</option>
                    <option value="Belt Cam" <?= ($filterKategori ?? '') === 'Belt Cam' ? 'selected' : '' ?>>Belt Cam</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="filter_status" form="filterForm" class="form-select form-select-sm fw-bold text-uppercase border-1 bg-white w-100" onchange="this.form.submit()">
                    <option value="">-- SEMUA STATUS --</option>
                    <option value="Belum Selesai" <?= ($filterStatus ?? '') === 'Belum Selesai' ? 'selected' : '' ?>>Belum Selesai</option>
                    <option value="Menunggu Approval (L1)" <?= ($filterStatus ?? '') === 'Menunggu Approval (L1)' ? 'selected' : '' ?>>Menunggu Approval (L1)</option>
                    <option value="Approved L1 (Menunggu L2)" <?= ($filterStatus ?? '') === 'Approved L1 (Menunggu L2)' ? 'selected' : '' ?>>Approved L1 (Menunggu L2)</option>
                    <option value="Approved L2 (Menunggu Final)" <?= ($filterStatus ?? '') === 'Approved L2 (Menunggu Final)' ? 'selected' : '' ?>>Approved L2 (Menunggu Final)</option>
                    <option value="Selesai (Final)" <?= ($filterStatus ?? '') === 'Selesai (Final)' ? 'selected' : '' ?>>Selesai (Final)</option>
                </select>
            </div>
            <?php if(!empty($filterLokasi) || !empty($filterLine) || !empty($filterKategori) || !empty($filterStatus)): ?>
                <div class="col-12 col-md-auto ms-auto">
                    <a href="<?= site_url('kontrol?view=summary') ?>" class="btn btn-sm btn-outline-secondary rounded-pill w-100">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Helper functions for column sorting
$getSortUrl = function(string $column) use ($bulan, $filterLokasi, $filterLine, $filterKategori, $filterStatus, $sortBy, $order) {
    $params = [
        'view' => 'summary',
        'bulan' => $bulan,
        'filter_lokasi' => $filterLokasi,
        'filter_line' => $filterLine,
        'filter_kategori' => $filterKategori,
        'filter_status' => $filterStatus,
    ];

    if ($sortBy === $column) {
        $params['order'] = ($order === 'asc') ? 'desc' : 'asc';
    } else {
        $params['sort_by'] = $column;
        $params['order'] = 'asc';
    }

    return site_url('kontrol') . '?' . http_build_query($params);
};

$getSortIcon = function(string $column) use ($sortBy, $order) {
    if ($sortBy !== $column) {
        return '<i class="bi bi-arrow-down-up text-muted ms-1" style="font-size:0.75rem;"></i>';
    }

    return ($order === 'asc')
        ? '<i class="bi bi-sort-up text-primary ms-1" style="font-size:0.85rem;"></i>'
        : '<i class="bi bi-sort-down text-primary ms-1" style="font-size:0.85rem;"></i>';
};
?>

<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <!-- Baris Kolom dan Sorting -->
                    <tr>
                        <th class="ps-4" style="width: 15%;">
                            <a href="<?= $getSortUrl('lokasi') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                                LOKASI <?= $getSortIcon('lokasi') ?>
                            </a>
                        </th>
                        <th style="width: 15%;">
                            <a href="<?= $getSortUrl('line') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                                LINE <?= $getSortIcon('line') ?>
                            </a>
                        </th>
                        <th style="width: 20%;">
                            <a href="<?= $getSortUrl('kategori') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                                KATEGORI <?= $getSortIcon('kategori') ?>
                            </a>
                        </th>
                        <th class="fw-bold text-uppercase text-secondary align-middle" style="width: 20%; font-size: 0.72rem; letter-spacing: 0.08em;">
                            <a href="<?= $getSortUrl('percent') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase">
                                PROGRES PENGECEKAN <?= $getSortIcon('percent') ?>
                            </a>
                        </th>
                        <th style="width: 20%;">
                            <a href="<?= $getSortUrl('statusText') ?>" class="text-decoration-none text-secondary d-inline-flex align-items-center fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.08em;">
                                STATUS APPROVAL <?= $getSortIcon('statusText') ?>
                            </a>
                        </th>
                        <th class="pe-4 text-end fw-bold text-uppercase text-secondary align-middle" style="font-size: 0.72rem; letter-spacing: 0.08em;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($summaryRows)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($summaryRows as $row): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-dark"><?= esc($row['lokasi']) ?></td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25"><?= esc($row['line']) ?></span></td>
                                <td class="fw-medium text-dark"><?= esc($row['kategori']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar <?= $row['percent'] == 100 ? 'bg-success' : 'bg-primary' ?>" role="progressbar" style="width: <?= $row['percent'] ?>%;" aria-valuenow="<?= $row['percent'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="small fw-bold <?= $row['percent'] == 100 ? 'text-success' : 'text-primary' ?>" style="min-width: 45px;"><?= $row['checked'] ?>/<?= $row['total'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?= $row['badgeClass'] ?> rounded-pill px-3 py-2"><?= $row['statusText'] ?></span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="<?= site_url('kontrol?lokasi=' . urlencode($row['lokasi']) . '&line=' . urlencode($row['line']) . '&kategori=' . urlencode($row['kategori']) . '&bulan=' . urlencode($bulan)) ?>" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3">
                                        Lihat Form
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>

