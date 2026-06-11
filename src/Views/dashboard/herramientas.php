<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Herramientas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .tools-wrap { max-width:1400px; margin:0 auto; padding:32px 24px; }
        .tools-header { margin-bottom:32px; }
        .tools-header h1 { font-family:Georgia,var(--font-serif); font-size:28px; font-weight:400; color:var(--text); display:flex; align-items:center; gap:12px; }
        .tools-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; }
        .tools-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .tools-header .back:hover { color:var(--text); }

        .margen-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px; }
        .margen-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; }
        .margen-card .num { font-size:30px; font-weight:700; color:var(--text); }
        .margen-card .lab { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; }

        .negocio-section { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; margin-bottom:24px; overflow:hidden; }
        .negocio-section h2 { font-family:Georgia,var(--font-serif); font-size:18px; font-weight:500; color:var(--text); padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .negocio-section h2 .dot { width:10px; height:10px; border-radius:50%; display:inline-block; flex-shrink:0; }
        .table-wrap { overflow-x:auto; }
        table.dt { width:100%; border-collapse:collapse; }
        .dt th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); white-space:nowrap; }
        .dt td { padding:14px 20px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .dt tbody tr:last-child td { border-bottom:none; }
        .dt tbody tr:hover { background:rgba(255,255,255,0.015); }

        .badge-margen { display:inline-block; padding:3px 10px; border-radius:3px; font-size:11px; font-weight:600; }
        .badge-margen.alto { background:rgba(107,143,113,0.12); color:#6b8f71; }
        .badge-margen.medio { background:rgba(154,138,74,0.12); color:#9a8a4a; }
        .badge-margen.bajo { background:rgba(154,90,90,0.12); color:#9a5a5a; }
        .badge-margen.sin { background:rgba(128,128,128,0.08); color:var(--text-dim); }

        .empty-state { text-align:center; padding:60px 20px; color:var(--text-dim); }
        .empty-state i { font-size:36px; margin-bottom:12px; opacity:0.3; color:var(--text-muted); }

        @media(max-width:768px){
            .tools-wrap { padding:20px 16px; }
            .margen-grid { grid-template-columns:repeat(2,1fr); }
            .dt td,.dt th { padding:10px 12px; white-space:nowrap; }
        }
    </style>
</head>
<body class="dashboard-body">

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= BASE_URL ?>/" class="logo-link" style="display:flex;align-items:center;gap:10px;">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" style="height:30px;width:auto;opacity:0.85;">
        </a>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>/productos"><i class="fas fa-cube"></i> Productos</a>
        <a href="<?= BASE_URL ?>/categorias"><i class="fas fa-folder"></i> Categorías</a>
        <a href="<?= BASE_URL ?>/gestionar-negocios"><i class="fas fa-store-alt"></i> Gestionar negocios</a>
        <a href="<?= BASE_URL ?>/repartidores-admin"><i class="fas fa-truck"></i> Repartidores</a>
        <a href="<?= BASE_URL ?>/plantillas-disponibles"><i class="fas fa-plus-circle"></i> Nuevo negocio</a>
        <a href="<?= BASE_URL ?>/herramientas" class="active" style="margin-top:24px;border-top:1px solid var(--border);padding-top:16px;"><i class="fas fa-tools"></i> Herramientas</a>
        <a href="<?= BASE_URL ?>/sucursales"><i class="fas fa-code-branch"></i> Sucursales</a>
        <a href="<?= BASE_URL ?>/inventario"><i class="fas fa-boxes"></i> Inventario</a>
        <a href="<?= BASE_URL ?>/kardex"><i class="fas fa-history"></i> Kardex</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:8px;"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
    </nav>
</div>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
        </div>
        <div style="display:flex;align-items:center;gap:0">
            <a href="#" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;color:var(--text-muted);text-decoration:none;transition:color .2s;margin-right:4px" title="Notificaciones" onclick="alert('Próximamente: centro de notificaciones');return false">
                <i class="fas fa-bell" style="font-size:15px"></i>
                <span style="position:absolute;top:4px;right:4px;width:7px;height:7px;border-radius:50%;background:#9a5a5a;display:none"></span>
            </a>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema">&#9790;</button>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-trigger" id="userTrigger">
                    <span class="user-name"><?= htmlspecialchars($usuario['nombre']) ?></span>
                    <div class="user-avatar">
                        <?php if ($avatar_usuario): ?>
                            <img src="<?= BASE_URL ?>/<?= $avatar_usuario ?>" alt="Avatar">
                        <?php else: ?>
                            <?= $inicial ?>
                        <?php endif; ?>
                    </div>
                    <span style="font-size:8px;color:var(--text-dim);line-height:1;">&#9660;</span>
                </div>
                <div class="dropdown-menu">
                    <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                    <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout">Cerrar sesion</a>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-container">

    <div class="tools-header">
        <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
        <h1><i class="fas fa-wrench" style="color:var(--text-muted)"></i> Herramientas</h1>
        <div class="sub">Gestiona el rendimiento de tus productos</div>
    </div>

    <?php $totalProd = 0; $conMargen = 0; $sumMargen = 0; $mejorMargen = 0; $mejorProd = ''; ?>
    <?php foreach ($productos_por_negocio as $grupo): ?>
        <?php foreach ($grupo['productos'] as $p): $totalProd++; ?>
            <?php if ($p['margen'] !== null): $conMargen++; $sumMargen += $p['margen']; ?>
                <?php if ($p['margen'] > $mejorMargen): $mejorMargen = $p['margen']; $mejorProd = $p['nombre']; endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <?php $promedioMargen = $conMargen > 0 ? $sumMargen / $conMargen : 0; ?>

    <div class="margen-grid">
        <div class="margen-card">
            <div class="num"><?= $totalProd ?></div>
            <div class="lab">Productos totales</div>
        </div>
        <div class="margen-card">
            <div class="num"><?= $conMargen ?></div>
            <div class="lab">Con costo registrado</div>
        </div>
        <div class="margen-card">
            <div class="num" style="color:<?= $promedioMargen >= 30 ? '#6b8f71' : ($promedioMargen >= 10 ? '#9a8a4a' : '#9a5a5a') ?>"><?= number_format($promedioMargen, 1) ?>%</div>
            <div class="lab">Margen promedio</div>
        </div>
        <div class="margen-card">
            <div class="num" style="color:<?= $margen_global['total_ganancia'] > 0 ? '#6b8f71' : 'var(--text-dim)' ?>">Bs. <?= number_format($margen_global['total_ganancia'], 2) ?></div>
            <div class="lab">Ganancia total estimada</div>
        </div>
    </div>

    <?php if ($conMargen > 0 && $mejorProd): ?>
    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:20px 24px;margin-bottom:28px;display:flex;align-items:center;gap:16px;">
        <i class="fas fa-trophy" style="font-size:24px;color:#9a8a4a;"></i>
        <div>
            <span style="font-size:13px;color:var(--text-dim);">Mejor margen</span>
            <div style="font-size:16px;font-weight:600;color:var(--text);"><?= htmlspecialchars($mejorProd) ?> <span style="color:#6b8f71;font-size:14px;">(<?= number_format($mejorMargen, 1) ?>%)</span></div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (count($productos_por_negocio) > 0): ?>
        <?php foreach ($productos_por_negocio as $grupo): ?>
        <div class="negocio-section">
            <h2>
                <span class="dot" style="background:<?= $grupo['negocio']['color_primario'] ?? '#888' ?>"></span>
                <?= htmlspecialchars($grupo['negocio']['nombre_comercial']) ?>
                <span style="font-size:12px;font-weight:400;color:var(--text-dim);margin-left:auto;"><?= count($grupo['productos']) ?> productos</span>
            </h2>
            <?php if (count($grupo['productos']) > 0): ?>
            <div class="table-wrap">
                <table class="dt">
                    <thead>
                        <tr><th>Producto</th><th>Precio venta</th><th>Precio costo</th><th>Ganancia</th><th>Margen</th><th>Stock</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grupo['productos'] as $p): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                            <td>Bs. <?= number_format($p['precio_base'], 2) ?></td>
                            <td><?= $p['precio_costo'] ? 'Bs. ' . number_format($p['precio_costo'], 2) : '<span style="color:var(--text-dim)">—</span>' ?></td>
                            <td><?= $p['ganancia'] !== null ? 'Bs. ' . number_format($p['ganancia'], 2) : '<span style="color:var(--text-dim)">—</span>' ?></td>
                            <td>
                                <?php if ($p['margen'] !== null): ?>
                                    <span class="badge-margen <?= $p['margen'] >= 30 ? 'alto' : ($p['margen'] >= 10 ? 'medio' : 'bajo') ?>">
                                        <?= number_format($p['margen'], 1) ?>%
                                    </span>
                                <?php else: ?>
                                    <span class="badge-margen sin">Sin costo</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $p['stock'] ?? 0 ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box"></i>
                <p>No hay productos en este negocio</p>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:60px 20px;text-align:center;">
            <i class="fas fa-store" style="font-size:40px;margin-bottom:12px;opacity:0.25;color:var(--text-muted)"></i>
            <p style="font-size:15px;color:var(--text-dim);margin-bottom:6px">No tienes negocios creados</p>
            <p style="font-size:12px;color:var(--text-muted);margin-bottom:20px">Crea un negocio y agrega productos para ver sus margenes</p>
            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-square"><i class="fas fa-plus"></i> Crear negocio</a>
        </div>
    <?php endif; ?>

    </div>
</div>

<span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

<script>
(function() {
    var menuBtn = document.getElementById('menuBtn');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
    if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); overlay.addEventListener('click', toggleSidebar); }

    var userDropdown = document.getElementById('userDropdown');
    var userTrigger = document.getElementById('userTrigger');
    if (userTrigger) {
        userTrigger.addEventListener('click', function(e) { e.stopPropagation(); userDropdown.classList.toggle('active'); });
        document.addEventListener('click', function() { userDropdown.classList.remove('active'); });
    }

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