<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - Aplikasi Pengecekan Bengkel (MTCE)</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
  <div class="card shadow-sm" style="width:100%; max-width:380px;">
    <div class="card-body p-4">
      <h4 class="card-title text-center mb-3">MTCE</h4>
      <p class="text-center text-muted small mb-4">Aplikasi Pengecekan Bengkel</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger py-2"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <?php if (isset($errors)): ?>
        <div class="alert alert-danger py-2">
          <?php foreach ($errors as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
