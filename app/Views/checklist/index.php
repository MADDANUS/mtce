<?= view('layout/header', ['title' => $title]) ?>

<?php
// Helper to build the create form URL preserving the dynamic machine ID
$getCreateUrl = function(string $categorySlug) use ($lokasiSlug, $jenisSlug, $idMesin) {
    $url = "checklist/{$lokasiSlug}/{$jenisSlug}/create/{$categorySlug}";
    if (!empty($idMesin)) {
        $url .= "?id_mesin=" . (int)$idMesin;
    }
    return site_url($url);
};
?>

<div class="page-header">
  <div>
    <a href="<?= site_url("checklist/{$lokasiSlug}") ?>" class="btn btn-sm btn-outline-secondary mb-2">
      <i class="bi bi-arrow-left"></i> Kembali ke Tipe
    </a>
    <h5 class="mb-0">
      Buat Pengecekan Baru — <span style="color:var(--accent)"><?= esc($jenisName) ?> <?= esc($lokasiName) ?></span>
      <?php if (!empty($idMesin)): ?>
        <span class="badge bg-info ms-2" style="font-size:0.75rem;"><i class="bi bi-qr-code me-1"></i>Mesin Terkunci</span>
      <?php endif; ?>
    </h5>
  </div>
</div>

<div class="row g-3">
  <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
    <!-- OVERHAUL CARDS -->

    <!-- Card Bar Feeder CNC -->
    <div class="col-md-6">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:var(--accent-light);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-hdd-stack-fill" style="color:var(--accent);font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Overhaul</div>
              <h6 class="mb-0 fw-700" style="font-weight:700;">Bar Feeder CNC</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Pengecekan overhaul menyeluruh untuk unit Bar Feeder CNC, meliputi Equipment Check, Electrical Check, dan Function Test.
          </p>
          <a href="<?= $getCreateUrl('bar-feeder-cnc') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Overhaul
          </a>
        </div>
      </div>
    </div>

    <!-- Card Mesin CNC -->
    <div class="col-md-6">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#d1fae5;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-cpu-fill" style="color:var(--success);font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Overhaul</div>
              <h6 class="mb-0" style="font-weight:700;">Mesin CNC</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Pengecekan overhaul menyeluruh untuk Mesin CNC utama, meliputi Ballscrew, Belt, Bearing, Electrical Check, dan Function Test.
          </p>
          <a href="<?= $getCreateUrl('mesin-cnc') ?>" class="btn btn-success w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Overhaul
          </a>
        </div>
      </div>
    </div>

  <?php else: ?>
    <!-- PREVENTIVE CARDS (6 Kategori) -->

    <!-- 1. Penerangan -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-lightbulb-fill" style="color:var(--warning);font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Penerangan</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek lampu sorot, headstock room, cutting room, lampu area atas mesin, kelengkapan dan lumen.
          </p>
          <a href="<?= $getCreateUrl('penerangan') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

    <!-- 2. Kabel & Pipa -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:var(--accent-light);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-hdd-network-fill" style="color:var(--accent);font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Kabel &amp; Pipa</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek kabel mesin ke panel/bartop, selang hydraulic, saluran amano/vacuum, kabel, dan selang oli.
          </p>
          <a href="<?= $getCreateUrl('kabel-dan-pipa') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

    <!-- 3. Angin Bocor -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#e0f2fe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-wind" style="color:#0284c7;font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Angin Bocor</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek kebocoran solenoid, regulator, fitting, coupler, selang angin bartop/mesin, dan air gun.
          </p>
          <a href="<?= $getCreateUrl('angin-bocor') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

    <!-- 4. Bearing -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#fce7f3;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-gear-wide-connected" style="color:#db2777;font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Bearing</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek noise &amp; temperature pada Bearing Spindle, Chucking, Center Shaft A/B/C, dan Bearing CAM.
          </p>
          <a href="<?= $getCreateUrl('bearing') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

    <!-- 5. Gearbox -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-gear-fill" style="color:#7c3aed;font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Gearbox</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek kondisi oli (terlihat dari lubang pengisian), mata gear (tidak backloss), dan nok seal (tidak rembes).
          </p>
          <a href="<?= $getCreateUrl('gearbox') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

    <!-- 6. Belt -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;background:#d1fae5;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="bi bi-arrow-repeat" style="color:var(--success);font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Preventive</div>
              <h6 class="mb-0" style="font-weight:700;">Belt</h6>
            </div>
          </div>
          <p style="font-size:0.83rem;color:var(--text-secondary);line-height:1.6;" class="mb-4">
            Cek sambungan &amp; kondisi belt pada Belt Spindle, Gearbox, Motor, Optional, Oil Pump, dan Belt CAM.
          </p>
          <a href="<?= $getCreateUrl('belt') ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-play-fill"></i> Mulai Pengecekan
          </a>
        </div>
      </div>
    </div>

  <?php endif; ?>
</div>

<?= view('layout/footer') ?>
