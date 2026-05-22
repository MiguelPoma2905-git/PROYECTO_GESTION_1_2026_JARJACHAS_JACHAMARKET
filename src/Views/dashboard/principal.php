<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
</head>
<body class="dashboard-body">

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= BASE_URL ?>/" class="logo-link">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img">
            </a>
            <p class="sidebar-user-email">Panel de control</p>
        </div>
        
        <?php if (count($roles_usuario) > 1): ?>
        <div class="rol-selector">
            <h4>Cambiar rol</h4>
            <div class="rol-buttons">
                <?php foreach ($roles_usuario as $rol): ?>
                <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="rol-btn <?= $rol_activo === $rol['nombre_rol'] ? 'active' : '' ?>">
                    <?php if ($rol['nombre_rol'] === 'Cliente'): ?>Cliente
                    <?php elseif ($rol['nombre_rol'] === 'Emprendedor'): ?>Vendedor
                    <?php else: ?><?= $rol['nombre_rol'] ?>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/dashboard" class="active">Dashboard</a>
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <a href="<?= BASE_URL ?>/plantillas-disponibles">Nuevo negocio</a>
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <a href="<?= BASE_URL ?>/mis-pedidos">Mis pedidos</a>
                <a href="<?= BASE_URL ?>/favoritos">Favoritos</a>
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <a href="<?= BASE_URL ?>/dashboard-repartidor">Entregas</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/perfil">Configuraci&oacute;n</a>
            <?php if ($es_admin): ?>
            <a href="<?= BASE_URL ?>/admin" style="color: #3498DB;">⚙ Administraci&oacute;n</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" style="margin-top: 40px;">Cerrar sesi&oacute;n</a>
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
                    <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-menu">
                    <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Ajustes</a>
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
            
            <div class="welcome-section">
                <h1>Hola, <?= htmlspecialchars($usuario['nombre']) ?></h1>
                <p>Est&aacute;s viendo el panel como <strong><?= $rol_activo ?></strong></p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card"><h3>Negocios activos</h3><div class="value"><?= $stats['total_negocios'] ?></div></div>
                <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $stats['total_usuarios'] ?></div></div>
                <div class="stat-card"><h3>Productos</h3><div class="value"><?= $stats['total_productos'] ?></div></div>
                <div class="stat-card"><h3>Valoraci&oacute;n</h3><div class="value">4.8</div></div>
            </div>
            
            <?php if ($rol_activo === 'Emprendedor'): ?>
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
                        <div class="empty-state" style="text-align:center;padding:70px;color:var(--text-dim);grid-column:1/-1">
                            <p>No tienes negocios creados</p>
                            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-create" style="display: inline-block; margin-top: 16px;">+ Crear mi primer negocio</a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Cliente'): ?>
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
                        <div class="empty-state" style="text-align:center;padding:70px;color:var(--text-dim);grid-column:1/-1"><p>No hay negocios disponibles a&uacute;n</p></div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <div class="stats-grid">
                    <div class="stat-card"><h3>Pedidos hoy</h3><div class="value">0</div></div>
                    <div class="stat-card"><h3>Ganancias mes</h3><div class="value">Bs. 0</div></div>
                    <div class="stat-card"><h3>Calificaci&oacute;n</h3><div class="value">5.0</div></div>
                    <div class="stat-card"><h3>Entregas</h3><div class="value">0</div></div>
                </div>
                <div class="empty-state" style="text-align:center;padding:70px;color:var(--text-dim)"><p>No hay pedidos de entrega disponibles</p></div>

            <?php elseif ($rol_activo === 'Administrador'): ?>
                <div class="section-header-row"><h2>Panel de control</h2></div>
                <div class="stats-grid" style="margin-bottom:32px">
                    <div class="stat-card"><h3>Usuarios</h3><div class="value"><?= $stats['total_usuarios'] ?></div></div>
                    <div class="stat-card"><h3>Negocios</h3><div class="value"><?= $stats['total_negocios'] ?></div></div>
                    <div class="stat-card"><h3>Productos</h3><div class="value"><?= $stats['total_productos'] ?></div></div>
                    <div class="stat-card"><h3>Valoraci&oacute;n</h3><div class="value">4.8</div></div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:600px">
                    <a href="<?= BASE_URL ?>/admin" style="background:linear-gradient(135deg,#1A3A5C,#2C6FBB);color:#fff;padding:32px;border-radius:20px;text-decoration:none;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                        <div style="font-size:40px;margin-bottom:12px">⚙</div>
                        <div style="font-size:16px;font-weight:600">Panel de Administración</div>
                        <div style="font-size:12px;opacity:0.6;margin-top:6px">Gestionar usuarios, negocios y BD</div>
                    </a>
                    <a href="<?= BASE_URL ?>/perfil" style="background:linear-gradient(135deg,#2C3E50,#555);color:#fff;padding:32px;border-radius:20px;text-decoration:none;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                        <div style="font-size:40px;margin-bottom:12px">👤</div>
                        <div style="font-size:16px;font-weight:600">Mi Perfil</div>
                        <div style="font-size:12px;opacity:0.6;margin-top:6px">Editar datos y configuración</div>
                    </a>
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
        })();
    </script>
</body>
</html>
