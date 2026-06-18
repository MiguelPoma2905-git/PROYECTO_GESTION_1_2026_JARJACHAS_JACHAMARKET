<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
    <style>
        .greeting-wrap { overflow:hidden; transition:all 0.6s ease; }
        .greeting-text { font-family:Georgia,var(--font-serif);font-size:22px;font-weight:400;color:var(--text);margin-bottom:12px;min-height:1.2em; }
        .greeting-text .glow-char, .cliente-greeting .glow-char { animation:glowPulseWhite 2.5s ease-in-out infinite;text-shadow:0 0 8px rgba(79,172,254,0.08),0 0 24px rgba(79,172,254,0.12),0 0 48px rgba(79,172,254,0.06); }
        .cliente-greeting .glow-char { text-shadow:0 0 12px rgba(79,172,254,0.1),0 0 32px rgba(79,172,254,0.15),0 0 64px rgba(79,172,254,0.08),0 0 120px rgba(79,172,254,0.04); }
        .greeting-text .cursor, .cliente-greeting .cursor { display:inline-block;width:3px;height:1.1em;background:var(--text);margin-left:3px;animation:blink 0.8s step-end infinite;vertical-align:text-bottom; }
        .greeting-text.fade-out { opacity:0;transform:translateY(-12px);transition:all 0.8s ease; }
        @keyframes glowPulseWhite { 0%,100%{text-shadow:0 0 8px rgba(79,172,254,0.08),0 0 24px rgba(79,172,254,0.12),0 0 48px rgba(79,172,254,0.06)} 50%{text-shadow:0 0 16px rgba(79,172,254,0.2),0 0 40px rgba(79,172,254,0.25),0 0 80px rgba(79,172,254,0.12),0 0 140px rgba(79,172,254,0.06)} }
        @keyframes blink { 50%{opacity:0} }
        [data-theme="dark"] .cliente-greeting .glow-char { text-shadow:0 0 12px rgba(79,172,254,0.15),0 0 36px rgba(79,172,254,0.2),0 0 72px rgba(79,172,254,0.1),0 0 140px rgba(79,172,254,0.05); }
        [data-theme="light"] .cliente-greeting .glow-char { text-shadow:0 0 8px rgba(79,172,254,0.15),0 0 24px rgba(79,172,254,0.1),0 0 48px rgba(79,172,254,0.05); }
        [data-theme="dark"] .greeting-text .glow-char { text-shadow:0 0 8px rgba(255,255,255,0.15),0 0 24px rgba(255,255,255,0.2),0 0 48px rgba(255,255,255,0.1); }
        [data-theme="light"] .greeting-text .glow-char { text-shadow:0 0 6px rgba(255,255,255,0.4),0 0 16px rgba(255,255,255,0.2); }
    </style>
