<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        :root { --admin-bg: #0a0a0f; --admin-card: #12121a; --admin-border: rgba(255,255,255,0.06); --admin-accent: #6366f1; --admin-text: #f1f5f9; --admin-muted: #94a3b8; --admin-dim: #475569; }
        [data-theme="light"] { --admin-bg: #f8fafc; --admin-card: #ffffff; --admin-border: rgba(0,0,0,0.08); --admin-text: #0f172a; --admin-muted: #64748b; --admin-dim: #94a3b8; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',system-ui,sans-serif; background:var(--admin-bg); color:var(--admin-text); min-height:100vh; }
        .wrap { max-width:1400px; margin:0 auto; }
        .hero {
            background:linear-gradient(135deg,#0f0f1a 0%,#1a1a2e 50%,#0f0f1a 100%);
            padding:40px 40px 32px; position:relative; overflow:hidden;
        }
        [data-theme="light"] .hero { background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 50%,#eef2ff 100%); }
        .hero::before { content:''; position:absolute; top:-50%; right:-20%; width:500px; height:500px; background:radial-gradient(circle,rgba(99,102,241,0.12) 0%,transparent 60%); pointer-events:none; }
        .hero-inner { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; }
        .hero h1 { font-family:'Cormorant Garamond',serif; font-size:36px; font-weight:500; background:linear-gradient(135deg,#fff,#94a3b8); -webkit-background-clip:text; background-clip:text; color:transparent; }
        [data-theme="light"] .hero h1 { background:linear-gradient(135deg,#1e293b,#6366f1); -webkit-background-clip:text; background-clip:text; color:transparent; }
        .hero .back { color:var(--admin-muted); text-decoration:none; font-size:13px; display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; background:rgba(255,255,255,0.04); transition:all .2s; }
        .hero .back:hover { color:#fff; background:rgba(255,255,255,0.08); }
        [data-theme="light"] .hero .back:hover { color:#1e293b; background:rgba(0,0,0,0.06); }
        .body { padding:32px 40px; }

        .resumen-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px; }
        .res-card { background:var(--admin-card); border:1px solid var(--admin-border); border-radius:16px; padding:24px; }
        .res-card .num { font-size:32px; font-weight:700; color:var(--admin-text); }
        .res-card .lab { font-size:11px; color:var(--admin-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; }

        .filtros { background:var(--admin-card); border:1px solid var(--admin-border); border-radius:16px; padding:20px 24px; margin-bottom:24px; display:flex; gap:16px; align-items:center; flex-wrap:wrap; }
        .filtros label { font-size:11px; color:var(--admin-dim); text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
        .filtros select { background:rgba(255,255,255,0.03); border:1px solid var(--admin-border); border-radius:8px; padding:8px 12px; color:var(--admin-text); font-size:13px; cursor:pointer; }
        .filtros select:focus { outline:none; border-color:var(--admin-accent); }
        .filtros select option { background:#12121a; color:#f1f5f9; }
        [data-theme="light"] .filtros select option { background:#fff; color:#0f172a; }
        .filtros .btn-filtrar { background:var(--admin-accent); color:#fff; border:none; padding:8px 20px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; transition:all .2s; }
        .filtros .btn-filtrar:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(99,102,241,0.2); }
        .filtros .btn-limpiar { background:rgba(255,255,255,0.04); color:var(--admin-muted); border:1px solid var(--admin-border); padding:8px 20px; border-radius:8px; font-size:12px; cursor:pointer; text-decoration:none; transition:all .2s; }
        .filtros .btn-limpiar:hover { color:var(--admin-text); border-color:var(--admin-accent); }

        .table-wrap { background:var(--admin-card); border:1px solid var(--admin-border); border-radius:20px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; padding:14px 20px; font-size:10px; font-weight:600; color:var(--admin-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--admin-border); background:rgba(255,255,255,0.02); }
        [data-theme="light"] thead th { background:rgba(0,0,0,0.02); }
        tbody tr { transition:all .2s; border-bottom:1px solid var(--admin-border); }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:rgba(99,102,241,0.03); }
        td { padding:14px 20px; font-size:13px; color:var(--admin-text); }
        .badge-pl { display:inline-block; padding:3px 10px; border-radius:6px; font-size:10px; font-weight:600; margin:2px; }
        .badge-pl.pagado { background:rgba(16,185,129,0.12); color:#10b981; }
        .badge-pl.pendiente { background:rgba(245,158,11,0.12); color:#f59e0b; }
        .badge-pl.fallido { background:rgba(239,68,68,0.12); color:#ef4444; }
        .badge-pl.enruta { background:rgba(99,102,241,0.12); color:#6366f1; }
        .badge-pl.entregado { background:rgba(16,185,129,0.12); color:#10b981; }
        .badge-pl.preparando { background:rgba(245,158,11,0.12); color:#f59e0b; }

        .plantilla-tag { display:inline-block; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:600; }
        .plantilla-tag.electro { background:rgba(26,58,92,0.2); color:#2C6FBB; }
        .plantilla-tag.techo { background:rgba(52,152,219,0.15); color:#3498DB; }
        .plantilla-tag.otro { background:rgba(255,255,255,0.05); color:var(--admin-muted); }
        .empty { text-align:center; padding:60px 20px; color:var(--admin-dim); }
        .empty i { font-size:40px; margin-bottom:16px; opacity:0.3; }

        @media(max-width:768px){ .hero{padding:24px 20px} .body{padding:24px 20px} .resumen-grid{grid-template-columns:1fr} .filtros{flex-direction:column;align-items:stretch} }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div class="hero-inner">
            <h1><i class="fas fa-chart-line" style="margin-right:12px;color:#10b981"></i>Ventas</h1>
            <a href="<?= BASE_URL ?>/admin" class="back"><i class="fas fa-arrow-left"></i> Volver al panel</a>
        </div>
    </div>
    <div class="body">

        <div class="resumen-grid">
            <div class="res-card">
                <div class="num" style="color:#6366f1"><?= $resumen['total_pedidos'] ?></div>
                <div class="lab">Total pedidos</div>
            </div>
            <div class="res-card">
                <div class="num" style="color:#10b981">Bs. <?= number_format($resumen['total_ventas'], 2) ?></div>
                <div class="lab">Total ventas</div>
            </div>
            <div class="res-card">
                <div class="num" style="color:<?= count($pedidos) > 0 ? '#f59e0b' : 'var(--admin-dim)' ?>"><?= count($pedidos) ?></div>
                <div class="lab">Pedidos mostrados</div>
            </div>
        </div>

        <form class="filtros" method="GET" action="<?= BASE_URL ?>/admin/ventas">
            <div>
                <label>Negocio</label>
                <select name="id_emprendimiento">
                    <option value="">Todos los negocios</option>
                    <?php foreach ($negocios as $n): ?>
                        <option value="<?= $n['id_emprendimiento'] ?>" <?= $negocio_filter == $n['id_emprendimiento'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nombre_comercial']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Plantilla</label>
                <select name="id_plantilla">
                    <option value="">Todas las plantillas</option>
                    <?php
                    $vistas = [];
                    foreach ($negocios as $n) {
                        $key = $n['id_plantilla'];
                        if (!isset($vistas[$key])) {
                            $vistas[$key] = $n['plantilla_nombre'];
                        }
                    }
                    foreach ($vistas as $id => $nom):
                    ?>
                        <option value="<?= $id ?>" <?= $plantilla_filter == $id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-filtrar"><i class="fas fa-filter"></i> Filtrar</button>
            <a href="<?= BASE_URL ?>/admin/ventas" class="btn-limpiar"><i class="fas fa-times"></i> Limpiar</a>
        </form>

        <?php if (count($pedidos) > 0): ?>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Código</th><th>Cliente</th><th>Negocio</th><th>Plantilla</th><th>Items</th><th>Total</th><th>Pago</th><th>Estado</th><th>Fecha</th></tr></thead>
                <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <?php
                        $pt = $p['id_plantilla'] == 6 ? 'electro' : ($p['id_plantilla'] == 4 ? 'techo' : 'otro');
                        $pc = $p['estado_pago'] == 'Completado' ? 'pagado' : (strtolower($p['estado_pago'] ?? 'pendiente'));
                        $lc = strtolower($p['estado_logistico'] ?? '');
                    ?>
                    <tr>
                        <td style="font-weight:600;font-size:12px;color:var(--admin-accent)"><?= htmlspecialchars($p['codigo_seguimiento']) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($p['cliente_nombre'] . ' ' . $p['cliente_apellidos']) ?></strong>
                            <br><span style="font-size:11px;color:var(--admin-dim)"><?= htmlspecialchars($p['cliente_email']) ?></span>
                        </td>
                        <td><strong><?= htmlspecialchars($p['nombre_comercial']) ?></strong></td>
                        <td><span class="plantilla-tag <?= $pt ?>"><?= htmlspecialchars($p['plantilla_nombre']) ?></span></td>
                        <td><?= $p['total_items'] ?> item(s)</td>
                        <td><strong>Bs. <?= number_format($p['total'], 2) ?></strong></td>
                        <td>
                            <span class="badge-pl <?= $pc ?>"><?= $p['metodo_pago'] ?></span>
                            <br><span style="font-size:10px;color:var(--admin-dim)"><?= $p['estado_pago'] ?></span>
                        </td>
                        <td><span class="badge-pl <?= str_replace('_', '', $lc) ?>"><?= $p['estado_logistico'] ?></span></td>
                        <td style="font-size:12px;color:var(--admin-dim)"><?= $p['fecha_creacion'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="table-wrap"><div class="empty">
                <i class="fas fa-shopping-cart"></i>
                <p>No hay ventas registradas</p>
                <p style="font-size:12px;color:var(--admin-dim);margin-top:8px">Crea un negocio con plantilla Electrodomésticos, agrega productos y realiza una compra para ver ventas aquí.</p>
            </div></div>
        <?php endif; ?>
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
