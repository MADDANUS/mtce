<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Detail Pengecekan #<?= (int) $header['id_transaksi'] ?></h5>
  <a href="<?= site_url('riwayat') ?>" class="btn btn-sm btn-outline-secondary">&laquo; Kembali</a>
</div>

<div class="card-stat p-3 mb-3">
  <div class="row g-3">
    <div class="col-md-3">
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
    <div class="col-md-2">
      <div class="text-muted small">Durasi</div>
      <div class="fw-semibold"><?= $durasiDetik !== null ? gmdate('i \m\e\n\i\t s \d\e\t\i\k', $durasiDetik) : '-' ?></div>
    </div>
  </div>
</div>

<div class="card-stat p-3">
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
          <td class="bagian-cell"><?= esc($d['bagian_check']) ?></td>
          <td><?= esc($d['point_check']) ?></td>
          <td><?= esc($d['standard_check']) ?></td>
          <td class="text-center">
            <?php if ($d['hasil_check'] === 'V'): ?>
              <span class="badge badge-v">V</span>
            <?php elseif ($d['hasil_check'] === 'Δ'): ?>
              <span class="badge badge-d">Δ</span>
            <?php elseif ($d['hasil_check'] === 'X'): ?>
              <span class="badge badge-x">X</span>
            <?php else: ?>
              <span class="text-muted">-</span>
            <?php endif; ?>
          </td>
          <td><?= esc($d['ulasan'] ?? '-') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= view('layout/footer') ?>
