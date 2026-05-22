<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Verificar Código - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        body { min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:0 }
        .auth-container { margin:32px auto }
        .auth-theme-btn {
            position:fixed; top:20px; right:20px; z-index:100;
            width:40px; height:40px; border-radius:50%;
            background:var(--card-bg); border:1px solid var(--border);
            color:var(--text-muted); font-size:16px; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; backdrop-filter:blur(8px);
        }
        .auth-theme-btn:hover { border-color:var(--border-hi); color:var(--text); }
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
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
    <div class="carousel-particles" id="particles"></div>
    <div class="auth-container" style="max-width:480px;text-align:center;z-index:10;position:relative">
        <div class="auth-form-side" style="border-left:none;padding:48px 40px">
            <div class="logo-auth">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img-lg">
            </div>
            
            <div class="auth-form-header text-center">
                <h1>Verifica tu correo</h1>
                <p>Hemos enviado un código de verificación a:</p>
            </div>
            
            <div class="email-display">
                <?= htmlspecialchars($email) ?>
            </div>
            
            <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($resent): ?>
            <div class="success-msg">Se ha enviado un nuevo código a tu correo</div>
            <?php endif; ?>
            
            <form method="POST" action="<?= BASE_URL ?>/verificar-otp">
                <input type="text" name="codigo" maxlength="6" class="codigo-input" 
                       pattern="[0-9]{6}" required placeholder="000000" autofocus>
                <button type="submit" class="btn-auth">
                    Verificar y activar cuenta
                </button>
            </form>
            
            <div class="text-center" style="margin-top:24px">
                <a href="<?= BASE_URL ?>/reenviar-otp" class="reenviar-link">¿No recibiste el código? Reenviar</a>
            </div>
            
            <div class="timer-text" id="timer">
                El código expira en 10:00
            </div>
        </div>
    </div>

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
    <script>
        let timeLeft = 600;
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                if (timeLeft <= 0) {
                    timerElement.innerHTML = 'El código ha expirado. Solicita uno nuevo.';
                } else {
                    timerElement.innerHTML = `El código expira en ${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }
            timeLeft--;
        }
        setInterval(updateTimer, 1000);
        document.querySelector('.codigo-input').focus();
    </script>
    <script>
    (function() {
        var slides = document.querySelectorAll('#bgCarousel .carousel-slide');
        var current = 0;
        var total = slides.length;
        var interval = 7000;

        function createParticles() {
            var container = document.getElementById('particles');
            for (var i = 0; i < 15; i++) {
                var p = document.createElement('div');
                p.className = 'carousel-particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.width = (2 + Math.random() * 4) + 'px';
                p.style.height = p.style.width;
                p.style.animationDuration = (10 + Math.random() * 20) + 's';
                p.style.animationDelay = (Math.random() * 20) + 's';
                p.style.opacity = 0.1 + Math.random() * 0.3;
                container.appendChild(p);
            }
        }

        function nextSlide() {
            slides[current].classList.remove('active');
            slides[current].classList.add('prev');
            current = (current + 1) % total;
            slides[current].classList.add('active');
            setTimeout(function() {
                slides.forEach(function(s) { s.classList.remove('prev'); });
            }, 1500);
        }

        createParticles();
        setInterval(nextSlide, interval);
    })();
    </script>
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
</body>
</html>