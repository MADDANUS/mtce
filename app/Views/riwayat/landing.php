<?= view('layout/header', ['title' => $title]) ?>

<div class="row justify-content-center my-4">
  <div class="col-md-8 text-center mb-3">
    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-clock-history me-2 text-primary"></i>Pilih Lokasi Riwayat</h5>
    <p class="text-muted small">Silakan pilih lokasi manufaktur (Manufacturing Line) untuk melihat riwayat pengecekan mesin.</p>
  </div>
</div>

<div class="row justify-content-center g-4">
  <!-- Card MFG 1 -->
  <div class="col-md-5">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
      <div class="card-body p-4 d-flex flex-column text-center bg-gradient-mfg1" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-top: 5px solid var(--accent);">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary p-3 rounded-circle mb-3 mx-auto" style="width: 70px; height: 70px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-1-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002H7.971L6.072 5.385v1.271l1.834-1.318h.065V12h1.312V4.002Z"/>
          </svg>
        </div>
        <h6 class="card-title fw-bold text-dark mb-2">Line MFG 1</h6>
        <p class="card-text text-muted small mb-4">Melihat daftar riwayat pengecekan (Preventive &amp; Overhaul) untuk mesin di area produksi Manufacturing Line 1.</p>
        <a href="<?= site_url('riwayat/lokasi/mfg1') ?>" class="btn btn-primary w-100 py-2.5 fw-bold rounded-3 mt-auto">Pilih MFG 1 &raquo;</a>
      </div>
    </div>
  </div>

  <!-- Card MFG 2 -->
  <div class="col-md-5">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover transition" style="transition: transform 0.2s, box-shadow 0.2s;">
      <div class="card-body p-4 d-flex flex-column text-center" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-top: 5px solid var(--success);">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success p-3 rounded-circle mb-3 mx-auto" style="width: 70px; height: 70px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-2-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24c0-.69.493-1.024 1.258-1.024.756 0 1.224.392 1.224 1.007 0 .546-.329.858-.875 1.2l-.105.067c-.636.417-1.282.883-1.282 2.226h2.784v-.967H8.56c0-.528.273-.836.83-1.21l.16-.11c.712-.48 1.132-1.003 1.132-1.85 0-1.282-.967-1.977-2.438-1.977-1.5 0-2.455.858-2.455 2.012H6.646Z"/>
          </svg>
        </div>
        <h6 class="card-title fw-bold text-dark mb-2">Line MFG 2</h6>
        <p class="card-text text-muted small mb-4">Melihat daftar riwayat pengecekan (Preventive &amp; Overhaul) untuk mesin di area produksi Manufacturing Line 2.</p>
        <a href="<?= site_url('riwayat/lokasi/mfg2') ?>" class="btn btn-success text-white w-100 py-2.5 fw-bold rounded-3 mt-auto">Pilih MFG 2 &raquo;</a>
      </div>
    </div>
  </div>
</div>

<style>
  .card-hover:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow) !important;
  }
</style>

<?= view('layout/footer') ?>
