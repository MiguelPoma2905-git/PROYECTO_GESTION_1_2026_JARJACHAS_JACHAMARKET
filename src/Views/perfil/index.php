<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Mi Perfil - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .perfil-header { margin-bottom:40px; }
        .perfil-title { font-family:Georgia,var(--font-serif);font-size:28px;font-weight:400;color:var(--text);margin:0; }
        .perfil-subtitle { font-size:13px;color:var(--text-dim);margin-top:6px; }

        .perfil-grid { display:grid;grid-template-columns:320px 1fr;gap:28px; }

        .perfil-card { background:var(--card-bg);border:1px solid var(--border);border-radius:4px;overflow:hidden; }
        .perfil-card-header { padding:20px 24px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border); }
        .perfil-card-header i { font-size:15px;color:var(--text-dim);width:20px;text-align:center; }
        .perfil-card-header h3 { font-family:Georgia,var(--font-serif);font-size:17px;font-weight:400;color:var(--text);margin:0; }
        .perfil-card-body { padding:24px; }

        .avatar-wrap { text-align:center;padding:32px 24px 24px; }
        .avatar-circle { width:130px;height:130px;border-radius:50%;margin:0 auto 16px;background:linear-gradient(135deg,var(--surface2),var(--surface));display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:600;color:var(--text);cursor:pointer;position:relative;overflow:hidden;border:2px solid var(--border); }
        .avatar-circle:hover { border-color:var(--border-hi); }
        .avatar-circle img { width:100%;height:100%;object-fit:cover; }
        .avatar-circle .avatar-overlay { position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s;color:#fff;font-size:12px;font-weight:500;gap:6px; }
        .avatar-circle:hover .avatar-overlay { opacity:1; }
        .avatar-name { font-size:18px;font-weight:600;color:var(--text);font-family:Georgia,var(--font-serif); }
        .avatar-email { font-size:12px;color:var(--text-muted);margin-top:4px; }
        .role-tags { display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:16px; }
        .role-tag { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:3px;font-size:11px;font-weight:500;background:rgba(128,128,128,0.08);color:var(--text-muted); }

        .info-list { margin-top:4px; }
        .info-row { display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border); }
        .info-row:last-child { border-bottom:none; }
        .info-icon { width:36px;height:36px;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;background:rgba(128,128,128,0.06);color:var(--text-muted); }
        .info-content { flex:1;min-width:0; }
        .info-label { font-size:10px;color:var(--text-dim);text-transform:uppercase;letter-spacing:0.4px; }
        .info-value { font-size:13px;color:var(--text);font-weight:500;margin-top:2px;word-break:break-word; }
        .info-value.empty { color:var(--text-dim);font-weight:400;font-style:italic; }

        .f-group { margin-bottom:20px; }
        .f-group:last-child { margin-bottom:0; }
        .f-group label { display:block;font-size:11px;color:var(--text-dim);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;font-weight:500; }
        .f-group input,.f-group textarea,.f-group select { width:100%;padding:12px 14px;background:var(--card-bg);border:1px solid var(--border);border-radius:3px;color:var(--text);font-size:13px;font-family:var(--font-sans);outline:none; }
        .f-group input:focus,.f-group textarea:focus,.f-group select:focus { border-color:var(--border-hi); }
        .f-group textarea { resize:vertical;min-height:80px; }
        .f-group input[disabled] { opacity:0.4;cursor:not-allowed; }
        .f-hint { font-size:10px;color:var(--text-dim);margin-top:4px; }

        .perfil-btn { display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:var(--text);color:var(--bg);border:none;border-radius:3px;font-size:13px;font-weight:600;cursor:pointer;font-family:var(--font-sans); }
        .perfil-btn-sm { padding:8px 18px;font-size:11px; }
        .perfil-btn-outline { background:transparent;color:var(--text-muted);border:1px solid var(--border); }
        .perfil-btn-outline:hover { border-color:var(--border-hi);color:var(--text); }
        .perfil-btn-danger { background:rgba(154,90,90,0.08);color:#9a5a5a;border:1px solid rgba(154,90,90,0.15); }

        .perfil-msg { padding:12px 18px;border-radius:3px;font-size:13px;margin-bottom:24px;display:flex;align-items:center;gap:10px; }
        .perfil-msg.success { background:rgba(107,143,113,0.08);border:1px solid rgba(107,143,113,0.15);color:#6b8f71; }
        .perfil-msg.error { background:rgba(154,90,90,0.08);border:1px solid rgba(154,90,90,0.15);color:#9a5a5a; }

        .perfil-form-row { display:grid;grid-template-columns:1fr 1fr;gap:20px; }

        .negocio-list { display:flex;flex-direction:column; }
        .negocio-row { display:flex;align-items:center;justify-content:space-between;padding:16px 0;border-bottom:1px solid var(--border);gap:16px; }
        .negocio-row:last-child { border-bottom:none; }
        .negocio-row-left { display:flex;align-items:center;gap:14px;flex:1;min-width:0; }
        .negocio-color-dot { width:40px;height:40px;border-radius:4px;flex-shrink:0; }
        .negocio-row-name { font-size:14px;font-weight:500;color:var(--text); }
        .negocio-row-meta { font-size:11px;color:var(--text-muted);margin-top:2px; }

        .repartidor-section { border-top:1px solid var(--border);padding:20px 24px; }
        .repartidor-section .r-header { display:flex;align-items:center;gap:10px;margin-bottom:8px; }
        .repartidor-section .r-header i { font-size:14px;color:var(--text-muted); }
        .repartidor-section .r-header span { font-size:13px;font-weight:500;color:var(--text); }
        .repartidor-section p { font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5; }

        .sidebar-nav a { display:flex;align-items:center;gap:10px; }

        @media(max-width:900px){
            .perfil-grid{grid-template-columns:1fr;}
        }
        @media(max-width:600px){
            .perfil-card-body{padding:18px;}
            .perfil-card-header{padding:16px 18px 14px;}
            .avatar-wrap{padding:24px 18px 18px;}
            .avatar-circle{width:100px;height:100px;font-size:36px;}
            .perfil-title{font-size:22px;}
            .perfil-form-row{grid-template-columns:1fr;}
            .negocio-row{flex-wrap:wrap;}
        }
        @media(max-width:480px){
            .avatar-circle{width:80px;height:80px;font-size:28px;}
            .perfil-btn{width:100%;justify-content:center;}
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
            <a href="<?= BASE_URL ?>/dashboard"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9632;</span> Dashboard</a>
            <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesion</a>
        </nav>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-content">
        <div class="top-bar">
            <div style="display:flex;align-items:center;gap:8px;">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
            </div>
            <div style="display:flex;align-items:center;gap:0;">
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
                        <span style="font-size:8px;color:var(--text-dim);line-height:1;">&#9660;</span>
                    </div>
                    <div class="dropdown-menu">
                        <?php if (count($roles_usuario) > 1): ?>
                        <div style="padding:8px 16px 4px;font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;border-bottom:1px solid var(--border)">Elegir rol</div>
                            <?php foreach ($roles_usuario as $rol):
                                $colorRol = match($rol['nombre_rol']) {
                                    'Cliente' => '#7a8a9a',
                                    'Emprendedor' => '#6b8f71',
                                    'Repartidor' => '#8a7a6a',
                                    'Administrador' => '#7a7a8a',
                                    default => '#888'
                                };
                            ?>
                            <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="dropdown-item <?= $rol['nombre_rol'] === $rol_activo ? 'active-role' : '' ?>">
                                <span class="role-dot" style="background:<?= $colorRol ?>"></span>
                                <?= htmlspecialchars($rol['nombre_rol']) ?>
                                <?php if ($rol['nombre_rol'] === $rol_activo): ?><span style="margin-left:auto;font-size:10px;opacity:0.6">&#10003;</span><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                            <div style="border-top:1px solid var(--border);margin:4px 0"></div>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item" style="color:#9a5a5a">Cerrar sesion</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-container">
            <div class="perfil-header">
                <h1 class="perfil-title"><i class="fas fa-user-circle" style="margin-right:12px;color:var(--text-muted)"></i>Mi Perfil</h1>
                <p class="perfil-subtitle">Gestiona tu informacion personal y configuracion de cuenta</p>
            </div>

            <?php if ($success): ?>
            <div class="perfil-msg success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="perfil-msg error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="perfil-grid">
                <!-- Left column: Avatar + info -->
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
                            <div class="avatar-name"><?= htmlspecialchars($usuario['nombres'] ?? '') ?> <?= htmlspecialchars($usuario['apellidos'] ?? '') ?></div>
                            <div class="avatar-email"><?= htmlspecialchars($usuario['email'] ?? '') ?></div>
                            <div class="role-tags">
                                <?php foreach ($roles_nombres as $rol): ?>
                                <span class="role-tag">
                                    <?php if ($rol === 'Emprendedor'): ?><i class="fas fa-store"></i><?php elseif ($rol === 'Cliente'): ?><i class="fas fa-user"></i><?php elseif ($rol === 'Repartidor'): ?><i class="fas fa-motorcycle"></i><?php elseif ($rol === 'Administrador'): ?><i class="fas fa-shield-alt"></i><?php endif; ?>
                                    <?= $rol === 'Emprendedor' ? 'Vendedor' : $rol ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>
                    <div class="perfil-card-body" style="padding-top:0">
                        <div class="info-list">
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-phone"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Telefono</div>
                                    <div class="info-value <?= empty($usuario['telefono']) ? 'empty' : '' ?>"><?= $usuario['telefono'] ?: 'No registrado' ?></div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Ubicacion</div>
                                    <div class="info-value <?= empty($usuario['ubicacion']) ? 'empty' : '' ?>"><?= htmlspecialchars($usuario['ubicacion'] ?? '') ?: 'No especificada' ?></div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-clock"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Miembro desde</div>
                                    <div class="info-value"><?= isset($usuario['fecha_registro']) ? date('d/m/Y', strtotime($usuario['fecha_registro'])) : '&#8212;' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (in_array('Repartidor', $roles_nombres)): ?>
                    <div class="repartidor-section">
                        <div class="r-header">
                            <i class="fas fa-motorcycle"></i>
                            <span>Rol Repartidor</span>
                        </div>
                        <p>Si ya no deseas realizar entregas, puedes eliminar este rol.</p>
                        <form method="POST" action="<?= BASE_URL ?>/perfil/quitar-repartidor" onsubmit="return confirm('&#191;Eliminar el rol Repartidor? Puedes volver a agregarlo despu&#233;s.');">
                            <button type="submit" class="perfil-btn perfil-btn-sm perfil-btn-danger"><i class="fas fa-times"></i> Quitar rol Repartidor</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right column: Edit form -->
                <div class="perfil-card">
                    <div class="perfil-card-header">
                        <i class="fas fa-pen"></i>
                        <h3>Editar informacion</h3>
                    </div>
                    <div class="perfil-card-body">
                        <form method="POST" action="<?= BASE_URL ?>/perfil/actualizar">
                            <div class="perfil-form-row">
                                <div class="f-group">
                                    <label>Nombres</label>
                                    <input type="text" name="nombres" value="<?= htmlspecialchars($usuario['nombres'] ?? '') ?>" required>
                                </div>
                                <div class="f-group">
                                    <label>Apellidos</label>
                                    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="f-group">
                                <label>Correo electronico</label>
                                <input type="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" disabled>
                                <div class="f-hint"><i class="fas fa-info-circle"></i> El correo no se puede modificar</div>
                            </div>
                            <div class="perfil-form-row">
                                <div class="f-group">
                                    <label>Telefono</label>
                                    <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" placeholder="Ej: 71234567">
                                </div>
                                <div class="f-group">
                                    <label>Ubicacion</label>
                                    <input type="text" name="ubicacion" value="<?= htmlspecialchars($usuario['ubicacion'] ?? '') ?>" placeholder="Ej: La Paz, Bolivia">
                                </div>
                            </div>
                            <div class="f-group">
                                <label>Biografia</label>
                                <textarea name="bio" placeholder="Cuentanos sobre ti..."><?= htmlspecialchars($usuario['bio'] ?? '') ?></textarea>
                            </div>
                            <div class="f-group">
                                <label>Nueva contrasena</label>
                                <input type="password" name="password" placeholder="Dejalo vacio para mantener la actual">
                                <div class="f-hint"><i class="fas fa-info-circle"></i> Minimo 6 caracteres</div>
                            </div>
                            <button type="submit" class="perfil-btn"><i class="fas fa-save"></i> Guardar cambios</button>
                        </form>
                    </div>
                </div>

                <!-- Negocios section - full width -->
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
                                <form method="POST" action="<?= BASE_URL ?>/perfil/eliminar-negocio" onsubmit="return confirm('&#191;Eliminar el negocio <?= htmlspecialchars($n['nombre_comercial']) ?>? Se borrar&#225;n todos sus productos.');" style="flex-shrink:0;">
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

    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

    <script>
        (function(){
            var menuBtn = document.getElementById('menuBtn');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            function toggleSidebar() { sidebar.classList.toggle('open'); if (overlay) overlay.classList.toggle('active'); }
            if (menuBtn && sidebar) { menuBtn.addEventListener('click', function(e) { e.stopPropagation(); toggleSidebar(); }); }
            if (overlay) { overlay.addEventListener('click', function() { sidebar.classList.remove('open'); overlay.classList.remove('active'); }); }

            var preview = document.getElementById('avatarPreview');
            var input = document.getElementById('avatarInput');
            if (preview && input) {
                preview.addEventListener('click', function() { input.click(); });
                input.addEventListener('change', function() { if (this.files.length > 0) this.form.submit(); });
            }

            var userTrigger = document.getElementById('userTrigger');
            var userDropdown = document.getElementById('userDropdown');
            if (userTrigger && userDropdown) {
                userTrigger.addEventListener('click', function(e) { e.stopPropagation(); userDropdown.classList.toggle('active'); });
                document.addEventListener('click', function() { userDropdown.classList.remove('active'); });
            }

            var themeToggle = document.getElementById('themeToggle');
            var html = document.documentElement;
            var saved = localStorage.getItem('jacha_theme') || 'dark';
            html.setAttribute('data-theme', saved);
            if (themeToggle) {
                themeToggle.innerHTML = saved === 'dark' ? '\u2600' : '\u263E';
                themeToggle.addEventListener('click', function() {
                    var current = html.getAttribute('data-theme');
                    var next = current === 'dark' ? 'light' : 'dark';
                    html.setAttribute('data-theme', next);
                    localStorage.setItem('jacha_theme', next);
                    themeToggle.innerHTML = next === 'dark' ? '\u2600' : '\u263E';
                });
            }
        })();
    </script>
</body>
</html>