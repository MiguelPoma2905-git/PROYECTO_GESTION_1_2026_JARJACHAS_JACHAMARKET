<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <title>Mis Estadísticas - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .est-header { margin-bottom:28px; }
        .est-title { font-family:Georgia,var(--font-serif);font-size:24px;font-weight:400;color:var(--text);margin:0; }
        .est-subtitle { font-size:13px;color:var(--text-muted);margin-top:4px; }
        .est-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px; }
        .est-card { background:var(--card-bg);border:1px solid var(--border);border-radius:10px;padding:20px 18px;transition:all .25s var(--ease);position:relative;overflow:hidden; }
        .est-card:hover { border-color:var(--border-hi);transform:translateY(-2px);box-shadow:var(--shadow-md); }
        .est-card-icon { width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:12px; }
        .est-card .est-val { font-family:Georgia,var(--font-serif);font-size:26px;font-weight:500;color:var(--text);line-height:1.2; }
        .est-card .est-val small { font-size:14px;font-weight:400;color:var(--text-muted);font-family:var(--font-sans); }
        .est-card .est-lbl { font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.4px;margin-top:4px; }
        .est-section-title { font-family:Georgia,var(--font-serif);font-size:18px;font-weight:400;color:var(--text);margin:0 0 14px; }
        .pedidos-table-wrap { background:var(--card-bg);border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:28px; }
        .pedidos-table { width:100%;border-collapse:collapse; }
        .pedidos-table th { padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;background:var(--surface2);border-bottom:1px solid var(--border); }
        .pedidos-table td { padding:12px 16px;font-size:13px;color:var(--text);border-bottom:1px solid var(--border); }
        .pedidos-table tr:last-child td { border-bottom:none; }
        .pedidos-table tr:hover td { background:var(--glow); }
        .est-badge { display:inline-block;padding:2px 10px;border-radius:20px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.3px; }
        .est-badge.entregado { background:#27AE6015;color:#27AE60; }
        .est-badge.en-proceso { background:#F39C1215;color:#F39C12; }
        .est-badge.cancelado { background:#E74C3C15;color:#E74C3C; }
        .est-empty { text-align:center;padding:50px 20px;color:var(--text-dim); }
        .est-empty-icon { font-size:40px;opacity:0.25;margin-bottom:10px; }
        .est-empty p { font-size:14px; }
        .pedidos-table .codigo { font-family:monospace;font-size:12px;color:var(--text-muted); }
        .pedidos-table .monto { font-weight:600;font-family:Georgia,var(--font-serif); }
        .est-state-row { display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:28px; }
        .est-state-card { background:var(--card-bg);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center; }
        .est-state-card .num { font-family:Georgia,var(--font-serif);font-size:28px;font-weight:500;color:var(--text); }
        .est-state-card .lbl { font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.4px;margin-top:2px; }
        .est-state-card .bar { height:4px;border-radius:2px;margin-top:10px;background:var(--border);overflow:hidden; }
        .est-state-card .bar-fill { height:100%;border-radius:2px;transition:width .6s var(--ease); }
        @media(max-width:900px){ .est-grid{grid-template-columns:repeat(2,1fr);} }
        @media(max-width:600px){
            .est-grid{grid-template-columns:1fr;gap:10px;}
            .est-state-row{grid-template-columns:1fr;}
            .pedidos-table th,.pedidos-table td{padding:8px 10px;font-size:12px;}
            .pedidos-table td:nth-child(4),.pedidos-table th:nth-child(4){display:none;}
            .est-card{padding:16px;}
            .est-card .est-val{font-size:22px;}
            .est-card-icon{width:32px;height:32px;font-size:13px;margin-bottom:8px;}
            .est-title{font-size:20px;}
            .est-section-title{font-size:16px;}
        }
        @media(max-width:480px){
            .pedidos-table td:nth-child(3),.pedidos-table th:nth-child(3){display:none;}
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
            <?php if ($rol_activo === 'Cliente'): ?>
            <a href="<?= BASE_URL ?>/mis-estadisticas" class="active"> Mis estadísticas</a>
            <a href="<?= BASE_URL ?>/mis-pedidos"> Mis pedidos</a>
            <a href="<?= BASE_URL ?>/favoritos"> Favoritos</a>
            <?php endif; ?>
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
            <div class="est-header">
                <h1 class="est-title">Mis estadísticas</h1>
                <p class="est-subtitle">Resumen de tu actividad en Jacha Marketplace</p>
            </div>

            <div class="est-grid">
                <div class="est-card">
                    <div class="est-card-icon" style="background:#3498DB15;color:#3498DB;"><i class="fas fa-shopping-bag"></i></div>
                    <div class="est-val"><?= $stats['total_pedidos'] ?? 0 ?></div>
                    <div class="est-lbl">Pedidos totales</div>
                </div>
                <div class="est-card">
                    <div class="est-card-icon" style="background:#27AE6015;color:#27AE60;"><i class="fas fa-check-circle"></i></div>
                    <div class="est-val"><?= $stats['entregados'] ?? 0 ?></div>
                    <div class="est-lbl">Entregados</div>
                </div>
                <div class="est-card">
                    <div class="est-card-icon" style="background:#F39C1215;color:#F39C12;"><i class="fas fa-spinner"></i></div>
                    <div class="est-val"><?= $stats['en_proceso'] ?? 0 ?></div>
                    <div class="est-lbl">En proceso</div>
                </div>
                <div class="est-card">
                    <div class="est-card-icon" style="background:#8E44AD15;color:#8E44AD;"><i class="fas fa-dollar-sign"></i></div>
                    <div class="est-val">Bs. <?= number_format($stats['total_gastado'] ?? 0, 2) ?></div>
                    <div class="est-lbl">Total gastado</div>
                </div>
            </div>

            <div class="est-state-row">
                <div class="est-state-card">
                    <div class="num"><?= $stats['total_pedidos'] ?? 0 ?></div>
                    <div class="lbl">Pedidos realizados</div>
                    <div class="bar"><div class="bar-fill" style="width:100%;background:#3498DB;"></div></div>
                </div>
                <div class="est-state-card">
                    <?php $tasa = ($stats['total_pedidos'] ?? 0) > 0 ? round((($stats['entregados'] ?? 0) / ($stats['total_pedidos'] ?? 1)) * 100) : 0; ?>
                    <div class="num"><?= $tasa ?>%</div>
                    <div class="lbl">Tasa de entrega</div>
                    <div class="bar"><div class="bar-fill" style="width:<?= $tasa ?>%;background:#27AE60;"></div></div>
                </div>
                <div class="est-state-card">
                    <div class="num">Bs. <?= number_format($stats['promedio_gasto'] ?? 0, 0) ?></div>
                    <div class="lbl">Gasto promedio</div>
                    <div class="bar"><div class="bar-fill" style="width:<?= min(100, ($stats['promedio_gasto'] ?? 0) > 0 ? (($stats['promedio_gasto'] ?? 0) / 200) * 100 : 0) ?>%;background:#8E44AD;"></div></div>
                </div>
            </div>

            <h2 class="est-section-title"><i class="fas fa-history" style="margin-right:8px;opacity:0.5;"></i>Pedidos recientes</h2>
            <div class="pedidos-table-wrap">
                <?php if (count($pedidos) > 0): ?>
                <table class="pedidos-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tienda</th>
                            <th>Fecha</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        ?>
                        <tr>
                            <td><span class="codigo"><?= htmlspecialchars($p['codigo_seguimiento']) ?></span></td>
                            <td><strong><?= htmlspecialchars($p['nombre_comercial'] ?? '—') ?></strong></td>
                            <td><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></td>
                            <td><?= $p['total_items'] ?></td>
                            <td><span class="monto">Bs. <?= number_format($p['total'], 2) ?></span></td>
                            <td><span class="est-badge <?= $estadoBadge ?>"><?= $estadoLabel ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="est-empty">
                    <div class="est-empty-icon"><i class="fas fa-box-open"></i></div>
                    <p>Aún no has realizado ningún pedido</p>
                    <p style="font-size:12px;color:var(--text-muted);margin-top:4px;">Explora las tiendas y descubre productos únicos</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
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
