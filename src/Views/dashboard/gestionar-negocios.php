<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Gestionar Negocios - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
    <style>
        .wrap { max-width:1200px; margin:0 auto; padding:32px 24px; }
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
        [data-theme="light"] .dt th { background:rgba(0,0,0,0.03); }
        .dt td { padding:14px 18px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .dt tbody tr:last-child td { border-bottom:none; }
        .dt tbody tr:hover { background:rgba(255,255,255,0.015); }
        [data-theme="light"] .dt tbody tr:hover { background:rgba(0,0,0,0.03); }
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


        @media(max-width:768px){
            .wrap { padding:16px; }
            .dt td,.dt th { padding:10px 12px; }
            .acts { flex-direction:column; gap:4px; }
            .page-hdr { flex-direction:column; align-items:flex-start; gap:8px; }
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .t-card, .msg { animation: fadeInUp 0.6s ease both; }
        .t-card:nth-child(1) { animation-delay: 0.1s; }
        .t-card:active { transform: scale(0.99); }
        .t-card { transition: transform 0.2s ease, box-shadow 0.3s ease; }
        @media (min-width: 769px) { .t-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.06); } }
        .page-hdr h1 { display: flex; align-items: center; gap: 12px; }
        .page-hdr h1::before { content: '\f0ae'; font-family: 'Font Awesome 6 Free'; font-weight: 900; font-size: 20px; opacity: 0.4; width: 40px; height: 40px; border-radius: 10px; background: rgba(107, 143, 113, 0.1); display: flex; align-items: center; justify-content: center; color: #6b8f71; }
        .es { border-radius: 12px; background: var(--card-bg); border: 1px solid var(--border); }
    </style>
</head>
<body class="dashboard-body">

<?php $current_page = 'gestionar-negocios'; ?>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>

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
                    <span class="user-name"><?= htmlspecialchars($usuario['nombre'] ?? 'Usuario') ?></span>
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
            <a href="<?= BASE_URL ?>/plantillas-disponibles" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--text);color:var(--bg);border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;transition:all 0.2s"><i class="fas fa-plus"></i> Nuevo negocio</a>
        </div>

        <?php if ($mensaje): ?>
        <div class="msg msg-ok"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="msg msg-err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($mis_negocios) > 0): ?>
        <div class="t-card" style="animation-delay:0.1s">
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
            <div style="text-align:center;padding:80px 20px;color:var(--text-dim)">
                <i class="fas fa-store-alt" style="font-size:48px;margin-bottom:16px;opacity:0.15;color:var(--text-muted)"></i>
                <p style="font-size:15px;margin-bottom:6px">No tienes negocios creados</p>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:20px">Elige una plantilla y crea tu primer emprendimiento</p>
                <a href="<?= BASE_URL ?>/plantillas-disponibles" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:var(--text);color:var(--bg);border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;transition:all 0.2s"><i class="fas fa-plus"></i> Crear mi primer negocio</a>
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
