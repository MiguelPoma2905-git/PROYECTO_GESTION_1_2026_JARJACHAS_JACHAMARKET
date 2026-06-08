<?php
if (isset($_SESSION['usuario'])) { header('Location: ' . BASE_URL . '/'); exit; }
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$token = $_GET['token'] ?? '';
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= $token ? 'Nueva contraseña' : 'Recuperar contraseña' ?> - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        body { min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:0 }
        .auth-container { margin:32px auto;max-width:480px }
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
        .auth-theme-btn {
            position:fixed; top:20px; right:20px; z-index:100;
            width:40px; height:40px; border-radius:50%;
            background:var(--card-bg); border:1px solid var(--border);
            color:var(--text-muted); font-size:16px; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; backdrop-filter:blur(8px);
        }
        .auth-theme-btn:hover { border-color:var(--border-hi); color:var(--text); }
        @media (max-width:600px) {
            body { background:var(--bg) !important; }
            #bgCarousel,.bg-carousel-overlay,.bg-carousel-gradient-overlay { display:none !important; }
            .auth-container { margin:0;border-radius:0;min-height:100vh;background:var(--bg);border:none;box-shadow:none }
            .auth-theme-btn { top:12px;right:12px;width:36px;height:36px;font-size:14px }
        }
    </style>
</head>
<body>
    <button class="auth-theme-btn" id="themeToggle" title="Cambiar tema">&#9790;</button>
    <div class="bg-carousel" id="bgCarousel">
        <div class="carousel-slide carousel-slide-1 active"></div>
        <div class="carousel-slide carousel-slide-2"></div>
        <div class="carousel-slide carousel-slide-3"></div>
        <div class="carousel-slide carousel-slide-4"></div>
        <div class="carousel-slide carousel-slide-5"></div>
    </div>
    <div class="bg-carousel-overlay"></div>
    <div class="bg-carousel-gradient-overlay"></div>
    <div class="light light-tl"></div>
    <div class="light light-br"></div>
    <div class="auth-container">
        <div style="text-align:center;margin-bottom:32px">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" style="height:40px;opacity:0.85">
        </div>
        <div class="auth-form-side" style="border:none;width:100%;padding:48px 40px;background:var(--auth-bg);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);border-radius:8px;border:1px solid var(--border);box-shadow:0 25px 50px -12px rgba(0,0,0,0.5)">
            <?php if ($success): ?>
            <div style="background:rgba(46,204,113,0.15);border-left:3px solid #2ecc71;padding:14px 18px;border-radius:8px;margin-bottom:20px;font-size:13px;color:#2ecc71"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($token): ?>
                <h1 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:32px;font-weight:500;color:var(--text);margin-bottom:8px">Nueva contraseña</h1>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:32px">Ingresa tu nueva contraseña</p>
                <form method="POST" action="<?= BASE_URL ?>/reset-password">
                    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="form-group">
                        <label>Nueva contraseña</label>
                        <input type="password" name="password" required minlength="6" placeholder="Ingresa tu nueva contraseña" style="width:100%;padding:15px 18px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:6px;font-size:14px;color:var(--text);font-family:'DM Sans',system-ui,sans-serif">
                    </div>
                    <div class="form-group">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="confirm_password" required minlength="6" placeholder="Repite tu nueva contraseña" style="width:100%;padding:15px 18px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:6px;font-size:14px;color:var(--text);font-family:'DM Sans',system-ui,sans-serif">
                    </div>
                    <button type="submit" class="btn-auth">Cambiar contraseña</button>
                </form>
            <?php else: ?>
                <h1 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:32px;font-weight:500;color:var(--text);margin-bottom:8px">Recuperar contraseña</h1>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:32px">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña</p>
                <form method="POST" action="<?= BASE_URL ?>/recuperar-password">
                    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" required placeholder="tu@email.com" style="width:100%;padding:15px 18px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:6px;font-size:14px;color:var(--text);font-family:'DM Sans',system-ui,sans-serif">
                    </div>
                    <button type="submit" class="btn-auth">Enviar enlace</button>
                </form>
            <?php endif; ?>
            <div class="auth-link" style="margin-top:24px">
                <p><a href="<?= BASE_URL ?>/login">Volver al inicio de sesión</a></p>
            </div>
        </div>
    </div>
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
    <script>
    (function() {
        var theme = localStorage.getItem('jacha_theme') || 'dark';
        document.documentElement.setAttribute('data-theme', theme);
        var toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.innerHTML = theme === 'dark' ? '\u2600' : '\u263E';
            toggle.addEventListener('click', function() {
                var current = document.documentElement.getAttribute('data-theme');
                var next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('jacha_theme', next);
                toggle.innerHTML = next === 'dark' ? '\u2600' : '\u263E';
            });
        }
    })();
    </script>
</body>
</html>
