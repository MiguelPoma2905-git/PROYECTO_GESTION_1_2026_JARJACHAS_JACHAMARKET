<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Jacha Marketplace - Potenciando emprendimientos bolivianos</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        [data-theme="light"] .btn-hero-primary { background:#1a1a2e;color:#fff !important;box-shadow:0 4px 24px rgba(26,26,46,0.2); }
        [data-theme="light"] .btn-hero-primary:hover { background:#2a2a4e;box-shadow:0 8px 40px rgba(26,26,46,0.25); }
        .hero-featured { padding:100px 48px;max-width:1440px;margin:0 auto; }
        .hero-featured .section-title { font-size:48px;margin-bottom:12px; }
        .hero-featured .section-desc { font-size:15px;margin-bottom:48px; }
        .feat-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:28px; }
        .feat-card { background:var(--card-bg);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:all .5s cubic-bezier(.4,0,.2,1);position:relative;animation:featUp .6s ease both; }
        .feat-card:nth-child(1){animation-delay:0.05s}
        .feat-card:nth-child(2){animation-delay:0.10s}
        .feat-card:nth-child(3){animation-delay:0.15s}
        .feat-card:nth-child(4){animation-delay:0.20s}
        .feat-card:nth-child(5){animation-delay:0.25s}
        .feat-card:nth-child(6){animation-delay:0.30s}
        .feat-card:hover { transform:translateY(-10px);border-color:rgba(255,255,255,0.08);box-shadow:0 30px 80px rgba(0,0,0,0.3); }
        [data-theme="light"] .feat-card:hover { border-color:rgba(0,0,0,0.08);box-shadow:0 30px 80px rgba(0,0,0,0.06); }
        .feat-card::before { content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,var(--card-bg));z-index:1;pointer-events:none; }
        .feat-card-img { width:100%;height:280px;object-fit:cover;display:block;transition:transform .6s;background:var(--surface2); }
        .feat-card:hover .feat-card-img { transform:scale(1.06); }
        .feat-card-body { position:relative;z-index:2;padding:28px;margin-top:-60px; }
        .feat-card-tag { display:inline-block;padding:4px 14px;border-radius:4px;font-size:10px;font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:12px; }
        .feat-card-body h3 { font-size:20px;font-weight:600;color:var(--text);margin-bottom:8px; }
        .feat-card-body p { font-size:13px;color:var(--text-muted);line-height:1.6;margin-bottom:16px; }
        .feat-card-btn { display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:all .3s; }
        .feat-card-btn:hover { transform:translateY(-2px); }
        .feat-empty { text-align:center;padding:80px;color:var(--text-dim);grid-column:1/-1; }
        @keyframes featUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }
        @media(max-width:1024px){ .feat-grid{grid-template-columns:repeat(2,1fr)} .hero-featured{padding:60px 32px} }
        @media(max-width:768px){ .feat-grid{grid-template-columns:1fr} .hero-featured{padding:40px 20px} .feat-card-img{height:220px} }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <div class="logo-wrapper">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img">
            </div>
            <button class="menu-toggle" id="menuToggle">&#9776;</button>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="margin-left:12px;flex-shrink:0">&#9790;</button>
            <nav class="nav-menu" id="navMenu">
                <a href="<?= BASE_URL ?>/">Inicio</a>
                <a href="<?= BASE_URL ?>/db-demo" class="btn-nav-outline">Demostración BD</a>
                <a href="<?= BASE_URL ?>/plantillas-disponibles">Plantillas</a>
                <?php if ($is_logged_in): ?>
                    <a href="<?= BASE_URL ?>/dashboard">Mi panel</a>
                    <a href="<?= BASE_URL ?>/logout">Cerrar sesión</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/login" class="btn-nav-outline">Iniciar sesión</a>
                    <a href="<?= BASE_URL ?>/registro" class="btn-nav-primary">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <span class="hero-badge">Bolivia · 2026</span>
                <h1>Potencia tu <em>emprendimiento</em><br>en el mundo digital</h1>
                <p class="hero-desc">
                    La plataforma que conecta el talento boliviano con clientes de todo el país.
                    Crea tu tienda online, gestiona tus ventas y haz crecer tu negocio.
                </p>
                <div class="hero-buttons">
                    <?php if (!$is_logged_in): ?>
                        <a href="<?= BASE_URL ?>/registro" class="btn-hero-primary">Comenzar ahora →</a>
                        <a href="<?= BASE_URL ?>/explorar" class="btn-hero-secondary">Explorar negocios</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/dashboard" class="btn-hero-primary">Ir a mi panel →</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="hero-carousel">
                <div class="carousel-container" id="carouselContainer">
                    <?php foreach ($ambientes as $index => $ambiente): ?>
                    <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                        <img src="<?= BASE_URL ?>/assets/images/ambiente_<?= strtolower($ambiente['nombre']) ?>.jpg" alt="<?= htmlspecialchars($ambiente['nombre']) ?>" class="carousel-image" onerror="this.parentElement.innerHTML='<div class=\'carousel-placeholder\'><div class=\'color-preview\'><div class=\'color-circle\' style=\'background:<?= $ambiente['color_primario'] ?>;\'></div><div class=\'color-circle\' style=\'background:<?= $ambiente['color_secundario'] ?>;\'></div></div><p style=\'font-size:12px;\'><?= htmlspecialchars($ambiente['descripcion']) ?></p></div>'">
                        <div class="carousel-caption">
                            <h3><?= htmlspecialchars($ambiente['nombre']) ?></h3>
                            <p><?= htmlspecialchars($ambiente['descripcion']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-indicators" id="carouselIndicators">
                    <?php foreach ($ambientes as $index => $ambiente): ?>
                    <div class="indicator <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <div class="stats-bar">
            <div class="stats-inner">
                <div class="stat-item"><div class="stat-number"><?= $total_negocios ?></div><div class="stat-label">Negocios activos</div></div>
                <div class="stat-item"><div class="stat-number"><?= $total_productos ?></div><div class="stat-label">Productos</div></div>
                <div class="stat-item"><div class="stat-number"><?= $total_usuarios ?></div><div class="stat-label">Usuarios</div></div>
                <div class="stat-item"><div class="stat-number"><?= $total_pedidos ?></div><div class="stat-label">Pedidos</div></div>
            </div>
        </div>

        <section class="hero-featured">
            <div class="section-header">
                <div class="section-label">Negocios destacados</div>
                <h2 class="section-title">Descubre y adquiere productos</h2>
                <p class="section-desc">Explora emprendimientos bolivianos únicos y apoya el talento local</p>
            </div>
            <?php if (count($escaparates) > 0): ?>
            <div class="feat-grid">
                <?php foreach ($escaparates as $neg): ?>
                <div class="feat-card" onclick="window.location.href='<?= BASE_URL ?>/tienda/<?= $neg['id_emprendimiento'] ?>'">
                    <img src="<?= BASE_URL ?>/assets/images/features/producto_destacado_0<?= rand(1,4) ?>.jpg" alt="" class="feat-card-img" onerror="this.style.display='none'">
                    <div class="feat-card-body">
                        <span class="feat-card-tag" style="background:<?= $neg['color_primario'] ?>20;color:<?= $neg['color_primario'] ?>"><?= htmlspecialchars($neg['plantilla_nombre']) ?></span>
                        <h3><?= htmlspecialchars($neg['nombre_comercial']) ?></h3>
                        <p><?= htmlspecialchars(substr($neg['descripcion'] ?? '', 0, 100)) ?>...</p>
                        <a href="<?= BASE_URL ?>/tienda/<?= $neg['id_emprendimiento'] ?>" class="feat-card-btn" style="background:<?= $neg['color_primario'] ?>;color:#fff">Ver tienda →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="feat-empty"><p>Próximamente nuevos negocios destacados</p></div>
            <?php endif; ?>
        </section>


    </main>

    <footer class="footer">
        <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" style="height:28px;width:auto">
        <p class="footer-copy">© 2026 Jacha Marketplace - Potenciando emprendimientos bolivianos</p>
    </footer>

    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

    <script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();
</script>
<script>
(function() {
    var themeToggle = document.getElementById('themeToggle');
    var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
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
    <script>
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.indicator');
        let currentIndex = 0, interval;
        function showSlide(index) { slides.forEach((s,i)=>s.classList.toggle('active',i===index)); indicators.forEach((ind,i)=>ind.classList.toggle('active',i===index)); currentIndex=index; }
        function nextSlide() { showSlide((currentIndex+1)%slides.length); }
        function startCarousel() { if(interval) clearInterval(interval); interval = setInterval(nextSlide,5000); }
        indicators.forEach(i=>i.addEventListener('click',()=>{ showSlide(parseInt(i.getAttribute('data-index'))); startCarousel(); }));
        if(slides.length>0) startCarousel();
        
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        if(menuToggle) menuToggle.addEventListener('click',()=>navMenu.classList.toggle('active'));
        document.querySelectorAll('.nav-menu a').forEach(l=>l.addEventListener('click',()=>{if(window.innerWidth<=768)navMenu.classList.remove('active');}));
        

    </script>
</body>
</html>
