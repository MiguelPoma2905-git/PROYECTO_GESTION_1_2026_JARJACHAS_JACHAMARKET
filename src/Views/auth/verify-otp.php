<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Verificar Código - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: #0a0a0a;
            color: #ebebeb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?= BASE_URL ?>/assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            pointer-events: none;
        }
        .light-1 { position: fixed; top: -20%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 0; }
        .light-2 { position: fixed; bottom: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .verification-container {
            position: relative; z-index: 1; width: 100%; max-width: 480px; margin: 40px 24px;
            background: rgba(8,8,8,0.75); backdrop-filter: blur(15px); border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.08); padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            animation: fadeInUp 0.6s ease-out both;
            text-align: center;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .logo-wrapper { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 32px; }
        .logo-img { height: 48px; width: auto; filter: brightness(0) invert(1); }
        .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 500; color: #ffffff; }
        .logo-text span { font-weight: 300; color: #888; font-size: 22px; }
        .verification-card h1 { font-size: 28px; font-weight: 600; margin-bottom: 12px; color: #ffffff; }
        .verification-card p { color: #888; font-size: 14px; margin-bottom: 24px; }
        .email-display { 
            background: #141414; border: 1px solid #2a2a2a; border-radius: 14px; padding: 14px; 
            margin-bottom: 28px; font-size: 14px; color: #ffffff; word-break: break-all;
        }
        .codigo-input {
            width: 100%; text-align: center; font-size: 36px; letter-spacing: 12px; padding: 16px;
            background: #141414; border: 1px solid #2a2a2a; border-radius: 14px; color: #ffffff;
            font-family: monospace; margin-bottom: 28px;
        }
        .codigo-input:focus { outline: none; border-color: #ffffff; box-shadow: 0 0 0 3px rgba(255,255,255,0.1); }
        .btn-verify { width: 100%; padding: 14px; background: #ffffff; border: none; border-radius: 14px; font-size: 15px; font-weight: 600; color: #0a0a0a; cursor: pointer; transition: all 0.3s; }
        .btn-verify:hover { background: #e0e0e0; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,255,255,0.15); }
        .resend-link { margin-top: 24px; }
        .resend-link a { color: #aaa; text-decoration: none; font-size: 13px; transition: color 0.2s; }
        .resend-link a:hover { color: #ffffff; }
        .timer { margin-top: 16px; font-size: 12px; color: #555; }
        .error-message { background: rgba(255,255,255,0.05); border-left: 3px solid #ffffff; padding: 14px; margin-bottom: 24px; font-size: 13px; color: #ffffff; border-radius: 10px; text-align: left; }
        .success-message { background: rgba(255,255,255,0.05); border-left: 3px solid #aaa; padding: 14px; margin-bottom: 24px; font-size: 13px; color: #ccc; border-radius: 10px; text-align: left; }
        @media (max-width: 480px) { 
            .verification-container { padding: 32px 24px; } 
            .codigo-input { font-size: 28px; letter-spacing: 6px; } 
            .logo-img { height: 40px; } 
            .logo-text { font-size: 24px; } 
            .logo-text span { font-size: 18px; } 
        }
    </style>
</head>
<body>
    <div class="light-1"></div>
    <div class="light-2"></div>

    <div class="verification-container">
        <div class="logo-wrapper">
            <img src="<?= BASE_URL ?>/assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
            <div class="logo-text">JACHA<span>market</span></div>
        </div>
        
        <div class="verification-card">
            <h1>Verifica tu correo</h1>
            <p>Hemos enviado un código de verificación a:</p>
            <div class="email-display">
                <?= htmlspecialchars($email) ?>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($resent): ?>
            <div class="success-message">Se ha enviado un nuevo código a tu correo</div>
            <?php endif; ?>
            
            <form method="POST" action="<?= BASE_URL ?>/verify-otp">
                <input type="text" name="codigo" maxlength="6" class="codigo-input" 
                       pattern="[0-9]{6}" required placeholder="000000" autofocus>
                <button type="submit" class="btn-verify">
                    Verificar y activar cuenta
                </button>
            </form>
            
            <div class="resend-link">
                <a href="<?= BASE_URL ?>/resend-otp">¿No recibiste el código? Reenviar</a>
            </div>
            
            <div class="timer" id="timer">
                El código expira en 10:00
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 600;
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                if (timeLeft <= 0) {
                    timerElement.innerHTML = 'El código ha expirado. Solicita uno nuevo.';
                    timerElement.style.color = '#fa7136';
                } else {
                    timerElement.innerHTML = `El código expira en ${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }
            timeLeft--;
        }
        setInterval(updateTimer, 1000);
        document.querySelector('.codigo-input').focus();
    </script>
</body>
</html>
