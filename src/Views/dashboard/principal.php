<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .stat-card, .negocio-card, .btn-create, .btn-visitar, .btn-admin { border-radius:4px !important; }
        .negocio-tag { border-radius:3px !important; }
        .btn-create { border-radius:4px !important; }
        .greeting-wrap { overflow:hidden; transition:all 0.6s ease; }
        .greeting-text { font-family:Georgia,var(--font-serif);font-size:26px;font-weight:400;color:var(--text);margin-bottom:20px;min-height:1.2em; }
        .greeting-text .glow-char { display:inline-block;animation:glowPulse 2s ease-in-out infinite;text-shadow:0 0 20px rgba(255,255,255,0.3); }
        .greeting-text .cursor { display:inline-block;width:2px;height:1em;background:var(--text);margin-left:2px;animation:blink 0.8s step-end infinite;vertical-align:text-bottom; }
        .greeting-text.fade-out { opacity:0;transform:translateY(-12px);transition:all 0.8s ease; }
        @keyframes glowPulse { 0%,100%{text-shadow:0 0 20px rgba(255,255,255,0.15)} 50%{text-shadow:0 0 40px rgba(255,255,255,0.35)} }
        @keyframes glowPulseWhite { 0%,100%{text-shadow:0 0 8px rgba(255,255,255,0.15),0 0 20px rgba(255,255,255,0.25),0 0 40px rgba(255,255,255,0.15),0 0 80px rgba(255,255,255,0.08)} 50%{text-shadow:0 0 12px rgba(255,255,255,0.3),0 0 30px rgba(255,255,255,0.4),0 0 60px rgba(255,255,255,0.2),0 0 120px rgba(255,255,255,0.1)} }
        @keyframes blink { 50%{opacity:0} }
        .stat-card .value { text-shadow:0 0 30px rgba(255,255,255,0.05); }
        .mini-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;max-width:720px;margin-left:auto;margin-right:auto; }
        .mini-card { background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:20px;text-align:center; }
        .mini-card .num { font-size:26px;font-weight:600;color:var(--text);font-family:Georgia,var(--font-serif); }
        .mini-card .lbl { font-size:11px;color:var(--text-muted);margin-top:6px;text-transform:uppercase;letter-spacing:0.5px; }
        .emprendedor-cards { display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:8px; }
        .emp-card { background:var(--card-bg);border:1px solid var(--border);border-radius:4px;overflow:hidden;display:flex;flex-direction:column; }
        .emp-card-img { width:100%;height:140px;object-fit:cover;display:block;border-bottom:1px solid var(--border);background:var(--card-bg); }
        .emp-card-body { padding:24px;flex:1;display:flex;flex-direction:column; }
        .emp-card-name { font-size:17px;font-weight:600;color:var(--text);font-family:Georgia,var(--font-serif);margin-bottom:4px; }
        .emp-card-desc { font-size:12px;color:var(--text-dim);line-height:1.5;margin-bottom:16px;flex:1; }
        .emp-card-meta { display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px; }
        .emp-tag { display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:3px;font-size:10px;font-weight:500;background:rgba(128,128,128,0.06);color:var(--text-muted); }
        .emp-tag i { font-size:10px; }
        .emp-card-actions { display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px; }
        .emp-btn { display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px;border-radius:3px;font-size:11px;font-weight:500;text-decoration:none;transition:all .15s;cursor:pointer;border:none;font-family:var(--font-sans); }
        .emp-btn:hover { opacity:0.8; }
        .emp-btn-primary { background:var(--text);color:var(--bg); }
        .emp-btn-outline { background:transparent;border:1px solid var(--border);color:var(--text-muted); }
        .emp-btn-outline:hover { border-color:var(--border-hi);color:var(--text); }
        .admin-table { width:100%; border-collapse:collapse; }
        .admin-table th, .admin-table td { vertical-align:middle; }
        .admin-table th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); }
        .admin-table td { padding:14px 20px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); }
        .admin-table tbody tr:last-child td { border-bottom:none; }
        .admin-table tbody tr:hover { background:rgba(255,255,255,0.015); }
        @media(max-width:768px){
            .emprendedor-cards{grid-template-columns:1fr;}
            .mini-grid{max-width:100%;}
        }
        .activity-list { background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:16px;margin-bottom:24px; }
        .activity-item { display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--text-muted); }
        .activity-item:last-child { border-bottom:none; }
        .activity-dot { width:8px;height:8px;border-radius:50%;flex-shrink:0; }
        .activity-item strong { color:var(--text);font-weight:500; }
        .btn-square { display:inline-block;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:4px;text-decoration:none;font-size:13px;font-weight:600; }
        .btn-square:hover { }
        [data-theme="dark"] .greeting-text .glow-char { text-shadow:0 0 25px rgba(255,255,255,0.25); }
        [data-theme="light"] .greeting-text .glow-char { text-shadow:0 0 20px rgba(0,0,0,0.08); }
        [data-theme="dark"] .cliente-greeting .glow-char { text-shadow:0 0 8px rgba(255,255,255,0.2),0 0 25px rgba(255,255,255,0.3),0 0 50px rgba(255,255,255,0.15),0 0 100px rgba(255,255,255,0.08); }
        [data-theme="light"] .cliente-greeting .glow-char { text-shadow:0 0 6px rgba(255,255,255,0.5),0 0 16px rgba(255,255,255,0.3),0 0 30px rgba(255,255,255,0.15); }
        [data-theme="light"] .sidebar-header img { filter:brightness(0); }
        .cliente-header { margin-bottom:24px; }
        .cliente-greeting { font-family:Georgia,var(--font-serif);font-size:26px;font-weight:400;color:var(--text);min-height:2em; }
        .cliente-greeting .glow-char { display:inline-block;animation:glowPulseWhite 2.5s ease-in-out infinite;text-shadow:0 0 8px rgba(255,255,255,0.15),0 0 20px rgba(255,255,255,0.25),0 0 40px rgba(255,255,255,0.15),0 0 80px rgba(255,255,255,0.08); }
        .cliente-greeting .cursor { display:inline-block;width:3px;height:1.1em;background:var(--text);margin-left:3px;animation:blink 0.8s step-end infinite;vertical-align:text-bottom; }
        .cliente-toolbar { margin-bottom:28px; }
        .cliente-search { display:flex;align-items:center;gap:10px;background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:0 14px;margin-bottom:14px; }
        .cliente-search:focus-within { border-color:var(--border-hi); }
        .cliente-search i { color:var(--text-dim);font-size:14px; }
        .cliente-search input { width:100%;background:none;border:none;padding:12px 0;font-size:14px;color:var(--text);outline:none;font-family:var(--font-sans); }
        .cliente-search input::placeholder { color:var(--text-dim); }
        .cliente-view-actions { display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
        .cliente-filtros { display:flex;gap:6px;flex-wrap:wrap; }
        .filter-btn { padding:6px 16px;border-radius:3px;border:1px solid var(--border);background:transparent;color:var(--text-muted);font-size:12px;font-weight:500;cursor:pointer;font-family:var(--font-sans); }
        .filter-btn:hover { border-color:var(--border-hi);color:var(--text);background:var(--glow); }
        .filter-btn.active { background:var(--text);color:var(--bg);border-color:var(--text); }
        .view-toggle { display:flex;gap:4px;background:var(--card-bg);border:1px solid var(--border);border-radius:3px;padding:3px; }
        .view-btn { width:32px;height:28px;border:none;border-radius:3px;background:transparent;color:var(--text-dim);font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center; }
        .view-btn:hover { color:var(--text-muted); }
        .view-btn.active { background:var(--surface3);color:var(--text); }
        .negocios-container { width:100%; }
        .negocios-grid.blocks-view { display:grid;grid-template-columns:repeat(3,1fr);gap:20px; }
        .negocios-grid.list-view { display:flex;flex-direction:column;gap:12px; }
        .negocios-grid.list-view .negocio-card { display:flex;flex-direction:row;overflow:hidden;border-radius:4px;border:1px solid var(--border);background:var(--card-bg); }
        .negocios-grid.list-view .negocio-card:hover { border-color:var(--border-hi); }
        .negocios-grid.list-view .negocio-link { display:flex;flex-direction:row;text-decoration:none;color:inherit;width:100%; }
        .negocios-grid.list-view .negocio-portada,
        .negocios-grid.list-view .negocio-preview { width:200px;min-height:150px;flex-shrink:0;border-radius:0;margin:0; }
        .negocios-grid.list-view .negocio-preview .negocio-mockup { padding:12px; }
        .negocios-grid.list-view .negocio-info { flex:1;padding:16px 20px;display:flex;flex-direction:column;justify-content:center; }
        .negocios-grid.list-view .negocio-info h3 { font-size:17px;margin-bottom:4px; }
        .negocios-grid.list-view .negocio-info p { font-size:13px;margin-bottom:8px; }
        .negocio-card .negocio-link { text-decoration:none;color:inherit;display:block; }
        .negocio-portada { width:100%;height:160px;background-size:cover;background-position:center;border-bottom:1px solid var(--border); }
        .negocios-grid.blocks-view .negocio-card { cursor:pointer;background:var(--card-bg);border:1px solid var(--border);border-radius:4px;overflow:hidden; }
        .negocios-grid.blocks-view .negocio-card:hover { border-color:var(--border-hi); }
        .negocios-grid.hero-view { display:flex;flex-direction:column;gap:20px; }
        .negocios-grid.hero-view .negocio-card { border-radius:4px;overflow:hidden;border:1px solid var(--border);background:var(--card-bg);position:relative; }
        .negocios-grid.hero-view .negocio-card:hover { border-color:var(--border-hi); }
        .negocios-grid.hero-view .negocio-link { position:relative; }
        .negocios-grid.hero-view .negocio-portada,
        .negocios-grid.hero-view .negocio-preview { width:100%;height:360px;border-radius:0;margin:0;border-bottom:none;position:relative; }
        .negocios-grid.hero-view .negocio-preview { display:flex;align-items:center;justify-content:center; }
        .negocios-grid.hero-view .negocio-preview .negocio-mockup { display:none; }
        .negocios-grid.hero-view .negocio-info { position:absolute;bottom:0;left:0;right:0;padding:50px 28px 24px;background:linear-gradient(transparent,rgba(0,0,0,0.75)); }
        .negocios-grid.hero-view .negocio-info h3 { font-size:26px;color:#fff;margin-bottom:4px;text-shadow:0 2px 8px rgba(0,0,0,0.3); }
        .negocios-grid.hero-view .negocio-info p { font-size:14px;color:rgba(255,255,255,0.85);margin-bottom:12px;text-shadow:0 1px 4px rgba(0,0,0,0.2); }
        .negocios-grid.hero-view .negocio-badges { display:flex;gap:8px;flex-wrap:wrap; }
        .negocios-grid.hero-view .negocio-tag { background:rgba(255,255,255,0.18) !important;color:#fff !important;font-size:11px;padding:4px 16px;backdrop-filter:blur(4px); }
        [data-theme="light"] .negocios-grid.hero-view .negocio-info { background:linear-gradient(transparent,rgba(0,0,0,0.7)); }
        .negocios-grid.blocks-view .negocio-info { padding:16px 18px; }
        .negocios-grid.blocks-view .negocio-info h3 { font-size:16px;font-weight:600;color:var(--text);margin-bottom:4px; }
        .negocios-grid.blocks-view .negocio-info p { font-size:12px;color:var(--text-muted);margin-bottom:10px;line-height:1.5; }
        .negocios-grid.blocks-view .negocio-badges { display:flex;gap:6px;flex-wrap:wrap; }
        .negocios-grid.blocks-view .negocio-tag { font-size:10px;padding:3px 10px;border-radius:3px;display:inline-block; }
        .negocios-grid .negocio-item.hidden { display:none !important; }
        .negocios-grid.list-view .negocio-item.hidden { display:none !important; }
        .negocios-grid.hero-view .negocio-item.hidden { display:none !important; }
        .empty-state { grid-column:1/-1; }
        @media(max-width:900px){
            .perfil-grid{grid-template-columns:1fr;}
            .emprendedor-cards{grid-template-columns:1fr;}
            .mini-grid{max-width:100%;}
        }
        @media(max-width:768px){
            .negocios-grid.blocks-view { grid-template-columns:1fr; }
            .negocios-grid.list-view .negocio-portada,
            .negocios-grid.list-view .negocio-preview { width:120px;min-height:120px; }
            .negocios-grid.list-view .negocio-info { padding:12px 14px; }
            .negocios-grid.hero-view .negocio-portada,
            .negocios-grid.hero-view .negocio-preview { height:240px; }
            .negocios-grid.hero-view .negocio-info { padding:36px 18px 16px; }
            .negocios-grid.hero-view .negocio-info h3 { font-size:20px; }
            .negocios-grid.hero-view .negocio-info p { font-size:13px; }
            .cliente-view-actions { flex-direction:column;align-items:stretch; }
            .cliente-filtros { justify-content:center; }
            .view-toggle { align-self:flex-end; }
            .cliente-greeting { font-size:20px; }
            .cliente-header { margin-bottom:16px; }
            .cliente-toolbar { margin-bottom:20px; }
            #admin-usuarios > div:last-child, #admin-negocios > div:last-child { overflow-x:auto; }
            .admin-table th, .admin-table td { padding:10px 12px; white-space:nowrap; }
            .stats-grid { grid-template-columns:repeat(2,1fr); }
        }
        @media(max-width:480px){
            .admin-table td > div { flex-direction:column; }
        }
        @media(max-width:480px){
            .negocios-grid.hero-view .negocio-portada,
            .negocios-grid.hero-view .negocio-preview { height:200px; }
            .negocios-grid.hero-view .negocio-info { padding:28px 14px 12px; }
            .negocios-grid.hero-view .negocio-info h3 { font-size:17px; }
            .negocios-grid.hero-view .negocio-info p { font-size:12px; }
            .cliente-greeting { font-size:17px; }
            .cliente-search input { font-size:13px; }
            .filter-btn { font-size:11px;padding:5px 12px; }
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
            <a href="<?= BASE_URL ?>/dashboard" class="active"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9632;</span> Dashboard</a>
            <?php if ($rol_activo === 'Administrador'): ?>
                <a href="#admin-usuarios"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Usuarios</a>
                <a href="#admin-negocios"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Negocios</a>
                <a href="<?= BASE_URL ?>/admin/ventas"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Ventas</a>
            <?php elseif ($rol_activo === 'Emprendedor'): ?>
                <a href="<?= BASE_URL ?>/productos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Productos</a>
                <a href="<?= BASE_URL ?>/gestionar-negocios"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Gestionar negocios</a>
                <a href="<?= BASE_URL ?>/repartidores-admin"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Repartidores</a>
                <a href="<?= BASE_URL ?>/plantillas-disponibles"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Nuevo negocio</a>
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <a href="<?= BASE_URL ?>/mis-estadisticas"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Mis estad&iacute;sticas</a>
                <a href="<?= BASE_URL ?>/mis-pedidos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Mis pedidos</a>
                <a href="<?= BASE_URL ?>/favoritos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9829;</span> Favoritos</a>
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <a href="<?= BASE_URL ?>/dashboard-repartidor"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Entregas</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" style="margin-top: 40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesi&oacute;n</a>
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
                            $display_name = $rol['nombre_rol'] === 'Emprendedor' ? 'Vendedor' : $rol['nombre_rol'];
                        ?>
                        <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="dropdown-item" style="<?= $rol_activo === $rol['nombre_rol'] ? 'color:var(--text);font-weight:600' : '' ?>">
                            <span style="width:8px;height:8px;border-radius:50%;display:inline-block;background:<?= $color_rol ?>"></span>
                            <?= $display_name ?>
                            <?php if ($rol_activo === $rol['nombre_rol']): ?><span style="margin-left:auto;font-size:10px">✓</span><?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    <div style="border-top:1px solid var(--border);margin:4px 0"></div>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                    <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout">Cerrar sesi&oacute;n</a>
                </div>
            </div>
        </div>
        </div>
        
        <div class="dash-container">
            <?php if ($success): ?>
            <div style="background: rgba(255,255,255,0.05); border-left: 3px solid #fff; padding: 14px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 13px; color: #fff;">
                ✓ &iexcl;Negocio creado exitosamente! Ahora puedes verlo en "Mis negocios".
            </div>
            <?php endif; ?>
            
            <div class="greeting-wrap" id="greetingWrap">
                <div class="greeting-text" id="greetingText"></div>
            </div>
            
            <?php if ($rol_activo !== 'Cliente' && $rol_activo !== 'Administrador'): ?>
            <div class="stats-grid">
                <div class="stat-card"><h3>Negocios activos</h3><div class="value"><?= $stats['total_negocios'] ?></div></div>
                <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $stats['total_usuarios'] ?></div></div>
                <div class="stat-card"><h3>Productos</h3><div class="value"><?= $stats['total_productos'] ?></div></div>
                <div class="stat-card"><h3>Valoraci&oacute;n</h3><div class="value">4.8</div></div>
            </div>
            <?php endif; ?>
            
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <div class="mini-grid">
                    <div class="mini-card"><div class="num"><?= count($mis_negocios) ?></div><div class="lbl">Mis negocios</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_productos'] ?></div><div class="lbl">Productos totales</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_usuarios'] ?></div><div class="lbl">Usuarios en plataforma</div></div>
                </div>
                <div class="section-header-row">
                    <h2>Mis negocios</h2>
                    <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-create"><i class="fas fa-plus"></i> Nuevo negocio</a>
                </div>
                <?php if (count($mis_negocios) > 0): ?>
                <div class="emprendedor-cards">
                    <?php foreach ($mis_negocios as $negocio):
                        $np = $negocio['color_primario'] ?? '#C0392B';
                        $ns = $negocio['color_secundario'] ?? '#2C3E50';
                        $portadaUrl = $negocio['portada'] ?? null;
                        $plantillaId = $negocio['id_plantilla'] ?? 0;
                        $imgSrc = $portadaUrl ? (BASE_URL . '/' . $portadaUrl) : (BASE_URL . '/assets/images/plantillas/plantilla_' . $plantillaId . '.jpg');
                    ?>
                    <div class="emp-card">
                        <img class="emp-card-img" src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($negocio['nombre_comercial']) ?>" loading="lazy">
                        <div class="emp-card-body">
                            <div class="emp-card-name"><?= htmlspecialchars($negocio['nombre_comercial']) ?></div>
                            <div class="emp-card-desc"><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 80)) ?><?= strlen($negocio['descripcion'] ?? '') > 80 ? '...' : '' ?></div>
                            <div class="emp-card-meta">
                                <span class="emp-tag" style="background:<?= $np ?>12;color:<?= $np ?>"><i class="fas fa-box"></i> <?= $negocio['total_productos'] ?> productos</span>
                                <span class="emp-tag" style="background:<?= $ns ?>12;color:<?= $ns ?>"><i class="fas fa-palette"></i> <?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                            </div>
                            <div class="emp-card-actions">
                                <a href="<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>" class="emp-btn emp-btn-primary"><i class="fas fa-eye"></i> Ver</a>
                                <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="emp-btn emp-btn-outline"><i class="fas fa-palette"></i> Estilo</a>
                                <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="emp-btn emp-btn-outline"><i class="fas fa-box"></i> Prod.</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
                <div class="cliente-header">
                    <div class="cliente-greeting" id="clienteGreeting"></div>
                </div>
                <div class="cliente-toolbar">
                    <div class="cliente-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Buscar negocios por nombre..." oninput="filtrarNegocios()">
                    </div>
                    <div class="cliente-view-actions">
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
                <div class="negocios-container" id="negociosContainer">
                    <div class="negocios-grid blocks-view" id="negociosGrid">
                        <?php if (count($otros_negocios) > 0): ?>
                            <?php foreach ($otros_negocios as $negocio):
                                $np = $negocio['color_primario'] ?? '#C0392B';
                                $ns = $negocio['color_secundario'] ?? '#2C3E50';
                                $nt = $negocio['color_texto'] ?? '#1A1A2E';
                                $portada = $negocio['portada'] ?? null;
                                $tipografia = $negocio['tipografia'] ?? 'Inter';
                                $telefono = $negocio['telefono'] ?? '';
                            ?>
                            <div class="negocio-card negocio-item" data-nombre="<?= htmlspecialchars(strtolower($negocio['nombre_comercial'])) ?>" data-id="<?= $negocio['id_emprendimiento'] ?>" data-count="<?= $negocio['total_productos'] ?>">
                                <a href="<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>" class="negocio-link">
                                    <?php if ($portada): ?>
                                    <div class="negocio-portada" style="background-image:url('<?= BASE_URL ?>/<?= $portada ?>')"></div>
                                    <?php else: ?>
                                    <div class="negocio-preview" style="background:linear-gradient(135deg,<?= $np ?>,<?= $ns ?>)">
                                        <div class="negocio-mockup">
                                            <div class="mockup-bar" style="background:rgba(0,0,0,0.2)"></div>
                                            <div class="mockup-hero">
                                                <div class="mockup-title"><?= htmlspecialchars(substr($negocio['nombre_comercial'], 0, 12)) ?></div>
                                                <div class="mockup-line" style="width:60%"></div>
                                                <div class="mockup-line" style="width:40%"></div>
                                            </div>
                                            <div class="mockup-grid">
                                                <div class="mockup-item"></div>
                                                <div class="mockup-item"></div>
                                                <div class="mockup-item"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="negocio-info">
                                        <h3 style="font-family:'<?= $tipografia ?>',sans-serif"><?= htmlspecialchars($negocio['nombre_comercial']) ?></h3>
                                        <p><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 80)) ?><?= strlen($negocio['descripcion'] ?? '') > 80 ? '...' : '' ?></p>
                                        <div class="negocio-badges">
                                            <span class="negocio-tag" style="background:<?= $np ?>15;color:<?= $np ?>"><?= $negocio['total_productos'] ?> productos</span>
                                            <span class="negocio-tag" style="background:<?= $ns ?>15;color:<?= $ns ?>"><?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state" style="text-align:center;padding:60px 20px;color:var(--text-dim);grid-column:1/-1;background:var(--card-bg);border:1px solid var(--border);border-radius:4px">
                                <i class="fas fa-store" style="font-size:40px;margin-bottom:12px;opacity:0.25;color:var(--text-muted)"></i>
                                <p style="font-size:15px;margin-bottom:6px">No hay negocios disponibles a&uacute;n</p>
                                <p style="font-size:12px;color:var(--text-muted)">Vuelve m&aacute;s tarde para descubrir nuevas tiendas</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
            <?php elseif ($rol_activo === 'Repartidor'):
                $repStats = (new \App\Repositories\PedidoRepository())->getStatsRepartidor((int)$usuario['id']);
            ?>
                <div class="stats-grid" style="max-width:800px;margin-left:auto;margin-right:auto">
                    <div class="stat-card"><h3>Pedidos hoy</h3><div class="value"><?= $repStats['entregas_hoy'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Ganancias hoy</h3><div class="value">Bs. <?= number_format($repStats['ganancias_hoy'] ?? 0, 2) ?></div></div>
                    <div class="stat-card"><h3>Activos</h3><div class="value"><?= $repStats['activos'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Entregas totales</h3><div class="value"><?= $repStats['entregas_totales'] ?? 0 ?></div></div>
                </div>
                <div style="text-align:center;margin-top:24px">
                    <a href="<?= BASE_URL ?>/dashboard-repartidor" style="display:inline-flex;align-items:center;gap:10px;padding:14px 36px;background:var(--text);color:var(--bg);border-radius:4px;text-decoration:none;font-size:14px;font-weight:600">
                        <i class="fas fa-motorcycle"></i> Ir a panel de entregas <i class="fas fa-arrow-right" style="font-size:11px"></i>
                    </a>
                </div>

            <?php elseif ($rol_activo === 'Administrador'): ?>
                <!-- Statistics -->
                <div class="stats-grid" style="margin-bottom:32px">
                    <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $admin_stats['usuarios'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Negocios</h3><div class="value"><?= $admin_stats['negocios'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Productos</h3><div class="value"><?= $admin_stats['productos'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Pedidos</h3><div class="value"><?= $admin_stats['pedidos'] ?? 0 ?></div></div>
                </div>

                <!-- Nav actions -->
                <div class="section-header-row" style="margin-bottom:24px">
                    <a href="<?= BASE_URL ?>/admin/ventas" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:4px;text-decoration:none;font-size:13px;font-weight:600">
                        <i class="fas fa-chart-line"></i> Ver Ventas
                    </a>
                    <form method="POST" action="<?= BASE_URL ?>/admin/seed-demo" style="margin:0">
                        <button type="submit" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:4px;border:none;font-size:13px;font-weight:600;cursor:pointer">
                            <i class="fas fa-database"></i> Cargar Datos Base
                        </button>
                    </form>
                </div>

                <!-- Messages -->
                <?php if (isset($_SESSION['admin_msg'])): ?>
                    <div style="background:rgba(107,143,113,0.1);border-left:3px solid #6b8f71;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#6b8f71;display:flex;align-items:center;gap:10px">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['admin_msg']) ?><?php unset($_SESSION['admin_msg']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['admin_error'])): ?>
                    <div style="background:rgba(154,90,90,0.1);border-left:3px solid #9a5a5a;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#9a5a5a;display:flex;align-items:center;gap:10px">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['admin_error']) ?><?php unset($_SESSION['admin_error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Users -->
                <div id="admin-usuarios" style="margin-bottom:40px">
                    <div class="section-header-row">
                        <h2>Usuarios</h2>
                        <span style="font-size:12px;color:var(--text-dim);background:var(--card-bg);padding:4px 12px;border-radius:3px;border:1px solid var(--border)"><?= count($admin_usuarios) ?> registrados</span>
                    </div>
                    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:4px;overflow-x:auto">
                        <table class="admin-table">
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
                                            $colorRol = $rc === 'Administrador' ? '#7a7a8a' : ($rc === 'Emprendedor' ? '#6b8f71' : ($rc === 'Cliente' ? '#8a8a6a' : '#7b7f8f'));
                                        ?>
                                            <span style="display:inline-block;padding:3px 10px;border-radius:3px;font-size:10px;font-weight:600;background:rgba(128,128,128,0.08);color:var(--text-muted);margin:2px 3px"><?= htmlspecialchars($rc) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php $est = $u['estado'] ?? 'Activo'; ?>
                                        <span style="display:inline-flex;align-items:center;gap:6px">
                                            <span style="width:8px;height:8px;border-radius:50%;background:<?= strtolower($est) === 'activo' ? '#6b8f71' : (strtolower($est) === 'inactivo' ? '#9a5a5a' : '#9a8a4a') ?>"></span>
                                            <?= $est ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                                            <a href="<?= BASE_URL ?>/admin/editar-usuario?id=<?= $u['id_usuario'] ?>" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:3px;font-size:11px;font-weight:600;background:var(--surface2);color:var(--text);text-decoration:none">
                                                <i class="fas fa-pen" style="font-size:10px"></i> Editar
                                            </a>
                                            <?php if ($u['email'] !== 'mikypramos2905@gmail.com'): ?>
                                            <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-usuario" onsubmit="return confirm('Eliminar usuario <?= htmlspecialchars($u['nombres']) ?>?');" style="margin:0">
                                                <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:3px;font-size:11px;font-weight:600;background:rgba(154,90,90,0.08);color:#9a5a5a;border:1px solid rgba(154,90,90,0.15);cursor:pointer">
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
                <div id="admin-negocios" style="margin-bottom:40px">
                    <div class="section-header-row">
                        <h2>Negocios</h2>
                        <span style="font-size:12px;color:var(--text-dim);background:var(--card-bg);padding:4px 12px;border-radius:3px;border:1px solid var(--border)"><?= count($admin_negocios) ?> registrados</span>
                    </div>
                    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:4px;overflow-x:auto">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre comercial</th>
                                    <th>Propietario</th>
                                    <th>Estado</th>
                                    <th>Accion</th>
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
                                        <span style="display:inline-flex;align-items:center;gap:6px">
                                            <span style="width:8px;height:8px;border-radius:50%;background:<?= strtolower($estN) === 'aprobado' ? '#6b8f71' : (strtolower($estN) === 'pendiente' ? '#9a8a4a' : '#9a5a5a') ?>"></span>
                                            <?= $estN ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-negocio" onsubmit="return confirm('Eliminar negocio <?= htmlspecialchars($n['nombre_comercial']) ?>?');" style="margin:0">
                                            <input type="hidden" name="id" value="<?= $n['id_emprendimiento'] ?>">
                                            <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:3px;font-size:11px;font-weight:600;background:rgba(154,90,90,0.08);color:#9a5a5a;border:1px solid rgba(154,90,90,0.15);cursor:pointer">
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
                <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:4px;padding:32px;margin-bottom:32px">
                    <h3 style="font-family:Georgia,var(--font-serif);font-size:22px;font-weight:500;color:var(--text);margin-bottom:6px">
                        <i class="fas fa-exclamation-triangle" style="color:#9a5a5a;margin-right:10px"></i>Reiniciar base de datos
                    </h3>
                    <p style="font-size:13px;color:var(--text-dim);margin-bottom:20px;line-height:1.6">
                        Esto eliminara TODOS los datos (negocios, productos, pedidos, usuarios no-admin) y reconstruira la base de datos desde cero. El super administrador se mantendra. <strong style="color:#9a5a5a">Esta accion no se puede deshacer.</strong>
                    </p>
                    <form method="POST" action="<?= BASE_URL ?>/admin/reiniciar-bd" onsubmit="return confirm('ESTAS ABSOLUTAMENTE SEGURO? Se borraran todos los datos. Escribe RESET para confirmar.');">
                        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                            <input type="text" name="confirmar" placeholder="Escribe RESET para confirmar" required style="background:var(--card-bg);border:1px solid var(--border);border-radius:3px;padding:12px 16px;color:var(--text);font-size:13px;width:200px;outline:none">
                            <button type="submit" style="display:inline-flex;align-items:center;gap:8px;background:rgba(154,90,90,0.08);color:#9a5a5a;border:1px solid rgba(154,90,90,0.15);padding:12px 28px;border-radius:3px;font-size:13px;font-weight:600;cursor:pointer">
                                <i class="fas fa-radiation"></i> Reiniciar base de datos
                            </button>
                        </div>
                    </form>
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

            // Typewriter greeting - different per role
            var greeting = document.getElementById('greetingText');
            var clienteGreeting = document.getElementById('clienteGreeting');
            
            function typeWriterGreeting(el, text, fadeOut) {
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
                        var delay = 30 + Math.random() * 30;
                        if (ch === ' ' || ch === ',') delay = 50;
                        setTimeout(typeChar, delay);
                    } else if (fadeOut) {
                        var cursor = document.createElement('span');
                        cursor.className = 'cursor';
                        el.appendChild(cursor);
                        setTimeout(function() {
                            cursor.style.display = 'none';
                            el.classList.add('fade-out');
                            setTimeout(function() {
                                var wrap = document.getElementById('greetingWrap');
                                if (wrap) {
                                    wrap.style.maxHeight = '0';
                                    wrap.style.marginBottom = '0';
                                    wrap.style.padding = '0';
                                }
                            }, 800);
                        }, 1800);
                    }
                }
                setTimeout(typeChar, 400);
            }
            
            if (clienteGreeting) {
                typeWriterGreeting(clienteGreeting, 'Descubre los mejores negocios bolivianos y apoya el talento local', false);
            } else if (greeting) {
                var nombre = '<?= htmlspecialchars(($usuario['nombre'] ?? ''), ENT_QUOTES) ?>';
                typeWriterGreeting(greeting, 'Hola, ' + nombre, true);
            }
        })();
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
                        grid.className = 'negocios-grid ' + this.getAttribute('data-view') + '-view';
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
            document.querySelectorAll('.negocio-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    var item = this.closest('.negocio-item');
                    if (item) {
                        var id = item.getAttribute('data-id');
                        if (id) localStorage.setItem('jacha_visit_' + id, Date.now());
                    }
                });
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>
