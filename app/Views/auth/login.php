<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login — MTCE System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    html { font-size: 14px; }
    body {
        font-family: 'Inter', -apple-system, sans-serif;
        background: #f3f4f6;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-font-smoothing: antialiased;
    }
    .login-wrap {
        width: 100%;
        max-width: 380px;
        padding: 1rem;
    }
    .login-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        padding: 2.25rem 2rem 2rem;
    }
    .brand-icon {
        width: 44px; height: 44px;
        background: #4f46e5;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: #fff; margin: 0 auto 1rem;
    }
    .login-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #111827;
        text-align: center;
        letter-spacing: -0.02em;
        margin-bottom: 0.25rem;
    }
    .login-subtitle {
        font-size: 0.8rem;
        color: #9ca3af;
        text-align: center;
        font-weight: 500;
        margin-bottom: 1.75rem;
    }
    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.35rem;
    }
    .form-control {
        border-radius: 7px;
        border: 1.5px solid #e5e7eb;
        padding: 0.6rem 0.85rem;
        font-size: 0.875rem;
        color: #111827;
        background: #fff;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        outline: none;
    }
    .btn-login {
        width: 100%;
        padding: 0.65rem;
        background: #4f46e5;
        border: none;
        border-radius: 7px;
        font-size: 0.875rem;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        letter-spacing: 0.01em;
        transition: background 0.15s, box-shadow 0.15s;
        margin-top: 0.25rem;
    }
    .btn-login:hover {
        background: #4338ca;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
    }
    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 7px;
        padding: 0.7rem 0.9rem;
        font-size: 0.825rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.72rem;
        color: #d1d5db;
        letter-spacing: 0.03em;
    }
</style>
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="brand-icon"><i class="bi bi-shield-fill-check"></i></div>
    <div class="login-title">MTCE System</div>
    <div class="login-subtitle">Maintenance Checklist &amp; Equipment</div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (isset($errors)): ?>
      <div class="alert-danger">
        <?php foreach ($errors as $e): ?><div><i class="bi bi-dot"></i><?= esc($e) ?></div><?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-login">Masuk <i class="bi bi-arrow-right ms-1"></i></button>
    </form>
  </div>
  <div class="login-footer">MTCE &copy; <?= date('Y') ?> — Maintenance Preventive &amp; Overhaul System</div>
</div>
</body>
</html>
