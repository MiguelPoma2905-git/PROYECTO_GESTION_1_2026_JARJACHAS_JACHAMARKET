<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .stat-card, .negocio-card, .btn-create, .btn-visitar, .btn-admin { border-radius:8px !important; }
        .negocio-tag { border-radius:6px !important; }
        .btn-create { border-radius:8px !important; }
        .greeting-wrap { overflow:hidden; transition:all 0.6s ease; }
        .greeting-text { font-family:Georgia,var(--font-serif);font-size:26px;font-weight:400;color:var(--text);margin-bottom:20px;min-height:1.2em; }
        .greeting-text .glow-char { display:inline-block;animation:glowPulse 2s ease-in-out infinite;text-shadow:0 0 20px rgba(255,255,255,0.3); }
        .greeting-text .cursor { display:inline-block;width:2px;height:1em;background:var(--text);margin-left:2px;animation:blink 0.8s step-end infinite;vertical-align:text-bottom; }
        .greeting-text.fade-out { opacity:0;transform:translateY(-12px);transition:all 0.8s ease; }
        @keyframes glowPulse { 0%,100%{text-shadow:0 0 20px rgba(255,255,255,0.15)} 50%{text-shadow:0 0 40px rgba(255,255,255,0.35)} }
        @keyframes blink { 50%{opacity:0} }
        .stat-card .value { text-shadow:0 0 30px rgba(255,255,255,0.05); }
        .mini-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px; }
        .mini-card { background:var(--card-bg);border:1px solid var(--border);border-radius:8px;padding:16px;text-align:center;transition:all .2s; }
        .mini-card:hover { border-color:var(--border-hi);transform:translateY(-2px);box-shadow:var(--shadow-md); }
        .mini-card .num { font-size:22px;font-weight:600;color:var(--text);font-family:Georgia,var(--font-serif); }
        .mini-card .lbl { font-size:11px;color:var(--text-muted);margin-top:4px;text-transform:uppercase;letter-spacing:0.3px; }
        .activity-list { background:var(--card-bg);border:1px solid var(--border);border-radius:8px;padding:16px;margin-bottom:24px; }
        .activity-item { display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--text-muted); }
        .activity-item:last-child { border-bottom:none; }
        .activity-dot { width:8px;height:8px;border-radius:50%;flex-shrink:0; }
        .activity-item strong { color:var(--text);font-weight:500; }
        .btn-square { display:inline-block;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;transition:all .2s; }
        .btn-square:hover { transform:translateY(-2px);box-shadow:0 6px 20px var(--glow-lg); }
        [data-theme="dark"] .greeting-text .glow-char { text-shadow:0 0 25px rgba(255,255,255,0.25); }
        [data-theme="light"] .greeting-text .glow-char { text-shadow:0 0 20px rgba(0,0,0,0.08); }
        [data-theme="light"] .sidebar-header img { filter:brightness(0); }
        @media(max-width:768px){ .mini-grid{grid-template-columns:1fr} }
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
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <a href="<?= BASE_URL ?>/plantillas-disponibles"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Nuevo negocio</a>
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <a href="<?= BASE_URL ?>/mis-pedidos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Mis pedidos</a>
                <a href="<?= BASE_URL ?>/favoritos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9829;</span> Favoritos</a>
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <a href="<?= BASE_URL ?>/dashboard-repartidor"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Entregas</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/perfil"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Configuraci&oacute;n</a>
            <?php if ($es_admin): ?>
            <a href="<?= BASE_URL ?>/admin" style="color: #3498DB;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Administraci&oacute;n</a>
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
            <div style="background: rgba(255,255,255,0.05); border-left: 3px solid #fff; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #fff;">
                ✓ &iexcl;Negocio creado exitosamente! Ahora puedes verlo en "Mis negocios".
            </div>
            <?php endif; ?>
            
            <div class="greeting-wrap" id="greetingWrap">
                <div class="greeting-text" id="greetingText"></div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card"><h3>Negocios activos</h3><div class="value"><?= $stats['total_negocios'] ?></div></div>
                <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $stats['total_usuarios'] ?></div></div>
                <div class="stat-card"><h3>Productos</h3><div class="value"><?= $stats['total_productos'] ?></div></div>
                <div class="stat-card"><h3>Valoraci&oacute;n</h3><div class="value">4.8</div></div>
            </div>
            
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <div class="mini-grid">
                    <div class="mini-card"><div class="num"><?= count($mis_negocios) ?></div><div class="lbl">Mis negocios</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_productos'] ?></div><div class="lbl">Productos totales</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_usuarios'] ?></div><div class="lbl">Usuarios en plataforma</div></div>
                </div>
                <div class="section-header-row">
                    <h2>Mis negocios</h2>
                    <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-create">+ Nuevo negocio</a>
                </div>
                <div class="negocios-grid">
                        <?php if (count($mis_negocios) > 0): ?>
                        <?php foreach ($mis_negocios as $negocio):
                            $np = $negocio['color_primario'] ?? '#C0392B';
                            $ns = $negocio['color_secundario'] ?? '#2C3E50';
                        ?>
                        <div class="negocio-card" onclick="window.location.href='<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>'">
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
                            <div class="negocio-info">
                                <h3><?= htmlspecialchars($negocio['nombre_comercial']) ?></h3>
                                <p><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 60)) ?>...</p>
                                <div class="negocio-badges">
                                    <span class="negocio-tag" style="background:<?= $np ?>15;color:<?= $np ?>"><?= $negocio['total_productos'] ?> productos</span>
                                    <span class="negocio-tag" style="background:<?= $ns ?>15;color:<?= $ns ?>"><?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                                </div>
                                <div class="negocio-actions">
                                     <a href="<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>" class="btn-visitar" style="background:<?= $np ?>;color:#fff">Ver tienda</a>
                                     <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="btn-admin" style="border-color:<?= $np ?>;color:<?= $np ?>">Personalizar</a>
                                     <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="btn-admin">Productos</a>
                                 </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state" style="text-align:center;padding:60px 20px;color:var(--text-dim);grid-column:1/-1;background:var(--card-bg);border:1px solid var(--border);border-radius:8px">
                            <div style="font-size:48px;margin-bottom:12px;opacity:0.3">🏪</div>
                            <p style="font-size:15px;margin-bottom:6px">No tienes negocios creados</p>
                            <p style="font-size:12px;color:var(--text-muted);margin-bottom:20px">Elige una plantilla y crea tu primera tienda online</p>
                            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-square">+ Crear mi primer negocio</a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <div class="mini-grid">
                    <div class="mini-card"><div class="num"><?= count($otros_negocios) ?></div><div class="lbl">Tiendas disponibles</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_productos'] ?></div><div class="lbl">Productos en l&iacute;nea</div></div>
                    <div class="mini-card"><div class="num"><?= $stats['total_usuarios'] ?></div><div class="lbl">Usuarios activos</div></div>
                </div>
                <div class="section-header-row"><h2>Descubre negocios</h2></div>
                <div class="negocios-grid">
                    <?php if (count($otros_negocios) > 0): ?>
                        <?php foreach ($otros_negocios as $negocio):
                            $np = $negocio['color_primario'] ?? '#C0392B';
                            $ns = $negocio['color_secundario'] ?? '#2C3E50';
                        ?>
                        <div class="negocio-card" onclick="window.location.href='<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>'">
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
                            <div class="negocio-info">
                                <h3><?= htmlspecialchars($negocio['nombre_comercial']) ?></h3>
                                <p><?= htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 60)) ?>...</p>
                                <div class="negocio-badges">
                                    <span class="negocio-tag" style="background:<?= $np ?>15;color:<?= $np ?>"><?= $negocio['total_productos'] ?> productos</span>
                                    <span class="negocio-tag" style="background:<?= $ns ?>15;color:<?= $ns ?>"><?= $negocio['plantilla_nombre'] ?? 'Moderno' ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>/tienda/<?= $negocio['id_emprendimiento'] ?>" class="btn-visitar" style="display:block;text-align:center;background:<?= $np ?>;color:#fff">Ver tienda</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state" style="text-align:center;padding:60px 20px;color:var(--text-dim);grid-column:1/-1;background:var(--card-bg);border:1px solid var(--border);border-radius:8px">
                            <div style="font-size:48px;margin-bottom:12px;opacity:0.3">🔍</div>
                            <p style="font-size:15px;margin-bottom:6px">No hay negocios disponibles a&uacute;n</p>
                            <p style="font-size:12px;color:var(--text-muted)">Vuelve m&aacute;s tarde para descubrir nuevas tiendas</p>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Repartidor'):
                $repStats = (new \App\Repositories\PedidoRepository())->getStatsRepartidor((int)$usuario['id']);
            ?>
                <div class="stats-grid">
                    <div class="stat-card"><h3>Pedidos hoy</h3><div class="value"><?= $repStats['entregas_hoy'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Ganancias hoy</h3><div class="value">Bs. <?= number_format($repStats['ganancias_hoy'] ?? 0, 2) ?></div></div>
                    <div class="stat-card"><h3>Activos</h3><div class="value"><?= $repStats['activos'] ?? 0 ?></div></div>
                    <div class="stat-card"><h3>Entregas totales</h3><div class="value"><?= $repStats['entregas_totales'] ?? 0 ?></div></div>
                </div>
                <div style="text-align:center;margin-top:12px">
                    <a href="<?= BASE_URL ?>/dashboard-repartidor" style="display:inline-block;padding:12px 28px;background:var(--text);color:var(--bg);border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;transition:all .2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">Ir a panel de entregas &rarr;</a>
                </div>

            <?php elseif ($rol_activo === 'Administrador'): ?>
                <div class="section-header-row"><h2>Panel de control</h2></div>
                <div class="stats-grid" style="margin-bottom:32px">
                    <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $stats['total_usuarios'] ?></div></div>
                    <div class="stat-card"><h3>Negocios</h3><div class="value"><?= $stats['total_negocios'] ?></div></div>
                    <div class="stat-card"><h3>Productos</h3><div class="value"><?= $stats['total_productos'] ?></div></div>
                    <div class="stat-card"><h3>Valoraci&oacute;n</h3><div class="value">4.8</div></div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:600px">
                    <a href="<?= BASE_URL ?>/admin" style="background:linear-gradient(135deg,#1A3A5C,#2C6FBB);color:#fff;padding:32px;border-radius:8px;text-decoration:none;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                        <div style="font-size:40px;margin-bottom:12px">⚙</div>
                        <div style="font-size:16px;font-weight:600">Panel de Administración</div>
                        <div style="font-size:12px;opacity:0.6;margin-top:6px">Gestionar usuarios, negocios y BD</div>
                    </a>
                    <a href="<?= BASE_URL ?>/perfil" style="background:linear-gradient(135deg,#2C3E50,#555);color:#fff;padding:32px;border-radius:8px;text-decoration:none;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                        <div style="font-size:40px;margin-bottom:12px">👤</div>
                        <div style="font-size:16px;font-weight:600">Mi Perfil</div>
                        <div style="font-size:12px;opacity:0.6;margin-top:6px">Editar datos y configuración</div>
                    </a>
                </div>
                <div class="activity-list" style="margin-top:24px">
                    <div style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:8px">Resumen del sistema</div>
                    <div class="activity-item"><span class="activity-dot" style="background:#3498DB"></span><strong><?= $stats['total_usuarios'] ?></strong> usuarios registrados</div>
                    <div class="activity-item"><span class="activity-dot" style="background:#2ECC71"></span><strong><?= $stats['total_negocios'] ?></strong> negocios activos en la plataforma</div>
                    <div class="activity-item"><span class="activity-dot" style="background:#F39C12"></span><strong><?= $stats['total_productos'] ?></strong> productos publicados</div>
                    <div class="activity-item"><span class="activity-dot" style="background:#9B59B6"></span>Valoraci&oacute;n promedio: <strong>4.8 / 5.0</strong></div>
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
                link.addEventListener('click', function() { if (window.innerWidth < 769) toggleSidebar(); });
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

            // Typewriter greeting animation
            var greeting = document.getElementById('greetingText');
            if (greeting) {
                var nombre = '<?= htmlspecialchars(($usuario['nombre'] ?? ''), ENT_QUOTES) ?>';
                var fullText = 'Hola, ' + nombre;
                greeting.innerHTML = '';
                greeting.style.whiteSpace = 'pre-wrap';
                var i = 0;
                function typeChar() {
                    if (i < fullText.length) {
                        var ch = fullText[i];
                        if (ch === ' ') {
                            greeting.appendChild(document.createTextNode(' '));
                        } else {
                            var span = document.createElement('span');
                            span.className = 'glow-char';
                            span.textContent = ch;
                            greeting.appendChild(span);
                        }
                        i++;
                        var delay = 30 + Math.random() * 30;
                        if (ch === ' ' || ch === ',') delay = 50;
                        setTimeout(typeChar, delay);
                    } else {
                        var cursor = document.createElement('span');
                        cursor.className = 'cursor';
                        greeting.appendChild(cursor);
                        setTimeout(function() {
                            cursor.style.display = 'none';
                            greeting.classList.add('fade-out');
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
        })();
    </script>
</body>
</html>
