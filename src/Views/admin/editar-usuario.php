<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Editar Usuario - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .edit-wrap { max-width:800px; margin:0 auto; padding:32px 24px; }
        .edit-header { margin-bottom:32px; display:flex; align-items:center; justify-content:space-between; }
        .edit-header h1 { font-family:Georgia,var(--font-serif); font-size:28px; font-weight:400; color:var(--text); }
        .edit-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:3px; background:var(--card-bg); border:1px solid var(--border); }
        .edit-header .back:hover { color:var(--text); border-color:var(--border-hi); }

        .form-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:36px; }
        .form-section { font-size:11px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1.5px; padding-bottom:12px; border-bottom:1px solid var(--border); margin-bottom:24px; display:flex; align-items:center; gap:10px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .f-group { margin-bottom:20px; }
        .f-group label { display:block; font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; font-weight:600; }
        .f-group input, .f-group textarea, .f-group select {
            width:100%; background:var(--card-bg); border:1px solid var(--border);
            border-radius:3px; padding:12px 16px; color:var(--text);
            font-size:14px; font-family:'Inter',sans-serif; outline:none;
        }
        .f-group input:focus, .f-group textarea:focus, .f-group select:focus { border-color:var(--border-hi); }
        .f-group textarea { resize:vertical; min-height:80px; }
        .f-group select { cursor:pointer; }
        .checkbox-group { display:flex; gap:12px; flex-wrap:wrap; }
        .checkbox-group label {
            display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); cursor:pointer;
            text-transform:none; letter-spacing:0; font-weight:400;
            padding:8px 16px; border-radius:3px; border:1px solid var(--border);
        }
        .checkbox-group label:hover { border-color:var(--border-hi); background:var(--surface2); }
        .checkbox-group input[type="checkbox"] { width:auto; accent-color:var(--text); }
        .msg { background:rgba(107,143,113,0.08); border-left:3px solid #6b8f71; padding:14px 18px; border-radius:3px; margin-bottom:24px; font-size:13px; color:#6b8f71; display:flex; align-items:center; gap:10px; }
        .msg.err { background:rgba(154,90,90,0.08); border-left-color:#9a5a5a; color:#9a5a5a; }
        .btn-save { background:var(--text); color:var(--bg); border:none; padding:14px 36px; border-radius:3px; font-size:14px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:10px; }
        .btn-cancel { padding:14px 28px; border-radius:3px; border:1px solid var(--border); color:var(--text-muted); text-decoration:none; font-size:13px; font-weight:500; display:flex; align-items:center; gap:8px; background:transparent; }
        .btn-cancel:hover { border-color:var(--border-hi); color:var(--text); }
        .note { font-size:12px; color:var(--text-dim); margin-top:4px; }
        @media(max-width:600px){ .form-row{grid-template-columns:1fr} .edit-header{flex-direction:column;align-items:flex-start;gap:12px} }
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
        <a href="<?= BASE_URL ?>/admin/ventas"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9776;</span> Ventas</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesion</a>
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

    <div class="dash-container">

    <div class="edit-header">
        <h1><i class="fas fa-user-edit" style="margin-right:12px;color:var(--text-muted)"></i>Editar Usuario</h1>
        <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al panel</a>
    </div>

    <?php if ($success): ?>
        <div class="msg"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?= BASE_URL ?>/admin/editar-usuario/guardar">
            <input type="hidden" name="id" value="<?= $user['id_usuario'] ?>">

            <div class="form-section"><i class="fas fa-user"></i> Informacion personal</div>
            <div class="form-row">
                <div class="f-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" value="<?= htmlspecialchars($user['nombres']) ?>" required>
                </div>
                <div class="f-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="<?= htmlspecialchars($user['apellidos']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="f-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="f-group">
                    <label>Telefono</label>
                    <input type="text" name="telefono" value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="f-group">
                    <label>Ubicacion</label>
                    <input type="text" name="ubicacion" value="<?= htmlspecialchars($user['ubicacion'] ?? '') ?>">
                </div>
                <div class="f-group">
                    <label>Estado</label>
                    <select name="estado">
                        <option value="Activo" <?= ($user['estado'] ?? '') === 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Inactivo" <?= ($user['estado'] ?? '') === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        <option value="Suspendido" <?= ($user['estado'] ?? '') === 'Suspendido' ? 'selected' : '' ?>>Suspendido</option>
                    </select>
                </div>
            </div>

            <div class="f-group">
                <label>Biografia</label>
                <textarea name="bio"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
            </div>

            <div class="form-section" style="margin-top:32px"><i class="fas fa-shield-halved"></i> Roles</div>
            <div class="f-group">
                <?php if ($user['email'] === 'mikypramos2905@gmail.com'): ?>
                    <p class="note"><i class="fas fa-lock" style="color:var(--text-muted);margin-right:6px"></i>Los roles del super administrador no se pueden modificar.</p>
                <?php else: ?>
                    <div class="checkbox-group">
                    <?php foreach ($roles as $rol): ?>
                        <label>
                            <input type="checkbox" name="roles[]" value="<?= $rol['id_rol'] ?>"
                                <?= in_array($rol['id_rol'], $user_role_ids) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($rol['nombre_rol']) ?>
                        </label>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-section" style="margin-top:32px"><i class="fas fa-key"></i> Cambiar contrasena</div>
            <div class="f-group">
                <label>Nueva contrasena (dejar vacio para mantener)</label>
                <input type="password" name="password" placeholder="Minimo 6 caracteres" minlength="6">
            </div>

            <div style="margin-top:32px;display:flex;gap:12px">
                <button type="submit" class="btn-save"><i class="fas fa-check"></i> Guardar cambios</button>
                <a href="<?= BASE_URL ?>/dashboard" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>

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