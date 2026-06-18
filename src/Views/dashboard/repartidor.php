<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repartidor - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=10">
    <style>
        /* Pedido cards - repartidor style matching the new design */
        .rep-section-title {
            font-family: Georgia, var(--font-serif);
            font-size: 20px;
            font-weight: 400;
            color: var(--text);
            margin: 36px 0 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .rep-section-title .badge {
            font-size: 11px;
            background: var(--surface3);
            color: var(--text-dim);
            padding: 2px 10px;
            border-radius: 6px;
            font-family: var(--font-sans);
            font-weight: 500;
        }
        .pedido-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 10px;
            transition: all 0.2s;
        }
        .pedido-card:hover {
            border-color: var(--border-hi);
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .pedido-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        .pedido-cliente {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        .pedido-codigo {
            font-size: 11px;
            color: var(--text-dim);
            font-family: monospace;
            margin-top: 1px;
        }
        .pedido-negocio {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .pedido-negocio i {
            font-size: 11px;
            opacity: 0.5;
        }
        .pedido-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            padding: 10px 12px;
            background: var(--hover-surface);
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .pedido-info-item {
            font-size: 12px;
            color: var(--text-muted);
        }
        .pedido-info-item strong {
            color: var(--text);
            font-weight: 500;
            margin-right: 2px;
        }
        .pedido-status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .status-preparando { background: #9a8a4a15; color: #9a8a4a; }
        .status-enruta { background: #6b7f8f15; color: #6b7f8f; }
        .status-entregado { background: #6b8f7115; color: #6b8f71; }
        .pedido-actions { display: flex; gap: 8px; }
        .btn-asignar, .btn-entregar {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-asignar { background: var(--text); color: var(--bg); }
        .btn-asignar:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-asignar:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
        .btn-entregar { background: #6b8f7115; color: #6b8f71; border: 1px solid #6b8f7130; }
        .btn-entregar:hover { background: #6b8f7125; transform: translateY(-1px); }
        .empty-state { text-align: center; padding: 50px 20px; color: var(--text-dim); }
        .empty-state i { font-size: 36px; opacity: 0.2; margin-bottom: 8px; }
        .empty-state p { font-size: 13px; }
        .toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 20px;
            font-size: 13px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            z-index: 999;
            opacity: 0;
            transform: translateY(16px);
            transition: all 0.3s;
        }
        .toast.show { opacity: 1; transform: translateY(0); }
        .toast.success { border-left: 3px solid #6b8f71; }
        .toast.error { border-left: 3px solid #c97c6b; }
        @media (max-width: 768px) {
            .pedido-info { grid-template-columns: 1fr; }
            .pedido-top { flex-direction: column; gap: 8px; }
        }
    </style>
</head>
<body class="dashboard-body">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="<?= BASE_URL ?>/">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="JachaMarket">
            </a>
        </div>
        <nav class="sidebar-nav">
            <div class="s-label">Navegaci&oacute;n</div>
            <a href="<?= BASE_URL ?>/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="<?= BASE_URL ?>/dashboard-repartidor" class="active"><i class="fas fa-truck"></i> Entregas</a>
            <div class="sidebar-footer" style="margin-top:auto;padding:8px 10px;border-top:1px solid var(--border)">
                <a href="<?= BASE_URL ?>/logout" class="s-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesi&oacute;n</a>
            </div>
        </nav>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-btn" id="menuBtn">&#9776;</button>
            </div>
            <div class="top-bar-right">
                <button class="notif-btn" id="notifBtn" title="Notificaciones">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">0</span>
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
                        <a href="<?= BASE_URL ?>/perfil" class="dropdown-item"><i class="fas fa-user"></i> Mi Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesi&oacute;n</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-container">
            <div class="page-title-area" style="margin-bottom:24px">
                <h1>Panel de Repartidor</h1>
                <a href="<?= BASE_URL ?>/dashboard" style="margin-left:auto;font-size:13px;color:var(--text-muted);text-decoration:none">&larr; Volver al dashboard</a>
            </div>

            <div class="stats-grid">
                <div class="stat-card card-orders">
                    <div class="stat-header">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Pedidos hoy</h3>
                    </div>
                    <div class="value"><?= $stats['entregas_hoy'] ?? 0 ?></div>
                    <div class="stat-sub">entregas completadas</div>
                </div>
                <div class="stat-card card-earnings">
                    <div class="stat-header">
                        <i class="fas fa-coins"></i>
                        <h3>Ganancias hoy</h3>
                    </div>
                    <div class="value">Bs. <?= number_format($stats['ganancias_hoy'] ?? 0, 2) ?></div>
                    <div class="stat-sub"><?= $stats['entregas_totales'] ?? 0 ?> entregas totales</div>
                </div>
                <div class="stat-card card-margin">
                    <div class="stat-header">
                        <i class="fas fa-motorcycle"></i>
                        <h3>Activos</h3>
                    </div>
                    <div class="value"><?= $stats['activos'] ?? 0 ?></div>
                    <div class="stat-sub">entregas en curso</div>
                </div>
                <div class="stat-card card-cost">
                    <div class="stat-header">
                        <i class="fas fa-history"></i>
                        <h3>Ganancias totales</h3>
                    </div>
                    <div class="value">Bs. <?= number_format($stats['ganancias_totales'] ?? 0, 2) ?></div>
                    <div class="stat-sub">historial completo</div>
                </div>
            </div>

            <h2 class="rep-section-title">
                <i class="fas fa-clock" style="font-size:16px;opacity:0.5"></i> Pedidos pendientes
                <span class="badge"><?= count($pedidos_pendientes) ?></span>
            </h2>
            <?php if (count($pedidos_pendientes) > 0): ?>
                <?php foreach ($pedidos_pendientes as $p): ?>
                <div class="pedido-card" data-id="<?= $p['id_pedido'] ?>">
                    <div class="pedido-top">
                        <div>
                            <div class="pedido-cliente"><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></div>
                            <div class="pedido-codigo"><?= htmlspecialchars($p['codigo_seguimiento']) ?></div>
                        </div>
                        <span class="pedido-status status-preparando">Preparando</span>
                    </div>
                    <div class="pedido-negocio"><i class="fas fa-store"></i> <?= htmlspecialchars($p['nombre_comercial']) ?></div>
                    <div class="pedido-info">
                        <div class="pedido-info-item"><strong>Tel&eacute;fono:</strong> <?= htmlspecialchars($p['cliente_telefono'] ?? '&mdash;') ?></div>
                        <div class="pedido-info-item"><strong>Direcci&oacute;n:</strong> <?= htmlspecialchars($p['direccion_entrega'] ?? '&mdash;') ?></div>
                        <div class="pedido-info-item"><strong>Total:</strong> Bs. <?= number_format($p['total'], 2) ?></div>
                        <div class="pedido-info-item"><strong>Pago:</strong> <?= htmlspecialchars($p['metodo_pago']) ?> &middot; <?= htmlspecialchars($p['estado_pago']) ?></div>
                    </div>
                    <div class="pedido-actions">
                        <button class="btn-asignar" onclick="asignarPedido(<?= $p['id_pedido'] ?>, this)">Asignarme</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-check-circle"></i><p>No hay pedidos pendientes de entrega</p></div>
            <?php endif; ?>

            <h2 class="rep-section-title">
                <i class="fas fa-truck" style="font-size:16px;opacity:0.5"></i> Mis entregas activas
                <span class="badge"><?= count($mis_activos) ?></span>
            </h2>
            <?php if (count($mis_activos) > 0): ?>
                <?php foreach ($mis_activos as $p): ?>
                <div class="pedido-card" data-id="<?= $p['id_pedido'] ?>">
                    <div class="pedido-top">
                        <div>
                            <div class="pedido-cliente"><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></div>
                            <div class="pedido-codigo"><?= htmlspecialchars($p['codigo_seguimiento']) ?></div>
                        </div>
                        <span class="pedido-status <?= $p['estado_logistico'] === 'En_Ruta' ? 'status-enruta' : 'status-preparando' ?>">
                            <?= $p['estado_logistico'] === 'En_Ruta' ? 'En ruta' : ($p['estado_logistico'] === 'Preparando' ? 'Preparando' : $p['estado_logistico']) ?>
                        </span>
                    </div>
                    <div class="pedido-negocio"><i class="fas fa-store"></i> <?= htmlspecialchars($p['nombre_comercial']) ?></div>
                    <div class="pedido-info">
                        <div class="pedido-info-item"><strong>Tel&eacute;fono:</strong> <?= htmlspecialchars($p['cliente_telefono'] ?? '&mdash;') ?></div>
                        <div class="pedido-info-item"><strong>Direcci&oacute;n:</strong> <?= htmlspecialchars($p['direccion_entrega'] ?? '&mdash;') ?></div>
                        <div class="pedido-info-item"><strong>Total:</strong> Bs. <?= number_format($p['total'], 2) ?></div>
                        <div class="pedido-info-item"><strong>Pago:</strong> <?= htmlspecialchars($p['metodo_pago']) ?> &middot; <?= htmlspecialchars($p['estado_pago']) ?></div>
                    </div>
                    <?php if ($p['estado_logistico'] === 'En_Ruta'): ?>
                    <div class="pedido-actions">
                        <button class="btn-entregar" onclick="entregarPedido(<?= $p['id_pedido'] ?>, this)">Marcar entregado</button>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-inbox"></i><p>No tienes entregas activas</p></div>
            <?php endif; ?>

            <?php if (count($historial) > 0): ?>
            <h2 class="rep-section-title">
                <i class="fas fa-history" style="font-size:16px;opacity:0.5"></i> Historial reciente
                <span class="badge"><?= count($historial) ?></span>
            </h2>
                <?php foreach ($historial as $p): ?>
                <div class="pedido-card">
                    <div class="pedido-top">
                        <div>
                            <div class="pedido-cliente"><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></div>
                            <div class="pedido-codigo"><?= htmlspecialchars($p['codigo_seguimiento']) ?></div>
                        </div>
                        <span class="pedido-status status-entregado">Entregado</span>
                    </div>
                    <div class="pedido-info">
                        <div class="pedido-info-item"><strong>Negocio:</strong> <?= htmlspecialchars($p['nombre_comercial']) ?></div>
                        <div class="pedido-info-item"><strong>Entregado:</strong> <?= date('d/m/Y H:i', strtotime($p['fecha_entrega'])) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
    function mostrarToast(msg, tipo) {
        var t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast ' + tipo + ' show';
        setTimeout(function() { t.classList.remove('show'); }, 3000);
    }
    function asignarPedido(id, btn) {
        btn.disabled = true;
        btn.textContent = 'Asignando...';
        var form = new FormData();
        form.append('id_pedido', id);
        fetch('<?= BASE_URL ?>/repartidor/asignar', { method: 'POST', body: form })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                mostrarToast('Pedido asignado correctamente', 'success');
                var card = btn.closest('.pedido-card');
                card.parentNode.removeChild(card);
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                mostrarToast('Error: ' + (d.error || 'no se pudo asignar'), 'error');
                btn.disabled = false;
                btn.textContent = 'Asignarme';
            }
        })
        .catch(function() {
            mostrarToast('Error de conexi\u00f3n', 'error');
            btn.disabled = false;
            btn.textContent = 'Asignarme';
        });
    }
    function entregarPedido(id, btn) {
        if (!confirm('\u00bfMarcar este pedido como entregado?')) return;
        btn.disabled = true;
        btn.textContent = 'Entregando...';
        var form = new FormData();
        form.append('id_pedido', id);
        fetch('<?= BASE_URL ?>/repartidor/entregar', { method: 'POST', body: form })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                mostrarToast('Pedido marcado como entregado', 'success');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                mostrarToast('Error: ' + (d.error || 'no se pudo entregar'), 'error');
                btn.disabled = false;
                btn.textContent = 'Marcar entregado';
            }
        })
        .catch(function() {
            mostrarToast('Error de conexi\u00f3n', 'error');
            btn.disabled = false;
            btn.textContent = 'Marcar entregado';
        });
    }
    </script>
</body>
</html>