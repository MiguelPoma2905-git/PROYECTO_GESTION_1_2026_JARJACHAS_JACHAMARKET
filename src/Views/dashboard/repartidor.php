<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repartidor - Jacha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        body { font-family:'Inter',system-ui,sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }
        .rep-wrap { max-width:1200px; margin:0 auto; padding:32px 24px; }
        .rep-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; }
        .rep-header h1 { font-family: Georgia, var(--font-serif); font-size:28px; font-weight:400; color:var(--text); }
        .rep-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .rep-header .back:hover { color:var(--text); }
        .rep-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:40px; }
        .rep-stat { background:var(--card-bg); border:1px solid var(--border); border-radius:16px; padding:24px; transition:all .2s; }
        .rep-stat:hover { border-color:var(--border-hi); transform:translateY(-2px); box-shadow:var(--shadow-lg); }
        .rep-stat .label { font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
        .rep-stat .value { font-size:28px; font-weight:600; color:var(--text); }
        .rep-stat .sub { font-size:11px; color:var(--text-muted); margin-top:4px; }
        .rep-section { margin-bottom:40px; }
        .rep-section h2 { font-family: Georgia, var(--font-serif); font-size:22px; font-weight:400; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .rep-section h2 .badge { font-size:11px; background:var(--surface3); color:var(--text-muted); padding:2px 10px; border-radius:20px; font-family:'Inter',sans-serif; }
        .pedido-card { background:var(--card-bg); border:1px solid var(--border); border-radius:14px; padding:20px; margin-bottom:12px; transition:all .2s; }
        .pedido-card:hover { border-color:var(--border-hi); }
        .pedido-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
        .pedido-cliente { font-size:15px; font-weight:600; color:var(--text); }
        .pedido-codigo { font-size:11px; color:var(--text-muted); margin-top:2px; font-family:monospace; }
        .pedido-negocio { font-size:12px; color:var(--text-muted); }
        .pedido-info { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:12px; padding:12px; background:var(--surface2); border-radius:10px; }
        .pedido-info-item { font-size:12px; color:var(--text-muted); }
        .pedido-info-item strong { color:var(--text); font-weight:500; }
        .pedido-status { display:inline-block; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:500; }
        .status-preparando { background:#F39C1215; color:#F39C12; }
        .status-enruta { background:#3498DB15; color:#3498DB; }
        .status-entregado { background:#2ECC7115; color:#2ECC71; }
        .pedido-actions { display:flex; gap:8px; margin-top:12px; }
        .btn-asignar, .btn-entregar { padding:8px 18px; border:none; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; transition:all .2s; }
        .btn-asignar { background:var(--text); color:var(--bg); }
        .btn-asignar:hover { transform:translateY(-2px); box-shadow:0 4px 16px var(--glow-lg); }
        .btn-asignar:disabled { opacity:0.4; cursor:not-allowed; transform:none; }
        .btn-entregar { background:#2ECC7115; color:#2ECC71; border:1px solid #2ECC7130; }
        .btn-entregar:hover { background:#2ECC7125; }
        .empty-state { text-align:center; padding:60px 20px; color:var(--text-muted); }
        .empty-state p { font-size:13px; }
        .toast { position:fixed; bottom:24px; right:24px; background:var(--card-bg); border:1px solid var(--border); border-radius:12px; padding:14px 20px; font-size:13px; box-shadow:var(--shadow-lg); z-index:999; opacity:0; transform:translateY(16px); transition:all .3s; }
        .toast.show { opacity:1; transform:translateY(0); }
        .toast.success { border-left:3px solid #2ECC71; }
        .toast.error { border-left:3px solid #E74C3C; }
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
        <h2>Calendario de entregas</h2>
        <div id="calendar" style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:20px;margin-bottom:24px;"></div>
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

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var events = [];
        <?php foreach ($pedidos_pendientes as $p): ?>
        events.push({
            title: 'Pendiente: <?= htmlspecialchars($p['codigo_seguimiento'], ENT_QUOTES) ?>',
            start: '<?= date('Y-m-d', strtotime($p['fecha_creacion'])) ?>',
            color: '#F39C12',
            textColor: '#fff',
            url: '<?= BASE_URL ?>/dashboard-repartidor'
        });
        <?php endforeach; ?>
        <?php foreach ($mis_activos as $p): ?>
        events.push({
            title: '<?= $p['estado_logistico'] === 'En_Ruta' ? 'En ruta' : 'Activo' ?>: <?= htmlspecialchars($p['codigo_seguimiento'], ENT_QUOTES) ?>',
            start: '<?= date('Y-m-d', strtotime($p['fecha_creacion'])) ?>',
            color: '#3498DB',
            textColor: '#fff',
            url: '<?= BASE_URL ?>/dashboard-repartidor'
        });
        <?php endforeach; ?>
        <?php foreach ($historial as $p): ?>
        events.push({
            title: 'Entregado: <?= htmlspecialchars($p['codigo_seguimiento'], ENT_QUOTES) ?>',
            start: '<?= date('Y-m-d', strtotime($p['fecha_entrega'])) ?>',
            color: '#2ECC71',
            textColor: '#fff',
            url: '<?= BASE_URL ?>/dashboard-repartidor'
        });
        <?php endforeach; ?>

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            events: events,
            height: 'auto',
            firstDay: 1
        });
        calendar.render();
    }
});

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