<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        :root {
            --admin-bg: #0a0a0f;
            --admin-card: #12121a;
            --admin-border: rgba(255,255,255,0.06);
            --admin-glow: rgba(99,102,241,0.12);
            --admin-accent: #6366f1;
            --admin-accent2: #8b5cf6;
            --admin-success: #10b981;
            --admin-danger: #ef4444;
            --admin-warning: #f59e0b;
            --admin-text: #f1f5f9;
            --admin-muted: #94a3b8;
            --admin-dim: #475569;
        }
        [data-theme="light"] {
            --admin-bg: #f8fafc;
            --admin-card: #ffffff;
            --admin-border: rgba(0,0,0,0.08);
            --admin-glow: rgba(99,102,241,0.08);
            --admin-text: #0f172a;
            --admin-muted: #64748b;
            --admin-dim: #94a3b8;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Inter',system-ui,sans-serif;
            background:var(--admin-bg); color:var(--admin-text);
            min-height:100vh;
        }
        .admin-wrap { max-width:1400px; margin:0 auto; padding:0; }

        /* HERO */
        .admin-hero {
            background:linear-gradient(135deg,#0f0f1a 0%,#1a1a2e 50%,#0f0f1a 100%);
            padding:48px 40px 80px;
            position:relative; overflow:hidden;
        }
        [data-theme="light"] .admin-hero {
            background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 50%,#eef2ff 100%);
        }
        .admin-hero::before {
            content:''; position:absolute; top:-50%; right:-20%;
            width:600px; height:600px;
            background:radial-gradient(circle,rgba(99,102,241,0.15) 0%,transparent 60%);
            pointer-events:none;
        }
        .admin-hero::after {
            content:''; position:absolute; bottom:0; left:0; right:0;
            height:1px;
            background:linear-gradient(90deg,transparent,rgba(99,102,241,0.3),transparent);
        }
        .admin-hero-inner { position:relative; z-index:1; }
        .admin-hero-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:40px; }
        .admin-hero h1 {
            font-family:'Cormorant Garamond',serif;
            font-size:42px; font-weight:500;
            background:linear-gradient(135deg,#fff,#94a3b8);
            -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        [data-theme="light"] .admin-hero h1 {
            background:linear-gradient(135deg,#1e293b,#6366f1);
            -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        .admin-hero .sub { font-size:13px; color:var(--admin-muted); margin-top:4px; }
        .admin-hero .back {
            color:var(--admin-muted); text-decoration:none; font-size:13px;
            display:flex; align-items:center; gap:6px; transition:all .2s;
            padding:8px 16px; border-radius:8px; background:rgba(255,255,255,0.04);
        }
        .admin-hero .back:hover { color:#fff; background:rgba(255,255,255,0.08); }
        [data-theme="light"] .admin-hero .back:hover { color:#1e293b; background:rgba(0,0,0,0.06); }

        /* STATS */
        .admin-stats {
            display:grid; grid-template-columns:repeat(4,1fr); gap:20px;
            margin-top:-40px; padding:0 40px; position:relative; z-index:2;
        }
        .stat-card {
            background:var(--admin-card); border:1px solid var(--admin-border);
            border-radius:20px; padding:28px; position:relative; overflow:hidden;
            transition:all .4s cubic-bezier(.4,0,.2,1);
            animation:fadeUp .5s ease both;
        }
        .stat-card:nth-child(1){animation-delay:0.05s}
        .stat-card:nth-child(2){animation-delay:0.10s}
        .stat-card:nth-child(3){animation-delay:0.15s}
        .stat-card:nth-child(4){animation-delay:0.20s}
        .stat-card:hover { transform:translateY(-4px); border-color:rgba(99,102,241,0.2); box-shadow:0 12px 40px rgba(99,102,241,0.08); }
        .stat-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,var(--admin-accent),var(--admin-accent2));
            opacity:0; transition:opacity .4s;
        }
        .stat-card:hover::before { opacity:1; }
        .stat-icon {
            width:44px; height:44px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; margin-bottom:16px;
        }
        .stat-icon.users { background:rgba(99,102,241,0.12); color:#6366f1; }
        .stat-icon.business { background:rgba(16,185,129,0.12); color:#10b981; }
        .stat-icon.products { background:rgba(245,158,11,0.12); color:#f59e0b; }
        .stat-icon.orders { background:rgba(139,92,246,0.12); color:#8b5cf6; }
        .stat-card .num { font-size:36px; font-weight:700; color:var(--admin-text); letter-spacing:-1px; }
        .stat-card .lab { font-size:11px; color:var(--admin-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; font-weight:500; }

        /* CONTENT */
        .admin-body { padding:40px; }

        /* MESSAGES */
        .msg {
            background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.2);
            padding:14px 20px; border-radius:12px; margin-bottom:24px;
            font-size:13px; color:#10b981; display:flex; align-items:center; gap:10px;
        }
        .msg.err { background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.2); color:#ef4444; }

        /* SECTION */
        .section {
            margin-bottom:40px;
            animation:fadeUp .5s ease both; animation-delay:0.25s;
        }
        .section-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:20px;
        }
        .section-header h2 {
            font-family:'Cormorant Garamond',serif;
            font-size:26px; font-weight:500; color:var(--admin-text);
        }
        .section-header .count {
            font-size:12px; color:var(--admin-dim); background:var(--admin-card);
            padding:4px 12px; border-radius:20px; border:1px solid var(--admin-border);
        }

        /* TABLE */
        .table-wrap {
            background:var(--admin-card); border:1px solid var(--admin-border);
            border-radius:20px; overflow:hidden;
        }
        table { width:100%; border-collapse:collapse; }
        thead th {
            text-align:left; padding:14px 20px;
            font-size:10px; font-weight:600; color:var(--admin-dim);
            text-transform:uppercase; letter-spacing:1px;
            border-bottom:1px solid var(--admin-border);
            background:rgba(255,255,255,0.02);
        }
        [data-theme="light"] thead th { background:rgba(0,0,0,0.02); }
        tbody tr {
            transition:all .2s;
            border-bottom:1px solid var(--admin-border);
        }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(99,102,241,0.03); }
        td { padding:14px 20px; font-size:13px; color:var(--admin-text); }
        td .email { color:var(--admin-muted); font-size:12px; }
        .badge {
            display:inline-block; padding:3px 10px; border-radius:6px;
            font-size:10px; font-weight:600; letter-spacing:.3px;
            background:rgba(255,255,255,0.05); color:var(--admin-muted);
            margin:2px 3px;
        }
        .badge.admin { background:rgba(99,102,241,0.12); color:#6366f1; }
        .badge.vendedor { background:rgba(16,185,129,0.12); color:#10b981; }
        .badge.cliente { background:rgba(245,158,11,0.12); color:#f59e0b; }
        .badge.repartidor { background:rgba(239,68,68,0.12); color:#ef4444; }
        .status-dot { display:inline-block; width:8px; height:8px; border-radius:50%; margin-right:6px; }
        .status-dot.active { background:#10b981; }
        .status-dot.inactive { background:#ef4444; }
        .status-dot.blocked { background:#f59e0b; }

        /* BUTTONS */
        .btn-group { display:flex; gap:6px; flex-wrap:wrap; }
        .btn-icon {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 16px; border-radius:8px; font-size:11px; font-weight:600;
            border:none; cursor:pointer; text-decoration:none;
            transition:all .2s;
        }
        .btn-icon.edit { background:rgba(99,102,241,0.1); color:#6366f1; }
        .btn-icon.edit:hover { background:rgba(99,102,241,0.2); transform:translateY(-1px); }
        .btn-icon.del { background:rgba(239,68,68,0.1); color:#ef4444; }
        .btn-icon.del:hover { background:rgba(239,68,68,0.2); transform:translateY(-1px); }

        /* RESET SECTION */
        .reset-card {
            background:var(--admin-card); border:1px solid var(--admin-border);
            border-radius:20px; padding:32px;
            border-left:3px solid var(--admin-danger);
            animation:fadeUp .5s ease both; animation-delay:0.35s;
        }
        .reset-card h3 { font-family:'Cormorant Garamond',serif; font-size:22px; font-weight:500; color:var(--admin-text); margin-bottom:6px; }
        .reset-card p { font-size:13px; color:var(--admin-dim); margin-bottom:20px; line-height:1.6; }
        .reset-card .input-group { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
        .reset-card input {
            background:rgba(255,255,255,0.04); border:1px solid var(--admin-border);
            border-radius:10px; padding:12px 16px; color:var(--admin-text);
            font-size:13px; width:180px; transition:border .2s;
        }
        .reset-card input:focus { outline:none; border-color:var(--admin-danger); }
        .reset-card input::placeholder { color:var(--admin-dim); }
        .btn-reset {
            background:rgba(239,68,68,0.12); color:#ef4444;
            border:1px solid rgba(239,68,68,0.2); padding:12px 28px;
            border-radius:10px; font-size:13px; font-weight:600;
            cursor:pointer; transition:all .3s; display:flex; align-items:center; gap:8px;
        }
        .btn-reset:hover { background:rgba(239,68,68,0.2); transform:translateY(-2px); box-shadow:0 8px 24px rgba(239,68,68,0.15); }
        .btn-reset i { font-size:14px; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

        @media(max-width:1024px){ .admin-stats{grid-template-columns:repeat(2,1fr)} }
        @media(max-width:768px){
            .admin-hero{padding:32px 20px 64px}
            .admin-stats{padding:0 20px;grid-template-columns:1fr}
            .admin-body{padding:24px 20px}
            .admin-hero-top{flex-direction:column;align-items:flex-start;gap:16px}
            table{font-size:12px}
            thead th,td{padding:10px 14px}
            .btn-group{flex-direction:column}
            .reset-card .input-group{flex-direction:column;align-items:stretch}
            .reset-card input{width:100%}
        }
    </style>
</head>
<body>
<div class="admin-wrap">

    <!-- HERO -->
    <div class="admin-hero">
        <div class="admin-hero-inner">
            <div class="admin-hero-top">
                <div>
                    <h1>Panel de Administración</h1>
                    <p class="sub">
                        <i class="fas fa-shield-halved" style="margin-right:6px;color:#6366f1"></i>
                        Super administrador: <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>
                    </p>
                </div>
                <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
            </div>
        </div>
    </div>

    <!-- STATS -->
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

    <!-- NAV ACTIONS -->
    <div class="admin-body" style="padding-bottom:0">
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px">
            <a href="<?= BASE_URL ?>/admin/ventas" class="btn-icon edit" style="padding:12px 24px;font-size:13px;background:rgba(16,185,129,0.12);color:#10b981">
                <i class="fas fa-chart-line"></i> Ver Ventas
            </a>
            <form method="POST" action="<?= BASE_URL ?>/admin/seed-demo" style="margin:0">
                <button type="submit" class="btn-icon edit" style="padding:12px 24px;font-size:13px;background:rgba(99,102,241,0.12);color:#6366f1">
                    <i class="fas fa-database"></i> Cargar Datos Demo (Electrodomésticos)
                </button>
            </form>
        </div>
    </div>

    <!-- MESSAGES -->
    <div class="admin-body">
        <?php if (isset($_SESSION['admin_msg'])): ?>
            <div class="msg"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['admin_msg']) ?><?php unset($_SESSION['admin_msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['admin_error'])): ?>
            <div class="msg err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['admin_error']) ?><?php unset($_SESSION['admin_error']); ?></div>
        <?php endif; ?>

        <!-- USERS -->
        <div class="section">
            <div class="section-header">
                <h2><i class="fas fa-users" style="margin-right:10px;color:#6366f1"></i>Usuarios</h2>
                <span class="count"><?= count($usuarios) ?> registrados</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Roles</th><th>Estado</th><th>Acciones</th></tr></thead>
                    <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td style="color:var(--admin-dim);font-size:12px">#<?= $u['id_usuario'] ?></td>
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
                                    <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-usuario" onsubmit="return confirm('¿Eliminar usuario <?= htmlspecialchars($u['nombres']) ?>?');" style="margin:0">
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

        <!-- BUSINESSES -->
        <div class="section">
            <div class="section-header">
                <h2><i class="fas fa-store" style="margin-right:10px;color:#10b981"></i>Negocios</h2>
                <span class="count"><?= count($negocios) ?> registrados</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>ID</th><th>Nombre comercial</th><th>Propietario</th><th>Estado</th><th>Descripción</th><th>Acción</th></tr></thead>
                    <tbody>
                    <?php foreach ($negocios as $n): ?>
                        <tr>
                            <td style="color:var(--admin-dim);font-size:12px">#<?= $n['id_emprendimiento'] ?></td>
                            <td><strong><?= htmlspecialchars($n['nombre_comercial']) ?></strong></td>
                            <td><span class="email"><?= htmlspecialchars($n['propietario_email']) ?></span></td>
                            <td>
                                <?php $estN = $n['estado'] ?? 'Pendiente'; ?>
                                <span class="status-dot <?= strtolower($estN) === 'aprobado' ? 'active' : (strtolower($estN) === 'pendiente' ? 'blocked' : 'inactive') ?>"></span>
                                <?= $estN ?>
                            </td>
                            <td style="color:var(--admin-dim);font-size:12px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars(substr($n['descripcion'] ?? '', 0, 50)) ?></td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>/admin/eliminar-negocio" onsubmit="return confirm('¿Eliminar negocio <?= htmlspecialchars($n['nombre_comercial']) ?>?');" style="margin:0">
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

        <!-- RESET -->
        <div class="reset-card">
            <h3><i class="fas fa-exclamation-triangle" style="color:#ef4444;margin-right:10px"></i>Reiniciar base de datos</h3>
            <p>Esto eliminará TODOS los datos (negocios, productos, pedidos, usuarios no-admin) y reconstruirá la base de datos desde cero. El super administrador se mantendrá. <strong style="color:#ef4444">Esta acción no se puede deshacer.</strong></p>
            <form method="POST" action="<?= BASE_URL ?>/admin/reiniciar-bd" onsubmit="return confirm('¿ESTÁS ABSOLUTAMENTE SEGURO? Se borrarán todos los datos. Escribe RESET para confirmar.');">
                <div class="input-group">
                    <input type="text" name="confirmar" placeholder="Escribe RESET para confirmar" required>
                    <button type="submit" class="btn-reset"><i class="fas fa-radiation"></i> Reiniciar base de datos</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();
</script>
</body>
</html>
