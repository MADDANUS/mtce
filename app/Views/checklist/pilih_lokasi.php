<?= view('layout/header', ['title' => $title]) ?>

<div class="row justify-content-center my-5">
  <div class="col-md-8 text-center mb-4">
    <h2 class="fw-bold text-dark mb-2">Pilih Lokasi Bengkel</h2>
    <p class="text-muted">Silakan pilih lokasi manufaktur (Manufacturing Line) untuk memulai pengecekan mesin.</p>
  </div>
</div>

<div class="row justify-content-center g-4">
  <!-- Card MFG 1 -->
  <div class="col-md-5">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
      <div class="card-body p-5 d-flex flex-column text-center bg-gradient-mfg1" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-top: 5px solid #0d6efd;">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary p-4 rounded-circle mb-4 mx-auto" style="width: 80px; height: 80px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-1-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002H7.971L6.072 5.385v1.271l1.834-1.318h.065V12h1.312V4.002Z"/>
          </svg>
        </div>
        <h3 class="card-title fw-bold text-dark mb-3">Line MFG 1</h3>
        <p class="card-text text-muted mb-4">Melakukan pengecekan untuk mesin-mesin yang berada di area produksi Manufacturing Line 1.</p>
        <a href="<?= site_url('checklist/mfg1') ?>" class="btn btn-primary w-100 py-3 fw-bold rounded-3 mt-auto">Pilih MFG 1 &raquo;</a>
      </div>
    </div>
  </div>

  <!-- Card MFG 2 -->
  <div class="col-md-5">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
      <div class="card-body p-5 d-flex flex-column text-center" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-top: 5px solid #20c997;">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success p-4 rounded-circle mb-4 mx-auto" style="width: 80px; height: 80px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-2-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24c0-.69.493-1.024 1.258-1.024.756 0 1.224.392 1.224 1.007 0 .546-.329.858-.875 1.2l-.105.067c-.636.417-1.282.883-1.282 2.226h2.784v-.967H8.56c0-.528.273-.836.83-1.21l.16-.11c.712-.48 1.132-1.003 1.132-1.85 0-1.282-.967-1.977-2.438-1.977-1.5 0-2.455.858-2.455 2.012H6.646Z"/>
          </svg>
        </div>
        <h3 class="card-title fw-bold text-dark mb-3">Line MFG 2</h3>
        <p class="card-text text-muted mb-4">Melakukan pengecekan untuk mesin-mesin yang berada di area produksi Manufacturing Line 2.</p>
        <a href="<?= site_url('checklist/mfg2') ?>" class="btn btn-success text-white w-100 py-3 fw-bold rounded-3 mt-auto">Pilih MFG 2 &raquo;</a>
      </div>
    </div>
  </div>
</div>

<style>
  .card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.15)!important;
  }
</style>

<?= view('layout/footer') ?>
