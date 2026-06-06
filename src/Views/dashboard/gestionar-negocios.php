<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Gestionar Negocios - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .wrap { max-width:1200px; margin:0 auto; padding:32px 24px; }
        [data-theme="light"] .sidebar-header img { filter:brightness(0); }
        .page-hdr { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
        .page-hdr h1 { font-family:'Cormorant Garamond',serif; font-size:28px; font-weight:500; color:var(--text); }
        .page-hdr .sub { font-size:13px; color:var(--text-muted); margin-top:2px; }

        .msg { border-radius:3px; padding:12px 16px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .msg-ok { background:rgba(107,143,113,0.1); border:1px solid rgba(107,143,113,0.15); color:#6b8f71; }
        .msg-err { background:rgba(154,90,90,0.1); border:1px solid rgba(154,90,90,0.15); color:#9a5a5a; }

        .t-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; overflow:hidden; }
        .twrap { overflow-x:auto; }
        table.dt { width:100%; border-collapse:collapse; }
        .dt th { text-align:left; padding:14px 18px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); white-space:nowrap; }
        .dt td { padding:14px 18px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .dt tbody tr:last-child td { border-bottom:none; }
        .dt tbody tr:hover { background:rgba(255,255,255,0.015); }
        .dt .color-dot { width:10px; height:10px; border-radius:50%; display:inline-block; vertical-align:middle; margin-right:8px; flex-shrink:0; }

        .sb { display:inline-block; padding:3px 10px; border-radius:3px; font-size:10px; font-weight:600; white-space:nowrap; }
        .sb-Aprobado { background:rgba(107,143,113,0.15); color:#6b8f71; }
        .sb-Pendiente { background:rgba(154,138,74,0.15); color:#9a8a4a; }
        .sb-Rechazado { background:rgba(154,90,90,0.15); color:#9a5a5a; }
        .sb-Oculto { background:rgba(107,127,143,0.15); color:#6b7f8f; }

        .acts { display:flex; gap:6px; flex-wrap:wrap; }
        .ba { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:3px; font-size:11px; font-weight:500; text-decoration:none; cursor:pointer; border:none; font-family:inherit; transition:opacity .2s; }
        .ba:hover { opacity:0.8; }
        .ba-show { background:rgba(107,143,113,0.12); color:#6b8f71; }
        .ba-hide { background:rgba(107,127,143,0.12); color:#6b7f8f; }
        .ba-del { background:rgba(154,90,90,0.12); color:#9a5a5a; }

        .es { padding:60px 20px; text-align:center; color:var(--text-dim); }
        .es p { font-size:13px; color:var(--text-muted); }
        .es .btn-p { display:inline-flex; align-items:center; gap:7px; padding:12px 22px; background:var(--text); color:var(--bg); border:none; border-radius:4px; font-size:13px; font-weight:600; cursor:pointer; transition:opacity .2s; font-family:inherit; text-decoration:none; margin-top:16px; }
        .es .btn-p:hover { opacity:0.85; }

        @media(max-width:768px){
            .wrap { padding:16px; }
            .dt td,.dt th { padding:10px 12px; }
            .acts { flex-direction:column; gap:4px; }
            .page-hdr { flex-direction:column; align-items:flex-start; gap:8px; }
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
        <a href="<?= BASE_URL ?>/productos"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Productos</a>
        <a href="<?= BASE_URL ?>/gestionar-negocios" class="active"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Gestionar negocios</a>
        <a href="<?= BASE_URL ?>/repartidores-admin"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Repartidores</a>
        <a href="<?= BASE_URL ?>/plantillas-disponibles"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Nuevo negocio</a>
        <a href="<?= BASE_URL ?>/perfil"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Mi Perfil</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesi&oacute;n</a>
    </nav>
</div>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
            <h2 style="font-size:18px;font-weight:600;margin-left:8px;">Gestionar negocios</h2>
        </div>
        <div style="display:flex;align-items:center;gap:0">
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema"><i class="fas fa-moon"></i></button>
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
                    <?php if (count($roles_usuario) > 1): ?>
                    <div style="padding:8px 16px 4px;font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;border-bottom:1px solid var(--border)">Elegir rol</div>
                        <?php foreach ($roles_usuario as $rol):
                            $color_rol = match($rol['nombre_rol']) {
                                'Cliente' => '#3498DB', 'Emprendedor' => '#2ECC71',
                                'Repartidor' => '#F39C12', 'Administrador' => '#E74C3C', default => '#888'
                            };
                            $display_name = $rol['nombre_rol'] === 'Emprendedor' ? 'Vendedor' : $rol['nombre_rol'];
                        ?>
                        <a href="<?= BASE_URL ?>/dashboard?cambiar_rol=<?= $rol['nombre_rol'] ?>" class="dropdown-item" style="<?= $rol_activo === $rol['nombre_rol'] ? 'color:var(--text);font-weight:600' : '' ?>">
                            <span style="width:8px;height:8px;border-radius:50%;display:inline-block;background:<?= $color_rol ?>"></span>
                            <?= $display_name ?>
                            <?php if ($rol_activo === $rol['nombre_rol']): ?><span style="margin-left:auto;font-size:10px">&#10003;</span><?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    <div style="border-top:1px solid var(--border);margin:4px 0"></div>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                    <a href="<?= BASE_URL ?>/logout" class="dropdown-item" style="color:#9a5a5a">Cerrar sesi&oacute;n</a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="page-hdr">
            <div>
                <h1>Gestionar negocios</h1>
                <div class="sub">Administra el estado de tus emprendimientos</div>
            </div>
        </div>

        <?php if ($mensaje): ?>
        <div class="msg msg-ok"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="msg msg-err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($mis_negocios) > 0): ?>
        <div class="t-card">
            <div class="twrap">
                <table class="dt">
                    <thead>
                        <tr>
                            <th>Negocio</th>
                            <th>Contacto</th>
                            <th>Productos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mis_negocios as $n):
                            $np = $n['color_primario'] ?? '#888';
                            $esOculto = $n['estado'] === 'Oculto';
                        ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <span class="color-dot" style="background:<?= $np ?>"></span>
                                    <div>
                                        <strong><?= htmlspecialchars($n['nombre_comercial']) ?></strong>
                                        <div style="font-size:11px;color:var(--text-dim)"><?= htmlspecialchars($n['plantilla_nombre'] ?? 'Sin plantilla') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:12px;color:var(--text-muted)">
                                    <?= htmlspecialchars($n['telefono'] ?? '—') ?>
                                </div>
                            </td>
                            <td><?= $n['total_productos'] ?></td>
                            <td><span class="sb sb-<?= $n['estado'] ?>"><?= $n['estado'] ?></span></td>
                            <td>
                                <div class="acts">
                                    <?php if ($esOculto): ?>
                                    <form method="POST" style="margin:0">
                                        <input type="hidden" name="id_negocio" value="<?= $n['id_emprendimiento'] ?>">
                                        <input type="hidden" name="accion" value="mostrar">
                                        <button type="submit" class="ba ba-show" onclick="return confirm('Mostrar <?= htmlspecialchars($n['nombre_comercial']) ?> en la plataforma?')"><i class="fas fa-eye"></i> Mostrar</button>
                                    </form>
                                    <?php else: ?>
                                    <form method="POST" style="margin:0">
                                        <input type="hidden" name="id_negocio" value="<?= $n['id_emprendimiento'] ?>">
                                        <input type="hidden" name="accion" value="ocultar">
                                        <button type="submit" class="ba ba-hide" onclick="return confirm('Ocultar <?= htmlspecialchars($n['nombre_comercial']) ?> de la plataforma?')"><i class="fas fa-eye-slash"></i> Ocultar</button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="POST" style="margin:0" onsubmit="return confirm('&#191;Eliminar permanentemente <?= htmlspecialchars($n['nombre_comercial']) ?>? Todos sus productos se borrar&#225;n.');">
                                        <input type="hidden" name="id_negocio" value="<?= $n['id_emprendimiento'] ?>">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <button type="submit" class="ba ba-del"><i class="fas fa-trash"></i> Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="t-card">
            <div class="es">
                <p>No tienes negocios creados</p>
                <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-p"><i class="fas fa-plus"></i> Crear mi primer negocio</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

<script>
(function(){
    var ct = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', ct);
    var tt = document.getElementById('themeToggle');
    if (tt) {
        tt.innerHTML = ct === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        tt.addEventListener('click', function() {
            var t = document.documentElement.getAttribute('data-theme');
            var nt = t === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', nt);
            localStorage.setItem('jacha_theme', nt);
            tt.innerHTML = nt === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        });
    }

    var menuBtn = document.getElementById('menuBtn');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    if (menuBtn && sidebar && overlay) {
        menuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    var ut = document.getElementById('userTrigger');
    var ud = document.getElementById('userDropdown');
    if (ut && ud) {
        ut.addEventListener('click', function(e) {
            e.stopPropagation();
            ud.classList.toggle('open');
        });
        document.addEventListener('click', function() { ud.classList.remove('open'); });
    }
})();
</script>
</body>
</html>
