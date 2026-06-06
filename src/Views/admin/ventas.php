<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Ventas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .ventas-wrap { max-width:1400px; margin:0 auto; padding:32px 24px; }
        .ventas-header { margin-bottom:32px; }
        .ventas-header h1 { font-family:Georgia,var(--font-serif); font-size:28px; font-weight:400; color:var(--text); }
        .ventas-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; }
        .ventas-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .ventas-header .back:hover { color:var(--text); }

        .resumen-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px; }
        .res-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; }
        .res-card .num { font-size:30px; font-weight:700; color:var(--text); }
        .res-card .lab { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; }

        .filtros { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:20px 24px; margin-bottom:24px; display:flex; gap:16px; align-items:center; flex-wrap:wrap; }
        .filtros label { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
        .filtros select { background:var(--card-bg); border:1px solid var(--border); border-radius:3px; padding:8px 12px; color:var(--text); font-size:13px; cursor:pointer; outline:none; }
        .filtros select:focus { border-color:var(--border-hi); }
        .filtros select option { background:var(--card-bg); color:var(--text); }
        .btn-filtrar { background:var(--text); color:var(--bg); border:none; padding:8px 20px; border-radius:3px; font-size:12px; font-weight:600; cursor:pointer; }
        .btn-limpiar { background:transparent; color:var(--text-muted); border:1px solid var(--border); padding:8px 20px; border-radius:3px; font-size:12px; cursor:pointer; text-decoration:none; }
        .btn-limpiar:hover { color:var(--text); border-color:var(--border-hi); }

        .table-wrap { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); vertical-align:middle; }
        tbody tr { border-bottom:1px solid var(--border); }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,0.015); }
        td { padding:14px 20px; font-size:13px; color:var(--text); vertical-align:middle; }
        .badge-pl { display:inline-block; padding:3px 10px; border-radius:3px; font-size:10px; font-weight:600; margin:2px; }
        .badge-pl.pagado, .badge-pl.completado { background:rgba(107,143,113,0.1); color:#6b8f71; }
        .badge-pl.pendiente { background:rgba(154,138,74,0.1); color:#9a8a4a; }
        .badge-pl.fallido { background:rgba(154,90,90,0.1); color:#9a5a5a; }
        .badge-pl.En_Ruta, .badge-pl.enruta { background:rgba(107,127,143,0.1); color:#6b7f8f; }
        .badge-pl.Entregado, .badge-pl.entregado { background:rgba(107,143,113,0.1); color:#6b8f71; }
        .badge-pl.Preparando, .badge-pl.preparando { background:rgba(154,138,74,0.1); color:#9a8a4a; }
        .empty { text-align:center; padding:60px 20px; color:var(--text-dim); }
        .empty i { font-size:36px; margin-bottom:12px; opacity:0.3; color:var(--text-muted); }

        @media(max-width:768px){ .resumen-grid{grid-template-columns:1fr} .filtros{flex-direction:column;align-items:stretch} .table-wrap{overflow-x:auto} table{font-size:12px} thead th,td{padding:10px 12px;white-space:nowrap} }
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
        <a href="<?= BASE_URL ?>/dashboard"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9632;</span> Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/ventas" class="active"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Ventas</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesion</a>
    </nav>
</div>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
        </div>
        <div style="display:flex;align-items:center;gap:0">
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema">&#9790;</button>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-trigger" id="userTrigger">
                    <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?></span>
                    <div class="user-avatar">
                        <?php
                        $avatarUsuario = (new \App\Repositories\UsuarioRepository())->getAvatar($_SESSION['usuario']['id'] ?? 0);
                        $inicial = strtoupper(substr($_SESSION['usuario']['nombre'] ?? 'U', 0, 1));
                        ?>
                        <?php if ($avatarUsuario): ?>
                            <img src="<?= BASE_URL ?>/<?= $avatarUsuario ?>" alt="Avatar">
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

    <div class="ventas-header">
        <h1><i class="fas fa-chart-line" style="margin-right:12px;color:var(--text-muted)"></i>Ventas</h1>
    </div>

    <div class="resumen-grid">
        <div class="res-card">
            <div class="num"><?= $resumen['total_pedidos'] ?></div>
            <div class="lab">Total pedidos</div>
        </div>
        <div class="res-card">
            <div class="num">Bs. <?= number_format($resumen['total_ventas'], 2) ?></div>
            <div class="lab">Total ventas</div>
        </div>
        <div class="res-card">
            <div class="num" style="color:<?= count($pedidos) > 0 ? 'var(--text)' : 'var(--text-dim)' ?>"><?= count($pedidos) ?></div>
            <div class="lab">Pedidos mostrados</div>
        </div>
    </div>

    <form class="filtros" method="GET" action="<?= BASE_URL ?>/admin/ventas">
        <div>
            <label>Negocio</label>
            <select name="id_emprendimiento">
                <option value="">Todos los negocios</option>
                <?php foreach ($negocios as $n): ?>
                    <option value="<?= $n['id_emprendimiento'] ?>" <?= $negocio_filter == $n['id_emprendimiento'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($n['nombre_comercial']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Plantilla</label>
            <select name="id_plantilla">
                <option value="">Todas las plantillas</option>
                <?php
                $vistas = [];
                foreach ($negocios as $n) {
                    $key = $n['id_plantilla'];
                    if (!isset($vistas[$key])) {
                        $vistas[$key] = $n['plantilla_nombre'];
                    }
                }
                foreach ($vistas as $id => $nom):
                ?>
                    <option value="<?= $id ?>" <?= $plantilla_filter == $id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nom) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-filtrar"><i class="fas fa-filter"></i> Filtrar</button>
        <a href="<?= BASE_URL ?>/admin/ventas" class="btn-limpiar"><i class="fas fa-times"></i> Limpiar</a>
    </form>

    <?php if (count($pedidos) > 0): ?>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Codigo</th><th>Cliente</th><th>Negocio</th><th>Plantilla</th><th>Items</th><th>Total</th><th>Pago</th><th>Estado</th><th>Fecha</th></tr></thead>
            <tbody>
            <?php foreach ($pedidos as $p): ?>
                <?php
                    $pc = $p['estado_pago'] == 'Completado' ? 'completado' : (strtolower($p['estado_pago'] ?? 'pendiente'));
                    $lc = $p['estado_logistico'] ?? '';
                ?>
                <tr>
                    <td style="font-weight:600;font-size:12px;color:var(--text-muted)"><?= htmlspecialchars($p['codigo_seguimiento']) ?></td>
                    <td>
                        <strong><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></strong>
                        <br><span style="font-size:11px;color:var(--text-dim)"><?= htmlspecialchars($p['cliente_email']) ?></span>
                    </td>
                    <td><strong><?= htmlspecialchars($p['nombre_comercial']) ?></strong></td>
                    <td><span class="badge-pl" style="background:var(--surface2);color:var(--text-muted)"><?= htmlspecialchars($p['plantilla_nombre']) ?></span></td>
                    <td><?= $p['total_items'] ?> item(s)</td>
                    <td><strong>Bs. <?= number_format($p['total'], 2) ?></strong></td>
                    <td>
                        <span class="badge-pl <?= $pc ?>"><?= $p['metodo_pago'] ?></span>
                        <br><span style="font-size:10px;color:var(--text-dim)"><?= $p['estado_pago'] ?></span>
                    </td>
                    <td><span class="badge-pl <?= str_replace(' ', '_', $lc) ?>"><?= $lc ?></span></td>
                    <td style="font-size:12px;color:var(--text-dim)"><?= $p['fecha_creacion'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="table-wrap"><div class="empty">
            <i class="fas fa-shopping-cart"></i>
            <p>No hay ventas registradas</p>
            <p style="font-size:12px;color:var(--text-dim);margin-top:8px">Crea un negocio, agrega productos y realiza una compra para ver ventas aqui.</p>
        </div></div>
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