<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Crear negocio - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
        .crear-container { position:relative;z-index:10;width:100%;max-width:1120px;margin:40px 24px;display:flex;background:var(--auth-bg);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);border-radius:32px;border:1px solid var(--border);overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);animation:fadeInUp 0.6s var(--ease) both }
        .crear-brand { flex:1.2;padding:48px;background:linear-gradient(135deg,rgba(18,18,18,0.5),rgba(22,22,22,0.3));display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden }
        .crear-brand::before { content:'';position:absolute;top:-30%;right:-20%;width:300px;height:300px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);border-radius:50%;pointer-events:none }
        .crear-brand-content { position:relative;z-index:1 }
        .crear-brand-message { margin-bottom:auto }
        .crear-brand-message h2 { font-family:var(--font-serif);font-size:40px;font-weight:400;line-height:1.2;margin-bottom:20px;color:var(--text) }
        .crear-brand-message p { font-size:14px;color:var(--text-muted);line-height:1.7;max-width:340px }
        .crear-brand-footer { font-size:11px;color:var(--text-dim);margin-top:60px }
        .crear-brand .template-showcase { margin-top:40px;background:var(--glow);border:1px solid var(--border);border-radius:20px;padding:28px;position:relative;z-index:1 }
        .crear-brand .template-showcase h4 { font-family:var(--font-serif);font-size:20px;font-weight:400;color:var(--text);margin-bottom:16px }
        .crear-brand .template-palette { display:flex;gap:16px;margin-bottom:20px }
        .crear-brand .template-palette .color-block { width:48px;height:48px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.3) }
        .crear-brand .template-palette .color-block { border:2px solid rgba(255,255,255,0.15) }
        .crear-brand .template-desc { font-size:12px;color:var(--text-dim);line-height:1.6 }
        .crear-brand .template-desc strong { color:var(--text-muted) }
        .crear-form-side { flex:1;padding:48px 56px;background:var(--auth-side-bg);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);border-left:1px solid var(--border) }
        .crear-form-header { margin-bottom:40px }
        .crear-form-header h1 { font-size:34px;font-weight:600;margin-bottom:12px;background:linear-gradient(135deg,var(--text),var(--text-muted));-webkit-background-clip:text;background-clip:text;color:transparent }
        .crear-form-header p { font-size:14px;color:var(--text-muted) }
        .crear-form .form-group { margin-bottom:24px }
        .crear-form label { display:block;margin-bottom:8px;font-size:13px;font-weight:500;color:var(--text-muted);letter-spacing:0.3px }
        .crear-form input,.crear-form textarea { width:100%;padding:15px 18px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:14px;font-size:15px;color:var(--text);transition:all 0.3s ease;font-family:inherit }
        .crear-form input:focus,.crear-form textarea:focus { outline:none;border-color:var(--border-hi);box-shadow:0 0 0 3px var(--accent-glow) }
        .crear-form input::placeholder,.crear-form textarea::placeholder { color:var(--text-dim) }
        .crear-form textarea { resize:vertical;min-height:120px }
        .crear-back { text-align:center;margin-top:32px;padding-top:24px;border-top:1px solid var(--border) }
        .crear-back p { font-size:13px;color:var(--text-muted) }
        .crear-back a { color:var(--text);font-weight:500;transition:color 0.2s }
        .crear-back a:hover { opacity:0.7 }
        @media (max-width:900px) { .crear-container { flex-direction:column;margin:24px } .crear-brand { padding:32px;text-align:center } .crear-brand-message p { max-width:100% } .crear-form-side { padding:40px 32px;border-left:none;border-top:1px solid var(--border) } .crear-brand-footer { margin-top:32px } .crear-brand .template-showcase { text-align:left } }
    </style>
</head>
<body>
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

    <div class="light light-tl"></div>
    <div class="light light-br"></div>

    <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="position:fixed;top:20px;right:20px;z-index:100">&#9790;</button>
    <div class="crear-container">
        <div class="crear-brand">
            <div class="crear-brand-content">
                <div class="flex-center gap-md">
                    <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img-lg">
                </div>
            </div>
            <div class="crear-brand-message">
                <h2>Tu negocio<br>en l&iacute;nea</h2>
                <p>Configura los datos de tu emprendimiento y empieza a vender en minutos.</p>
            </div>
            <div class="template-showcase">
                <h4><?= htmlspecialchars($plantilla['nombre']) ?></h4>
                <div class="template-palette">
                    <div class="color-block primary" style="background:<?= $plantilla['color_primario'] ?>"></div>
                    <div class="color-block secondary" style="background:<?= $plantilla['color_secundario'] ?>"></div>
                </div>
                <div class="template-desc">
                    <strong>Colores de la plantilla:</strong><br>
                    Primario: <?= $plantilla['color_primario'] ?> &middot; Secundario: <?= $plantilla['color_secundario'] ?>
                </div>
            </div>
            <div class="crear-brand-footer">&copy; 2026 Jacha Marketplace</div>
        </div>
        <div class="crear-form-side">
            <div class="crear-form-header">
                <h1>Crear nuevo negocio</h1>
                <p>Completa los datos de tu emprendimiento</p>
            </div>
            <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form class="crear-form" method="POST" action="<?= BASE_URL ?>/crear-negocio?plantilla=<?= $_GET['plantilla'] ?? $plantilla['id_plantilla'] ?>">
                <div class="form-group">
                    <label>Nombre comercial *</label>
                    <input type="text" name="nombre_comercial" required placeholder="Ej: Tecnolog&iacute;a Plus">
                </div>
                <div class="form-group">
                    <label>NIT (opcional)</label>
                    <input type="text" name="nit" placeholder="Ej: 1234567890">
                </div>
                <div class="form-group">
                    <label>Descripci&oacute;n del negocio</label>
                    <textarea name="descripcion" placeholder="Cu&eacute;ntanos sobre tu emprendimiento..."></textarea>
                </div>
                <button type="submit" class="btn-crear">Crear negocio</button>
            </form>
            <div class="crear-back">
                <p><a href="<?= BASE_URL ?>/plantillas-disponibles">&larr; Volver a plantillas</a></p>
            </div>
        </div>
    </div>

    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

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
    <script>
        (function() {
            var themeToggle = document.getElementById('themeToggle');
            var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            if (themeToggle) {
                themeToggle.innerHTML = currentTheme === 'dark' ? '\u2600' : '\u263E';
                themeToggle.addEventListener('click', function() {
                    var theme = document.documentElement.getAttribute('data-theme');
                    var newTheme = theme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('jacha_theme', newTheme);
                    themeToggle.innerHTML = newTheme === 'dark' ? '\u2600' : '\u263E';
                });
            }
        })();
    </script>
</body>
</html>