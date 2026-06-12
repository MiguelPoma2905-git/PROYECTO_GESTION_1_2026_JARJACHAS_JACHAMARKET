<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Kardex - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .kdx-wrap { max-width:1400px; margin:0 auto; padding:32px 24px; }
        .kdx-header { margin-bottom:32px; }
        .kdx-header h1 { font-family:Georgia,'Cormorant Garamond',serif; font-size:28px; font-weight:400; color:var(--text); display:flex; align-items:center; gap:12px; }
        .kdx-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; }
        .kdx-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .kdx-header .back:hover { color:var(--text); }
        .kdx-tabs { display:flex; gap:4px; margin-bottom:28px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:4px; overflow-x:auto; }
        .kdx-tab { padding:10px 20px; border-radius:4px; font-size:12px; font-weight:500; color:var(--text-muted); text-decoration:none; white-space:nowrap; transition:all .15s; }
        .kdx-tab:hover { color:var(--text); background:var(--surface2); }
        .kdx-tab.active { background:var(--text); color:var(--bg); }
        .kdx-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; margin-bottom:24px; }
        .kdx-card h2 { font-family:Georgia,'Cormorant Garamond',serif; font-size:18px; font-weight:500; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .filtros { display:flex; gap:12px; margin-bottom:20px; align-items:end; flex-wrap:wrap; }
        .filtros .fg { display:flex;flex-direction:column;gap:4px; }
        .filtros .fg label { font-size:10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
        .filtros select, .filtros input { padding:9px 14px; border:1px solid var(--border); border-radius:4px; background:var(--card-bg); color:var(--text); font-size:12px; font-family:inherit; outline:none; }
        .filtros select:focus, .filtros input:focus { border-color:var(--border-hi); }
        .filtros .btn-f { display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:var(--text);color:var(--bg);border:none;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit; }
        .filtros .btn-f:hover { opacity:0.9; }
        .table-wrap { overflow-x:auto; }
        table.kdx { width:100%; border-collapse:collapse; }
        .kdx th { text-align:left; padding:14px 16px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); white-space:nowrap; }
        [data-theme="light"] .kdx th { background:rgba(0,0,0,0.03); }
        .kdx td { padding:14px 16px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .kdx tbody tr:last-child td { border-bottom:none; }
        .kdx tbody tr:hover { background:rgba(255,255,255,0.015); }
        [data-theme="light"] .kdx tbody tr:hover { background:rgba(0,0,0,0.03); }
        .badge-tipo { display:inline-block;padding:3px 10px;border-radius:4px;font-size:10px;font-weight:600; }
        .badge-tipo.Ingreso_Compra, .badge-tipo.Ingreso { background:rgba(107,143,113,0.1);color:#6b8f71; }
        .badge-tipo.Salida_Venta, .badge-tipo.Salida { background:rgba(154,90,90,0.1);color:#9a5a5a; }
        .badge-tipo.Ajuste_Perdida, .badge-tipo.Ajuste { background:rgba(154,138,74,0.1);color:#9a8a4a; }
        .badge-tipo.Transferencia { background:rgba(107,127,143,0.1);color:#6b7f8f; }
        .cant-pos { color:#6b8f71; font-weight:600; }
        .cant-neg { color:#9a5a5a; font-weight:600; }
        .empty-state { text-align:center;padding:60px 20px;color:var(--text-dim); }
        .empty-state i { font-size:36px;margin-bottom:12px;opacity:0.3;color:var(--text-muted); }
        @media(max-width:900px){
            .kdx-wrap { padding:24px 20px; }
            .kdx th,.kdx td { padding:10px 12px; white-space:nowrap; }
        }
        @media(max-width:480px){
            .kdx-wrap { padding:16px 12px; }
            .kdx-header h1 { font-size:22px; }
            .kdx-card { padding:16px; }
            .filtros { flex-direction:column; align-items:stretch; }
            .filtros .fg { width:100%; }
            .filtros .fg select, .filtros .fg input { width:100%; }
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
        <a href="<?= BASE_URL ?>/herramientas" style="margin-top:24px;border-top:1px solid var(--border);padding-top:16px;"><i class="fas fa-tools"></i> Herramientas</a>
        <a href="<?= BASE_URL ?>/sucursales"><i class="fas fa-code-branch"></i> Sucursales</a>
        <a href="<?= BASE_URL ?>/inventario"><i class="fas fa-boxes"></i> Inventario</a>
        <a href="<?= BASE_URL ?>/kardex" class="active"><i class="fas fa-history"></i> Kardex</a>
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

    <div class="kdx-header">
        <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
        <h1><i class="fas fa-history" style="color:var(--text-muted)"></i> Kardex / Historial</h1>
        <div class="sub">Registro detallado de todos los movimientos de inventario</div>
    </div>

    <?php if (count($mis_negocios) > 0): ?>

    <div class="kdx-tabs">
        <?php foreach ($mis_negocios as $n): ?>
            <a href="<?= BASE_URL ?>/kardex?id_emprendimiento=<?= $n['id_emprendimiento'] ?>" class="kdx-tab <?= $id_emprendimiento == $n['id_emprendimiento'] ? 'active' : '' ?>">
                <i class="fas fa-store"></i> <?= htmlspecialchars($n['nombre_comercial']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($negocio_seleccionado): ?>

    <div class="kdx-card">
        <h2><i class="fas fa-filter" style="color:var(--text-muted)"></i> Movimientos</h2>
        <form method="GET" action="<?= BASE_URL ?>/kardex" class="filtros">
            <input type="hidden" name="id_emprendimiento" value="<?= $id_emprendimiento ?>">
            <div class="fg">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <?php foreach ($tipos_kardex as $t): ?>
                        <option value="<?= $t ?>" <?= $filtro_tipo === $t ? 'selected' : '' ?>><?= str_replace('_', ' ', $t) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="fg">
                <label>Sucursal</label>
                <select name="id_sucursal">
                    <option value="">Todas</option>
                    <?php foreach ($sucursales as $s): ?>
                        <option value="<?= $s['id_sucursal'] ?>" <?= $filtro_sucursal == $s['id_sucursal'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nombre_sucursal']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="fg">
                <label>Desde</label>
                <input type="date" name="desde" value="<?= htmlspecialchars($filtro_desde) ?>">
            </div>
            <div class="fg">
                <label>Hasta</label>
                <input type="date" name="hasta" value="<?= htmlspecialchars($filtro_hasta) ?>">
            </div>
            <button type="submit" class="btn-f"><i class="fas fa-search"></i> Buscar</button>
            <a href="<?= BASE_URL ?>/kardex?id_emprendimiento=<?= $id_emprendimiento ?>" style="font-size:12px;color:var(--text-muted);text-decoration:none">Limpiar</a>
        </form>

        <?php if (count($movimientos) > 0): ?>
        <div class="table-wrap">
            <table class="kdx">
                <thead>
                    <tr><th>Fecha</th><th>Tipo</th><th>Producto</th><th>SKU</th><th>Sucursal</th><th>Cantidad</th><th>Responsable</th><th>Observaci&oacute;n</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $m): ?>
                    <tr>
                        <td style="font-size:12px;color:var(--text-dim)"><?= $m['fecha'] ?></td>
                        <td><span class="badge-tipo <?= $m['tipo'] ?>"><?= str_replace('_', ' ', $m['tipo']) ?></span></td>
                        <td><strong><?= htmlspecialchars($m['producto_nombre']) ?></strong></td>
                        <td style="font-size:12px;color:var(--text-dim)"><?= htmlspecialchars($m['sku'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($m['nombre_sucursal'] ?? '—') ?></td>
                        <td class="<?= in_array($m['tipo'], ['Salida_Venta', 'Ajuste_Perdida']) ? 'cant-neg' : 'cant-pos' ?>">
                            <?= in_array($m['tipo'], ['Salida_Venta', 'Ajuste_Perdida']) ? '-' : '+' ?><?= (int)$m['cantidad'] ?>
                        </td>
                        <td style="font-size:12px;color:var(--text-muted)"><?= htmlspecialchars($m['responsable_nombre'] . ' ' . ($m['responsable_apellidos'] ?? '')) ?></td>
                        <td style="font-size:12px;color:var(--text-dim);max-width:200px"><?= htmlspecialchars($m['observacion'] ?? '—') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-history"></i>
            <p>No hay movimientos registrados</p>
            <p style="font-size:12px;color:var(--text-dim);margin-top:8px">Los movimientos aparecen cuando ajustas stock o transfieres entre sucursales.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <div class="kdx-card"><div class="empty-state"><i class="fas fa-store"></i><p>Selecciona un negocio</p></div></div>
    <?php endif; ?>

    <?php else: ?>
    <div class="kdx-card"><div class="empty-state"><i class="fas fa-store"></i><p>No tienes negocios</p></div></div>
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
