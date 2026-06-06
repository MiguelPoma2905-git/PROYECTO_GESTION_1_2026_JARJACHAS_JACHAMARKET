<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Administracion - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .admin-wrap { max-width:1400px; margin:0 auto; padding:32px 24px; }
        .admin-header { margin-bottom:32px; }
        .admin-header h1 { font-family:Georgia,var(--font-serif); font-size:28px; font-weight:400; color:var(--text); }
        .admin-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; display:flex; align-items:center; gap:8px; }
        .admin-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .admin-header .back:hover { color:var(--text); }

        .admin-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px; }
        .stat-card { background:var(--card-bg); border:1px solid var(--border); border-radius:12px; padding:24px; position:relative; overflow:hidden; transition:all .4s cubic-bezier(.4,0,.2,1); }
        .stat-card:hover { transform:translateY(-4px); border-color:var(--border-hi); box-shadow:var(--shadow-lg); }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--text); opacity:0; transition:opacity .4s; }
        .stat-card:hover::before { opacity:1; }
        .stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; margin-bottom:14px; }
        .stat-icon.users { background:rgba(150,150,150,0.1); color:var(--text); }
        .stat-icon.business { background:rgba(150,150,150,0.1); color:var(--text); }
        .stat-icon.products { background:rgba(150,150,150,0.1); color:var(--text); }
        .stat-icon.orders { background:rgba(150,150,150,0.1); color:var(--text); }
        .stat-card .num { font-size:32px; font-weight:700; color:var(--text); letter-spacing:-1px; }
        .stat-card .lab { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; font-weight:500; }

        .admin-body { }
        .msg { background:rgba(46,204,113,0.08); border-left:3px solid #2ecc71; padding:14px 18px; border-radius:8px; margin-bottom:24px; font-size:13px; color:#2ecc71; display:flex; align-items:center; gap:10px; }
        .msg.err { background:rgba(231,76,60,0.08); border-left-color:#e74c3c; color:#e74c3c; }

        .section { margin-bottom:40px; }
        .section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
        .section-header h2 { font-family:Georgia,var(--font-serif); font-size:24px; font-weight:400; color:var(--text); }
        .section-header .count { font-size:12px; color:var(--text-dim); background:var(--card-bg); padding:4px 12px; border-radius:20px; border:1px solid var(--border); }

        .table-wrap { background:var(--card-bg); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); }
        tbody tr { transition:all .2s; border-bottom:1px solid var(--border); }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,0.02); }
        td { padding:14px 20px; font-size:13px; color:var(--text); }
        td .email { color:var(--text-muted); font-size:12px; }
        .badge { display:inline-block; padding:3px 10px; border-radius:6px; font-size:10px; font-weight:600; background:rgba(255,255,255,0.05); color:var(--text-muted); margin:2px 3px; }
        .badge.admin { background:rgba(99,102,241,0.12); color:#6366f1; }
        .badge.vendedor { background:rgba(16,185,129,0.12); color:#10b981; }
        .badge.cliente { background:rgba(245,158,11,0.12); color:#f59e0b; }
        .badge.repartidor { background:rgba(239,68,68,0.12); color:#ef4444; }
        .status-dot { display:inline-block; width:8px; height:8px; border-radius:50%; margin-right:6px; }
        .status-dot.active { background:#10b981; }
        .status-dot.inactive { background:#ef4444; }
        .status-dot.blocked { background:#f59e0b; }

        .btn-group { display:flex; gap:6px; flex-wrap:wrap; }
        .btn-icon { display:inline-flex; align-items:center; gap:6px; padding:7px 16px; border-radius:8px; font-size:11px; font-weight:600; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
        .btn-icon.edit { background:var(--surface2); color:var(--text); }
        .btn-icon.edit:hover { background:var(--surface3); transform:translateY(-1px); }
        .btn-icon.del { background:rgba(239,68,68,0.1); color:#ef4444; }
        .btn-icon.del:hover { background:rgba(239,68,68,0.2); transform:translateY(-1px); }

        .nav-actions { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:24px; }
        .nav-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 22px; background:var(--text); color:var(--bg); border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; border:none; cursor:pointer; transition:all .2s; }
        .nav-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px var(--glow-lg); }
        .nav-btn-outline { display:inline-flex; align-items:center; gap:8px; padding:10px 22px; background:transparent; color:var(--text); border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; border:1px solid var(--border); cursor:pointer; transition:all .2s; }
        .nav-btn-outline:hover { background:var(--surface2); transform:translateY(-2px); }

        .reset-card { background:var(--card-bg); border:1px solid var(--border); border-radius:12px; padding:32px; border-left:3px solid #ef4444; margin-bottom:32px; }
        .reset-card h3 { font-family:Georgia,var(--font-serif); font-size:22px; font-weight:500; color:var(--text); margin-bottom:6px; }
        .reset-card p { font-size:13px; color:var(--text-dim); margin-bottom:20px; line-height:1.6; }
        .reset-card .input-group { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
        .reset-card input { background:var(--card-bg); border:1px solid var(--border); border-radius:8px; padding:12px 16px; color:var(--text); font-size:13px; width:200px; outline:none; transition:border .2s; }
        .reset-card input:focus { border-color:#ef4444; }
        .reset-card input::placeholder { color:var(--text-dim); }
        .btn-reset { display:inline-flex; align-items:center; gap:8px; background:rgba(239,68,68,0.12); color:#ef4444; border:1px solid rgba(239,68,68,0.2); padding:12px 28px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:all .3s; }
        .btn-reset:hover { background:rgba(239,68,68,0.2); transform:translateY(-2px); box-shadow:0 8px 24px rgba(239,68,68,0.15); }

        @media(max-width:1024px){ .admin-stats{grid-template-columns:repeat(2,1fr)} }
        @media(max-width:768px){
            .admin-wrap{padding:24px 16px}
            .admin-stats{padding:0;grid-template-columns:1fr}
            table{font-size:12px}
            thead th,td{padding:10px 14px}
            .btn-group{flex-direction:column}
            .reset-card .input-group{flex-direction:column;align-items:stretch}
            .reset-card input{width:100%}
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

    <!-- Header -->
    <div class="admin-header">
        <h1>Panel de Administracion</h1>
        <p class="sub">
            <i class="fas fa-shield-halved" style="color:var(--text-muted)"></i>
            Super administrador: <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>
        </p>
    </div>

    <!-- Stats -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-icon users"><i class="fas fa-users"></i></div>
            <div class="num"><?= $stats['usuarios'] ?></div>
            <div class="lab">Usuarios registrados</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon business"><i class="fas fa-store"></i></div>
            <div class="num"><?= $stats['negocios'] ?></div>
            <div class="lab">Negocios activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon products"><i class="fas fa-box"></i></div>
            <div class="num"><?= $stats['productos'] ?></div>
            <div class="lab">Productos publicados</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orders"><i class="fas fa-truck"></i></div>
            <div class="num"><?= $stats['pedidos'] ?></div>
            <div class="lab">Pedidos realizados</div>
        </div>
    </div>

    <!-- Nav actions -->
    <div class="nav-actions">
        <a href="<?= BASE_URL ?>/admin/ventas" class="nav-btn"><i class="fas fa-chart-line"></i> Ver Ventas</a>
        <form method="POST" action="<?= BASE_URL ?>/admin/seed-demo" style="margin:0">
            <button type="submit" class="nav-btn-outline"><i class="fas fa-database"></i> Cargar Datos Base</button>
        </form>
    </div>

    <!-- Messages -->
    <?php if (isset($_SESSION['admin_msg'])): ?>
        <div class="msg"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['admin_msg']) ?><?php unset($_SESSION['admin_msg']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['admin_error'])): ?>
        <div class="msg err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['admin_error']) ?><?php unset($_SESSION['admin_error']); ?></div>
    <?php endif; ?>

    <!-- Users -->
    <div class="section">
        <div class="section-header">
            <h2>Usuarios</h2>
            <span class="count"><?= count($usuarios) ?> registrados</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Roles</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td style="color:var(--text-dim);font-size:12px">#<?= $u['id_usuario'] ?></td>
                        <td><strong><?= htmlspecialchars($u['nombres'] . ' ' . $u['apellidos']) ?></strong></td>
                        <td><span class="email"><?= htmlspecialchars($u['email']) ?></span></td>
                        <td>
                            <?php foreach (explode(',', $u['roles'] ?? '') as $rol):
                                $rc = trim($rol);
                                $cls = $rc === 'Administrador' ? 'admin' : ($rc === 'Emprendedor' ? 'vendedor' : ($rc === 'Cliente' ? 'cliente' : ($rc === 'Repartidor' ? 'repartidor' : '')));
                            ?>
                                <span class="badge <?= $cls ?>"><?= htmlspecialchars($rc) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php $est = $u['estado'] ?? 'Activo'; ?>
                            <span class="status-dot <?= strtolower($est) === 'activo' ? 'active' : (strtolower($est) === 'inactivo' ? 'inactive' : 'blocked') ?>"></span>
                            <?= $est ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= BASE_URL ?>/admin/editar-usuario?id=<?= $u['id_usuario'] ?>" class="btn-icon edit"><i class="fas fa-pen"></i> Editar</a>
                                <?php if ($u['email'] !== 'mikypramos2905@gmail.com'): ?>
                                <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-usuario" onsubmit="return confirm('Eliminar usuario <?= htmlspecialchars($u['nombres']) ?>?');" style="margin:0">
                                    <input type="hidden" name="id" value="<?= $u['id_usuario'] ?>">
                                    <button type="submit" class="btn-icon del"><i class="fas fa-trash"></i> Eliminar</button>
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
    <div class="section">
        <div class="section-header">
            <h2>Negocios</h2>
            <span class="count"><?= count($negocios) ?> registrados</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Nombre comercial</th><th>Propietario</th><th>Estado</th><th>Descripcion</th><th>Accion</th></tr></thead>
                <tbody>
                <?php foreach ($negocios as $n): ?>
                    <tr>
                        <td style="color:var(--text-dim);font-size:12px">#<?= $n['id_emprendimiento'] ?></td>
                        <td><strong><?= htmlspecialchars($n['nombre_comercial']) ?></strong></td>
                        <td><span class="email"><?= htmlspecialchars($n['propietario_email']) ?></span></td>
                        <td>
                            <?php $estN = $n['estado'] ?? 'Pendiente'; ?>
                            <span class="status-dot <?= strtolower($estN) === 'aprobado' ? 'active' : (strtolower($estN) === 'pendiente' ? 'blocked' : 'inactive') ?>"></span>
                            <?= $estN ?>
                        </td>
                        <td style="color:var(--text-dim);font-size:12px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars(substr($n['descripcion'] ?? '', 0, 50)) ?></td>
                        <td>
                            <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-negocio" onsubmit="return confirm('Eliminar negocio <?= htmlspecialchars($n['nombre_comercial']) ?>?');" style="margin:0">
                                <input type="hidden" name="id" value="<?= $n['id_emprendimiento'] ?>">
                                <button type="submit" class="btn-icon del"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reset -->
    <div class="reset-card">
        <h3><i class="fas fa-exclamation-triangle" style="color:#ef4444;margin-right:10px"></i>Reiniciar base de datos</h3>
        <p>Esto eliminara TODOS los datos (negocios, productos, pedidos, usuarios no-admin) y reconstruira la base de datos desde cero. El super administrador se mantendra. <strong style="color:#ef4444">Esta accion no se puede deshacer.</strong></p>
        <form method="POST" action="<?= BASE_URL ?>/admin/reiniciar-bd" onsubmit="return confirm('ESTAS ABSOLUTAMENTE SEGURO? Se borraran todos los datos. Escribe RESET para confirmar.');">
            <div class="input-group">
                <input type="text" name="confirmar" placeholder="Escribe RESET para confirmar" required>
                <button type="submit" class="btn-reset"><i class="fas fa-radiation"></i> Reiniciar base de datos</button>
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
