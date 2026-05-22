<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Explorar negocios - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        .explore-header {
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .explore-header .logo-img { height: 46px; width: auto; }
        .explore-header nav { display: flex; gap: 24px; align-items: center; }
        .explore-header nav a { font-size: 14px; color: var(--text-muted); transition: color 0.2s; text-decoration: none; }
        .explore-header nav a:hover { color: var(--text); }
        .explore-hero {
            padding: 80px 48px 60px;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        .explore-hero h1 {
            font-family: var(--font-serif);
            font-size: 52px;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 16px;
            line-height: 1.15;
        }
        .explore-hero p {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .explore-count {
            display: inline-block;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-dim);
            background: var(--glow);
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 24px;
        }
        .explore-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px 80px;
        }
        .explore-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s var(--ease);
            cursor: pointer;
            animation: fadeInUp 0.5s var(--ease) both;
        }
        .explore-card:nth-child(1) { animation-delay: 0.03s; }
        .explore-card:nth-child(2) { animation-delay: 0.06s; }
        .explore-card:nth-child(3) { animation-delay: 0.09s; }
        .explore-card:nth-child(4) { animation-delay: 0.12s; }
        .explore-card:nth-child(5) { animation-delay: 0.15s; }
        .explore-card:nth-child(6) { animation-delay: 0.18s; }
        .explore-card:nth-child(7) { animation-delay: 0.21s; }
        .explore-card:nth-child(8) { animation-delay: 0.24s; }
        .explore-card:nth-child(9) { animation-delay: 0.27s; }
        .explore-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hi);
            box-shadow: var(--shadow-lg);
        }
        .explore-card-preview {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        .explore-card-preview::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.04), transparent);
            pointer-events: none;
        }
        .explore-card-colors { display: flex; gap: 14px; }
        .explore-card-color { width: 48px; height: 48px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.2); }
        .explore-card-body { padding: 24px; }
        .explore-card-body h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text); }
        .explore-card-body p { font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .explore-card-tag {
            display: inline-block;
            font-size: 11px;
            color: var(--text-dim);
            background: var(--badge-bg);
            padding: 4px 12px;
            border-radius: 20px;
            margin-right: 6px;
        }
        .explore-empty {
            text-align: center;
            grid-column: 1/-1;
            padding: 80px;
            color: var(--text-dim);
        }
        .explore-empty p { font-size: 16px; }
        .explore-footer {
            text-align: center;
            padding: 48px;
            border-top: 1px solid var(--border);
            color: var(--text-dim);
            font-size: 12px;
        }
        @media (max-width: 1024px) {
            .explore-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .explore-header { padding: 0 20px; }
            .explore-hero { padding: 48px 20px 40px; }
            .explore-hero h1 { font-size: 36px; }
            .explore-grid { grid-template-columns: 1fr; padding: 0 20px 48px; }
        }
    </style>
</head>
<body>
    <header class="explore-header">
        <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img"></a>
        <nav>
            <a href="<?= BASE_URL ?>/">Inicio</a>
            <a href="<?= BASE_URL ?>/plantillas-disponibles">Plantillas</a>
            <?php if ($is_logged_in): ?>
                <a href="<?= BASE_URL ?>/dashboard">Mi panel</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login" class="btn-nav-outline">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>/registro" class="btn-nav-primary">Registrarse</a>
            <?php endif; ?>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="margin-left:12px;flex-shrink:0">&#9790;</button>
        </nav>
    </header>

    <section class="explore-hero">
        <div class="explore-count"><?= count($negocios) ?> negocios disponibles</div>
        <h1>Descubre todos los <em>negocios</em> bolivianos</h1>
        <p>Explora la variedad de emprendimientos creados por talento nacional. Cada negocio tiene su propio estilo y personalidad.</p>
    </section>

    <div class="explore-grid">
        <?php if (count($negocios) > 0): ?>
            <?php foreach ($negocios as $negocio): ?>
            <div class="explore-card" data-id="<?= $negocio['id_emprendimiento'] ?>" data-nombre="<?= htmlspecialchars($negocio['nombre_comercial']) ?>">
                <div class="explore-card-preview" style="background: linear-gradient(135deg, <?= $negocio['color_primario'] ?? '#1a1a1a' ?>22, <?= $negocio['color_secundario'] ?? '#555555' ?>11);">
                    <div class="explore-card-colors">
                        <div class="explore-card-color" style="background: <?= $negocio['color_primario'] ?? '#1a1a1a' ?>;"></div>
                        <div class="explore-card-color" style="background: <?= $negocio['color_secundario'] ?? '#555555' ?>;"></div>
                    </div>
                </div>
                <div class="explore-card-body">
                    <h3><?= htmlspecialchars($negocio['nombre_comercial']) ?></h3>
                    <p><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 120)) ?></p>
                    <span class="explore-card-tag"><?= $negocio['total_productos'] ?> productos</span>
                    <span class="explore-card-tag"><?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="explore-empty">
                <p>Aún no hay negocios disponibles. ¡Sé el primero en crear tu tienda!</p>
                <a href="<?= BASE_URL ?>/registro" class="btn-hero-primary" style="display: inline-flex; margin-top: 24px;">Comenzar ahora →</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="explore-footer">
        <p>© 2026 Jacha Marketplace — Potenciando emprendimientos bolivianos</p>
    </footer>

    <div class="modal" id="authModal">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarAuthModal()">&times;</button>
            <h3>Descubre este negocio</h3>
            <p>Para visualizar los escaparates necesitas iniciar sesión o crear una cuenta gratuita.</p>
            <div class="modal-actions">
                <a href="<?= BASE_URL ?>/login" class="btn btn-primary">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>/registro" class="btn btn-secondary">Crear cuenta</a>
            </div>
        </div>
    </div>

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
        const authModal = document.getElementById('authModal');
        const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
        function handleCardClick(e) {
            let card = e.target.closest('.explore-card');
            if (!card) return;
            const id = card.getAttribute('data-id');
            if (!id) return;
            if (!isLoggedIn) {
                authModal.style.display = 'flex';
                return;
            }
            window.location.href = '<?= BASE_URL ?>/tienda/' + id;
        }
        document.querySelectorAll('.explore-card').forEach(c => c.addEventListener('click', handleCardClick));
        function cerrarAuthModal() { authModal.style.display = 'none'; }
        window.onclick = function(e) { if (e.target === authModal) cerrarAuthModal(); }
    </script>
</body>
</html>