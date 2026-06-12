<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <title>Categorías - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        :root { --radius: 4px; }
        .cat-layout { display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start;margin-top:16px }
        @media(max-width:900px){.cat-layout{grid-template-columns:1fr}}
        .cat-card { background:var(--card-bg);border:1px solid var(--border);border-radius:var(--radius);padding:20px }
        .cat-card h3 { font-family:'Cormorant Garamond',serif;margin:0 0 12px;font-size:18px;color:var(--text) }
        .category-tree { list-style:none;padding:0;margin:0 }
        .category-tree li { padding:6px 0 6px 20px;border-left:1px dashed var(--border);margin:2px 0;position:relative }
        .category-tree li:before { content:'';position:absolute;left:0;top:50%;width:16px;height:0;border-top:1px dashed var(--border) }
        .category-tree li:last-child { border-left-color:transparent }
        .tree-toggle { cursor:pointer;display:inline-block;width:16px;text-align:center;font-size:10px;color:var(--text-muted);user-select:none;margin-right:4px }
        .tree-toggle-empty { visibility:hidden }
        .tree-toggle+.hidden { display:none }
        .cat-name { font-weight:500;font-size:14px }
        .cat-name .prod-badge { font-weight:400;font-size:11px;color:var(--text-muted);background:var(--hover-bg);padding:1px 6px;border-radius:10px;margin-left:6px }
        .btn-sm { display:inline-block;padding:2px 6px;font-size:12px;text-decoration:none;color:var(--text-muted);border-radius:var(--radius);opacity:.6 }
        .btn-sm:hover { opacity:1;background:var(--hover-bg) }
        .btn-sm.btn-danger:hover { color:#9a5a5a;background:rgba(154,90,90,.1) }
        .form-group { margin-bottom:12px }
        .form-group label { display:block;font-size:13px;font-weight:500;color:var(--text-muted);margin-bottom:4px }
        .form-group input,.form-group select { width:100%;padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius);background:var(--bg);color:var(--text);font-family:Inter,sans-serif;font-size:14px;box-sizing:border-box }
        .form-group input:focus,.form-group select:focus { outline:none;border-color:var(--accent) }
        .form-actions { display:flex;gap:8px;margin-top:16px }
        .form-actions .btn { padding:8px 20px;border:none;border-radius:var(--radius);cursor:pointer;font-family:Inter,sans-serif;font-size:14px;transition:opacity .2s }
        .form-actions .btn-primary { background:var(--text);color:var(--bg) }
        .form-actions .btn-primary:hover { opacity:.85 }
        .form-actions .btn-secondary { background:var(--hover-bg);color:var(--text) }
        .form-actions .btn-secondary:hover { opacity:.8 }
        .alert { padding:10px 14px;border-radius:var(--radius);font-size:13px;margin-bottom:12px }
        .alert-success { background:rgba(46,204,113,.12);color:#27ae60;border:1px solid rgba(46,204,113,.2) }
        .alert-error { background:rgba(231,76,60,.1);color:#c0392b;border:1px solid rgba(231,76,60,.15) }
        .empty-state { text-align:center;padding:40px 20px;color:var(--text-muted) }
        .empty-state i { font-size:36px;display:block;margin-bottom:8px;color:var(--text-muted) }
        .helper-text { font-size:12px;color:var(--text-muted);margin-top:3px }
        .sidebar { position:fixed;left:0;top:0;bottom:0;width:220px;background:var(--card-bg);border-right:1px solid var(--border);padding:20px 0;overflow-y:auto;z-index:100;display:flex;flex-direction:column }
        .sidebar .logo { padding:0 20px 20px;border-bottom:1px solid var(--border);margin-bottom:12px;text-align:center }
        .sidebar .logo a { font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--text);text-decoration:none;font-weight:500 }
        .sidebar a { display:flex;align-items:center;gap:8px;padding:8px 20px;color:var(--text);text-decoration:none;font-size:14px;transition:background .2s;cursor:pointer }
        .sidebar a:hover,.sidebar a.active { background:var(--hover-bg) }
        .sidebar a.active { border-right:2px solid var(--accent);color:var(--accent) }
        .sidebar a i { width:20px;text-align:center;flex-shrink:0;font-size:14px;color:var(--text-muted) }
        .sidebar a.active i { color:var(--accent) }
        .main-content { margin-left:220px;min-height:100vh;padding:24px 32px;max-width:1100px }
        .top-bar { display:flex;align-items:center;justify-content:space-between;margin-bottom:24px }
        .top-bar h2 { font-family:'Cormorant Garamond',serif;font-size:26px;margin:0;font-weight:500;color:var(--text) }
        .user-menu { display:flex;align-items:center;gap:12px }
        .avatar { width:32px;height:32px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;overflow:hidden;flex-shrink:0 }
        .avatar img { width:100%;height:100%;object-fit:cover }
        .role-selector { font-size:12px;padding:4px 8px;border:1px solid var(--border);border-radius:var(--radius);background:var(--bg);color:var(--text);font-family:Inter,sans-serif;cursor:pointer }
        .negocio-tabs { display:flex;gap:0;margin-bottom:16px;border-bottom:1px solid var(--border);flex-wrap:wrap }
        .negocio-tabs a { padding:8px 16px;font-size:13px;text-decoration:none;color:var(--text-muted);border-bottom:2px solid transparent;transition:all .2s }
        .negocio-tabs a:hover { color:var(--text) }
        .negocio-tabs a.active { color:var(--accent);border-bottom-color:var(--accent);font-weight:500 }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo"><a href="<?= BASE_URL ?>/dashboard">JACHA</a></div>
    <a href="<?= BASE_URL ?>/dashboard"><i class="fas fa-th-large"></i> Principal</a>
    <?php if ($es_admin): ?>
    <a href="<?= BASE_URL ?>/admin"><i class="fas fa-shield-alt"></i> Administración</a>
    <?php endif; ?>
    <a href="<?= BASE_URL ?>/productos"><i class="fas fa-cube"></i> Productos</a>
    <a href="<?= BASE_URL ?>/categorias" class="active"><i class="fas fa-folder"></i> Categorías</a>
    <a href="<?= BASE_URL ?>/sucursales"><i class="fas fa-code-branch"></i> Sucursales</a>
    <a href="<?= BASE_URL ?>/inventario"><i class="fas fa-boxes"></i> Inventario</a>
    <a href="<?= BASE_URL ?>/kardex"><i class="fas fa-history"></i> Kardex</a>
    <?php if ($es_admin): ?>
    <a href="<?= BASE_URL ?>/plantillas"><i class="fas fa-paint-brush"></i> Plantillas</a>
    <?php endif; ?>
    <a href="<?= BASE_URL ?>/herramientas" style="margin-top:24px;border-top:1px solid var(--border);padding-top:16px;"><i class="fas fa-tools"></i> Herramientas</a>
    <a href="<?= BASE_URL ?>/logout" style="margin-top:8px;"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
</div>

<div class="main-content">
    <div class="top-bar">
        <h2><i class="fas fa-folder" style="margin-right:8px;color:var(--accent)"></i> Categorías</h2>
        <div class="user-menu">
            <?php if (!empty($mis_negocios)): ?>
            <select class="role-selector" onchange="window.location.href='?id_emprendimiento='+this.value">
                <option value="">Todas las categorías</option>
                <?php foreach ($mis_negocios as $n): ?>
                <option value="<?= $n['id_emprendimiento'] ?>" <?= $id_emprendimiento === $n['id_emprendimiento'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($n['nombre_comercial']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
            <a href="#" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;color:var(--text-muted);text-decoration:none;transition:color .2s" title="Notificaciones" onclick="alert('Próximamente: centro de notificaciones');return false">
                <i class="fas fa-bell" style="font-size:15px"></i>
                <span style="position:absolute;top:4px;right:4px;width:7px;height:7px;border-radius:50%;background:#9a5a5a;display:none"></span>
            </a>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="background:none;border:none;color:var(--text-muted);font-size:18px;cursor:pointer;padding:4px;border-radius:var(--radius);transition:all .2s">&#9790;</button>
            <div class="avatar"><?php if ($avatar_usuario): ?><img src="data:image/jpeg;base64,<?= base64_encode($avatar_usuario) ?>"><?php else: ?><?= $inicial ?><?php endif; ?></div>
        </div>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="cat-layout">
        <div class="cat-card">
            <h3><i class="fas fa-sitemap" style="margin-right:6px;color:var(--accent)"></i> Árbol de categorías</h3>
            <?php if (empty($tree)): ?>
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>No hay categorías todavía.<br>Crea la primera desde el formulario.</p>
            </div>
            <?php else: ?>
            <?= $tree_html ?>
            <?php endif; ?>
        </div>

        <div class="cat-card">
            <h3><i class="fas fa-<?= $edit_categoria ? 'pen' : 'plus' ?>" style="margin-right:6px;color:var(--accent)"></i> <?= $edit_categoria ? 'Editar categoría' : 'Nueva categoría' ?></h3>
            <form method="POST">
                <?php if ($edit_categoria): ?>
                <input type="hidden" name="id_categoria" value="<?= $edit_categoria['id_categoria'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_categoria['nombre'] ?? '') ?>" placeholder="Ej: Ropa, Electrónica...">
                </div>

                <div class="form-group">
                    <label for="slug">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($edit_categoria['slug'] ?? '') ?>" placeholder="Se genera automáticamente si se deja vacío">
                    <div class="helper-text">Ej: ropa-deportiva, electronica. Sin espacios ni caracteres especiales.</div>
                </div>

                <div class="form-group">
                    <label for="id_padre">Categoría padre (opcional)</label>
                    <select id="id_padre" name="id_padre">
                        <option value="">— Sin padre (categoría raíz) —</option>
                        <?= $options_html ?>
                    </select>
                    <div class="helper-text">Si seleccionas un padre, esta será una subcategoría.</div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var saved = localStorage.getItem('jacha_theme') || localStorage.getItem('theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
    }
    var toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.addEventListener('click', function() {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme') || 'dark';
            var next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('jacha_theme', next);
        });
    }
});
</script>
</body>
</html>
