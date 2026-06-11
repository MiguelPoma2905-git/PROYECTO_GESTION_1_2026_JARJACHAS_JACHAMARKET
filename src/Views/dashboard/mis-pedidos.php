<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <title>Mis Pedidos - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .mp-header { margin-bottom:28px; }
        .mp-title { font-family:Georgia,var(--font-serif);font-size:24px;font-weight:400;color:var(--text);margin:0; }
        .mp-subtitle { font-size:13px;color:var(--text-muted);margin-top:4px; }
        .mp-count { font-size:13px;color:var(--text-muted);margin-bottom:20px; }
        .mp-list { display:flex;flex-direction:column;gap:16px; }
        .mp-card { background:var(--card-bg);border:1px solid var(--border);border-radius:12px;overflow:hidden;transition:all .25s var(--ease); }
        .mp-card:hover { border-color:var(--border-hi);box-shadow:var(--shadow-md); }
        .mp-card-header { display:flex;align-items:center;justify-content:space-between;padding:16px 20px;cursor:pointer;user-select:none;gap:12px;flex-wrap:wrap; }
        .mp-card-header:hover { background:var(--glow); }
        .mp-card-header .left { display:flex;align-items:center;gap:12px;flex-wrap:wrap; }
        .mp-card-header .codigo { font-family:monospace;font-size:12px;color:var(--text-muted); }
        .mp-card-header .tienda { font-weight:600;color:var(--text);font-size:14px; }
        .mp-card-header .fecha { font-size:12px;color:var(--text-muted); }
        .mp-card-header .monto { font-weight:600;font-family:Georgia,var(--font-serif);font-size:16px;color:var(--text); }
        .mp-card-header .arrow { color:var(--text-dim);font-size:12px;transition:transform .3s var(--ease); }
        .mp-card-header .arrow.open { transform:rotate(180deg); }
        .mp-badge { display:inline-block;padding:2px 10px;border-radius:20px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.3px; }
        .mp-badge.entregado { background:#27AE6015;color:#27AE60; }
        .mp-badge.en-proceso { background:#F39C1215;color:#F39C12; }
        .mp-badge.cancelado { background:#E74C3C15;color:#E74C3C; }
        .mp-card-body { border-top:1px solid var(--border);padding:16px 20px;display:none;background:var(--surface2); }
        .mp-card-body.open { display:block; }
        .mp-items { margin-bottom:12px; }
        .mp-item { display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;gap:8px; }
        .mp-item:last-child { border-bottom:none; }
        .mp-item .qty { color:var(--text-muted);font-size:12px;min-width:24px; }
        .mp-item .name { flex:1;color:var(--text); }
        .mp-item .price { color:var(--text);font-weight:500;white-space:nowrap; }
        .mp-details-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;margin-top:12px;padding-top:12px;border-top:1px solid var(--border); }
        .mp-detail-item { }
        .mp-detail-item .lbl { font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.3px; }
        .mp-detail-item .val { font-size:13px;color:var(--text);margin-top:2px; }
        .mp-empty { text-align:center;padding:80px 20px; }
        .mp-empty-icon { font-size:48px;opacity:0.2;margin-bottom:12px; }
        .mp-empty p { font-size:14px;color:var(--text-dim); }
        @media(max-width:600px){
            .mp-card-header{flex-direction:column;align-items:stretch;gap:8px;}
            .mp-card-header .left{flex-wrap:wrap;gap:6px;}
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
            <a href="<?= BASE_URL ?>/dashboard"> Dashboard</a>
            <a href="<?= BASE_URL ?>/mis-estadisticas"> Mis estadísticas</a>
            <a href="<?= BASE_URL ?>/mis-pedidos" class="active"> Mis pedidos</a>
            <?php if ($es_admin): ?>
            <a href="<?= BASE_URL ?>/admin" style="color: #3498DB;"> Administración</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"> Cerrar sesión</a>
        </nav>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-btn" id="sidebarToggle">&#9776;</button>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
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
                        <span style="font-size:8px;color:var(--text-dim);line-height:1;">▼</span>
                    </div>
                    <div class="dropdown-menu">
                        <?php if (count($roles_usuario) > 1): ?>
                        <div style="padding:8px 16px 4px;font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;border-bottom:1px solid var(--border)">Elegir rol</div>
                            <?php foreach ($roles_usuario as $rol):
                                $color_rol = match($rol['nombre_rol']) {
                                    'Cliente' => '#3498DB',
                                    'Emprendedor' => '#2ECC71',
                                    'Repartidor' => '#F39C12',
                                    'Administrador' => '#E74C3C',
                                    default => '#888'
                                };
                            ?>
                            <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="dropdown-item <?= $rol['nombre_rol'] === $rol_activo ? 'active-role' : '' ?>">
                                <span class="role-dot" style="background:<?= $color_rol ?>"></span>
                                <?= htmlspecialchars($rol['nombre_rol']) ?>
                                <?php if ($rol['nombre_rol'] === $rol_activo): ?><span style="margin-left:auto;font-size:10px;opacity:0.6">✓</span><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                            <div style="border-top:1px solid var(--border);margin:4px 0"></div>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item" style="color:#E74C3C">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-container">
            <div class="mp-header">
                <h1 class="mp-title">Mis pedidos</h1>
                <p class="mp-subtitle">Historial completo de tus compras en Jacha Marketplace</p>
            </div>

            <?php if (count($pedidos) > 0): ?>
            <div class="mp-count"><?= count($pedidos) ?> pedido(s)</div>
            <div class="mp-list">
                <?php foreach ($pedidos as $p):
                    $estadoBadge = match($p['estado_logistico']) {
                        'Entregado' => 'entregado',
                        'Cancelado' => 'cancelado',
                        default => 'en-proceso'
                    };
                    $estadoLabel = match($p['estado_logistico']) {
                        'Recibido' => 'Recibido',
                        'Preparando' => 'Preparando',
                        'En_Ruta' => 'En ruta',
                        'Entregado' => 'Entregado',
                        'Cancelado' => 'Cancelado',
                        default => $p['estado_logistico']
                    };
                    $detalles = $detalles_por_pedido[$p['id_pedido']] ?? [];
                ?>
                <div class="mp-card">
                    <div class="mp-card-header" onclick="togglePedido(<?= $p['id_pedido'] ?>)">
                        <div class="left">
                            <span class="codigo"><?= htmlspecialchars($p['codigo_seguimiento']) ?></span>
                            <span class="tienda"><?= htmlspecialchars($p['nombre_comercial'] ?? '—') ?></span>
                            <span class="fecha"><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></span>
                            <span class="mp-badge <?= $estadoBadge ?>"><?= $estadoLabel ?></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span class="monto">Bs. <?= number_format($p['total'], 2) ?></span>
                            <span class="arrow" id="arrow-<?= $p['id_pedido'] ?>">▼</span>
                        </div>
                    </div>
                    <div class="mp-card-body" id="body-<?= $p['id_pedido'] ?>">
                        <div class="mp-items">
                            <?php foreach ($detalles as $d): ?>
                            <div class="mp-item">
                                <span class="qty"><?= $d['cantidad'] ?>x</span>
                                <span class="name"><?= htmlspecialchars($d['producto_nombre']) ?></span>
                                <span class="price">Bs. <?= number_format($d['precio_unitario'], 2) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mp-details-grid">
                            <div class="mp-detail-item">
                                <div class="lbl">Subtotal</div>
                                <div class="val">Bs. <?= number_format($p['subtotal'], 2) ?></div>
                            </div>
                            <div class="mp-detail-item">
                                <div class="lbl">Envío</div>
                                <div class="val">Bs. <?= number_format($p['costo_envio'], 2) ?></div>
                            </div>
                            <div class="mp-detail-item">
                                <div class="lbl">Total</div>
                                <div class="val" style="font-weight:600;">Bs. <?= number_format($p['total'], 2) ?></div>
                            </div>
                            <div class="mp-detail-item">
                                <div class="lbl">Pago</div>
                                <div class="val"><?= htmlspecialchars($p['metodo_pago']) ?></div>
                            </div>
                            <div class="mp-detail-item">
                                <div class="lbl">Estado pago</div>
                                <div class="val"><?= htmlspecialchars($p['estado_pago']) ?></div>
                            </div>
                            <div class="mp-detail-item">
                                <div class="lbl">Dirección</div>
                                <div class="val" style="font-size:12px;"><?= htmlspecialchars($p['direccion_entrega'] ?? '—') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="mp-empty">
                <div class="mp-empty-icon"><i class="fas fa-box-open"></i></div>
                <p>Aún no has realizado ningún pedido</p>
                <p style="font-size:12px;color:var(--text-muted);margin-top:4px;">Explora las tiendas y descubre productos para comprar</p>
                <a href="<?= BASE_URL ?>/explorar" style="display:inline-block;margin-top:16px;padding:10px 24px;background:#3498DB;color:#fff;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;">Explorar tiendas</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function togglePedido(id) {
            var body = document.getElementById('body-' + id);
            var arrow = document.getElementById('arrow-' + id);
            if (body && arrow) {
                body.classList.toggle('open');
                arrow.classList.toggle('open');
            }
        }

        (function(){
            var toggle = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            function toggleSidebar() {
                sidebar.classList.toggle('open');
                if (overlay) overlay.classList.toggle('active');
            }
            if (toggle && sidebar) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                });
            }

            var userTrigger = document.getElementById('userTrigger');
            var userDropdown = document.getElementById('userDropdown');
            if (userTrigger && userDropdown) {
                userTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('open');
                });
                document.addEventListener('click', function() {
                    userDropdown.classList.remove('open');
                });
            }

            var themeToggle = document.getElementById('themeToggle');
            var html = document.documentElement;
            if (themeToggle) {
                var saved = localStorage.getItem('jacha_theme') || 'dark';
                html.setAttribute('data-theme', saved);
                themeToggle.addEventListener('click', function() {
                    var current = html.getAttribute('data-theme');
                    var next = current === 'dark' ? 'light' : 'dark';
                    html.setAttribute('data-theme', next);
                    localStorage.setItem('jacha_theme', next);
                });
            }
        })();
    </script>
</body>
</html>
