<?= view('layout/header', ['title' => $title]) ?>

<div class="row justify-content-center my-5">
  <div class="col-md-8 text-center py-5 shadow-sm rounded-4 bg-white border border-light">
    <div class="bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center p-4 rounded-circle mb-4" style="width: 100px; height: 100px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-gear-wide-connected animate-spin" viewBox="0 0 16 16">
        <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434L7.068.727zM8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
      </svg>
    </div>
    
    <h2 class="fw-bold text-dark mb-3">Overhaul - <?= esc($lokasiName) ?></h2>
    <h4 class="text-warning fw-semibold mb-4">Fitur Sedang Dikembangkan</h4>
    <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
      Menu pengecekan Overhaul untuk area <?= esc($lokasiName) ?> saat ini belum tersedia dan akan segera diimplementasikan pada fase berikutnya. Route dan alur halaman sudah terkonfigurasi dengan benar.
    </p>
    
    <div class="d-flex justify-content-center gap-3">
      <a href="<?= site_url("checklist/{$lokasiSlug}") ?>" class="btn btn-primary px-4 py-2">&laquo; Kembali ke Tipe</a>
      <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary px-4 py-2">Ke Dashboard</a>
    </div>
  </div>
</div>

<style>
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  .animate-spin {
    animation: spin 8s linear infinite;
  }
</style>

<?= view('layout/footer') ?>
