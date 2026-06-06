<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repartidor - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        body { font-family:'Inter',system-ui,sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }
        .rep-wrap { max-width:1200px; margin:0 auto; padding:32px 24px; }
        .rep-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; }
        .rep-header h1 { font-family: Georgia, var(--font-serif); font-size:28px; font-weight:400; color:var(--text); }
        .rep-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .rep-header .back:hover { color:var(--text); }
        .rep-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:40px; }
        .rep-stat { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; }
        .rep-stat .label { font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
        .rep-stat .value { font-size:28px; font-weight:600; color:var(--text); }
        .rep-stat .sub { font-size:11px; color:var(--text-muted); margin-top:4px; }
        .rep-section { margin-bottom:40px; }
        .rep-section h2 { font-family: Georgia, var(--font-serif); font-size:22px; font-weight:400; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .rep-section h2 .badge { font-size:11px; background:rgba(255,255,255,0.04); color:var(--text-dim); padding:2px 10px; border-radius:3px; font-family:'Inter',sans-serif; }
        .pedido-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:20px; margin-bottom:12px; }
        .pedido-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
        .pedido-cliente { font-size:15px; font-weight:600; color:var(--text); }
        .pedido-codigo { font-size:11px; color:var(--text-muted); margin-top:2px; font-family:monospace; }
        .pedido-negocio { font-size:12px; color:var(--text-muted); }
        .pedido-info { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:12px; padding:12px; background:rgba(255,255,255,0.02); border:1px solid var(--border); border-radius:3px; }
        .pedido-info-item { font-size:12px; color:var(--text-muted); }
        .pedido-info-item strong { color:var(--text); font-weight:500; }
        .pedido-status { display:inline-block; padding:4px 10px; border-radius:3px; font-size:11px; font-weight:500; }
        .status-preparando { background:#9a8a4a15; color:#9a8a4a; }
        .status-enruta { background:#6b7f8f15; color:#6b7f8f; }
        .status-entregado { background:#6b8f7115; color:#6b8f71; }
        .pedido-actions { display:flex; gap:8px; margin-top:12px; }
        .btn-asignar, .btn-entregar { padding:8px 18px; border:none; border-radius:3px; font-size:12px; font-weight:600; cursor:pointer; transition:background .2s; font-family:inherit; }
        .btn-asignar { background:var(--text); color:var(--bg); }
        .btn-asignar:hover { opacity:0.85; }
        .btn-asignar:disabled { opacity:0.4; cursor:not-allowed; }
        .btn-entregar { background:#6b8f7115; color:#6b8f71; border:1px solid #6b8f7130; }
        .btn-entregar:hover { background:#6b8f7125; }
        .empty-state { text-align:center; padding:60px 20px; color:var(--text-muted); }
        .empty-state p { font-size:13px; }
        .toast { position:fixed; bottom:24px; right:24px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:14px 20px; font-size:13px; box-shadow:0 4px 20px rgba(0,0,0,0.3); z-index:999; opacity:0; transform:translateY(16px); transition:all .3s; }
        .toast.show { opacity:1; transform:translateY(0); }
        .toast.success { border-left:3px solid #6b8f71; }
        .toast.error { border-left:3px solid #9a5a5a; }
        @media(max-width:768px){ .rep-stats{grid-template-columns:repeat(2,1fr)} .pedido-info{grid-template-columns:1fr} .rep-header{flex-direction:column;align-items:flex-start;gap:12px} }
    </style>
</head>
<body>
<div class="rep-wrap">
    <div class="rep-header">
        <h1>Panel de Repartidor</h1>
        <a href="<?= BASE_URL ?>/dashboard" class="back">&larr; Volver al dashboard</a>
    </div>

    <div class="rep-stats">
        <div class="rep-stat">
            <div class="label">Pedidos hoy</div>
            <div class="value"><?= $stats['entregas_hoy'] ?? 0 ?></div>
            <div class="sub">entregas completadas</div>
        </div>
        <div class="rep-stat">
            <div class="label">Ganancias hoy</div>
            <div class="value">Bs. <?= number_format($stats['ganancias_hoy'] ?? 0, 2) ?></div>
            <div class="sub"><?= $stats['entregas_totales'] ?? 0 ?> entregas totales</div>
        </div>
        <div class="rep-stat">
            <div class="label">Activos</div>
            <div class="value"><?= $stats['activos'] ?? 0 ?></div>
            <div class="sub">entregas en curso</div>
        </div>
        <div class="rep-stat">
            <div class="label">Ganancias totales</div>
            <div class="value">Bs. <?= number_format($stats['ganancias_totales'] ?? 0, 2) ?></div>
            <div class="sub">historial completo</div>
        </div>
    </div>

    <div class="rep-section">
        <h2>
            Pedidos pendientes
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
                <div class="pedido-negocio"><?= htmlspecialchars($p['nombre_comercial']) ?></div>
                <div class="pedido-info">
                    <div class="pedido-info-item"><strong>Teléfono:</strong> <?= htmlspecialchars($p['cliente_telefono'] ?? '—') ?></div>
                    <div class="pedido-info-item"><strong>Dirección:</strong> <?= htmlspecialchars($p['direccion_entrega'] ?? '—') ?></div>
                    <div class="pedido-info-item"><strong>Total:</strong> Bs. <?= number_format($p['total'], 2) ?></div>
                    <div class="pedido-info-item"><strong>Pago:</strong> <?= htmlspecialchars($p['metodo_pago']) ?> · <?= htmlspecialchars($p['estado_pago']) ?></div>
                </div>
                <div class="pedido-actions">
                    <button class="btn-asignar" onclick="asignarPedido(<?= $p['id_pedido'] ?>, this)">Asignarme</button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><p>No hay pedidos pendientes de entrega</p></div>
        <?php endif; ?>
    </div>

    <div class="rep-section">
        <h2>
            Mis entregas activas
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
                <div class="pedido-negocio"><?= htmlspecialchars($p['nombre_comercial']) ?></div>
                <div class="pedido-info">
                    <div class="pedido-info-item"><strong>Teléfono:</strong> <?= htmlspecialchars($p['cliente_telefono'] ?? '—') ?></div>
                    <div class="pedido-info-item"><strong>Dirección:</strong> <?= htmlspecialchars($p['direccion_entrega'] ?? '—') ?></div>
                    <div class="pedido-info-item"><strong>Total:</strong> Bs. <?= number_format($p['total'], 2) ?></div>
                    <div class="pedido-info-item"><strong>Pago:</strong> <?= htmlspecialchars($p['metodo_pago']) ?> · <?= htmlspecialchars($p['estado_pago']) ?></div>
                </div>
                <?php if ($p['estado_logistico'] === 'En_Ruta'): ?>
                <div class="pedido-actions">
                    <button class="btn-entregar" onclick="entregarPedido(<?= $p['id_pedido'] ?>, this)">Marcar entregado</button>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><p>No tienes entregas activas</p></div>
        <?php endif; ?>
    </div>

    <?php if (count($historial) > 0): ?>
    <div class="rep-section">
        <h2>
            Historial reciente
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
    </div>
    <?php endif; ?>
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
        mostrarToast('Error de conexión', 'error');
        btn.disabled = false;
        btn.textContent = 'Asignarme';
    });
}

function entregarPedido(id, btn) {
    if (!confirm('¿Marcar este pedido como entregado?')) return;
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
        mostrarToast('Error de conexión', 'error');
        btn.disabled = false;
        btn.textContent = 'Marcar entregado';
    });
}
</script>
</body>
</html>