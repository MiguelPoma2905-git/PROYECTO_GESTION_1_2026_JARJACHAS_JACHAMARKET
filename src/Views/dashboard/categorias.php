<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <title>Categorías - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
    <style>
        .cat-page { padding: 28px 32px; max-width: 1200px; margin: 0 auto; animation: fadeIn 0.5s ease }
        .cat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px }
        .cat-header h1 { font-family: Georgia, var(--font-serif); font-size: 26px; font-weight: 400; color: var(--text); display: flex; align-items: center; gap: 12px }
        .cat-header h1 i { color: var(--text-muted); font-size: 22px }
        .cat-layout { display: grid; grid-template-columns: 1fr 420px; gap: 24px; align-items: start }
        @media (max-width: 960px) { .cat-layout { grid-template-columns: 1fr } .cat-page { padding: 20px 16px } }
        .cat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 14px; padding: 24px; transition: background 0.3s ease; animation: fadeInUp 0.5s ease both }
        .cat-card:nth-child(1) { animation-delay: 0.05s }
        .cat-card:nth-child(2) { animation-delay: 0.10s }
        .cat-card h2 { font-family: Georgia, var(--font-serif); font-size: 18px; font-weight: 500; color: var(--text); margin: 0 0 16px; display: flex; align-items: center; gap: 10px }
        .cat-card h2 i { color: var(--text-muted); font-size: 16px }
        .category-tree { list-style: none; padding: 0; margin: 0 }
        .category-tree li { padding: 8px 0 8px 24px; border-left: 1px dashed var(--border); margin: 1px 0; position: relative; transition: background 0.2s }
        .category-tree li:before { content: ''; position: absolute; left: 0; top: 50%; width: 20px; height: 0; border-top: 1px dashed var(--border) }
        .category-tree > li:first-child { margin-top: 0 }
        .cat-node { display: flex; align-items: center; gap: 8px; padding: 6px 10px; border-radius: 8px; transition: background 0.2s }
        .cat-node:hover { background: var(--hover-surface) }
        .tree-toggle { cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 4px; font-size: 10px; color: var(--text-muted); user-select: none; transition: all 0.2s; flex-shrink: 0 }
        .tree-toggle:hover { background: var(--surface3); color: var(--text) }
        .tree-toggle.open { transform: rotate(90deg) }
        .tree-toggle-empty { visibility: hidden; pointer-events: none }
        .cat-children.hidden { display: none }
        .cat-name { font-size: 14px; font-weight: 500; color: var(--text); flex: 1 }
        .prod-badge { font-size: 11px; font-weight: 500; color: var(--text-muted); background: var(--badge-bg); padding: 2px 10px; border-radius: 20px; margin-left: 8px; white-space: nowrap }
        .cat-actions { display: flex; gap: 4px; opacity: 0; transition: opacity 0.2s; margin-left: auto }
        .cat-node:hover .cat-actions { opacity: 1 }
        .cat-action { width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; color: var(--text-muted); text-decoration: none; transition: all 0.2s }
        .cat-action:hover { background: var(--surface3) }
        .cat-action.edit:hover { color: var(--text) }
        .cat-action.delete:hover { color: #e74c3c; background: rgba(231,76,60,0.1) }
        .empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted) }
        .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.25; color: var(--text-muted) }
        .empty-state p { font-size: 14px; line-height: 1.6 }
        .cat-form .form-group { margin-bottom: 20px }
        .cat-form label { display: block; font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px }
        .cat-form input, .cat-form select { width: 100%; padding: 10px 14px; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text); font-size: 14px; font-family: inherit; transition: border-color 0.2s; box-sizing: border-box }
        .cat-form input:focus, .cat-form select:focus { outline: none; border-color: var(--border-hi); box-shadow: 0 0 0 2px var(--accent-glow) }
        .cat-form input::placeholder { color: var(--text-dim) }
        .cat-form select { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23888' d='M1.41.59L6 5.17 10.59.59 12 2l-6 6-6-6z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px }
        .helper-text { font-size: 12px; color: var(--text-dim); margin-top: 6px; line-height: 1.4 }
        .form-actions { display: flex; gap: 10px; margin-top: 24px }
        .form-actions .btn { flex: 1; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; text-align: center; transition: all 0.2s; cursor: pointer; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none }
        .msg-glass { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 13px; animation: slideUp 0.4s ease; border: 1px solid transparent }
        .msg-glass i { font-size: 16px; flex-shrink: 0 }
        .msg-success { background: rgba(46,204,113,0.08); border-color: rgba(46,204,113,0.15); color: #2ecc71 }
        .msg-error { background: rgba(231,76,60,0.08); border-color: rgba(231,76,60,0.15); color: #e74c3c }
        @media (max-width: 768px) { .cat-actions { opacity: 1 } .cat-header { flex-direction: column; align-items: flex-start } }
    </style>
</head>
<body class="dashboard-body">
<?php $current_page = 'categorias'; ?>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>

<div class="main-content">
    <div class="top-bar">
        <div class="top-bar-left">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
        </div>
        <div class="top-bar-right">
            <?php if (!empty($mis_negocios)): ?>
            <select style="padding:6px 12px;border-radius:8px;border:1px solid var(--border);background:var(--card-bg);color:var(--text);font-size:12px;font-family:inherit;cursor:pointer;margin-right:4px" onchange="window.location.href='?id_emprendimiento='+this.value">
                <option value="">Todas</option>
                <?php foreach ($mis_negocios as $n): ?>
                <option value="<?= $n['id_emprendimiento'] ?>" <?= $id_emprendimiento === $n['id_emprendimiento'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($n['nombre_comercial']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
            <button class="notif-btn" id="notifBtn" title="Notificaciones">
                <i class="fas fa-bell"></i>
                <span class="notif-badge" id="notifBadge">0</span>
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

    <div class="cat-page">
        <div class="cat-header">
            <h1><i class="fas fa-folder"></i> Categor&iacute;as</h1>
        </div>

        <?php if ($success): ?>
        <div class="msg-glass msg-success">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            <button class="msg-close" onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;opacity:0.5;cursor:pointer;font-size:14px;padding:4px">&times;</button>
        </div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="msg-glass msg-error">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            <button class="msg-close" onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;opacity:0.5;cursor:pointer;font-size:14px;padding:4px">&times;</button>
        </div>
        <?php endif; ?>

        <div class="cat-layout">
            <div class="cat-card">
                <h2><i class="fas fa-sitemap"></i> Árbol de categor&iacute;as</h2>
                <?php if (empty($tree)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>No hay categor&iacute;as todav&iacute;a.<br>Crea la primera desde el formulario.</p>
                </div>
                <?php else: ?>
                <?= $tree_html ?>
                <?php endif; ?>
            </div>

            <div class="cat-card">
                <h2><i class="fas fa-<?= $edit_categoria ? 'pen' : 'plus' ?>"></i> <?= $edit_categoria ? 'Editar categor&iacute;a' : 'Nueva categor&iacute;a' ?></h2>
                <form method="POST" class="cat-form">
                    <?php if ($edit_categoria): ?>
                    <input type="hidden" name="id_categoria" value="<?= $edit_categoria['id_categoria'] ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_categoria['nombre'] ?? '') ?>" placeholder="Ej: Ropa, Electr&oacute;nica...">
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($edit_categoria['slug'] ?? '') ?>" placeholder="Se genera autom&aacute;ticamente">
                        <div class="helper-text">Ej: ropa-deportiva, electronica. Sin espacios ni caracteres especiales.</div>
                    </div>

                    <div class="form-group">
                        <label for="id_padre">Categor&iacute;a padre (opcional)</label>
                        <select id="id_padre" name="id_padre">
                            <option value="">— Sin padre (categor&iacute;a ra&iacute;z) —</option>
                            <?= $options_html ?>
                        </select>
                        <div class="helper-text">Si seleccionas un padre, esta ser&aacute; una subcategor&iacute;a.</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><?= $edit_categoria ? '<i class="fas fa-save"></i> Actualizar' : '<i class="fas fa-plus"></i> Crear' ?></button>
                        <?php if ($edit_categoria): ?>
                        <a href="<?= BASE_URL ?>/categorias<?= $id_emprendimiento ? '?id_emprendimiento=' . $id_emprendimiento : '' ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
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
        <div class="notif-empty">
            <i class="fas fa-bell"></i>
            <p>No hay notificaciones nuevas</p>
        </div>
    </div>
</div>

<span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);

    var themeToggle = document.getElementById('themeToggle');
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

    var menuBtn = document.getElementById('menuBtn');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
    if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); }
    if (overlay) { overlay.addEventListener('click', toggleSidebar); }

    var userDropdown = document.getElementById('userDropdown');
    var userTrigger = document.getElementById('userTrigger');
    if (userTrigger) {
        userTrigger.addEventListener('click', function(e) { e.stopPropagation(); userDropdown.classList.toggle('active'); });
        document.addEventListener('click', function() { userDropdown.classList.remove('active'); });
    }

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
});
</script>
</body>
</html>