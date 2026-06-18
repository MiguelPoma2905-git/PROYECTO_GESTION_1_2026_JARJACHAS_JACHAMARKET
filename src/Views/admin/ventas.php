<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Ventas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
</head>
<body class="dashboard-body">

<?php $current_page = 'admin-ventas'; $rol_activo = 'Administrador'; ?>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>

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

    <div class="ventas-wrap">

        <div class="ventas-header">
            <div class="ventas-header-top">
                <h1>
                    <span class="header-icon"><i class="fas fa-chart-line"></i></span>
                    Ventas
                </h1>
                <a href="<?= BASE_URL ?>/dashboard" style="display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border-radius:8px;font-size:12px;color:var(--text-muted);text-decoration:none;border:1px solid var(--border);transition:all 0.2s">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
            <div class="sub">Panel de monitoreo de ventas y transacciones de la plataforma</div>
        </div>

        <div class="ventas-resumen">
            <div class="venta-res-card">
                <div class="venta-res-top">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Total pedidos</span>
                </div>
                <div class="venta-res-num"><?= $resumen['total_pedidos'] ?></div>
                <div class="venta-res-sub">pedidos registrados en la plataforma</div>
            </div>
            <div class="venta-res-card">
                <div class="venta-res-top">
                    <i class="fas fa-coins"></i>
                    <span>Total ventas</span>
                </div>
                <div class="venta-res-num">Bs. <?= number_format($resumen['total_ventas'], 2) ?></div>
                <div class="venta-res-sub">ingreso bruto acumulado</div>
            </div>
            <div class="venta-res-card">
                <div class="venta-res-top">
                    <i class="fas fa-eye"></i>
                    <span>Mostrando</span>
                </div>
                <div class="venta-res-num" style="color:<?= count($pedidos) > 0 ? 'var(--text)' : 'var(--text-dim)' ?>"><?= count($pedidos) ?></div>
                <div class="venta-res-sub">pedidos en la vista actual</div>
            </div>
        </div>

        <form class="ventas-filtros" method="GET" action="<?= BASE_URL ?>/admin/ventas">
            <div class="filtro-group">
                <label><i class="fas fa-store" style="margin-right:4px"></i> Negocio</label>
                <select name="id_emprendimiento">
                    <option value="">Todos los negocios</option>
                    <?php foreach ($negocios as $n): ?>
                        <option value="<?= $n['id_emprendimiento'] ?>" <?= $negocio_filter == $n['id_emprendimiento'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nombre_comercial']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filtro-group">
                <label><i class="fas fa-palette" style="margin-right:4px"></i> Plantilla</label>
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
        <div class="ventas-table-wrap">
            <table class="ventas-table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Cliente</th>
                        <th>Negocio</th>
                        <th>Plantilla</th>
                        <th style="text-align:center">Items</th>
                        <th>Total</th>
                        <th>Pago</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $p):
                    $pc = $p['estado_pago'] == 'Completado' ? 'completado' : (strtolower($p['estado_pago'] ?? 'pendiente'));
                    $lc = $p['estado_logistico'] ?? '';
                ?>
                    <tr>
                        <td class="td-code"><?= htmlspecialchars($p['codigo_seguimiento']) ?></td>
                        <td class="td-cliente">
                            <strong><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></strong>
                            <div class="email"><?= htmlspecialchars($p['cliente_email']) ?></div>
                        </td>
                        <td class="td-negocio"><strong><?= htmlspecialchars($p['nombre_comercial']) ?></strong></td>
                        <td><span class="badge-plantilla"><i class="fas fa-palette"></i> <?= htmlspecialchars($p['plantilla_nombre']) ?></span></td>
                        <td style="text-align:center;font-weight:500"><?= $p['total_items'] ?></td>
                        <td class="td-total"><strong>Bs. <?= number_format($p['total'], 2) ?></strong></td>
                        <td>
                            <span class="badge-venta <?= $pc ?>"><i class="fas fa-<?= $pc === 'completado' ? 'check-circle' : ($pc === 'pendiente' ? 'clock' : 'times-circle') ?>"></i> <?= $p['metodo_pago'] ?></span>
                            <div style="font-size:10px;color:var(--text-dim);margin-top:3px"><?= $p['estado_pago'] ?></div>
                        </td>
                        <td><span class="badge-venta <?= str_replace(' ', '_', $lc) ?>"><?= $lc ?></span></td>
                        <td class="td-fecha"><i class="far fa-calendar-alt" style="margin-right:4px;opacity:0.5"></i><?= $p['fecha_creacion'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="ventas-table-wrap">
            <div class="ventas-empty">
                <div class="ventas-empty-icon"><i class="fas fa-shopping-cart"></i></div>
                <h3>No hay ventas registradas</h3>
                <p>Crea un negocio, agrega productos y realiza una compra para ver las ventas aquí.</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Margenes por negocio -->
        <div class="margenes-header">
            <h2><i class="fas fa-chart-pie"></i> Margenes por negocio</h2>
            <span style="font-size:11px;color:var(--text-dim);background:var(--card-bg);padding:4px 14px;border-radius:20px;border:1px solid var(--border)"><?= count($margenes_negocio) ?> negocios</span>
        </div>

        <?php if (count($margenes_negocio) > 0): ?>
        <div class="ventas-table-wrap">
            <table class="ventas-table">
                <thead>
                    <tr>
                        <th>Negocio</th>
                        <th style="text-align:center">Productos</th>
                        <th style="text-align:center">Con costo</th>
                        <th>Margen promedio</th>
                        <th>Ganancia total</th>
                        <th>Ingreso total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($margenes_negocio as $m):
                    $margen = (float)$m['margen_promedio'];
                    $barColor = $margen >= 30 ? '#6b8f71' : ($margen >= 10 ? '#9a8a4a' : '#9a5a5a');
                    $barWidth = min($margen, 100);
                ?>
                    <tr>
                        <td class="td-negocio"><strong><?= htmlspecialchars($m['nombre_comercial']) ?></strong></td>
                        <td style="text-align:center"><?= (int)$m['total_productos'] ?></td>
                        <td style="text-align:center"><?= (int)$m['con_costo'] ?></td>
                        <td>
                            <span style="color:<?= $barColor ?>;font-weight:600;font-size:14px"><?= number_format($margen, 1) ?>%</span>
                            <div class="margen-bar">
                                <div class="margen-bar-fill" style="width:<?= $barWidth ?>%;background:<?= $barColor ?>"></div>
                            </div>
                        </td>
                        <td><strong>Bs. <?= number_format($m['ganancia_total'], 2) ?></strong></td>
                        <td>Bs. <?= number_format($m['ingreso_total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="ventas-table-wrap">
            <div class="ventas-empty">
                <div class="ventas-empty-icon"><i class="fas fa-chart-pie"></i></div>
                <h3>No hay datos de margenes</h3>
                <p>Registra precios de costo en los productos para ver los margenes aquí.</p>
            </div>
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

    // Animate margen bars on scroll
    var bars = document.querySelectorAll('.margen-bar-fill');
    if (bars.length) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.width = entry.target.style.width;
                }
            });
        }, { threshold: 0.3 });
        bars.forEach(function(b) { observer.observe(b); });
    }
})();
</script>
</body>
</html>
