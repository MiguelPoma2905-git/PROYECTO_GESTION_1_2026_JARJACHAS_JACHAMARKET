<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Mi Perfil - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .perfil-header { margin-bottom:32px; }
        .perfil-title { font-family:Georgia,var(--font-serif);font-size:26px;font-weight:400;color:var(--text);margin:0;display:flex;align-items:center;gap:12px; }
        .perfil-title i { opacity:0.3;font-size:22px; }
        .perfil-subtitle { font-size:13px;color:var(--text-muted);margin-top:4px;margin-left:34px; }
        .perfil-grid { display:grid;grid-template-columns:320px 1fr;gap:24px; }
        .perfil-card { background:var(--card-bg);border:1px solid var(--border);border-radius:12px;overflow:hidden;transition:border-color .2s; }
        .perfil-card:hover { border-color:var(--border-hi); }
        .perfil-card-header { padding:18px 22px 14px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border); }
        .perfil-card-header i { font-size:15px;color:var(--text-dim);width:20px;text-align:center; }
        .perfil-card-header h3 { font-family:Georgia,var(--font-serif);font-size:17px;font-weight:400;color:var(--text);margin:0; }
        .perfil-card-body { padding:20px 22px 22px; }
        .avatar-wrap { text-align:center;padding:24px 22px 20px; }
        .avatar-circle { width:130px;height:130px;border-radius:50%;margin:0 auto 14px;background:linear-gradient(135deg,var(--surface2),var(--surface));display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:600;color:var(--text);cursor:pointer;transition:all .3s var(--ease);position:relative;overflow:hidden;border:2px solid var(--border); }
        .avatar-circle:hover { border-color:var(--border-hi);transform:scale(1.03); }
        .avatar-circle img { width:100%;height:100%;object-fit:cover; }
        .avatar-circle .avatar-overlay { position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s;color:#fff;font-size:12px;font-weight:500;gap:6px; }
        .avatar-circle:hover .avatar-overlay { opacity:1; }
        .avatar-name { font-size:17px;font-weight:600;color:var(--text);font-family:Georgia,var(--font-serif); }
        .avatar-email { font-size:12px;color:var(--text-muted);margin-top:2px; }
        .role-tags { display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-top:14px; }
        .role-tag { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:500;background:var(--surface3);color:var(--text-muted); }
        .role-tag.admin { background:#3498DB15;color:#3498DB; }
        .role-tag.repartidor { background:#E74C3C15;color:#E74C3C; }
        .role-tag.cliente { background:#3498DB12;color:#3498DB; }
        .role-tag.emprendedor { background:#2ECC7115;color:#27AE60; }
        .info-row { display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border); }
        .info-row:last-child { border-bottom:none; }
        .info-icon { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0; }
        .info-content { flex:1;min-width:0; }
        .info-label { font-size:10px;color:var(--text-dim);text-transform:uppercase;letter-spacing:0.4px; }
        .info-value { font-size:13px;color:var(--text);font-weight:500;margin-top:1px;word-break:break-word; }
        .info-value.empty { color:var(--text-dim);font-weight:400;font-style:italic; }
        .f-group { margin-bottom:16px; }
        .f-group:last-child { margin-bottom:0; }
        .f-group label { display:block;font-size:11px;color:var(--text-dim);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:5px;font-weight:500; }
        .f-group input,.f-group textarea,.f-group select { width:100%;padding:10px 13px;background:var(--surface2);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;font-family:var(--font-sans);transition:all .2s; }
        .f-group input:focus,.f-group textarea:focus,.f-group select:focus { outline:none;border-color:var(--border-hi);background:var(--surface3); }
        .f-group input::placeholder,.f-group textarea::placeholder { color:var(--text-dim); }
        .f-group textarea { resize:vertical;min-height:70px; }
        .f-group input[disabled] { opacity:0.4;cursor:not-allowed; }
        .f-hint { font-size:10px;color:var(--text-dim);margin-top:3px; }
        .perfil-btn { display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:var(--text);color:var(--bg);border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;font-family:var(--font-sans); }
        .perfil-btn:hover { transform:translateY(-2px);box-shadow:0 6px 20px var(--glow-lg); }
        .perfil-btn-sm { padding:7px 16px;font-size:11px; }
        .perfil-btn-outline { background:transparent;color:var(--text-muted);border:1px solid var(--border); }
        .perfil-btn-outline:hover { border-color:var(--border-hi);color:var(--text);background:var(--glow);box-shadow:none;transform:none; }
        .perfil-btn-danger { background:#E74C3C17;color:#E74C3C;border:1px solid rgba(231,76,60,0.2); }
        .perfil-btn-danger:hover { background:#E74C3C25;box-shadow:0 6px 20px rgba(231,76,60,0.15); }
        .perfil-msg { padding:10px 16px;border-radius:8px;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:10px; }
        .perfil-msg.success { background:#27AE6012;border:1px solid rgba(39,174,96,0.2);color:#27AE60; }
        .perfil-msg.error { background:#E74C3C12;border:1px solid rgba(231,76,60,0.2);color:#E74C3C; }
        .perfil-msg i { font-size:14px; }
        .negocio-list { display:flex;flex-direction:column; }
        .negocio-row { display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);gap:12px; }
        .negocio-row:last-child { border-bottom:none; }
        .negocio-row-left { display:flex;align-items:center;gap:12px;flex:1;min-width:0; }
        .negocio-color-dot { width:36px;height:36px;border-radius:8px;flex-shrink:0; }
        .negocio-row-name { font-size:14px;font-weight:500;color:var(--text); }
        .negocio-row-meta { font-size:11px;color:var(--text-muted);margin-top:1px; }
        .accordeon-section { margin-top:20px; }
        .accordeon-trigger { display:flex;align-items:center;justify-content:space-between;padding:14px 0;cursor:pointer;border-bottom:1px solid var(--border);user-select:none; }
        .accordeon-trigger span { font-size:13px;font-weight:500;color:var(--text); }
        .accordeon-trigger i { color:var(--text-dim);transition:transform .3s;font-size:12px; }
        .accordeon-trigger.open i { transform:rotate(180deg); }
        .accordeon-content { max-height:0;overflow:hidden;transition:max-height .35s var(--ease),padding .35s var(--ease); }
        .accordeon-content.open { max-height:400px;padding:6px 0 14px; }
        .perfil-form-row { display:grid;grid-template-columns:1fr 1fr;gap:14px; }
        @media(max-width:900px){ .perfil-grid{grid-template-columns:1fr;} }
        @media(max-width:600px){
            .perfil-form-row { grid-template-columns:1fr; }
            .perfil-card-body{padding:16px;}
            .perfil-card-header{padding:14px 16px 12px;}
            .avatar-circle{width:100px;height:100px;font-size:36px;}
            .perfil-title{font-size:20px;}
        }
        @media(max-width:480px){
            .avatar-circle{width:80px;height:80px;font-size:28px;}
            .perfil-btn{padding:8px 18px;font-size:12px;}
            .info-row{padding:8px 0;}
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
            <?php if ($es_admin): ?>
            <a href="<?= BASE_URL ?>/admin" style="color: #3498DB;"> Administraci&oacute;n</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"> Cerrar sesi&oacute;n</a>
        </nav>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <button class="theme-toggle" id="themeToggle" title="Cambiar tema">&#9790;</button>
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-trigger" id="userTrigger">
                        <span class="user-name"><?= htmlspecialchars($usuario['nombres'] ?? $usuario['nombre'] ?? '') ?></span>
                        <div class="user-avatar">
                            <?php if ($avatar && strpos($avatar, 'default/avatar_1.jpg') === false): ?>
                                <img src="<?= BASE_URL ?>/<?= $avatar ?>" alt="Avatar">
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
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item" style="color:#E74C3C">Cerrar sesi&oacute;n</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-container">
            <div class="perfil-header">
                <h1 class="perfil-title"><i class="fas fa-user-circle"></i> Mi Perfil</h1>
                <p class="perfil-subtitle">Gestiona tu informaci&oacute;n personal y configuraci&oacute;n de cuenta</p>
            </div>

            <?php if ($success): ?>
            <div class="perfil-msg success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="perfil-msg error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="perfil-grid">
                <div class="perfil-card">
                    <form method="POST" action="<?= BASE_URL ?>/perfil/actualizar" enctype="multipart/form-data" id="avatarForm">
                        <div class="avatar-wrap">
                            <div class="avatar-circle" id="avatarPreview" title="Haz clic para cambiar foto">
                                <?php if ($avatar && strpos($avatar, 'default/avatar_1.jpg') === false): ?>
                                    <img src="<?= BASE_URL ?>/<?= $avatar ?>" alt="Avatar">
                                <?php else: ?>
                                    <?= $inicial ?>
                                <?php endif; ?>
                                <span class="avatar-overlay"><i class="fas fa-camera"></i> Cambiar</span>
                            </div>
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" id="avatarInput" style="display:none">
                            <div class="avatar-name"><?= htmlspecialchars($usuario['nombres'] ?? $usuario['nombre'] ?? '') ?> <?= htmlspecialchars($usuario['apellidos'] ?? '') ?></div>
                            <div class="avatar-email"><?= htmlspecialchars($usuario['email'] ?? '') ?></div>
                            <div class="role-tags">
                                <?php foreach ($roles_nombres as $rol): ?>
                                <span class="role-tag <?= strtolower($rol) ?>">
                                    <?php if ($rol === 'Emprendedor'): ?><i class="fas fa-store"></i><?php elseif ($rol === 'Cliente'): ?><i class="fas fa-user"></i><?php elseif ($rol === 'Repartidor'): ?><i class="fas fa-motorcycle"></i><?php elseif ($rol === 'Administrador'): ?><i class="fas fa-shield-alt"></i><?php endif; ?>
                                    <?= $rol === 'Emprendedor' ? 'Vendedor' : $rol ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>
                    <div class="perfil-card-body" style="padding-top:0">
                        <div class="info-row">
                            <div class="info-icon" style="background:#3498DB12;color:#3498DB;"><i class="fas fa-phone"></i></div>
                            <div class="info-content">
                                <div class="info-label">Tel&eacute;fono</div>
                                <div class="info-value <?= empty($usuario['telefono']) ? 'empty' : '' ?>"><?= $usuario['telefono'] ?: 'No registrado' ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon" style="background:#27AE6012;color:#27AE60;"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-content">
                                <div class="info-label">Ubicaci&oacute;n</div>
                                <div class="info-value <?= empty($usuario['ubicacion']) ? 'empty' : '' ?>"><?= htmlspecialchars($usuario['ubicacion'] ?? '') ?: 'No especificada' ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon" style="background:#8E44AD12;color:#8E44AD;"><i class="fas fa-clock"></i></div>
                            <div class="info-content">
                                <div class="info-label">Miembro desde</div>
                                <div class="info-value"><?= isset($usuario['fecha_registro']) ? date('d/m/Y', strtotime($usuario['fecha_registro'])) : '—' ?></div>
                            </div>
                        </div>
                    </div>

                    <?php if (in_array('Repartidor', $roles_nombres)): ?>
                    <div style="border-top:1px solid var(--border);padding:16px 22px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                            <i class="fas fa-motorcycle" style="color:#E74C3C;font-size:14px;"></i>
                            <span style="font-size:13px;font-weight:500;color:var(--text);">Rol Repartidor</span>
                        </div>
                        <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5;">Si ya no deseas realizar entregas, puedes eliminar este rol.</p>
                        <form method="POST" action="<?= BASE_URL ?>/perfil/quitar-repartidor" onsubmit="return confirm('¿Eliminar el rol Repartidor? Puedes volver a agregarlo después.');">
                            <button type="submit" class="perfil-btn perfil-btn-sm perfil-btn-danger"><i class="fas fa-times"></i> Quitar rol Repartidor</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="perfil-card">
                    <div class="perfil-card-header">
                        <i class="fas fa-pen"></i>
                        <h3>Editar informaci&oacute;n</h3>
                    </div>
                    <div class="perfil-card-body">
                        <form method="POST" action="<?= BASE_URL ?>/perfil/actualizar">
                            <div class="perfil-form-row">
                                <div class="f-group">
                                    <label><i class="fas fa-user" style="margin-right:4px;opacity:0.4;"></i> Nombres</label>
                                    <input type="text" name="nombres" value="<?= htmlspecialchars($usuario['nombres'] ?? '') ?>" required>
                                </div>
                                <div class="f-group">
                                    <label><i class="fas fa-user" style="margin-right:4px;opacity:0.4;"></i> Apellidos</label>
                                    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="f-group">
                                <label><i class="fas fa-envelope" style="margin-right:4px;opacity:0.4;"></i> Correo electr&oacute;nico</label>
                                <input type="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" disabled>
                                <div class="f-hint"><i class="fas fa-info-circle"></i> El correo no se puede modificar</div>
                            </div>
                            <div class="perfil-form-row">
                                <div class="f-group">
                                    <label><i class="fas fa-phone" style="margin-right:4px;opacity:0.4;"></i> Tel&eacute;fono</label>
                                    <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" placeholder="Ej: 71234567">
                                </div>
                                <div class="f-group">
                                    <label><i class="fas fa-map-marker-alt" style="margin-right:4px;opacity:0.4;"></i> Ubicaci&oacute;n</label>
                                    <input type="text" name="ubicacion" value="<?= htmlspecialchars($usuario['ubicacion'] ?? '') ?>" placeholder="Ej: La Paz, Bolivia">
                                </div>
                            </div>
                            <div class="f-group">
                                <label><i class="fas fa-align-left" style="margin-right:4px;opacity:0.4;"></i> Biograf&iacute;a</label>
                                <textarea name="bio" placeholder="Cu&eacute;ntanos sobre ti..."><?= htmlspecialchars($usuario['bio'] ?? '') ?></textarea>
                            </div>
                            <div class="f-group" style="margin-top:6px;">
                                <label><i class="fas fa-lock" style="margin-right:4px;opacity:0.4;"></i> Nueva contrase&ntilde;a</label>
                                <input type="password" name="password" placeholder="D&eacute;jalo vac&iacute;o para mantener la actual">
                                <div class="f-hint"><i class="fas fa-info-circle"></i> M&iacute;nimo 6 caracteres</div>
                            </div>
                            <button type="submit" class="perfil-btn" style="margin-top:8px;"><i class="fas fa-save"></i> Guardar cambios</button>
                        </form>
                    </div>
                </div>

                <?php if (count($mis_negocios) > 0): ?>
                <div class="perfil-card" style="grid-column:1/-1;">
                    <div class="perfil-card-header">
                        <i class="fas fa-store"></i>
                        <h3>Mis Negocios (<?= count($mis_negocios) ?>)</h3>
                    </div>
                    <div class="perfil-card-body">
                        <div class="negocio-list">
                            <?php foreach ($mis_negocios as $n):
                                $np = $n['color_primario'] ?? '#C0392B';
                                $ns = $n['color_secundario'] ?? '#2C3E50';
                            ?>
                            <div class="negocio-row">
                                <div class="negocio-row-left">
                                    <div class="negocio-color-dot" style="background:linear-gradient(135deg,<?= $np ?>,<?= $ns ?>)"></div>
                                    <div>
                                        <div class="negocio-row-name"><?= htmlspecialchars($n['nombre_comercial']) ?></div>
                                        <div class="negocio-row-meta"><?= $n['total_productos'] ?> productos · <?= $n['plantilla_nombre'] ?? 'Moderno' ?></div>
                                    </div>
                                </div>
                                <form method="POST" action="<?= BASE_URL ?>/perfil/eliminar-negocio" onsubmit="return confirm('¿Eliminar el negocio <?= htmlspecialchars($n['nombre_comercial']) ?>? Se borrarán todos sus productos.');" style="flex-shrink:0;">
                                    <input type="hidden" name="id_negocio" value="<?= $n['id_emprendimiento'] ?>">
                                    <button type="submit" class="perfil-btn perfil-btn-sm perfil-btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        (function(){
            var menuBtn = document.getElementById('menuBtn');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            function toggleSidebar() {
                sidebar.classList.toggle('open');
                if (overlay) overlay.classList.toggle('active');
            }
            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function(e) {
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

            var preview = document.getElementById('avatarPreview');
            var input = document.getElementById('avatarInput');
            if (preview && input) {
                preview.addEventListener('click', function() { input.click(); });
                input.addEventListener('change', function() {
                    if (this.files.length > 0) this.form.submit();
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
