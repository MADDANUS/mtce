<?= view('layout/header', ['title' => $title]) ?>

<h5 class="mb-4 text-dark fw-bold">Buat Pengecekan Baru (Preventive MFG 1)</h5>

<div class="row g-4">
  <!-- Card Penerangan -->
  <div class="col-md-4">
    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
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
        <a href="<?= site_url('checklist/mfg1-preventive/create/penerangan') ?>" class="btn btn-warning text-white w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
      </div>
    </div>
  </div>

  <!-- Card Kabel & Pipa -->
  <div class="col-md-4">
    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
      <div class="card-body p-4 d-flex flex-column">
        <div class="d-flex align-items-center mb-3">
          <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hdd-network-fill" viewBox="0 0 16 16">
              <path d="M2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h5.5v3A1.5 1.5 0 0 0 6 11.5c0 .253.062.492.17.703l-1.015 1.014A.5.5 0 0 0 5.5 14h5a.5.5 0 0 0 .344-.863l-1.01-1.01c.107-.21.166-.45.166-.703a1.5 1.5 0 0 0-1.5-1.5v-3H14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zM2 3h12a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm6.5 8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
          </div>
          <h5 class="card-title mb-0 fw-bold">Kabel & Pipa</h5>
        </div>
        <p class="card-text text-muted mb-4">Pengecekan instalasi kabel mesin ke bartop, selang hydraulic, saluran amano/vacuum, kabel, dan selang oli.</p>
        <a href="<?= site_url('checklist/mfg1-preventive/create/kabel-dan-pipa') ?>" class="btn btn-primary w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
      </div>
    </div>
  </div>

  <!-- Card Angin Bocor -->
  <div class="col-md-4">
    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
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
        <a href="<?= site_url('checklist/mfg1-preventive/create/angin-bocor') ?>" class="btn btn-info text-white w-100 mt-auto fw-semibold">Mulai Pengecekan &raquo;</a>
      </div>
    </div>
  </div>
</div>

<?= view('layout/footer') ?>
