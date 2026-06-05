<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Equipo de Repartidores - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .stat-card, .btn-create, .btn-visitar, .btn-admin { border-radius:8px !important; }
        .negocio-tag { border-radius:6px !important; }
        .repartidores-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .form-vincular { display: flex; gap: 12px; margin-top: 14px; flex-wrap: wrap; }
        .form-vincular input { flex: 1; min-width: 200px; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background: rgba(255,255,255,0.02); color: var(--text); font-size: 14px; outline: none; }
        .form-vincular input:focus { border-color: var(--border-hi); }
        .btn-action { padding: 12px 24px; background: var(--text); color: var(--bg); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; transition: all .2s; }
        .btn-action:hover { transform: translateY(-2px); }
        .btn-danger { background: #e74c3c; color: #fff; }
        .repartidores-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .repartidores-table th, .repartidores-table td { padding: 14px; text-align: left; border-bottom: 1px solid var(--border); font-size: 13px; }
        .repartidores-table th { color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; font-size: 11px; }
        .repartidores-table td { color: var(--text-muted); }
        .repartidores-table tr:hover { background: rgba(255,255,255,0.01); }
        .select-negocio { padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background: var(--card-bg); color: var(--text); font-size: 14px; outline: none; margin-bottom: 24px; min-width: 250px; cursor: pointer; }
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
            <a href="<?= BASE_URL ?>/repartidores-admin" class="active"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Repartidores</a>
            <a href="<?= BASE_URL ?>/plantillas-disponibles"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9733;</span> Nuevo negocio</a>
            <a href="<?= BASE_URL ?>/perfil"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#9881;</span> Mi Perfil</a>
            <a href="<?= BASE_URL ?>/logout" style="margin-top: 40px;"><span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">&#8592;</span> Cerrar sesión</a>
        </nav>
    </div>
    
    <div class="overlay" id="overlay"></div>
    
    <div class="main-content">
         <div class="top-bar">
            <div style="display:flex;align-items:center;gap:8px">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
                <h2 style="font-size:18px;font-weight:600;margin-left:8px;">Mi Equipo de Repartidores</h2>
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
            <div style="background: rgba(46, 204, 113, 0.15); border-left: 3px solid #2ecc71; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #2ecc71;">
                ✓ <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div style="background: rgba(231, 76, 60, 0.15); border-left: 3px solid #e74c3c; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #e74c3c;">
                ✗ <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <div class="section-header-row" style="margin-bottom:12px;">
                <h2>Selecciona tu negocio</h2>
            </div>

            <select class="select-negocio" onchange="window.location.href='<?= BASE_URL ?>/repartidores-admin?id_emprendimiento=' + this.value">
                <option value="0">-- Elige un negocio --</option>
                <?php foreach ($negocios as $negocio): ?>
                <option value="<?= $negocio['id_emprendimiento'] ?>" <?= $id_emprendimiento === (int)$negocio['id_emprendimiento'] ? 'selected' : '' ?>><?= htmlspecialchars($negocio['nombre_comercial']) ?></option>
                <?php endforeach; ?>
            </select>

            <?php if ($id_emprendimiento > 0 && $negocio_seleccionado): ?>
                <div class="repartidores-card">
                    <h3>Vincular nuevo repartidor</h3>
                    <p style="color:var(--text-dim); font-size:12px; margin-top:4px;">El repartidor debe estar registrado previamente en la plataforma con el rol de Repartidor.</p>
                    <form class="form-vincular" method="POST" action="<?= BASE_URL ?>/repartidores-admin/vincular">
                        <input type="hidden" name="id_emprendimiento" value="<?= $id_emprendimiento ?>">
                        <input type="email" name="email" required placeholder="Correo electrónico del repartidor (ej: juan@repartidor.com)">
                        <button type="submit" class="btn-action">Vincular al negocio</button>
                    </form>
                </div>

                <div class="repartidores-card">
                    <h3>Repartidores de <?= htmlspecialchars($negocio_seleccionado['nombre_comercial']) ?></h3>
                    <?php if (count($repartidores) > 0): ?>
                        <div style="overflow-x:auto;">
                            <table class="repartidores-table">
                                <thead>
                                    <tr>
                                        <th>Repartidor</th>
                                        <th>Correo electrónico</th>
                                        <th style="text-align:right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($repartidores as $rep): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($rep['nombres']) ?> <?= htmlspecialchars($rep['apellidos']) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($rep['email']) ?></td>
                                        <td style="text-align:right">
                                            <form method="POST" action="<?= BASE_URL ?>/repartidores-admin/desvincular" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas quitar a este repartidor del negocio?');">
                                                <input type="hidden" name="id_emprendimiento" value="<?= $id_emprendimiento ?>">
                                                <input type="hidden" name="id_repartidor" value="<?= $rep['id_usuario'] ?>">
                                                <button type="submit" class="btn-action btn-danger" style="padding: 8px 16px; font-size: 11px;">Quitar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: var(--text-dim); text-align: center; padding: 40px; font-size: 13px;">No hay repartidores vinculados a este negocio aún.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div style="text-align:center; padding:80px; background:var(--card-bg); border: 1px solid var(--border); border-radius:12px;">
                    <span style="font-size:48px; opacity:0.3">👤</span>
                    <p style="margin-top:12px; color:var(--text-muted)">Por favor, selecciona uno de tus negocios de la lista superior para gestionar sus repartidores.</p>
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
