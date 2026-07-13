<?= view('layout/header', ['title' => $title]) ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <a href="<?= site_url("checklist/{$lokasiSlug}") ?>" class="btn btn-sm btn-outline-secondary mb-2">&laquo; Kembali ke Tipe</a>
    <h5 class="mb-0 text-dark fw-bold">Buat Pengecekan Baru (<?= esc($jenisName) ?> <?= esc($lokasiName) ?>)</h5>
  </div>
</div>

<div class="row g-4 justify-content-center">
  <?php if (strtolower($jenisSlug) === 'overhaul'): ?>
    <!-- OVERHAUL CARDS (2 Cards) -->
    
    <!-- Card Bar Feeder CNC -->
    <div class="col-md-5">
      <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hdd-stack-fill" viewBox="0 0 16 16">
                <path d="M2 9a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2H2zm0-7a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
              </svg>
            </div>
            <h5 class="card-title mb-0 fw-bold">Bar Feeder CNC</h5>
          </div>
          <p class="card-text text-muted mb-4">Pengecekan overhaul menyeluruh untuk unit Bar Feeder CNC, meliputi Equipment Check, Electrical Check, dan pengujian fungsi (Function Test).</p>
          <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/create/bar-feeder-cnc") ?>" class="btn btn-primary w-100 mt-auto fw-semibold py-2">Mulai Overhaul &raquo;</a>
        </div>
      </div>
    </div>

    <!-- Card Mesin CNC -->
    <div class="col-md-5">
      <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cpu-fill" viewBox="0 0 16 16">
                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5v1A1.5 1.5 0 0 0 6.5 5h3A1.5 1.5 0 0 0 11 3.5v-1A1.5 1.5 0 0 0 9.5 1h-3Zm0 11a1.5 1.5 0 0 0-1.5 1.5v1A1.5 1.5 0 0 0 6.5 16h3a1.5 1.5 0 0 0 1.5-1.5v-1A1.5 1.5 0 0 0 9.5 12h-3Z"/>
                <path d="M1 6.5A1.5 1.5 0 0 1 2.5 5h1A1.5 1.5 0 0 1 5 6.5v3A1.5 1.5 0 0 1 3.5 11h-1A1.5 1.5 0 0 1 1 9.5v-3Zm11 0A1.5 1.5 0 0 1 13.5 5h1a1.5 1.5 0 0 1 1.5 6.5v3a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-3Z"/>
              </svg>
            </div>
            <h5 class="card-title mb-0 fw-bold">Mesin CNC</h5>
          </div>
          <p class="card-text text-muted mb-4">Pengecekan overhaul menyeluruh untuk Mesin CNC utama, meliputi Ballscrew, Belt, Bearing, Electrical Check, dan pengujian fungsi (Function Test).</p>
          <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/create/mesin-cnc") ?>" class="btn btn-success text-white w-100 mt-auto fw-semibold py-2">Mulai Overhaul &raquo;</a>
        </div>
      </div>
    </div>

  <?php else: ?>
    <!-- PREVENTIVE CARDS (3 Cards) -->

    <!-- Card Penerangan -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 8 13H8a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
              </svg>
            </div>
            <h5 class="card-title mb-0 fw-bold">Penerangan</h5>
          </div>
          <p class="card-text text-muted mb-4">Pengecekan lampu sorot, headstock room, cutting room, lampu area atas mesin, dan lumen ruangan.</p>
          <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/create/penerangan") ?>" class="btn btn-warning text-white w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
        </div>
      </div>
    </div>

    <!-- Card Kabel & Pipa -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hdd-network-fill" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h5.5v3A1.5 1.5 0 0 0 6 11.5c0 .253.062.492.17.703l-1.015 1.014A.5.5 0 0 0 5.5 14h5a.5.5 0 0 0 .344-.863l-1.01-1.01c.107-.21.166-.45.166-.703a1.5 1.5 0 0 0-1.5-1.5v-3H14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zM2 3h12a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm6.5 8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
              </svg>
            </div>
            <h5 class="card-title mb-0 fw-bold">Kabel & Pipa</h5>
          </div>
          <p class="card-text text-muted mb-4">Pengecekan instalasi kabel mesin ke panel/bartop, selang hydraulic, saluran amano/vacuum, kabel, dan selang oli.</p>
          <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/create/kabel-dan-pipa") ?>" class="btn btn-primary w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
        </div>
      </div>
    </div>

    <!-- Card Angin Bocor -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-wind" viewBox="0 0 16 16">
                <path d="M12.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5zm-2-1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5zm-2 2a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0v-9a.5.5 0 0 1 .5-.5zm-2 1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm-2 1a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5z"/>
              </svg>
            </div>
            <h5 class="card-title mb-0 fw-bold">Angin Bocor</h5>
          </div>
          <p class="card-text text-muted mb-4">Pengecekan kebocoran solenoid unit, regulator unit, fitting, coupler, selang angin, dan air gun.</p>
          <a href="<?= site_url("checklist/{$lokasiSlug}/{$jenisSlug}/create/angin-bocor") ?>" class="btn btn-info text-white w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<style>
  .card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 .4rem 1.2rem rgba(0,0,0,.12)!important;
  }
</style>

<?= view('layout/footer') ?>
