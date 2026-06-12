<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sucursales - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .suc-wrap { max-width:1200px; margin:0 auto; padding:32px 24px; }
        .suc-header { margin-bottom:32px; }
        .suc-header h1 { font-family:Georgia,'Cormorant Garamond',serif; font-size:28px; font-weight:400; color:var(--text); display:flex; align-items:center; gap:12px; }
        .suc-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; }
        .suc-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .suc-header .back:hover { color:var(--text); }
        .suc-tabs { display:flex; gap:4px; margin-bottom:28px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:4px; overflow-x:auto; }
        .suc-tab { padding:10px 20px; border-radius:4px; font-size:12px; font-weight:500; color:var(--text-muted); text-decoration:none; white-space:nowrap; transition:all .15s; }
        .suc-tab:hover { color:var(--text); background:var(--surface2); }
        .suc-tab.active { background:var(--text); color:var(--bg); }
        .suc-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; margin-bottom:24px; }
        .suc-card h2 { font-family:Georgia,'Cormorant Garamond',serif; font-size:18px; font-weight:500; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .suc-form { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .suc-form .full { grid-column:1/-1; }
        .suc-form label { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.5px; font-weight:600; display:block; margin-bottom:4px; }
        .suc-form input, .suc-form textarea { width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:4px; background:var(--card-bg); color:var(--text); font-size:13px; font-family:'Inter',sans-serif; outline:none; box-sizing:border-box; transition:border-color .2s; }
        .suc-form input:focus, .suc-form textarea:focus { border-color:var(--border-hi); }
        .suc-form textarea { resize:vertical; min-height:60px; }
        .suc-form .btn-row { grid-column:1/-1; display:flex; gap:10px; margin-top:4px; }
        .btn-primary { display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:var(--text);color:var(--bg);border:none;border-radius:4px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif; }
        .btn-primary:hover { opacity:0.9; }
        .btn-secondary { display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:transparent;color:var(--text-muted);border:1px solid var(--border);border-radius:4px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;font-family:'Inter',sans-serif; }
        .btn-secondary:hover { border-color:var(--border-hi);color:var(--text); }
        .btn-danger { display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:4px;font-size:11px;font-weight:600;background:rgba(154,90,90,0.08);color:#9a5a5a;border:1px solid rgba(154,90,90,0.15);cursor:pointer;text-decoration:none;font-family:'Inter',sans-serif; }
        .btn-danger:hover { background:rgba(154,90,90,0.15); }
        .suc-table { width:100%; border-collapse:collapse; }
        .suc-table th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); }
        [data-theme="light"] .suc-table th { background:rgba(0,0,0,0.03); }
        .suc-table td { padding:14px 20px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .suc-table tbody tr:last-child td { border-bottom:none; }
        .suc-table tbody tr:hover { background:rgba(255,255,255,0.015); }
        [data-theme="light"] .suc-table tbody tr:hover { background:rgba(0,0,0,0.03); }
        .badge-ok { display:inline-block;padding:3px 10px;border-radius:4px;font-size:10px;font-weight:600;background:rgba(107,143,113,0.1);color:#6b8f71; }
        .empty-state { text-align:center;padding:60px 20px;color:var(--text-dim); }
        .empty-state i { font-size:36px;margin-bottom:12px;opacity:0.3;color:var(--text-muted); }
        .msg-success { background:rgba(107,143,113,0.1);border-left:3px solid #6b8f71;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#6b8f71;display:flex;align-items:center;gap:10px; }
        .msg-error { background:rgba(154,90,90,0.1);border-left:3px solid #9a5a5a;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#9a5a5a;display:flex;align-items:center;gap:10px; }
        .acoes { display:flex;gap:6px; }
        @media(max-width:900px){
            .suc-wrap { padding:24px 20px; }
            .suc-form { grid-template-columns:1fr; }
            .suc-form div[style*="grid-template-columns"] { grid-template-columns:1fr !important; }
            .suc-table th,.suc-table td { padding:12px 14px; white-space:nowrap; }
        }
        @media(max-width:480px){
            .suc-wrap { padding:16px 12px; }
            .suc-header h1 { font-size:22px; }
            .suc-card { padding:16px; }
            .suc-table th,.suc-table td { padding:10px 10px; font-size:12px; }
            .acoes { flex-direction:column; gap:4px; }
            .acoes a, .acoes form { width:100%; }
            .acoes .btn-danger, .acoes .btn-secondary { justify-content:center; width:100%; }
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
        <a href="<?= BASE_URL ?>/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>/productos"><i class="fas fa-cube"></i> Productos</a>
        <a href="<?= BASE_URL ?>/categorias"><i class="fas fa-folder"></i> Categorías</a>
        <a href="<?= BASE_URL ?>/gestionar-negocios"><i class="fas fa-store-alt"></i> Gestionar negocios</a>
        <a href="<?= BASE_URL ?>/repartidores-admin"><i class="fas fa-truck"></i> Repartidores</a>
        <a href="<?= BASE_URL ?>/plantillas-disponibles"><i class="fas fa-plus-circle"></i> Nuevo negocio</a>
        <a href="<?= BASE_URL ?>/herramientas" style="margin-top:24px;border-top:1px solid var(--border);padding-top:16px;"><i class="fas fa-tools"></i> Herramientas</a>
        <a href="<?= BASE_URL ?>/sucursales" class="active"><i class="fas fa-code-branch"></i> Sucursales</a>
        <a href="<?= BASE_URL ?>/inventario"><i class="fas fa-boxes"></i> Inventario</a>
        <a href="<?= BASE_URL ?>/kardex"><i class="fas fa-history"></i> Kardex</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:8px;"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
    </nav>
</div>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
        </div>
        <div style="display:flex;align-items:center;gap:0">
            <a href="#" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;color:var(--text-muted);text-decoration:none;transition:color .2s;margin-right:4px" title="Notificaciones" onclick="alert('Próximamente: centro de notificaciones');return false">
                <i class="fas fa-bell" style="font-size:15px"></i>
                <span style="position:absolute;top:4px;right:4px;width:7px;height:7px;border-radius:50%;background:#9a5a5a;display:none"></span>
            </a>
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

    <div class="suc-header">
        <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
        <h1><i class="fas fa-map-marker-alt" style="color:var(--text-muted)"></i> Sucursales</h1>
        <div class="sub">Gestiona las sucursales de tus negocios</div>
    </div>

    <?php if ($success): ?>
        <div class="msg-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (count($mis_negocios) > 0): ?>

    <div class="suc-tabs">
        <?php foreach ($mis_negocios as $n): ?>
            <a href="<?= BASE_URL ?>/sucursales?id_emprendimiento=<?= $n['id_emprendimiento'] ?>" class="suc-tab <?= $id_emprendimiento == $n['id_emprendimiento'] ? 'active' : '' ?>">
                <i class="fas fa-store"></i> <?= htmlspecialchars($n['nombre_comercial']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($negocio_seleccionado): ?>

    <div class="suc-card">
        <h2><i class="fas fa-plus-circle" style="color:var(--text-muted)"></i> <?= $edit_sucursal ? 'Editar sucursal' : 'Nueva sucursal' ?></h2>
        <form method="POST" action="<?= BASE_URL ?>/sucursales?id_emprendimiento=<?= $id_emprendimiento ?>" class="suc-form">
            <input type="hidden" name="accion" value="<?= $edit_sucursal ? 'editar' : 'crear' ?>">
            <?php if ($edit_sucursal): ?>
                <input type="hidden" name="id_sucursal" value="<?= $edit_sucursal['id_sucursal'] ?>">
            <?php endif; ?>
            <div class="full">
                <label>Nombre de la sucursal *</label>
                <input type="text" name="nombre_sucursal" required value="<?= htmlspecialchars($edit_sucursal['nombre_sucursal'] ?? '') ?>" placeholder="Ej: Sucursal Centro">
            </div>
            <div class="full">
                <label>Dirección</label>
                <textarea name="direccion" placeholder="Ej: Av. Principal #123"><?= htmlspecialchars($edit_sucursal['direccion'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Ciudad</label>
                <input type="text" name="ciudad" value="<?= htmlspecialchars($edit_sucursal['ciudad'] ?? '') ?>" placeholder="Ej: La Paz">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div>
                    <label>Latitud</label>
                    <input type="text" name="latitud" value="<?= htmlspecialchars($edit_sucursal['latitud'] ?? '') ?>" placeholder="Ej: -16.5000">
                </div>
                <div>
                    <label>Longitud</label>
                    <input type="text" name="longitud" value="<?= htmlspecialchars($edit_sucursal['longitud'] ?? '') ?>" placeholder="Ej: -68.1500">
                </div>
            </div>
            <div class="btn-row">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> <?= $edit_sucursal ? 'Guardar cambios' : 'Crear sucursal' ?></button>
                <?php if ($edit_sucursal): ?>
                    <a href="<?= BASE_URL ?>/sucursales?id_emprendimiento=<?= $id_emprendimiento ?>" class="btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="suc-card">
        <h2><i class="fas fa-list" style="color:var(--text-muted)"></i> Sucursales de <?= htmlspecialchars($negocio_seleccionado['nombre_comercial']) ?>
            <span style="font-size:12px;font-weight:400;color:var(--text-dim);margin-left:auto;"><?= count($sucursales) ?> sucursal(es)</span>
        </h2>
        <?php if (count($sucursales) > 0): ?>
        <div style="overflow-x:auto">
            <table class="suc-table">
                <thead>
                    <tr><th>Nombre</th><th>Dirección</th><th>Ciudad</th><th>Variantes</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($sucursales as $s): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($s['nombre_sucursal']) ?></strong></td>
                        <td style="color:var(--text-muted);font-size:12px"><?= htmlspecialchars($s['direccion'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($s['ciudad'] ?? '—') ?></td>
                        <td><span class="badge-ok"><?= (int)$s['total_variantes'] ?> producto(s)</span></td>
                        <td>
                            <div class="acoes">
                                <a href="<?= BASE_URL ?>/sucursales?id_emprendimiento=<?= $id_emprendimiento ?>&edit=<?= $s['id_sucursal'] ?>" class="btn-secondary" style="padding:7px 14px;font-size:11px"><i class="fas fa-pen"></i> Editar</a>
                                <?php if (count($sucursales) > 1): ?>
                                <form method="POST" action="<?= BASE_URL ?>/sucursales?id_emprendimiento=<?= $id_emprendimiento ?>" onsubmit="return confirm('Eliminar sucursal <?= htmlspecialchars($s['nombre_sucursal']) ?>? Se borrar\u00e1n todos sus datos de inventario.');" style="margin:0">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id_sucursal" value="<?= $s['id_sucursal'] ?>">
                                    <button type="submit" class="btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-map-marker-alt"></i>
            <p>No hay sucursales registradas</p>
            <p style="font-size:12px;color:var(--text-dim);margin-top:8px">Crea la primera sucursal usando el formulario de arriba.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <div class="suc-card">
        <div class="empty-state">
            <i class="fas fa-store"></i>
            <p>Selecciona un negocio para ver sus sucursales</p>
        </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="suc-card">
        <div class="empty-state">
            <i class="fas fa-store"></i>
            <p>No tienes negocios creados</p>
            <p style="font-size:12px;color:var(--text-dim);margin-top:8px;margin-bottom:20px">Crea un negocio primero para gestionar sucursales.</p>
            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-primary"><i class="fas fa-plus"></i> Crear negocio</a>
        </div>
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