</head>
<body class="dashboard-body">

    <?php $current_page = 'dashboard'; ?>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Top Bar Premium -->
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
            </div>
            <div class="top-bar-right">
                <button class="notif-btn" id="notifBtn" title="Notificaciones">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge" id="notifBadge">3</span>
                </button>
                <button class="theme-toggle" id="themeToggle" title="Cambiar tema">&#9790;</button>
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-trigger" id="userTrigger">
                        <span class="user-name"><?= htmlspecialchars($usuario['nombre'] ?? 'Usuario') ?></span>
                        <div class="user-avatar">
                            <?php if ($avatar_usuario): ?>
                                <img src="<?= BASE_URL ?>/<?= $avatar_usuario ?>" alt="Avatar">
                            <?php else: ?>
                                <?= $inicial ?>
                            <?php endif; ?>
                        </div>
                        <span class="dropdown-arrow">&#9660;</span>
                    </div>
                    <div class="dropdown-menu">
                        <?php if (count($roles_usuario) > 1): ?>
                        <div class="dropdown-header">Cambiar rol</div>
                            <?php foreach ($roles_usuario as $rol):
                                $color_rol = match($rol['nombre_rol']) {
                                    'Cliente' => '#4facfe',
                                    'Emprendedor' => '#2ecc71',
                                    'Repartidor' => '#f39c12',
                                    'Administrador' => '#e74c3c',
                                    default => '#888'
                                };
                                $display_name = $rol['nombre_rol'] === 'Emprendedor' ? 'Vendedor' : $rol['nombre_rol'];
                            ?>
                            <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="dropdown-item<?= $rol_activo === $rol['nombre_rol'] ? ' active-role' : '' ?>">
                                <span class="role-dot" style="background:<?= $color_rol ?>"></span>
                                <?= $display_name ?>
                                <?php if ($rol_activo === $rol['nombre_rol']): ?><span class="check-mark">&#10003;</span><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        <div class="dropdown-divider"></div>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/perfil" class="dropdown-item"><i class="fas fa-user"></i> Mi Perfil</a>
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesi&oacute;n</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dash-container">
            <?php if ($success): ?>
            <div style="background: var(--surface3); border-left: 3px solid var(--text); padding: 14px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 13px; color: var(--text);">
                ✓ &iexcl;Negocio creado exitosamente! Ahora puedes verlo en "Mis negocios".
            </div>
            <?php endif; ?>
            
            <div class="greeting-wrap" id="greetingWrap">
                <div class="greeting-text" id="greetingText"></div>
            </div>
            
            <?php if ($rol_activo !== 'Cliente' && $rol_activo !== 'Administrador'): ?>
            <div class="stats-grid">
                <div class="stat-card card-businesses">
                    <div class="stat-header">
                        <i class="fas fa-store"></i>
                        <h3>Negocios activos</h3>
                    </div>
                    <div class="value"><?= $stats['total_negocios'] ?></div>
                </div>
                <div class="stat-card card-users">
                    <div class="stat-header">
                        <i class="fas fa-users"></i>
                        <h3>Usuarios</h3>
                    </div>
                    <div class="value"><?= $stats['total_usuarios'] ?></div>
                </div>
                <div class="stat-card card-products">
                    <div class="stat-header">
                        <i class="fas fa-cube"></i>
                        <h3>Productos</h3>
                    </div>
                    <div class="value"><?= $stats['total_productos'] ?></div>
                </div>
                <div class="stat-card card-earnings">
                    <div class="stat-header">
                        <i class="fas fa-star"></i>
                        <h3>Valoraci&oacute;n</h3>
                    </div>
                    <div class="value">4.8</div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <div class="stats-grid">
                    <div class="stat-card card-businesses">
                        <div class="stat-header">
                            <i class="fas fa-store-alt"></i>
                            <h3>Mis negocios</h3>
                        </div>
                        <div class="value"><?= count($mis_negocios) ?></div>
                        <div class="stat-sub">emprendimientos propios</div>
                    </div>
                    <div class="stat-card card-products">
                        <div class="stat-header">
                            <i class="fas fa-boxes"></i>
                            <h3>Productos totales</h3>
                        </div>
                        <div class="value"><?= $stats['total_productos'] ?></div>
                        <div class="stat-sub">en todos tus negocios</div>
                    </div>
                    <div class="stat-card card-users">
                        <div class="stat-header">
                            <i class="fas fa-users"></i>
                            <h3>Usuarios plataforma</h3>
                        </div>
                        <div class="value"><?= $stats['total_usuarios'] ?></div>
                        <div class="stat-sub">registrados en el sistema</div>
                    </div>
                </div>
                <div class="section-header-row">
                    <h2>Mis negocios</h2>
                    <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-create"><i class="fas fa-plus"></i> Nuevo negocio</a>
                </div>
                <?php if (count($mis_negocios) > 0): ?>
                <div class="biz-grid">
                    <?php $cardIdx = 1; ?>
                    <?php foreach ($mis_negocios as $negocio):
                        $np = $negocio['color_primario'] ?? '#C0392B';
                        $ns = $negocio['color_secundario'] ?? '#2C3E50';
                        $portadaUrl = $negocio['portada'] ?? null;
                        $plantillaId = $negocio['id_plantilla'] ?? 0;
                        $imgSrc = $portadaUrl ? (BASE_URL . '/' . $portadaUrl) : (BASE_URL . '/assets/images/plantillas/plantilla_' . $plantillaId . '.jpg');
                    ?>
                    <div class="biz-card" style="animation-delay:<?= $cardIdx * 0.05 ?>s">
                        <img class="biz-card-img" src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($negocio['nombre_comercial']) ?>" loading="lazy" onerror="this.style.display='none'">
                        <div class="biz-card-body">
                            <div class="biz-card-name"><?= htmlspecialchars($negocio['nombre_comercial']) ?></div>
                            <div class="biz-card-desc"><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 100)) ?></div>
                            <div class="biz-card-tags">
                                <span class="biz-card-tag" style="background:<?= $np ?>15;color:<?= $np ?>"><i class="fas fa-box"></i> <?= $negocio['total_productos'] ?> productos</span>
                                <span class="biz-card-tag" style="background:<?= $ns ?>15;color:<?= $ns ?>"><i class="fas fa-palette"></i> <?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                            </div>
                            <div class="biz-card-actions">
                                <a href="<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>" class="biz-btn biz-btn-primary"><i class="fas fa-eye"></i> Ver</a>
                                <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="biz-btn biz-btn-outline"><i class="fas fa-palette"></i> Estilo</a>
                                <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="biz-btn biz-btn-outline"><i class="fas fa-box"></i> Prod.</a>
                            </div>
                        </div>
                    </div>
                    <?php $cardIdx++; endforeach; ?>
                </div>
                <?php else: ?>
                    <div class="empty-state" style="text-align:center;padding:60px 20px;color:var(--text-dim);grid-column:1/-1;background:var(--card-bg);border:1px solid var(--border);border-radius:4px">
                        <i class="fas fa-store" style="font-size:40px;margin-bottom:12px;opacity:0.25;color:var(--text-muted)"></i>
                        <p style="font-size:15px;margin-bottom:6px">No tienes negocios creados</p>
                        <p style="font-size:12px;color:var(--text-muted);margin-bottom:20px">Elige una plantilla y crea tu primera tienda online</p>
                        <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-square"><i class="fas fa-plus"></i> Crear mi primer negocio</a>
                    </div>
                <?php endif; ?>
                
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <div class="cliente-hero">
                    <div class="cliente-hero-glow"></div>
                    <div class="cliente-hero-glow-2"></div>
                    <div class="cliente-hero-content">

                        <div class="cliente-greeting" id="clienteGreeting"></div>
                        <p class="cliente-subtitle">Explora tiendas, descubre productos únicos y apoya el talento local</p>
                        <div class="cliente-search-wrap">
                            <div class="cliente-search-glow"></div>
                            <div class="cliente-search">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Busca tu próxima tienda favorita..." oninput="filtrarNegocios()">
                            </div>
                        </div>
                        <div class="cliente-toolbar">
                            <div class="cliente-filtros" id="filtrosContainer">
                                <button class="filter-btn active" data-filter="all">Todos</button>
                                <button class="filter-btn" data-filter="recientes">Visitas Recientemente</button>
                                <button class="filter-btn" data-filter="valorados">Mejor valorados</button>
                                <button class="filter-btn" data-filter="nuevos">Nuevos</button>
                            </div>
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="blocks" title="Vista bloques"><i class="fas fa-th-large"></i></button>
                                <button class="view-btn" data-view="list" title="Vista lista"><i class="fas fa-list"></i></button>
                                <button class="view-btn" data-view="hero" title="Vista heroica"><i class="fas fa-image"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="negocios-container" id="negociosContainer">
                    <div class="biz-grid" id="negociosGrid">
                        <?php if (count($otros_negocios) > 0): ?>
                            <?php $cardIdx = 1; ?>
                            <?php foreach ($otros_negocios as $negocio):
                                $np = $negocio['color_primario'] ?? '#C0392B';
                                $ns = $negocio['color_secundario'] ?? '#2C3E50';
                                $portada = $negocio['portada'] ?? null;
                            ?>
                            <div class="biz-card" style="--card-color:<?= $np ?>;animation-delay:<?= $cardIdx * 0.05 ?>s" data-nombre="<?= htmlspecialchars(strtolower($negocio['nombre_comercial'])) ?>" data-id="<?= $negocio['id_emprendimiento'] ?>" onclick="window.location.href='<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>'">
                                <?php if ($portada): ?>
                                <img src="<?= BASE_URL ?>/<?= $portada ?>" alt="" class="biz-card-img" loading="lazy" onerror="this.style.display='none'">
                                <?php else: ?>
                                <div class="biz-card-preview" style="background:linear-gradient(135deg,<?= $np ?>,<?= $ns ?>33)">
                                    <div class="biz-card-colors">
                                        <div class="biz-card-color" style="background:<?= $np ?>;--c:<?= $np ?>"></div>
                                        <div class="biz-card-color" style="background:<?= $ns ?>;--c:<?= $ns ?>"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="biz-card-body">
                                    <div class="biz-card-name"><?= htmlspecialchars($negocio['nombre_comercial']) ?></div>
                                    <div class="biz-card-desc"><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 100)) ?></div>
                                    <div class="biz-card-tags">
                                        <span class="biz-card-tag" style="background:<?= $np ?>15;color:<?= $np ?>"><?= $negocio['total_productos'] ?> productos</span>
                                        <span class="biz-card-tag" style="background:<?= $ns ?>15;color:<?= $ns ?>"><?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php $cardIdx++; endforeach; ?>
                        <?php else: ?>
                            <div class="cliente-empty">
                                <div class="cliente-empty-glow"></div>
                                <div class="cliente-empty-content">
                                    <div class="cliente-empty-icon">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <h3>A&uacute;n no hay negocios disponibles</h3>
                                    <p>Estamos sumando nuevos emprendimientos para ti. Vuelve pronto para descubrir tiendas &uacute;nicas.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
            <?php elseif ($rol_activo === 'Repartidor'):
                $repStats = (new \App\Repositories\PedidoRepository())->getStatsRepartidor((int)$usuario['id']);
            ?>
                <div class="stats-grid" style="max-width:800px;margin-left:auto;margin-right:auto">
                    <div class="stat-card card-orders">
                        <div class="stat-header">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>Pedidos hoy</h3>
                        </div>
                        <div class="value"><?= $repStats['entregas_hoy'] ?? 0 ?></div>
                        <div class="stat-sub">entregas completadas</div>
                    </div>
                    <div class="stat-card card-earnings">
                        <div class="stat-header">
                            <i class="fas fa-coins"></i>
                            <h3>Ganancias hoy</h3>
                        </div>
                        <div class="value">Bs. <?= number_format($repStats['ganancias_hoy'] ?? 0, 2) ?></div>
                        <div class="stat-sub">ingresos del d&iacute;a</div>
                    </div>
                    <div class="stat-card card-margin">
                        <div class="stat-header">
                            <i class="fas fa-motorcycle"></i>
                            <h3>Activos</h3>
                        </div>
                        <div class="value"><?= $repStats['activos'] ?? 0 ?></div>
                        <div class="stat-sub">entregas en curso</div>
                    </div>
                    <div class="stat-card card-cost">
                        <div class="stat-header">
                            <i class="fas fa-history"></i>
                            <h3>Entregas totales</h3>
                        </div>
                        <div class="value"><?= $repStats['entregas_totales'] ?? 0 ?></div>
                        <div class="stat-sub">historial completo</div>
                    </div>
                </div>
                <div style="text-align:center;margin-top:28px">
                    <a href="<?= BASE_URL ?>/dashboard-repartidor" style="display:inline-flex;align-items:center;gap:10px;padding:14px 36px;background:var(--text);color:var(--bg);border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;transition:all 0.2s">
                        <i class="fas fa-motorcycle"></i> Ir a panel de entregas <i class="fas fa-arrow-right" style="font-size:11px"></i>
                    </a>
                </div>

            <?php elseif ($rol_activo === 'Administrador'): ?>
                <!-- Metrics Row 1: Platform scale -->
                <div class="stats-grid">
                    <div class="stat-card card-earnings">
                        <div class="stat-header">
                            <i class="fas fa-crown"></i>
                            <h3>Ganancia total</h3>
                        </div>
                        <div class="value">Bs. <?= number_format($margen_widget['ganancia_total'] ?? 0, 2) ?></div>
                        <div class="stat-sub">beneficio neto acumulado</div>
                    </div>
                    <div class="stat-card card-users">
                        <div class="stat-header">
                            <i class="fas fa-users"></i>
                            <h3>Usuarios totales</h3>
                        </div>
                        <div class="value"><?= $admin_stats['usuarios'] ?? 0 ?></div>
                        <div class="stat-sub">registrados en la plataforma</div>
                    </div>
                    <div class="stat-card card-businesses">
                        <div class="stat-header">
                            <i class="fas fa-store"></i>
                            <h3>Negocios activos</h3>
                        </div>
                        <div class="value"><?= $admin_stats['negocios'] ?? 0 ?></div>
                        <div class="stat-sub">emprendimientos registrados</div>
                    </div>
                    <div class="stat-card card-orders">
                        <div class="stat-header">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>Pedidos</h3>
                        </div>
                        <div class="value"><?= $admin_stats['pedidos'] ?? 0 ?></div>
                        <div class="stat-sub">realizados en la plataforma</div>
                    </div>
                </div>

                <!-- Metrics Row 2: Product details & profitability -->
                <div class="stats-grid">
                    <div class="stat-card card-margin">
                        <div class="stat-header">
                            <i class="fas fa-trophy"></i>
                            <h3>Mejor margen</h3>
                        </div>
                        <div class="value">
                            <?php if (!empty($margen_widget['mejor_producto'])): ?>
                                <?= htmlspecialchars(substr($margen_widget['mejor_producto'], 0, 22)) ?>
                                <span><?= number_format($margen_widget['mejor_margen'] ?? 0, 1) ?>% de margen</span>
                            <?php else: ?>
                                <span style="font-family:var(--font-sans);font-size:12px;font-weight:400;opacity:0.5">Sin datos</span>
                            <?php endif; ?>
                        </div>
                        <div class="stat-sub">producto más rentable</div>
                    </div>
                    <div class="stat-card card-avgmargin">
                        <div class="stat-header">
                            <i class="fas fa-percent" style="color:<?= ($margen_widget['margen_promedio'] ?? 0) >= 30 ? '#6b8f71' : (($margen_widget['margen_promedio'] ?? 0) >= 10 ? '#b8a050' : '#c97c6b') ?>"></i>
                            <h3>Margen promedio</h3>
                        </div>
                        <div class="value" style="color:<?= ($margen_widget['margen_promedio'] ?? 0) >= 30 ? '#6b8f71' : (($margen_widget['margen_promedio'] ?? 0) >= 10 ? '#b8a050' : '#c97c6b') ?>"><?= number_format($margen_widget['margen_promedio'] ?? 0, 1) ?>%</div>
                        <div class="stat-sub">rentabilidad promedio</div>
                    </div>
                    <div class="stat-card card-products">
                        <div class="stat-header">
                            <i class="fas fa-cube"></i>
                            <h3>Productos</h3>
                        </div>
                        <div class="value"><?= $admin_stats['productos'] ?? 0 ?></div>
                        <div class="stat-sub">en catálogo</div>
                    </div>
                    <div class="stat-card card-cost">
                        <div class="stat-header">
                            <i class="fas fa-coins"></i>
                            <h3>Productos con costo</h3>
                        </div>
                        <div class="value"><?= (int)($margen_widget['total_con_costo'] ?? 0) ?></div>
                        <div class="stat-sub">con precio_costo registrado</div>
                    </div>
                </div>

                <!-- Nav actions -->
                <div class="section-header-row">
                    <div style="display:flex;gap:12px;flex-wrap:wrap">
                        <a href="<?= BASE_URL ?>/admin/ventas" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;transition:all 0.2s">
                            <i class="fas fa-chart-line"></i> Ver Ventas
                        </a>
                        <form method="POST" action="<?= BASE_URL ?>/admin/seed-demo" style="margin:0">
                            <button type="submit" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--surface2);color:var(--text);border-radius:10px;border:1px solid var(--border);font-size:13px;font-weight:500;cursor:pointer;transition:all 0.2s">
                                <i class="fas fa-database"></i> Cargar Datos Base
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Messages -->
                <?php if (isset($_SESSION['admin_msg'])): ?>
                    <div class="msg-glass msg-success">
                        <i class="fas fa-check-circle"></i>
                        <?= htmlspecialchars($_SESSION['admin_msg']) ?><?php unset($_SESSION['admin_msg']); ?>
                        <button class="msg-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['admin_error'])): ?>
                    <div class="msg-glass msg-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($_SESSION['admin_error']) ?><?php unset($_SESSION['admin_error']); ?>
                        <button class="msg-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Users -->
                <div id="admin-usuarios" style="margin-bottom:24px;animation:fadeInUp 0.6s var(--ease) both">
                    <div class="section-header-row">
                        <h2>Usuarios</h2>
                        <span style="font-size:10px;color:var(--text-dim);background:var(--card-bg);padding:3px 12px;border-radius:6px;border:1px solid var(--border)"><?= count($admin_usuarios) ?> registrados</span>
                    </div>
                    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;overflow-x:auto;transition:border-color 0.3s">
                        <table class="ventas-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($admin_usuarios as $u): ?>
                                <tr>
                                    <td style="color:var(--text-dim);font-size:12px">#<?= $u['id_usuario'] ?></td>
                                    <td><strong><?= htmlspecialchars($u['nombres'] . ' ' . $u['apellidos']) ?></strong></td>
                                    <td style="color:var(--text-muted);font-size:12px"><?= htmlspecialchars($u['email']) ?></td>
                                    <td>
                                        <?php foreach (explode(',', $u['roles'] ?? '') as $rol):
                                            $rc = trim($rol);
                                            $colorRol = $rc === 'Administrador' ? '#7a7a8a' : ($rc === 'Emprendedor' ? '#6b8f71' : ($rc === 'Cliente' ? '#4facfe' : '#f39c12'));
                                        ?>
                                            <span style="display:inline-block;padding:3px 10px;border-radius:6px;font-size:10px;font-weight:600;background:<?= $colorRol ?>15;color:<?= $colorRol ?>;margin:2px 3px"><?= htmlspecialchars($rc) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php $est = $u['estado'] ?? 'Activo'; ?>
                                        <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px">
                                            <span style="width:7px;height:7px;border-radius:50%;background:<?= strtolower($est) === 'activo' ? '#6b8f71' : (strtolower($est) === 'inactivo' ? '#e74c3c' : '#f39c12') ?>"></span>
                                            <?= $est ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                                            <a href="<?= BASE_URL ?>/admin/editar-usuario?id=<?= $u['id_usuario'] ?>" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:11px;font-weight:500;background:var(--surface2);color:var(--text);text-decoration:none;border:1px solid var(--border);transition:all 0.2s">
                                                <i class="fas fa-pen" style="font-size:10px"></i> Editar
                                            </a>
                                            <?php if ($u['email'] !== 'mikypramos2905@gmail.com'): ?>
                                            <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-usuario" onsubmit="return confirm('Eliminar usuario <?= htmlspecialchars($u['nombres']) ?>?');" style="margin:0">
                                                <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:11px;font-weight:500;background:rgba(231,76,60,0.08);color:#e74c3c;border:1px solid rgba(231,76,60,0.15);cursor:pointer;transition:all 0.2s">
                                                    <i class="fas fa-trash" style="font-size:10px"></i> Eliminar
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Businesses -->
                <div id="admin-negocios" style="margin-bottom:40px;animation:fadeInUp 0.6s var(--ease) both;animation-delay:0.1s">
                    <div class="section-header-row">
                        <h2>Negocios</h2>
                        <span style="font-size:11px;color:var(--text-dim);background:var(--card-bg);padding:4px 14px;border-radius:20px;border:1px solid var(--border)"><?= count($admin_negocios) ?> registrados</span>
                    </div>
                    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;overflow-x:auto;transition:border-color 0.3s">
                        <table class="ventas-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre comercial</th>
                                    <th>Propietario</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($admin_negocios as $n): ?>
                                <tr>
                                    <td style="color:var(--text-dim);font-size:12px">#<?= $n['id_emprendimiento'] ?></td>
                                    <td><strong><?= htmlspecialchars($n['nombre_comercial']) ?></strong></td>
                                    <td style="color:var(--text-muted);font-size:12px"><?= htmlspecialchars($n['propietario_email']) ?></td>
                                    <td>
                                        <?php $estN = $n['estado'] ?? 'Pendiente'; ?>
                                        <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px">
                                            <span style="width:7px;height:7px;border-radius:50%;background:<?= strtolower($estN) === 'aprobado' ? '#6b8f71' : (strtolower($estN) === 'pendiente' ? '#f39c12' : '#e74c3c') ?>"></span>
                                            <?= $estN ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-negocio" onsubmit="return confirm('Eliminar negocio <?= htmlspecialchars($n['nombre_comercial']) ?>?');" style="margin:0">
                                            <input type="hidden" name="id" value="<?= $n['id_emprendimiento'] ?>">
                                            <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:11px;font-weight:500;background:rgba(231,76,60,0.08);color:#e74c3c;border:1px solid rgba(231,76,60,0.15);cursor:pointer;transition:all 0.2s">
                                                <i class="fas fa-trash" style="font-size:10px"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reset -->
                <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:32px;margin-bottom:32px;animation:fadeInUp 0.6s var(--ease) both;animation-delay:0.2s;position:relative;overflow:hidden">
                    <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;border-radius:50%;background:rgba(231,76,60,0.03);pointer-events:none"></div>
                    <div style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap">
                        <div style="flex:1;min-width:200px">
                            <h3 style="font-family:Georgia,var(--font-serif);font-size:20px;font-weight:500;color:var(--text);margin-bottom:8px;display:flex;align-items:center;gap:10px">
                                <span style="width:36px;height:36px;border-radius:10px;background:rgba(231,76,60,0.1);color:#e74c3c;display:flex;align-items:center;justify-content:center;font-size:16px"><i class="fas fa-exclamation-triangle"></i></span>
                                Reiniciar base de datos
                            </h3>
                            <p style="font-size:13px;color:var(--text-dim);line-height:1.6;margin-bottom:0">
                                Esto eliminará TODOS los datos (negocios, productos, pedidos, usuarios no-admin) y reconstruirá la base de datos desde cero. El super administrador se mantendrá. <strong style="color:#e74c3c">Esta acción no se puede deshacer.</strong>
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="<?= BASE_URL ?>/admin/reiniciar-bd" onsubmit="return confirm('ESTAS ABSOLUTAMENTE SEGURO? Se borrarán todos los datos. Escribe RESET para confirmar.');" style="margin-top:20px">
                        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                            <input type="text" name="confirmar" placeholder="Escribe RESET para confirmar" required style="background:var(--input-bg);border:1px solid var(--input-border);border-radius:10px;padding:12px 16px;color:var(--text);font-size:13px;width:100%;max-width:240px;outline:none;transition:all 0.2s;font-family:monospace;letter-spacing:1px">
                            <button type="submit" style="display:inline-flex;align-items:center;gap:8px;background:rgba(231,76,60,0.1);color:#e74c3c;border:1px solid rgba(231,76,60,0.2);padding:12px 24px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.2s">
                                <i class="fas fa-radiation"></i> Reiniciar base de datos
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Notification Panel -->
    <div class="notif-panel-overlay" id="notifOverlay"></div>
    <div class="notif-panel" id="notifPanel">
        <div class="notif-panel-header">
            <h3><i class="fas fa-bell" style="font-size:16px;margin-right:8px;opacity:0.6"></i>Notificaciones</h3>
            <button class="notif-panel-close" id="notifClose">&times;</button>
        </div>
        <div class="notif-panel-body">
            <?php
            $notifications = [];
            $notifColors = [
                'user' => ['color' => '#7eb8da', 'icon' => 'fa-user-plus'],
                'store' => ['color' => '#b8a9d4', 'icon' => 'fa-store'],
                'product' => ['color' => '#d4a8b8', 'icon' => 'fa-cube'],
                'order' => ['color' => '#8fc4b8', 'icon' => 'fa-shopping-bag'],
                'margin' => ['color' => '#d4c078', 'icon' => 'fa-crown'],
                'system' => ['color' => '#a8b4d4', 'icon' => 'fa-shield'],
            ];
            $items = [
                ['type' => 'user', 'title' => 'Nuevo usuario registrado', 'desc' => 'Un nuevo emprendedor se unió a la plataforma', 'time' => 'Hace 2 horas'],
                ['type' => 'store', 'title' => 'Nuevo negocio creado', 'desc' => 'Un emprendedor abrió una nueva tienda online', 'time' => 'Hace 5 horas'],
                ['type' => 'order', 'title' => 'Nuevo pedido recibido', 'desc' => 'Un cliente realizó una compra en la plataforma', 'time' => 'Hace 8 horas'],
                ['type' => 'product', 'title' => 'Producto destacado', 'desc' => 'Se agregaron nuevos productos al catálogo', 'time' => 'Hace 1 día'],
                ['type' => 'margin', 'title' => 'Margen de ganancia actualizado', 'desc' => 'El margen promedio de la plataforma se ha recalculado', 'time' => 'Hace 2 días'],
                ['type' => 'system', 'title' => 'Sistema optimizado', 'desc' => 'Se aplicaron mejoras de rendimiento en la base de datos', 'time' => 'Hace 3 días'],
            ];
            $notifCount = count($items);
            ?>
            <?php if ($notifCount > 0): ?>
                <?php foreach ($items as $i => $item):
                    $c = $notifColors[$item['type']] ?? $notifColors['system'];
                ?>
                <div class="notif-item" style="animation-delay:<?= $i * 0.05 ?>s">
                    <i class="fas <?= $c['icon'] ?>" style="color:<?= $c['color'] ?>"></i>
                    <div class="notif-item-content">
                        <div class="notif-item-title"><?= $item['title'] ?></div>
                        <div class="notif-item-desc"><?= $item['desc'] ?></div>
                        <div class="notif-item-time"><?= $item['time'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="notif-empty">
                    <i class="fas fa-bell"></i>
                    <p>No hay notificaciones nuevas</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu & Sidebar
            var menuBtn = document.getElementById('menuBtn');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
            if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); overlay.addEventListener('click', toggleSidebar); }
            document.querySelectorAll('.sidebar-nav a, .rol-btn').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 769) toggleSidebar();
                    var href = this.getAttribute('href');
                    if (href && href.charAt(0) === '#') {
                        var target = document.getElementById(href.substring(1));
                        if (target) {
                            var offset = 100;
                            var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                            window.scrollTo({ top: top, behavior: 'smooth' });
                        }
                    }
                });
            });
            
            // User dropdown
            var userDropdown = document.getElementById('userDropdown');
            var userTrigger = document.getElementById('userTrigger');
            if (userTrigger) {
                userTrigger.addEventListener('click', function(e) { e.stopPropagation(); userDropdown.classList.toggle('active'); });
                document.addEventListener('click', function() { userDropdown.classList.remove('active'); });
            }

            // Theme toggle
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

            // Notification panel
            var notifBtn = document.getElementById('notifBtn');
            var notifPanel = document.getElementById('notifPanel');
            var notifOverlay = document.getElementById('notifOverlay');
            var notifClose = document.getElementById('notifClose');
            var notifBadge = document.getElementById('notifBadge');
            if (notifBtn && notifPanel) {
                notifBtn.addEventListener('click', function() {
                    notifPanel.classList.add('open');
                    notifOverlay.classList.add('active');
                    if (notifBadge) { notifBadge.classList.remove('show', 'pulse'); }
                });
                function closeNotif() {
                    notifPanel.classList.remove('open');
                    notifOverlay.classList.remove('active');
                }
                if (notifClose) notifClose.addEventListener('click', closeNotif);
                if (notifOverlay) notifOverlay.addEventListener('click', closeNotif);
            }
            if (notifBadge) { notifBadge.classList.add('show', 'pulse'); }

            // Typewriter greeting with 3-second auto-collapse
            var greeting = document.getElementById('greetingText');
            var clienteGreeting = document.getElementById('clienteGreeting');
            
            function typeWriterGreeting(el, text, isAdmin) {
                if (!el) return;
                el.innerHTML = '';
                el.style.whiteSpace = 'pre-wrap';
                var i = 0;
                function typeChar() {
                    if (i < text.length) {
                        var ch = text[i];
                        if (ch === ' ') {
                            el.appendChild(document.createTextNode(' '));
                        } else {
                            var span = document.createElement('span');
                            span.className = 'glow-char';
                            span.textContent = ch;
                            el.appendChild(span);
                        }
                        i++;
                        var delay = 25 + Math.random() * 25;
                        if (ch === ' ' || ch === ',') delay = 40;
                        setTimeout(typeChar, delay);
                    } else {
                        var cursor = document.createElement('span');
                        cursor.className = 'cursor';
                        el.appendChild(cursor);
                        if (isAdmin) {
                            // After typing finishes, wait 3 seconds then collapse
                            setTimeout(function() {
                                cursor.style.display = 'none';
                                el.classList.add('fade-out');
                                setTimeout(function() {
                                    var wrap = document.getElementById('greetingWrap');
                                    if (wrap) {
                                        wrap.style.maxHeight = '0';
                                        wrap.style.marginBottom = '0';
                                        wrap.style.padding = '0';
                                        wrap.style.opacity = '0';
                                    }
                                }, 800);
                            }, 3000);
                        }
                    }
                }
                setTimeout(typeChar, 300);
            }
            
            if (clienteGreeting) {
                typeWriterGreeting(clienteGreeting, 'Descubre el talento boliviano. Encuentra tu pr\u00f3ximo lugar favorito.', false);
            } else if (greeting) {
                typeWriterGreeting(greeting, 'Potencia tu emprendimiento en el mundo digital', true);
            }
        });
    </script>
    <?php if ($rol_activo === 'Cliente'): ?>
    <script>
        function ordenarNegocios(items, criterio) {
            var arr = Array.prototype.slice.call(items);
            arr.sort(function(a, b) {
                if (criterio === 'nuevos') {
                    return parseInt(b.getAttribute('data-id')) - parseInt(a.getAttribute('data-id'));
                } else if (criterio === 'valorados') {
                    return parseInt(b.getAttribute('data-count')) - parseInt(a.getAttribute('data-count'));
                } else if (criterio === 'recientes') {
                    var aTime = parseInt(localStorage.getItem('jacha_visit_' + a.getAttribute('data-id'))) || 0;
                    var bTime = parseInt(localStorage.getItem('jacha_visit_' + b.getAttribute('data-id'))) || 0;
                    return bTime - aTime;
                }
                return 0;
            });
            return arr;
        }

        function aplicarFiltro() {
            var input = document.getElementById('searchInput');
            var filter = input ? input.value.toLowerCase() : '';
            var items = document.querySelectorAll('.negocio-item');
            var activo = document.querySelector('.filter-btn.active');
            var criterio = activo ? activo.getAttribute('data-filter') : 'all';
            var grid = document.getElementById('negociosGrid');

            items.forEach(function(item) { item.classList.remove('hidden'); });

            if (criterio !== 'all') {
                var ordenados = ordenarNegocios(items, criterio);
                ordenados.forEach(function(item) { grid.appendChild(item); });
            }

            items.forEach(function(item) {
                var nombre = item.getAttribute('data-nombre') || '';
                if (nombre.indexOf(filter) === -1) {
                    item.classList.add('hidden');
                }
            });
        }

        function filtrarNegocios() {
            aplicarFiltro();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var viewBtns = document.querySelectorAll('.view-btn');
            var grid = document.getElementById('negociosGrid');
            viewBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    viewBtns.forEach(function(b) { b.classList.remove('active'); });
                    this.classList.add('active');
                    if (grid) {
                        grid.className = 'biz-grid ' + this.getAttribute('data-view') + '-view';
                    }
                });
            });
            var filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(function(b) { b.classList.remove('active'); });
                    this.classList.add('active');
                    aplicarFiltro();
                });
            });
            document.querySelectorAll('.biz-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    if (id) localStorage.setItem('jacha_visit_' + id, Date.now());
                });
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>
