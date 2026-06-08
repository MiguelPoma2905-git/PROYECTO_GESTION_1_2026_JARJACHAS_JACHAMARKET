<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Mis Solicitudes - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .solicitudes-wrap { max-width:800px; margin:0 auto; padding:32px 24px; }
        .sol-header { margin-bottom:32px; }
        .sol-header h1 { font-family:Georgia,var(--font-serif);font-size:28px;font-weight:400;color:var(--text); }
        .sol-header .back { color:var(--text-muted);text-decoration:none;font-size:13px; }
        .sol-header .back:hover { color:var(--text); }
        .sol-card { background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:20px;margin-bottom:12px;transition:all .2s; }
        .sol-card:hover { border-color:var(--border-hi); }
        .sol-card.pendiente { border-left:3px solid #F39C12; }
        .sol-card.aceptado { border-left:3px solid #2ECC71; }
        .sol-card.rechazado { border-left:3px solid #E74C3C; opacity:0.6; }
        .sol-negocio { font-size:17px;font-weight:600;color:var(--text);margin-bottom:4px; }
        .sol-desc { font-size:12px;color:var(--text-muted);margin-bottom:8px; }
        .sol-prop { font-size:12px;color:var(--text-muted); }
        .sol-prop strong { color:var(--text);font-weight:500; }
        .sol-status { display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:500;margin-top:8px; }
        .status-pendiente { background:#F39C1215;color:#F39C12; }
        .status-aceptado { background:#2ECC7115;color:#2ECC71; }
        .status-rechazado { background:#E74C3C15;color:#E74C3C; }
        .sol-actions { display:flex;gap:8px;margin-top:12px; }
        .btn-aceptar, .btn-rechazar { padding:8px 18px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s; }
        .btn-aceptar { background:#2ECC71;color:#fff; }
        .btn-aceptar:hover { background:#27AE60;transform:translateY(-2px); }
        .btn-rechazar { background:#E74C3C15;color:#E74C3C;border:1px solid #E74C3C30; }
        .btn-rechazar:hover { background:#E74C3C25; }
        .empty-state { text-align:center;padding:80px 20px;color:var(--text-muted); }
        .empty-state p { font-size:13px; }
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
            <a href="<?= BASE_URL ?>/dashboard-repartidor"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Entregas</a>
            <a href="<?= BASE_URL ?>/repartidor-solicitudes" class="active"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Mis solicitudes</a>
            <a href="<?= BASE_URL ?>/perfil"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Mi Perfil</a>
            <a href="<?= BASE_URL ?>/logout" style="margin-top:40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesión</a>
        </nav>
    </div>
    <div class="overlay" id="overlay"></div>
    <div class="main-content">
        <div class="top-bar">
            <div style="display:flex;align-items:center;gap:8px">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
                <h2 style="font-size:18px;font-weight:600;margin-left:8px;">Mis Solicitudes</h2>
            </div>
            <div style="display:flex;align-items:center;gap:0">
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
                        <span style="font-size:8px;color:var(--text-dim);line-height:1;">▼</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="dash-container">
            <?php if (!empty($success)): ?>
            <div style="background:rgba(46,204,113,0.15);border-left:3px solid #2ecc71;padding:14px 18px;border-radius:8px;margin-bottom:20px;font-size:13px;color:#2ecc71;">✓ <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
            <div style="background:rgba(231,76,60,0.15);border-left:3px solid #e74c3c;padding:14px 18px;border-radius:8px;margin-bottom:20px;font-size:13px;color:#e74c3c;">✗ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (count($solicitudes) > 0): ?>
                <?php foreach ($solicitudes as $s): ?>
                <div class="sol-card <?= strtolower($s['estado']) ?>">
                    <div class="sol-negocio"><?= htmlspecialchars($s['nombre_comercial']) ?></div>
                    <div class="sol-desc"><?= htmlspecialchars(substr($s['descripcion'] ?? '', 0, 120)) ?></div>
                    <div class="sol-prop">Propietario: <strong><?= htmlspecialchars($s['prop_nombre'] . ' ' . $s['prop_apellidos']) ?></strong> &middot; <?= htmlspecialchars($s['prop_email']) ?></div>
                    <div class="sol-status status-<?= strtolower($s['estado']) ?>"><?= $s['estado'] ?></div>
                    <?php if ($s['estado'] === 'Pendiente'): ?>
                    <div class="sol-actions">
                        <form method="POST" action="<?= BASE_URL ?>/repartidor-solicitudes" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
                            <input type="hidden" name="id_emprendimiento" value="<?= $s['id_emprendimiento'] ?>">
                            <input type="hidden" name="accion" value="aceptar">
                            <button type="submit" class="btn-aceptar">Aceptar</button>
                        </form>
                        <form method="POST" action="<?= BASE_URL ?>/repartidor-solicitudes" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
                            <input type="hidden" name="id_emprendimiento" value="<?= $s['id_emprendimiento'] ?>">
                            <input type="hidden" name="accion" value="rechazar">
                            <button type="submit" class="btn-rechazar">Rechazar</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes solicitudes de vinculación</p>
                    <p style="font-size:12px;margin-top:8px;">Los emprendedores pueden solicitarte como repartidor desde su panel</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        (function() {
            var menuBtn = document.getElementById('menuBtn');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
            if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); overlay.addEventListener('click', toggleSidebar); }
        })();
    </script>
</body>
</html>
