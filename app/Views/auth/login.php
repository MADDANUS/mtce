<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login — MTCE System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Industrial geometric fonts -->
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Inter:wght@400;500;600&family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    html { font-size: 14px; }
    
    body {
        font-family: 'Inter', sans-serif;
        background: #f8fafc; /* Light Steel */
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
    }

    /* ---- SPLIT LAYOUT CONTAINER ---- */
    .split-layout {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* ---- LEFT: HERO IMAGE ---- */
    .hero-side {
        flex: 1.2;
        background-color: #f8fafc;
        /* Tambahkan gradient halus di belakang gambar untuk estetika */
        background-image: radial-gradient(circle at center, rgba(2, 132, 199, 0.08) 0%, transparent 70%), url('<?= base_url("images/hero_bg_transparent.png") ?>');
        background-size: cover, 50%; /* Gradient cover, gambar 50% lebih kecil */
        background-repeat: no-repeat, no-repeat;
        background-position: center, center;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4rem;
        color: #0f172a;
    }



    .hero-content {
        position: relative;
        z-index: 2;
    }

    .brand-logo {
        font-family: 'Chakra Petch', sans-serif;
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
        color: #0284c7; /* Electric Blue */
        text-shadow: 0 0 10px rgba(2, 132, 199, 0.5);
    }
    .brand-tagline {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #94a3b8;
    }

    .hero-quote {
        position: relative;
        z-index: 2;
        max-width: 500px;
        border-left: 4px solid #0284c7;
        padding-left: 1.5rem;
    }
    .hero-quote p {
        font-family: 'Chakra Petch', sans-serif;
        font-size: 1.75rem;
        font-weight: 600;
        line-height: 1.3;
        margin-bottom: 1rem;
        color: #0f172a;
    }
    .hero-quote span {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.85rem;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* ---- RIGHT: FORM SIDE ---- */
    .form-side {
        flex: 1;
        background: #f8fafc; /* Light Steel */
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem 12%;
        max-width: 650px;
        position: relative;
    }

    /* Industrial accent lines */
    .form-side::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 4px;
        background: #0284c7;
    }

    .login-header {
        margin-bottom: 3rem;
    }
    .login-header h1 {
        font-family: 'Chakra Petch', sans-serif;
        font-weight: 700;
        font-size: 2.25rem;
        color: #0f172a; /* Gunmetal */
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    .login-header p {
        color: #475569;
        font-size: 1rem;
    }

    /* Form Styles */
    .form-label {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 4px; /* Sharp corners */
        padding: 0.8rem 1rem;
        font-size: 1.05rem;
        color: #0f172a;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        background: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
    }
    .form-control::placeholder {
        color: #94a3b8;
    }

    .input-group-text {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-left: none;
        border-radius: 0 4px 4px 0;
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
    }
    .form-control:focus + .input-group-text {
        border-color: #0284c7;
    }
    .input-group-text:hover {
        color: #0f172a;
    }

    .btn-login {
        background: #0284c7;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        padding: 1rem;
        font-family: 'Chakra Petch', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        width: 100%;
        margin-top: 2rem;
        transition: background 0.2s, transform 0.1s;
    }
    .btn-login:hover {
        background: #0369a1;
        color: #ffffff;
    }
    .btn-login:active {
        transform: scale(0.98);
    }

    .alert {
        border-radius: 4px;
        border: none;
        font-size: 0.9rem;
        padding: 1rem;
    }
    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border-left: 4px solid #16a34a;
    }

    /* Footer / Links */
    .login-footer {
        margin-top: 3rem;
        text-align: center;
        font-family: 'Roboto Mono', monospace;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-side { display: none; }
        .form-side { padding: 3rem; max-width: 100%; align-items: center; }
        .login-wrapper { width: 100%; max-width: 450px; }
        .mobile-brand { display: block !important; margin-bottom: 2rem; text-align: center; }
        .mobile-brand .brand-logo { color: #0284c7; font-family: 'Chakra Petch', sans-serif; font-size: 2.5rem; font-weight: 700; margin-bottom: 0.2rem;}
        .mobile-brand .brand-tagline {font-family: 'Roboto Mono', monospace; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.2em; color: #475569;}
    }
</style>
</head>
<body>

<div class="split-layout">
    <!-- LEFT PANEL: HERO IMAGE -->
    <div class="hero-side">
        <div class="hero-content">
            <div class="brand-logo">MTCE</div>
            <div class="brand-tagline">SYSTEM :: MAINTENANCE_CONTROL</div>
        </div>
        
        <div class="hero-quote">
            <p>PRECISION. RELIABILITY. PERFORMANCE.</p>
            <span>[ SYS_READY ]</span>
        </div>
    </div>

    <!-- RIGHT PANEL: LOGIN FORM -->
    <div class="form-side">
        <div class="login-wrapper w-100">
            <!-- Show brand on mobile only -->
            <div class="mobile-brand d-none">
                <div class="brand-logo">MTCE</div>
                <div class="brand-tagline">MAINTENANCE_CONTROL</div>
            </div>

            <div class="login-header">
                <h1>SYSTEM ACCESS</h1>
                <p>Enter your credentials to initiate secure connection.</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="post">
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="ID.USER" required autofocus autocomplete="username">
                </div>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between">
                        <span>Password</span>
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password" style="border-right: none;">
                        <span class="input-group-text" id="togglePassword" title="Show/Hide Password">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    CONNECT <i class="bi bi-box-arrow-in-right ms-2"></i>
                </button>
            </form>

            <div class="login-footer">
                &copy; <?= date('Y') ?> MTCE // V1.0 // ALL SYSTEMS NORMAL
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>
