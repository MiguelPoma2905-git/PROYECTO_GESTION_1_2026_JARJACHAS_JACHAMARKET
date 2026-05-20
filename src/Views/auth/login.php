<?php
if (isset($_SESSION['usuario'])) { header('Location: ' . BASE_URL . '/'); exit; }
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Iniciar Sesión - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', system-ui, sans-serif; background: #0a0a0a; color: #ebebeb; min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow-x: hidden; }
        body::before { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-image: url('<?= BASE_URL ?>/assets/images/fondo_login_3.png'); background-size: cover; background-position: center; opacity: 0.25; pointer-events: none; }
        .light-1 { position: fixed; top: -20%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 0; }
        .light-2 { position: fixed; bottom: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .login-container { position: relative; z-index: 1; width: 100%; max-width: 1120px; margin: 40px 24px; display: flex; background: rgba(8,8,8,0.65); backdrop-filter: blur(15px); border-radius: 32px; border: 1px solid rgba(255,255,255,0.08); overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); animation: fadeInUp 0.6s ease-out both; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .brand-side { flex: 1.2; padding: 48px; background: linear-gradient(135deg, rgba(8,8,8,0.5), rgba(16,16,16,0.3)); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
        .brand-side::before { content: ''; position: absolute; top: -30%; right: -20%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
        .logo-wrapper { display: flex; align-items: center; gap: 12px; margin-bottom: 60px; }
        .logo-img { height: 52px; width: auto; filter: brightness(0) invert(1); }
        .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 500; color: #ffffff; }
        .logo-text span { font-weight: 300; color: #888; font-size: 24px; }
        .brand-message h2 { font-family: 'Cormorant Garamond', serif; font-size: 40px; font-weight: 400; line-height: 1.2; margin-bottom: 20px; color: #ffffff; }
        .brand-message p { font-size: 14px; color: #999; line-height: 1.7; max-width: 320px; }
        .brand-footer { font-size: 11px; color: #666; margin-top: 60px; }
        .form-side { flex: 1; padding: 48px 56px; background: rgba(20,20,20,0.4); backdrop-filter: blur(10px); border-left: 1px solid rgba(255,255,255,0.05); }
        .form-header { margin-bottom: 40px; }
        .form-header h1 { font-size: 34px; font-weight: 600; margin-bottom: 12px; background: linear-gradient(135deg, #ffffff, #cccccc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .form-header p { font-size: 14px; color: #888; }
        .error-message { background: rgba(255,255,255,0.08); border-left: 3px solid #ffffff; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #ffffff; border-radius: 10px; }
        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #aaa; letter-spacing: 0.3px; }
        .form-group input { width: 100%; padding: 15px 18px; background: #141414; border: 1px solid #2a2a2a; border-radius: 14px; font-size: 15px; color: #ffffff; transition: all 0.3s ease; }
        .form-group input:focus { outline: none; border-color: #ffffff; box-shadow: 0 0 0 3px rgba(255,255,255,0.1); }
        .form-group input::placeholder { color: #555; }
        .btn-login { width: 100%; padding: 15px; background: #ffffff; border: none; border-radius: 14px; font-size: 15px; font-weight: 600; color: #0a0a0a; cursor: pointer; transition: all 0.3s ease; margin-top: 8px; }
        .btn-login:hover { background: #e8e8e8; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,255,255,0.15); }
        .register-link { text-align: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid #2a2a2a; }
        .register-link p { font-size: 13px; color: #888; }
        .register-link a { color: #ffffff; text-decoration: none; font-weight: 500; transition: color 0.2s; }
        .register-link a:hover { color: #cccccc; }
        @media (max-width: 900px) { .login-container { flex-direction: column; margin: 24px; } .brand-side { padding: 32px; text-align: center; } .logo-wrapper { justify-content: center; } .brand-message p { max-width: 100%; } .form-side { padding: 40px 32px; border-left: none; border-top: 1px solid rgba(255,255,255,0.05); } .brand-footer { margin-top: 32px; } }
        @media (max-width: 480px) { .brand-side { padding: 24px; } .form-side { padding: 32px 24px; } .brand-message h2 { font-size: 28px; } .form-header h1 { font-size: 28px; } .logo-img { height: 40px; } .logo-text { font-size: 24px; } .logo-text span { font-size: 18px; } }
    </style>
</head>
<body>
    <div class="light-1"></div>
    <div class="light-2"></div>
    <div class="login-container">
        <div class="brand-side">
            <div class="logo-area">
                <div class="logo-wrapper">
                    <img src="<?= BASE_URL ?>/assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
                    <div class="logo-text">JACHA<span>market</span></div>
                </div>
            </div>
            <div class="brand-message">
                <h2>Potencia tu<br>emprendimiento</h2>
                <p>La plataforma que conecta el talento boliviano con el mundo digital.</p>
            </div>
            <div class="brand-footer"><p>&copy; 2026 Jacha Marketplace</p></div>
        </div>
        <div class="form-side">
            <div class="form-header">
                <h1>Iniciar sesión</h1>
                <p>Ingresa tus credenciales para acceder a tu cuenta</p>
            </div>
            <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST" action="<?= BASE_URL ?>/login">
                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="Ingresa tu contraseña">
                </div>
                <button type="submit" class="btn-login">Acceder</button>
            </form>
            <div class="register-link">
                <p>&iquest;No tienes una cuenta? <a href="<?= BASE_URL ?>/registro">Crear cuenta</a></p>
            </div>
        </div>
    </div>
</body>
</html>
