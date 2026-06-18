<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <title>Equipo de Repartidores - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
    <style>
        .stat-card, .btn-create, .btn-visitar, .btn-admin { border-radius:8px !important; }
        .negocio-tag { border-radius:6px !important; }
        .repartidores-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 24px; margin-bottom: 24px; position: relative; overflow: hidden; }
        .repartidores-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 12px 12px 0 0; opacity: 0.4; }
        .repartidores-card:nth-of-type(1)::before { background: linear-gradient(90deg, #4facfe, #7eb8da); }
        .repartidores-card:nth-of-type(2)::before { background: linear-gradient(90deg, #f39c12, #e67e22); }
        .form-vincular { display: flex; gap: 12px; margin-top: 14px; flex-wrap: wrap; }
        .form-vincular input { flex: 1; min-width: 200px; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background: rgba(255,255,255,0.02); color: var(--text); font-size: 14px; outline: none; }
        .form-vincular input:focus { border-color: var(--border-hi); }
        .btn-action { padding: 12px 24px; background: var(--text); color: var(--bg); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; transition: all .2s; }
        .btn-action:hover { transform: translateY(-2px); }
        .btn-danger { background: #e74c3c; color: #fff; }
        .repartidores-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .repartidores-table th { color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; font-size: 10px; padding: 16px 14px 12px; }
        .repartidores-table td { padding: 14px; font-size: 13px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
        .repartidores-table tbody tr:last-child td { border-bottom: none; }
        .repartidores-table tr:hover { background: rgba(255,255,255,0.01); }
        .select-negocio { padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background: var(--card-bg); color: var(--text); font-size: 14px; outline: none; margin-bottom: 24px; min-width: 250px; cursor: pointer; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .repartidores-card, .select-negocio, .section-header-row { animation: fadeInUp 0.6s ease both; }
        .repartidores-card:nth-child(1) { animation-delay: 0.05s; }
        .repartidores-card:nth-child(2) { animation-delay: 0.1s; }
        .repartidores-card:active { transform: scale(0.99); }
        .repartidores-card { transition: transform 0.2s ease, box-shadow 0.3s ease; }
        @media (min-width: 769px) { .repartidores-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.06); } }
        .empty-state-glass { text-align:center; padding:80px 20px; background:var(--card-bg); border:1px solid var(--border); border-radius:16px; }
        .empty-state-glass i { font-size:48px; opacity:0.12; color:var(--text-muted); margin-bottom:16px; display:block; }
    </style>
</head>
<body class="dashboard-body">

    <?php $current_page = 'repartidores-admin'; ?>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    
    <div class="main-content">
         <div class="top-bar">
            <div style="display:flex;align-items:center;gap:8px">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
                <h2 style="font-size:18px;font-weight:600;margin-left:8px;">Mi Equipo de Repartidores</h2>
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
                        <span style="font-size:8px;color:var(--text-dim);line-height:1;">▼</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dash-container">
            <?php if (!empty($success)): ?>
            <div style="background: rgba(46, 204, 113, 0.08); backdrop-filter: blur(8px); border: 1px solid rgba(46, 204, 113, 0.12); padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #2ecc71; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div style="background: rgba(231, 76, 60, 0.08); backdrop-filter: blur(8px); border: 1px solid rgba(231, 76, 60, 0.12); padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #e74c3c; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
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
                    <h3><i class="fas fa-user-plus" style="margin-right:8px;opacity:0.5"></i> Vincular nuevo repartidor</h3>
                    <p style="color:var(--text-dim); font-size:12px; margin-top:4px;">El repartidor debe estar registrado previamente en la plataforma con el rol de Repartidor.</p>
                    <form class="form-vincular" method="POST" action="<?= BASE_URL ?>/repartidores-admin/vincular">
                        <input type="hidden" name="id_emprendimiento" value="<?= $id_emprendimiento ?>">
                        <input type="email" name="email" required placeholder="Correo electrónico del repartidor (ej: juan@repartidor.com)">
                        <button type="submit" class="btn-action">Vincular al negocio</button>
                    </form>
                </div>

                <div class="repartidores-card">
                    <h3><i class="fas fa-truck" style="margin-right:8px;opacity:0.5;color:#f39c12"></i> Repartidores de <?= htmlspecialchars($negocio_seleccionado['nombre_comercial']) ?></h3>
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
                <div class="empty-state-glass">
                    <i class="fas fa-users"></i>
                    <p style="font-size:15px;color:var(--text-dim);margin-bottom:4px">Selecciona un negocio</p>
                    <p style="font-size:12px;color:var(--text-muted)">Elige uno de tus negocios para gestionar sus repartidores.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function() {
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
            function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
            if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); overlay.addEventListener('click', toggleSidebar); }
        })();
    </script>
</body>
</html>
