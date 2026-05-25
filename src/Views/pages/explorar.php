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
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',system-ui,sans-serif; background:var(--bg,#121212); color:var(--text,#e8e8e8); min-height:100vh; }
        .explore-header {
            position:sticky; top:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between;
            padding:0 48px; height:72px;
            background:var(--nav-bg,rgba(18,18,18,0.85)); backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
        }
        .explore-header .logo-img { height:28px; width:auto; opacity:0.7; }
        .explore-header nav { display:flex; align-items:center; gap:20px; }
        .explore-header nav a { font-size:13px; color:var(--text-muted); text-decoration:none; transition:color .2s; }
        .explore-header nav a:hover { color:var(--text); }
        .theme-toggle { background:none; border:none; color:var(--text-muted); font-size:20px; cursor:pointer; transition:color .2s; padding:0; line-height:1; }
        .theme-toggle:hover { color:var(--text); }

        .explore-hero { padding:60px 48px 32px; text-align:center; max-width:900px; margin:0 auto; }
        .explore-hero h1 { font-family:'Cormorant Garamond',Georgia,serif; font-size:52px; font-weight:500; color:var(--text); margin-bottom:12px; line-height:1.15; }
        .explore-hero h1 em { font-style:italic; color:rgba(255,255,255,0.75); }
        [data-theme="light"] .explore-hero h1 em { color:rgba(0,0,0,0.65); }
        .explore-hero p { font-size:15px; color:var(--text-muted); line-height:1.7; max-width:600px; margin:0 auto 32px; }
        .explore-count { font-size:11px; letter-spacing:2px; text-transform:uppercase; color:var(--text-dim); margin-bottom:16px; }

        .explore-filters {
            max-width:900px; margin:0 auto 40px; padding:0 48px;
            display:flex; flex-direction:column; gap:16px;
        }
        .filter-row { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
        .search-wrap {
            flex:1; position:relative; min-width:220px;
        }
        .search-wrap input {
            width:100%; padding:13px 16px 13px 44px;
            background:var(--surface); border:1px solid var(--border);
            border-radius:8px; color:var(--text); font-size:14px;
            font-family:'DM Sans',system-ui,sans-serif; outline:none;
            transition:border-color .3s;
        }
        .search-wrap input:focus { border-color:var(--border-hi); }
        .search-wrap input::placeholder { color:var(--text-dim); }
        .search-icon {
            position:absolute; left:16px; top:50%; transform:translateY(-50%);
            font-size:15px; color:var(--text-dim); pointer-events:none;
        }
        .filter-select {
            padding:13px 36px 13px 16px; min-width:160px;
            background:var(--surface); border:1px solid var(--border);
            border-radius:8px; color:var(--text); font-size:13px;
            font-family:'DM Sans',system-ui,sans-serif; outline:none;
            cursor:pointer; transition:border-color .3s;
            appearance:none; -webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23666' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center;
        }
        .filter-select:focus { border-color:var(--border-hi); }
        .filter-select option { background:var(--surface); color:var(--text); }

        .filter-pill {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 16px; border:1px solid var(--border); border-radius:20px;
            background:transparent; color:var(--text-muted); font-size:12px;
            cursor:pointer; transition:all .25s; font-family:'DM Sans',system-ui,sans-serif;
        }
        .filter-pill:hover { border-color:var(--text-muted); color:var(--text); }
        .filter-pill.active { background:var(--text); color:var(--bg); border-color:var(--text); }
        .filter-pill .count { font-size:10px; opacity:0.6; }

        .results-info { padding:0 48px; max-width:1300px; margin:0 auto 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; }
        .results-info span { font-size:12px; color:var(--text-dim); }
        .results-info .clear-btn { font-size:11px; color:var(--text-muted); background:none; border:none; cursor:pointer; text-decoration:underline; font-family:'DM Sans',system-ui,sans-serif; display:none; }
        .results-info .clear-btn.show { display:inline; }

        .explore-grid {
            display:grid; grid-template-columns:repeat(3,1fr); gap:24px;
            max-width:1300px; margin:0 auto; padding:0 48px 80px;
        }
        .explore-card {
            background:var(--card-bg,#141414); border:1px solid var(--border);
            border-radius:8px; overflow:hidden; cursor:pointer;
            transition:all .4s cubic-bezier(.4,0,.2,1); position:relative;
            animation:cardUp .5s ease both;
        }
        .explore-card:nth-child(1) { animation-delay:0.03s; }
        .explore-card:nth-child(2) { animation-delay:0.06s; }
        .explore-card:nth-child(3) { animation-delay:0.09s; }
        .explore-card:nth-child(4) { animation-delay:0.12s; }
        .explore-card:nth-child(5) { animation-delay:0.15s; }
        .explore-card:nth-child(6) { animation-delay:0.18s; }
        .explore-card:nth-child(7) { animation-delay:0.21s; }
        .explore-card:nth-child(8) { animation-delay:0.24s; }
        .explore-card:nth-child(9) { animation-delay:0.27s; }
        .explore-card:nth-child(10){ animation-delay:0.30s; }
        .explore-card:nth-child(11){ animation-delay:0.33s; }
        .explore-card:nth-child(12){ animation-delay:0.36s; }
        .explore-card:hover { transform:translateY(-6px); border-color:var(--border-hi); box-shadow:0 20px 60px rgba(0,0,0,0.3); }
        [data-theme="light"] .explore-card:hover { box-shadow:0 20px 60px rgba(0,0,0,0.06); }
        .explore-card.hidden { display:none; }

        .explore-card-preview {
            height:140px; display:flex; align-items:center; justify-content:center;
            position:relative; overflow:hidden;
        }
        .explore-card-colors { display:flex; gap:12px; position:relative; z-index:1; }
        .explore-card-color { width:44px; height:44px; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.25); }
        .explore-card-body { padding:20px 24px 24px; }
        .explore-card-body h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:20px; font-weight:500; color:var(--text); margin-bottom:6px; }
        .explore-card-body .desc { font-size:13px; color:var(--text-muted); line-height:1.6; margin-bottom:16px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .explore-card-tags { display:flex; gap:6px; flex-wrap:wrap; }
        .explore-card-tag {
            font-size:10px; letter-spacing:0.5px; text-transform:uppercase;
            color:var(--text-dim); background:var(--surface2); padding:3px 10px;
            border-radius:4px; border:1px solid var(--border);
        }

        .explore-empty {
            text-align:center; grid-column:1/-1; padding:100px 40px; color:var(--text-dim);
        }
        .explore-empty h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:26px; font-weight:500; color:var(--text); margin-bottom:8px; }
        .explore-empty p { font-size:14px; margin-bottom:24px; }

        .explore-footer { text-align:center; padding:40px 48px; border-top:1px solid var(--border); color:var(--text-dim); font-size:12px; }

        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(8px); z-index:1000; display:none; align-items:center; justify-content:center; }
        .modal-overlay.active { display:flex; }
        .modal-box { background:var(--card-bg); border:1px solid var(--border); border-radius:8px; padding:40px; max-width:400px; width:90%; text-align:center; position:relative; box-shadow:0 32px 80px rgba(0,0,0,0.4); }
        .modal-box h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:22px; font-weight:500; color:var(--text); margin-bottom:8px; }
        .modal-box p { font-size:13px; color:var(--text-muted); margin-bottom:24px; line-height:1.6; }
        .modal-actions { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
        .modal-btn { padding:11px 28px; border-radius:6px; font-size:13px; font-weight:500; text-decoration:none; transition:all .2s; }
        .modal-btn-primary { background:var(--text); color:var(--bg); }
        .modal-btn-primary:hover { opacity:0.85; transform:translateY(-1px); }
        .modal-btn-secondary { border:1px solid var(--border); color:var(--text); background:transparent; }
        .modal-btn-secondary:hover { border-color:var(--border-hi); }
        .modal-btn-close { position:absolute; top:16px; right:16px; background:none; border:none; color:var(--text-dim); font-size:22px; cursor:pointer; transition:color .2s; }
        .modal-btn-close:hover { color:var(--text); }

        .watermark { position:fixed; bottom:12px; right:16px; opacity:0.25; pointer-events:none; z-index:9999; }
        .watermark img { height:16px; width:auto; }

        @keyframes cardUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @media(max-width:1200px){ .explore-grid { grid-template-columns:repeat(2,1fr); padding:0 32px 60px; } .explore-header { padding:0 32px; } .explore-hero { padding:48px 32px 24px; } .explore-filters { padding:0 32px; } .results-info { padding:0 32px; } }
        @media(max-width:768px){
            .explore-header { padding:0 20px; }
            .explore-header nav { gap:12px; }
            .explore-hero { padding:40px 20px 24px; }
            .explore-hero h1 { font-size:36px; }
            .explore-filters { padding:0 20px; }
            .filter-row { flex-direction:column; }
            .search-wrap { min-width:100%; }
            .filter-select { min-width:100%; }
            .results-info { padding:0 20px; flex-direction:column; text-align:center; }
            .explore-grid { grid-template-columns:1fr; padding:0 20px 48px; gap:20px; }
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
                <a href="<?= BASE_URL ?>/login">Iniciar sesi&oacute;n</a>
                <a href="<?= BASE_URL ?>/registro" class="btn-nav-primary">Registrarse</a>
            <?php endif; ?>
            <button class="theme-toggle" id="themeToggle">&#9790;</button>
        </nav>
    </header>

    <section class="explore-hero">
        <div class="explore-count"><?= count($negocios) ?> negocios disponibles</div>
        <h1>Explora todos los <em>negocios</em> bolivianos</h1>
        <p>Descubre emprendimientos &uacute;nicos creados por talento nacional. Cada negocio tiene su propio estilo y personalidad.</p>
    </section>

    <div class="explore-filters">
        <div class="filter-row">
            <div class="search-wrap">
                <span class="search-icon">&#128269;</span>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o descripci&oacute;n..." autocomplete="off">
            </div>
            <select class="filter-select" id="plantillaFilter">
                <option value="">Todas las plantillas</option>
                <?php foreach ($plantillas as $p): ?>
                <option value="<?= htmlspecialchars($p['nombre']) ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-row" id="pillFilters">
            <button class="filter-pill active" data-filter="all">Todos</button>
            <?php
            $tags = [];
            foreach ($negocios as $n) {
                $t = $n['plantilla_nombre'] ?? 'Moderno';
                $tags[$t] = ($tags[$t] ?? 0) + 1;
            }
            ksort($tags);
            foreach ($tags as $tag => $count): ?>
            <button class="filter-pill" data-filter="<?= htmlspecialchars($tag) ?>"><?= htmlspecialchars($tag) ?> <span class="count"><?= $count ?></span></button>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="results-info">
        <span id="resultsCount"><?= count($negocios) ?> resultado<?= count($negocios) !== 1 ? 's' : '' ?></span>
        <button class="clear-btn" id="clearFilters">Limpiar filtros</button>
    </div>

    <div class="explore-grid" id="exploreGrid">
        <?php if (count($negocios) > 0): ?>
            <?php foreach ($negocios as $negocio):
                $plantilla = $negocio['plantilla_nombre'] ?? 'Moderno';
            ?>
            <div class="explore-card" data-id="<?= $negocio['id_emprendimiento'] ?>" data-plantilla="<?= htmlspecialchars($plantilla) ?>" data-nombre="<?= htmlspecialchars($negocio['nombre_comercial']) ?>">
                <div class="explore-card-preview" style="background:linear-gradient(135deg,<?= $negocio['color_primario'] ?? '#1a1a1a' ?>22,<?= $negocio['color_secundario'] ?? '#555' ?>11)">
                    <div class="explore-card-colors">
                        <div class="explore-card-color" style="background:<?= $negocio['color_primario'] ?? '#1a1a1a' ?>"></div>
                        <div class="explore-card-color" style="background:<?= $negocio['color_secundario'] ?? '#555' ?>"></div>
                    </div>
                </div>
                <div class="explore-card-body">
                    <h3><?= htmlspecialchars($negocio['nombre_comercial']) ?></h3>
                    <p class="desc"><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 120)) ?></p>
                    <div class="explore-card-tags">
                        <span class="explore-card-tag"><?= $negocio['total_productos'] ?> productos</span>
                        <span class="explore-card-tag"><?= htmlspecialchars($plantilla) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="explore-empty">
                <h3>A&uacute;n no hay negocios disponibles</h3>
                <p>S&eacute; el primero en crear tu tienda online y muestra tus productos al mundo.</p>
                <a href="<?= BASE_URL ?>/registro" class="btn-hero-primary" style="display:inline-flex;">Comenzar ahora &rarr;</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="explore-footer">
        <p>&copy; 2026 Jacha Marketplace &mdash; Potenciando emprendimientos bolivianos</p>
    </footer>

    <div class="modal-overlay" id="authModal">
        <div class="modal-box">
            <button class="modal-btn-close" onclick="cerrarModal()">&times;</button>
            <h3>Descubre este negocio</h3>
            <p>Para visitar el escaparate de este negocio, inicia sesi&oacute;n o crea una cuenta gratuita.</p>
            <div class="modal-actions">
                <a href="<?= BASE_URL ?>/login" class="modal-btn modal-btn-primary">Iniciar sesi&oacute;n</a>
                <a href="<?= BASE_URL ?>/registro" class="modal-btn modal-btn-secondary">Registrarse</a>
            </div>
        </div>
    </div>

    <div class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>

    <script>
    (function() {
        var theme = localStorage.getItem('jacha_theme') || 'dark';
        document.documentElement.setAttribute('data-theme', theme);
        var toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.innerHTML = theme === 'dark' ? '\u2600' : '\u263E';
            toggle.addEventListener('click', function() {
                var t = document.documentElement.getAttribute('data-theme');
                var n = t === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', n);
                localStorage.setItem('jacha_theme', n);
                toggle.innerHTML = n === 'dark' ? '\u2600' : '\u263E';
            });
        }
    })();
    </script>
    <script>
        var cards = document.querySelectorAll('.explore-card');
        var searchInput = document.getElementById('searchInput');
        var plantillaFilter = document.getElementById('plantillaFilter');
        var pills = document.querySelectorAll('.filter-pill');
        var resultsCount = document.getElementById('resultsCount');
        var clearBtn = document.getElementById('clearFilters');

        function filterCards() {
            var q = (searchInput.value || '').toLowerCase();
            var pf = plantillaFilter.value;
            var activePill = document.querySelector('.filter-pill.active');
            var pillFilter = activePill ? activePill.getAttribute('data-filter') : 'all';

            var visible = 0;
            cards.forEach(function(c) {
                var nombre = (c.getAttribute('data-nombre') || '').toLowerCase();
                var plantilla = (c.getAttribute('data-plantilla') || '');
                var txt = nombre + ' ' + (c.querySelector('.desc') ? c.querySelector('.desc').textContent.toLowerCase() : '');
                var match = (!q || txt.indexOf(q) !== -1) &&
                            (!pf || plantilla === pf) &&
                            (pillFilter === 'all' || plantilla === pillFilter);
                c.classList.toggle('hidden', !match);
                if (match) visible++;
            });

            resultsCount.textContent = visible + ' resultado' + (visible !== 1 ? 's' : '');
            clearBtn.classList.toggle('show', !!(q || pf || activePill && activePill.getAttribute('data-filter') !== 'all'));
        }

        searchInput.addEventListener('input', filterCards);
        plantillaFilter.addEventListener('change', filterCards);
        pills.forEach(function(p) {
            p.addEventListener('click', function() {
                pills.forEach(function(x) { x.classList.remove('active'); });
                p.classList.add('active');
                filterCards();
            });
        });
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            plantillaFilter.value = '';
            pills.forEach(function(x) { x.classList.remove('active'); });
            document.querySelector('.filter-pill[data-filter="all"]').classList.add('active');
            filterCards();
        });

        // Card click
        var isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
        cards.forEach(function(c) {
            c.addEventListener('click', function() {
                var id = c.getAttribute('data-id');
                if (!id) return;
                if (!isLoggedIn) {
                    document.getElementById('authModal').classList.add('active');
                    return;
                }
                window.location.href = '<?= BASE_URL ?>/tienda/' + id;
            });
        });
        function cerrarModal() {
            document.getElementById('authModal').classList.remove('active');
        }
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</body>
</html>