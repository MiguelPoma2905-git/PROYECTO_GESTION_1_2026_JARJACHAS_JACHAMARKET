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
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [data-theme="light"] .btn-hero-primary { background:#1a1a2e;color:#fff !important;box-shadow:0 4px 24px rgba(26,26,46,0.2); }
        [data-theme="light"] .btn-hero-primary:hover { background:#2a2a4e;box-shadow:0 8px 40px rgba(26,26,46,0.25); }
        .hero-featured { padding:100px 48px;max-width:1440px;margin:0 auto; }
        .hero-featured .section-title { font-size:48px;margin-bottom:12px; }
        .hero-featured .section-desc { font-size:15px;margin-bottom:48px; }
        .feat-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:28px; }
        .feat-card { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:all .5s cubic-bezier(.4,0,.2,1);position:relative;animation:featUp .6s ease both; }
        .feat-card:nth-child(1){animation-delay:0.05s}
        .feat-card:nth-child(2){animation-delay:0.10s}
        .feat-card:nth-child(3){animation-delay:0.15s}
        .feat-card:nth-child(4){animation-delay:0.20s}
        .feat-card:nth-child(5){animation-delay:0.25s}
        .feat-card:nth-child(6){animation-delay:0.30s}
        .feat-card:hover { transform:translateY(-6px);box-shadow:0 24px 48px rgba(0,0,0,0.25);border-color:rgba(255,255,255,0.1); }
        [data-theme="light"] .feat-card:hover { box-shadow:0 24px 48px rgba(0,0,0,0.08);border-color:rgba(0,0,0,0.1); }
        .feat-card-img { width:100%;height:200px;object-fit:cover;display:block;transition:transform .6s;background:var(--surface2); }
        .feat-card:hover .feat-card-img { transform:scale(1.05); }
        .feat-card-body { padding:20px 24px 24px; }
        .feat-card-tag { display:inline-block;padding:4px 14px;border-radius:4px;font-size:11px;font-weight:500;letter-spacing:0.5px;margin-bottom:10px;font-family:'Cormorant Garamond',Georgia,serif; }
        .feat-card-body h3 { font-size:20px;font-weight:600;color:var(--text);margin-bottom:6px;font-family:'Cormorant Garamond',Georgia,serif; }
        .feat-card-body p { font-size:13px;color:var(--text-muted);line-height:1.6;margin-bottom:16px; }
        [data-theme="dark"] .feat-card-img { filter:brightness(0.85) contrast(1.1); }
        [data-theme="dark"] .feat-card:hover .feat-card-img { filter:brightness(1) contrast(1.1); }
        .feat-card-btn { display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:all .3s; }
        .feat-card-btn:hover { transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,0,0,0.2); }
        .feat-empty { text-align:center;padding:80px;color:var(--text-dim);grid-column:1/-1; }
        @keyframes featUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }
        @media(max-width:1024px){ .feat-grid{grid-template-columns:repeat(2,1fr)} .hero-featured{padding:60px 32px} }
        @media(max-width:768px){ .feat-grid{grid-template-columns:1fr} .hero-featured{padding:40px 20px} .feat-card-img{height:220px} }

        .feat-list { display:grid;grid-template-columns:1fr 1fr;gap:32px;margin:0 -48px;padding:0; }
        .feat-card-h { background:var(--card-bg);border:1px solid var(--border);border-radius:10px;overflow:hidden;transition:all .5s cubic-bezier(.4,0,.2,1);position:relative;animation:featUp .6s ease both; }
        .feat-card-h:nth-child(1){animation-delay:0.05s}
        .feat-card-h:nth-child(2){animation-delay:0.10s}
        .feat-card-h:nth-child(3){animation-delay:0.15s}
        .feat-card-h:nth-child(4){animation-delay:0.20s}
        .feat-card-h:hover { transform:translateY(-8px);border-color:rgba(255,255,255,0.1);box-shadow:0 24px 72px rgba(0,0,0,0.25); }
        [data-theme="light"] .feat-card-h:hover { border-color:rgba(0,0,0,0.08);box-shadow:0 24px 72px rgba(0,0,0,0.06); }
        .feat-card-h::before { content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,var(--card-bg));z-index:1;pointer-events:none; }
        .feat-card-h-body { position:relative;z-index:2;padding:52px 56px 20px; }
        .feat-card-h-body .feat-card-tag { display:inline-block;padding:6px 22px;border-radius:4px;font-size:13px;font-weight:500;letter-spacing:0.5px;font-family:'Cormorant Garamond',Georgia,serif;margin-bottom:8px; }
        .feat-card-h-body h3 { font-family:'Cormorant Garamond',Georgia,serif;font-size:38px;font-weight:600;color:var(--text);margin:0 0 12px;line-height:1.15; }
        .feat-card-h-body p { font-size:16px;color:var(--text-muted);line-height:1.8;margin:0;max-width:720px; }
        .feat-card-h-img { position:relative;z-index:0;line-height:0;overflow:hidden; }
        .feat-card-h-img img { width:100%;height:380px;object-fit:cover;display:block;transition:transform .6s; }
        .feat-card-h:hover .feat-card-h-img img { transform:scale(1.05); }
        [data-theme="dark"] .feat-card-h-img img { filter:brightness(0.8) contrast(1.15); }
        [data-theme="dark"] .feat-card-h:hover .feat-card-h-img img { filter:brightness(1) contrast(1.15); }
        @media(max-width:768px){
          .feat-list{max-width:100%;gap:28px;}
          .feat-card-h-body{padding:36px 24px 16px;}
          .feat-card-h-body h3{font-size:28px;}
          .feat-card-h-body p{font-size:15px;}
          .feat-card-h-img img{height:220px;}
        }

        .hero-featured.hero-bg { position:relative;background:transparent;z-index:0; }
        .hero-featured.hero-bg::before { content:'';position:absolute;inset:0;background:url('<?= BASE_URL ?>/assets/images/fondo_extra.jpg') center/cover no-repeat fixed;z-index:-2;filter:saturate(1.1) brightness(0.9); }
        .hero-featured.hero-bg::after { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.75) 0%,rgba(0,0,0,0.35) 50%,rgba(0,0,0,0.75) 100%);z-index:-1; }
        [data-theme="light"] .hero-featured.hero-bg::after { background:linear-gradient(135deg,rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.3) 50%,rgba(255,255,255,0.7) 100%); }
        .hero-featured.hero-bg .section-header { text-align:center;padding:60px 0 20px; }
        .hero-featured.hero-bg .section-title { color:#fff; }
        [data-theme="light"] .hero-featured.hero-bg .section-title { color:#1a1a2e; }
        .hero-featured.hero-bg .section-desc { color:rgba(255,255,255,0.75); }
        [data-theme="light"] .hero-featured.hero-bg .section-desc { color:rgba(0,0,0,0.6); }
        .hero-featured.hero-bg .section-label { color:rgba(255,255,255,0.6); }
        [data-theme="light"] .hero-featured.hero-bg .section-label { color:rgba(0,0,0,0.5); }
        .hero-featured.hero-bg .feat-card { background:var(--card-bg);border:1px solid var(--border);backdrop-filter:blur(2px); }
        .hero-featured.hero-bg .feat-card:hover { border-color:rgba(255,255,255,0.15);box-shadow:0 24px 48px rgba(0,0,0,0.35); }
        [data-theme="light"] .hero-featured.hero-bg .feat-card:hover { border-color:rgba(0,0,0,0.1);box-shadow:0 24px 48px rgba(0,0,0,0.08); }

        .hero-greeting { font-family:'Cormorant Garamond',Georgia,serif;font-size:54px;font-weight:500;color:var(--text);line-height:1.15;margin-bottom:12px;min-height:1.2em }
        .hero-greeting .glow-char { display:inline-block;animation:heroGlow 2.5s ease-in-out infinite;text-shadow:0 0 8px rgba(255,255,255,0.2),0 0 25px rgba(255,255,255,0.3),0 0 50px rgba(255,255,255,0.15),0 0 100px rgba(255,255,255,0.08) }
        [data-theme="light"] .hero-greeting .glow-char { text-shadow:0 0 6px rgba(255,255,255,0.5),0 0 16px rgba(255,255,255,0.3),0 0 30px rgba(255,255,255,0.15) }
        .hero-greeting .cursor { display:inline-block;width:3px;height:1.1em;background:var(--text);margin-left:3px;animation:blink 0.8s step-end infinite;vertical-align:text-bottom }
        .hero-greeting .hero-em { font-style:italic;color:var(--accent,inherit) }
        @keyframes heroGlow { 0%,100%{text-shadow:0 0 8px rgba(255,255,255,0.15),0 0 20px rgba(255,255,255,0.25),0 0 40px rgba(255,255,255,0.15),0 0 80px rgba(255,255,255,0.08)} 50%{text-shadow:0 0 12px rgba(255,255,255,0.3),0 0 30px rgba(255,255,255,0.4),0 0 60px rgba(255,255,255,0.2),0 0 120px rgba(255,255,255,0.1)} }
        @keyframes blink { 50%{opacity:0} }
        @media(max-width:768px){ .hero-greeting { font-size:36px } }
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
                <h1 class="hero-greeting" id="heroGreeting"></h1>
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

        <section class="hero-featured" style="padding-top:60px">
            <div class="section-header" style="margin-bottom:40px">
                <div class="section-label">Ventajas</div>
                <h2 class="section-title">Todo lo que necesitas para triunfar</h2>
                <p class="section-desc">Lleva tu emprendimiento al siguiente nivel con nuestras herramientas</p>
            </div>
            <div class="feat-list">
                <div class="feat-card-h">
                    <div class="feat-card-h-body">
                        <span class="feat-card-tag" style="background:#A8E6CF;color:#2D7A5E">Plantilla</span>
                        <h3>Elige tu plantilla</h3>
                        <p>Selecciona entre m&uacute;ltiples dise&ntilde;os profesionales y personaliza colores para reflejar tu marca.</p>
                    </div>
                    <div class="feat-card-h-img">
                        <img src="<?= BASE_URL ?>/assets/images/features/producto_destacado_01.jpg" alt="Plantillas">
                    </div>
                </div>
                <div class="feat-card-h">
                    <div class="feat-card-h-body">
                        <span class="feat-card-tag" style="background:#B3D9F7;color:#2C6B9E">Vende</span>
                        <h3>Publica productos</h3>
                        <p>Llega a clientes de todo Bolivia sin complicaciones.</p>
                    </div>
                    <div class="feat-card-h-img">
                        <img src="<?= BASE_URL ?>/assets/images/features/producto_destacado_02.jpg" alt="Vende">
                    </div>
                </div>
                <div class="feat-card-h">
                    <div class="feat-card-h-body">
                        <span class="feat-card-tag" style="background:#FCE4BD;color:#8D6B2B">Pedidos</span>
                        <h3>Gestiona pedidos</h3>
                        <p>Administra ventas y asigna repartidores para cada entrega.</p>
                    </div>
                    <div class="feat-card-h-img">
                        <img src="<?= BASE_URL ?>/assets/images/features/producto_destacado_03.jpg" alt="Gestiona">
                    </div>
                </div>
                <div class="feat-card-h">
                    <div class="feat-card-h-body">
                        <span class="feat-card-tag" style="background:#D4C5F9;color:#5E3A87">Crece</span>
                        <h3>Expande tu negocio</h3>
                        <p>Analiza ventas y haz crecer tu presencia digital.</p>
                    </div>
                    <div class="feat-card-h-img">
                        <img src="<?= BASE_URL ?>/assets/images/features/producto_destacado_04.jpg" alt="Crece">
                    </div>
                </div>
            </div>
        </section>

        <section class="hero-featured hero-bg">
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
            <?php endif; ?>
        </section>
        <?php if (count($escaparates) === 0): ?>
        <section class="hero-featured" style="padding-top:0">
            <div class="feat-empty"><p>Próximamente nuevos negocios destacados</p></div>
        </section>
        <?php endif; ?>

    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-col footer-brand-col">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="footer-logo">
                <p class="footer-desc">Plataforma que conecta el talento boliviano con clientes de todo el pa&iacute;s.</p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col footer-contact-col">
                <h4>Contacto</h4>
                <p><i class="fas fa-envelope"></i> contacto@jachamarketplace.com</p>
                <p><i class="fas fa-map-marker-alt"></i> La Paz &middot; Bolivia</p>
                <p><i class="fas fa-phone"></i> +591 7XXX-XXXX</p>
            </div>
            <div class="footer-col footer-proyecto-col">
                <h4>Proyecto Universitario</h4>
                <p><i class="fas fa-graduation-cap"></i> <strong>Unifranz</strong></p>
                <p class="footer-copy">&copy; 2026 Jacha Marketplace</p>
                <p class="footer-legal">Potenciando emprendimientos bolivianos</p>
            </div>
        </div>
    </footer>
    <style>
        .footer-logo { filter:brightness(0) invert(1);height:32px;width:auto;display:block;margin-bottom:16px; }
        [data-theme="light"] .footer-logo { filter:brightness(0); }
        [data-theme="dark"] .footer-logo { filter:brightness(0) invert(1); }
        .footer-inner { max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.2fr 1fr 1fr;gap:40px;text-align:left;padding:0 48px; }
        .footer-col h4 { font-family:'Cormorant Garamond',Georgia,serif;font-size:18px;font-weight:600;color:var(--text);margin:0 0 16px; }
        .footer-desc { font-size:13px;color:var(--text-muted);line-height:1.6;margin:0 0 20px;max-width:300px; }
        .footer-contact-col p,.footer-proyecto-col p { font-size:13px;color:var(--text-muted);margin:0 0 10px;display:flex;align-items:center;gap:8px; }
        .footer-contact-col p i,.footer-proyecto-col p i { width:16px;color:var(--text-dim);font-size:14px; }
        .footer-contact-col p i.fa-map-marker-alt,.footer-contact-col p i.fa-phone { color:var(--text-dim); }
        .footer-proyecto-col strong { color:var(--text);font-weight:600; }
        .footer-social { display:flex;gap:12px; }
        .social-link { display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:var(--surface2);color:var(--text);font-size:17px;transition:all .3s;text-decoration:none; }
        .social-link:hover { transform:translateY(-3px); }
        .social-link .fa-instagram { color:#E4405F; }
        .social-link .fa-facebook-f { color:#1877F2; }
        .social-link .fa-whatsapp { color:#25D366; }
        .footer-legal { font-size:11px;color:var(--text-dim);margin-top:4px; }
        .footer-copy { font-size:12px;color:var(--text-dim);margin:0; }
        @media(max-width:900px){ .footer-inner{grid-template-columns:1fr 1fr;gap:32px;} .footer-brand-col{grid-column:1/-1;} }
        @media(max-width:480px){ .footer-inner{grid-template-columns:1fr;gap:28px;padding:0 20px;} }
    </style>

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
        document.addEventListener('DOMContentLoaded', function() {
            var heroEl = document.getElementById('heroGreeting');
            if (heroEl) {
                var words = [
                    'Potencia', 'tu', 'emprendimiento', 'en', 'el', 'mundo', 'digital'
                ];
                var wordIdx = 0, charIdx = 0, firstDone = false;
                heroEl.innerHTML = '';
                var currentSpan = null;
                function typeWord() {
                    if (wordIdx >= words.length) {
                        var cursor = document.createElement('span');
                        cursor.className = 'cursor';
                        heroEl.appendChild(cursor);
                        return;
                    }
                    var word = words[wordIdx];
                    if (charIdx >= word.length) {
                        wordIdx++;
                        charIdx = 0;
                        currentSpan = null;
                        firstDone = true;
                        if (word === 'emprendimiento') {
                            heroEl.appendChild(document.createElement('br'));
                        }
                        setTimeout(typeWord, 40 + Math.random() * 30);
                        return;
                    }
                    if (!currentSpan) {
                        if (firstDone) heroEl.appendChild(document.createTextNode(' '));
                        currentSpan = document.createElement('span');
                        currentSpan.style.cssText = 'display:inline-block;white-space:nowrap';
                        heroEl.appendChild(currentSpan);
                    }
                    var ch = document.createElement('span');
                    ch.className = 'glow-char';
                    ch.textContent = word[charIdx];
                    currentSpan.appendChild(ch);
                    charIdx++;
                    setTimeout(typeWord, 25 + Math.random() * 30);
                }
                setTimeout(typeWord, 500);
            }

            var slides = document.querySelectorAll('.carousel-slide');
            var indicators = document.querySelectorAll('.indicator');
            var currentIndex = 0, interval;
            function showSlide(index) { slides.forEach(function(s,i){s.classList.toggle('active',i===index)}); indicators.forEach(function(ind,i){ind.classList.toggle('active',i===index)}); currentIndex=index; }
            function nextSlide() { showSlide((currentIndex+1)%slides.length); }
            function startCarousel() { if(interval) clearInterval(interval); interval = setInterval(nextSlide,5000); }
            if (indicators.length) indicators.forEach(function(i){i.addEventListener('click',function(){ showSlide(parseInt(i.getAttribute('data-index'))); startCarousel(); })});
            if(slides.length>0) startCarousel();

            var menuToggle = document.getElementById('menuToggle');
            var navMenu = document.getElementById('navMenu');
            if(menuToggle) menuToggle.addEventListener('click',function(){navMenu.classList.toggle('active')});
            document.querySelectorAll('.nav-menu a').forEach(function(l){l.addEventListener('click',function(){if(window.innerWidth<=768)navMenu.classList.remove('active')})});
        });
    </script>
</body>
</html>
