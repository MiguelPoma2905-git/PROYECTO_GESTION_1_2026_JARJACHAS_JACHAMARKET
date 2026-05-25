<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Seleccionar rol - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        body { min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:0 }
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
        .selector-container { width:100%;max-width:500px;margin:32px auto;background:var(--auth-bg);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-radius:32px;border:1px solid var(--border);padding:48px 40px;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);position:relative;z-index:10;animation:fadeInUp 0.6s var(--ease) both }
        .btn-continuar { width:100%;padding:14px;background:var(--text);color:var(--card-bg);border:none;border-radius:12px;font-size:15px;font-weight:600;cursor:pointer;transition:all .3s }
        .btn-continuar:hover:not(:disabled) { transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.3) }
        .btn-continuar:disabled { opacity:.4;cursor:not-allowed }
        .roles-grid { display:flex;flex-direction:column;gap:16px;margin-bottom:32px;text-align:left }
        .rol-option { background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px;cursor:pointer;transition:all 0.3s var(--ease);display:flex;align-items:center;gap:16px }
        .rol-option:hover { border-color:var(--border-hi);background:var(--hover-surface);transform:translateX(4px) }
        .rol-option.selected { border-color:var(--text);background:var(--surface3) }
        .rol-option h4 { font-size:16px;font-weight:600;color:var(--text);margin-bottom:4px }
        .rol-option p { font-size:13px;color:var(--text-muted);line-height:1.4 }
        .error { color:var(--text-muted);font-size:13px;margin-top:16px;margin-bottom:16px }
        @media (max-width:600px) {
            body { background:var(--bg) !important; }
            #bgCarousel,.bg-carousel-overlay,.bg-carousel-gradient-overlay,.carousel-particles,.watermark { display:none !important; }
            .selector-container { margin:0;min-height:100vh;border-radius:0;background:var(--bg);backdrop-filter:none;-webkit-backdrop-filter:none;border:none;box-shadow:none;padding:32px 20px }
            .auth-theme-btn { top:12px;right:12px;width:36px;height:36px;font-size:14px }
        }
        @media (max-width:480px) { .selector-container { padding:32px 24px } .rol-option { padding:16px } }
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
    <div class="selector-container">
        <div class="logo-auth">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img">
        </div>
        <h2 style="font-size:28px;margin-bottom:12px;color:var(--text)">Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?></h2>
        <p style="color:var(--text-muted);font-size:14px;margin-bottom:32px">Tienes acceso a múltiples perfiles. Selecciona con qué rol deseas ingresar hoy.</p>
        
        <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" id="rolForm" action="<?= BASE_URL ?>/selector-rol">
            <div class="roles-grid">
                <?php foreach ($roles_disponibles as $rol): ?>
                <label class="rol-option">
                    <input type="radio" name="rol" value="<?= $rol['nombre_rol'] ?>">
                    <span class="rol-radio"></span>
                    <div class="rol-info">
                        <h4><?= $rol['nombre_rol'] ?></h4>
                        <p>
                            <?php if ($rol['nombre_rol'] === 'Emprendedor'): ?>Gestiona tu tienda, productos y ventas
                            <?php elseif ($rol['nombre_rol'] === 'Cliente'): ?>Explora y compra productos bolivianos
                            <?php elseif ($rol['nombre_rol'] === 'Repartidor'): ?>Gestiona entregas y pedidos
                            <?php else: ?>Panel de administración
                            <?php endif; ?>
                        </p>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn-continuar">Continuar</button>
        </form>
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
        document.querySelectorAll('.rol-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.rol-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                option.querySelector('input[type="radio"]').checked = true;
            });
        });
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