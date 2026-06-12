<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Inventario - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .inv-wrap { max-width:1400px; margin:0 auto; padding:32px 24px; }
        .inv-header { margin-bottom:32px; }
        .inv-header h1 { font-family:Georgia,'Cormorant Garamond',serif; font-size:28px; font-weight:400; color:var(--text); display:flex; align-items:center; gap:12px; }
        .inv-header .sub { font-size:13px; color:var(--text-dim); margin-top:6px; }
        .inv-header .back { color:var(--text-muted); text-decoration:none; font-size:13px; transition:color .2s; }
        .inv-header .back:hover { color:var(--text); }
        .inv-tabs { display:flex; gap:4px; margin-bottom:28px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:4px; overflow-x:auto; }
        .inv-tab { padding:10px 20px; border-radius:4px; font-size:12px; font-weight:500; color:var(--text-muted); text-decoration:none; white-space:nowrap; transition:all .15s; }
        .inv-tab:hover { color:var(--text); background:var(--surface2); }
        .inv-tab.active { background:var(--text); color:var(--bg); }
        .stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
        .stat-box { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:20px 24px; }
        .stat-box .num { font-size:26px; font-weight:700; color:var(--text); }
        .stat-box .lbl { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; }
        .inv-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; margin-bottom:24px; }
        .inv-card h2 { font-family:Georgia,'Cormorant Garamond',serif; font-size:18px; font-weight:500; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .filtros { display:flex; gap:12px; margin-bottom:20px; align-items:center; flex-wrap:wrap; }
        .filtros select, .filtros input { padding:9px 14px; border:1px solid var(--border); border-radius:4px; background:var(--card-bg); color:var(--text); font-size:12px; font-family:inherit; outline:none; }
        .filtros select:focus, .filtros input:focus { border-color:var(--border-hi); }
        .filtros .btn-f { display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:var(--text);color:var(--bg);border:none;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit; }
        .filtros .btn-f:hover { opacity:0.9; }
        .table-wrap { overflow-x:auto; }
        table.invt { width:100%; border-collapse:collapse; }
        .invt th { text-align:left; padding:14px 16px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); white-space:nowrap; }
        [data-theme="light"] .invt th { background:rgba(0,0,0,0.03); }
        .invt td { padding:14px 16px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .invt tbody tr:last-child td { border-bottom:none; }
        .invt tbody tr:hover { background:rgba(255,255,255,0.015); }
        [data-theme="light"] .invt tbody tr:hover { background:rgba(0,0,0,0.03); }
        .stock-alerta { color:#9a5a5a; font-weight:600; }
        .stock-ok { color:#6b8f71; }
        .stock-cero { color:var(--text-dim); font-style:italic; }
        .badge-alerta { display:inline-block;padding:3px 10px;border-radius:4px;font-size:10px;font-weight:600;background:rgba(154,90,90,0.12);color:#9a5a5a; }
        .badge-ok { display:inline-block;padding:3px 10px;border-radius:4px;font-size:10px;font-weight:600;background:rgba(107,143,113,0.1);color:#6b8f71; }
        .badge-cero { display:inline-block;padding:3px 10px;border-radius:4px;font-size:10px;font-weight:600;background:rgba(128,128,128,0.08);color:var(--text-dim); }
        .acoes { display:flex;gap:6px; }
        .btn-sm { display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:4px;font-size:11px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;transition:all .15s; }
        .btn-sm-edit { background:rgba(107,127,143,0.1);color:#6b7f8f;border:1px solid rgba(107,127,143,0.15); }
        .btn-sm-edit:hover { background:rgba(107,127,143,0.18); }
        .btn-sm-trans { background:rgba(107,143,113,0.1);color:#6b8f71;border:1px solid rgba(107,143,113,0.15); }
        .btn-sm-trans:hover { background:rgba(107,143,113,0.18); }
        .btn-sm-kardex { background:rgba(154,138,74,0.1);color:#9a8a4a;border:1px solid rgba(154,138,74,0.15); }
        .btn-sm-kardex:hover { background:rgba(154,138,74,0.18); }
        .modal-overlay { display:none; position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center; }
        .modal-overlay.active { display:flex; }
        .modal-box { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:28px; max-width:480px;width:90%;max-height:90vh;overflow-y:auto; }
        .modal-box h3 { font-family:Georgia,'Cormorant Garamond',serif; font-size:20px; font-weight:500; color:var(--text); margin-bottom:16px; }
        .modal-box label { font-size:11px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.5px; font-weight:600; display:block; margin-bottom:4px; }
        .modal-box input, .modal-box select, .modal-box textarea { width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:4px; background:var(--card-bg); color:var(--text); font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; margin-bottom:14px; }
        .modal-box input:focus, .modal-box select:focus, .modal-box textarea:focus { border-color:var(--border-hi); }
        .modal-box .btn-row { display:flex;gap:10px;margin-top:8px; }
        .empty-state { text-align:center;padding:60px 20px;color:var(--text-dim); }
        .empty-state i { font-size:36px;margin-bottom:12px;opacity:0.3;color:var(--text-muted); }
        .msg-success { background:rgba(107,143,113,0.1);border-left:3px solid #6b8f71;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#6b8f71;display:flex;align-items:center;gap:10px; }
        .msg-error { background:rgba(154,90,90,0.1);border-left:3px solid #9a5a5a;padding:14px 18px;border-radius:4px;margin-bottom:24px;font-size:13px;color:#9a5a5a;display:flex;align-items:center;gap:10px; }
        @media(max-width:900px){
            .inv-wrap { padding:24px 20px; }
            .stats-row { grid-template-columns:repeat(2,1fr); }
            .invt th,.invt td { padding:10px 12px; white-space:nowrap; }
            .acoes { flex-direction:column; gap:4px; }
        }
        @media(max-width:480px){
            .inv-wrap { padding:16px 12px; }
            .stats-row { grid-template-columns:1fr; }
            .inv-header h1 { font-size:22px; }
            .inv-card { padding:16px; }
            .filtros { flex-direction:column; align-items:stretch; }
            .modal-box { padding:20px; }
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
        <a href="<?= BASE_URL ?>/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>/productos"><i class="fas fa-cube"></i> Productos</a>
        <a href="<?= BASE_URL ?>/categorias"><i class="fas fa-folder"></i> Categorías</a>
        <a href="<?= BASE_URL ?>/gestionar-negocios"><i class="fas fa-store-alt"></i> Gestionar negocios</a>
        <a href="<?= BASE_URL ?>/repartidores-admin"><i class="fas fa-truck"></i> Repartidores</a>
        <a href="<?= BASE_URL ?>/plantillas-disponibles"><i class="fas fa-plus-circle"></i> Nuevo negocio</a>
        <a href="<?= BASE_URL ?>/herramientas" style="margin-top:24px;border-top:1px solid var(--border);padding-top:16px;"><i class="fas fa-tools"></i> Herramientas</a>
        <a href="<?= BASE_URL ?>/sucursales"><i class="fas fa-code-branch"></i> Sucursales</a>
        <a href="<?= BASE_URL ?>/inventario" class="active"><i class="fas fa-boxes"></i> Inventario</a>
        <a href="<?= BASE_URL ?>/kardex"><i class="fas fa-history"></i> Kardex</a>
        <a href="<?= BASE_URL ?>/logout" style="margin-top:8px;"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
    </nav>
</div>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="menu-btn" id="menuBtn">&#9776;</button>
        </div>
        <div style="display:flex;align-items:center;gap:0">
            <a href="#" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;color:var(--text-muted);text-decoration:none;transition:color .2s;margin-right:4px" title="Notificaciones" onclick="alert('Próximamente: centro de notificaciones');return false">
                <i class="fas fa-bell" style="font-size:15px"></i>
                <span style="position:absolute;top:4px;right:4px;width:7px;height:7px;border-radius:50%;background:#9a5a5a;display:none"></span>
            </a>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema">&#9790;</button>
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
                    <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">Mi Perfil</a>
                    <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout">Cerrar sesion</a>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-container">

    <div class="inv-header">
        <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
        <h1><i class="fas fa-boxes" style="color:var(--text-muted)"></i> Inventario por Sucursal</h1>
        <div class="sub">Control de stock detallado por producto, variante y sucursal</div>
    </div>

    <?php if ($success): ?>
        <div class="msg-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (count($mis_negocios) > 0): ?>

    <div class="inv-tabs">
        <?php foreach ($mis_negocios as $n): ?>
            <a href="<?= BASE_URL ?>/inventario?id_emprendimiento=<?= $n['id_emprendimiento'] ?>" class="inv-tab <?= $id_emprendimiento == $n['id_emprendimiento'] ? 'active' : '' ?>">
                <i class="fas fa-store"></i> <?= htmlspecialchars($n['nombre_comercial']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($negocio_seleccionado): ?>

    <div class="stats-row">
        <div class="stat-box"><div class="num"><?= count($inventario) ?></div><div class="lbl">Registros</div></div>
        <div class="stat-box"><div class="num" style="color:#9a5a5a"><?= $total_alertas ?></div><div class="lbl">Stock bajo</div></div>
        <div class="stat-box"><div class="num" style="color:var(--text-dim)"><?= $total_stock_cero ?></div><div class="lbl">Sin stock</div></div>
        <div class="stat-box"><div class="num">Bs. <?= number_format($valor_total, 2) ?></div><div class="lbl">Valor inventario</div></div>
    </div>

    <div class="inv-card">
        <h2><i class="fas fa-filter" style="color:var(--text-muted)"></i> Stock por sucursal</h2>
        <form method="GET" action="<?= BASE_URL ?>/inventario" class="filtros">
            <input type="hidden" name="id_emprendimiento" value="<?= $id_emprendimiento ?>">
            <select name="id_sucursal">
                <option value="">Todas las sucursales</option>
                <?php foreach ($sucursales as $s): ?>
                    <option value="<?= $s['id_sucursal'] ?>" <?= $filtro_sucursal == $s['id_sucursal'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nombre_sucursal']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-f"><i class="fas fa-filter"></i> Filtrar</button>
            <a href="<?= BASE_URL ?>/inventario?id_emprendimiento=<?= $id_emprendimiento ?>" style="font-size:12px;color:var(--text-muted)">Limpiar</a>
        </form>

        <?php if (count($inventario) > 0): ?>
        <div class="table-wrap">
            <table class="invt">
                <thead>
                    <tr><th>Producto</th><th>SKU</th><th>Atributos</th><th>Sucursal</th><th>Stock</th><th>Alerta</th><th>Valor inventario</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($inventario as $item): ?>
                    <?php
                        $stockClass = $item['cantidad_actual'] == 0 ? 'stock-cero' : ($item['alerta'] ? 'stock-alerta' : 'stock-ok');
                        $badgeClass = $item['cantidad_actual'] == 0 ? 'badge-cero' : ($item['alerta'] ? 'badge-alerta' : 'badge-ok');
                        $atributosStr = '';
                        if ($item['valor_1']) $atributosStr .= $item['atributo_1'] . ': ' . $item['valor_1'];
                        if ($item['valor_2']) $atributosStr .= ($atributosStr ? ', ' : '') . $item['atributo_2'] . ': ' . $item['valor_2'];
                        if (!$atributosStr) $atributosStr = '—';
                    ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($item['producto_nombre']) ?></strong></td>
                        <td style="font-size:12px;color:var(--text-dim)"><?= htmlspecialchars($item['sku']) ?></td>
                        <td style="font-size:12px;color:var(--text-muted)"><?= htmlspecialchars($atributosStr) ?></td>
                        <td><?= htmlspecialchars($item['nombre_sucursal']) ?></td>
                        <td class="<?= $stockClass ?>"><strong><?= (int)$item['cantidad_actual'] ?></strong></td>
                        <td><span class="<?= $badgeClass ?>"><?= (int)$item['alerta_minima'] ?></span></td>
                        <td>Bs. <?= number_format($item['valor_inventario'], 2) ?></td>
                        <td>
                            <div class="acoes">
                                <button class="btn-sm btn-sm-edit" onclick="openAjustar(<?= $item['id_inventario'] ?>, '<?= htmlspecialchars(addslashes($item['producto_nombre'])) ?> - <?= htmlspecialchars(addslashes($item['sku'])) ?>', <?= (int)$item['cantidad_actual'] ?>, <?= (int)$item['alerta_minima'] ?>)"><i class="fas fa-pen"></i></button>
                                <button class="btn-sm btn-sm-trans" onclick="openTransferir(<?= $item['id_variante'] ?>, '<?= htmlspecialchars(addslashes($item['producto_nombre'])) ?> - <?= htmlspecialchars(addslashes($item['sku'])) ?>', <?= (int)$item['cantidad_actual'] ?>, <?= $item['id_sucursal'] ?>)"><i class="fas fa-exchange-alt"></i></button>
                                <a href="<?= BASE_URL ?>/kardex?id_emprendimiento=<?= $id_emprendimiento ?>&id_sucursal=<?= $item['id_sucursal'] ?>" class="btn-sm btn-sm-kardex"><i class="fas fa-history"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>No hay registros de inventario</p>
            <p style="font-size:12px;color:var(--text-dim);margin-top:8px">Agrega productos con variantes (SKU) para ver el inventario aqui.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <div class="inv-card"><div class="empty-state"><i class="fas fa-store"></i><p>Selecciona un negocio</p></div></div>
    <?php endif; ?>

    <?php else: ?>
    <div class="inv-card"><div class="empty-state"><i class="fas fa-store"></i><p>No tienes negocios</p><a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-f" style="margin-top:16px"><i class="fas fa-plus"></i> Crear negocio</a></div></div>
    <?php endif; ?>

    </div>
</div>

<!-- Modal Ajustar Stock -->
<div class="modal-overlay" id="modalAjustar">
    <div class="modal-box">
        <h3><i class="fas fa-pen" style="color:var(--text-muted)"></i> Ajustar Stock</h3>
        <form method="POST" action="<?= BASE_URL ?>/inventario?id_emprendimiento=<?= $id_emprendimiento ?>">
            <input type="hidden" name="accion" value="ajustar">
            <input type="hidden" name="id_inventario" id="aj_id">
            <p style="font-size:13px;color:var(--text-muted);margin-bottom:14px" id="aj_producto"></p>
            <label>Nueva cantidad</label>
            <input type="number" name="cantidad" id="aj_cantidad" min="0" required>
            <label>Observaci&oacute;n</label>
            <textarea name="observacion" placeholder="Ej: Ajuste por inventario fisico"></textarea>
            <div class="btn-row">
                <button type="submit" class="btn-f"><i class="fas fa-save"></i> Guardar</button>
                <button type="button" class="btn-f" style="background:transparent;color:var(--text-muted);border:1px solid var(--border)" onclick="closeModal('modalAjustar')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Transferir -->
<div class="modal-overlay" id="modalTransferir">
    <div class="modal-box">
        <h3><i class="fas fa-exchange-alt" style="color:var(--text-muted)"></i> Transferir Stock</h3>
        <form method="POST" action="<?= BASE_URL ?>/inventario?id_emprendimiento=<?= $id_emprendimiento ?>">
            <input type="hidden" name="accion" value="transferir">
            <input type="hidden" name="id_variante" id="tr_id_variante">
            <input type="hidden" name="id_sucursal_origen" id="tr_id_origen">
            <p style="font-size:13px;color:var(--text-muted);margin-bottom:14px" id="tr_producto"></p>
            <label>Stock disponible</label>
            <p style="font-size:16px;font-weight:600;color:var(--text);margin-bottom:14px" id="tr_stock"></p>
            <label>Sucursal destino</label>
            <select name="id_sucursal_destino" id="tr_destino" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($sucursales as $s): ?>
                    <option value="<?= $s['id_sucursal'] ?>"><?= htmlspecialchars($s['nombre_sucursal']) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Cantidad a transferir</label>
            <input type="number" name="cantidad" id="tr_cantidad" min="1" required>
            <div class="btn-row">
                <button type="submit" class="btn-f"><i class="fas fa-exchange-alt"></i> Transferir</button>
                <button type="button" class="btn-f" style="background:transparent;color:var(--text-muted);border:1px solid var(--border)" onclick="closeModal('modalTransferir')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

<script>
(function() {
    var menuBtn = document.getElementById('menuBtn');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
    if (menuBtn) { menuBtn.addEventListener('click', toggleSidebar); overlay.addEventListener('click', toggleSidebar); }

    var userDropdown = document.getElementById('userDropdown');
    var userTrigger = document.getElementById('userTrigger');
    if (userTrigger) {
        userTrigger.addEventListener('click', function(e) { e.stopPropagation(); userDropdown.classList.toggle('active'); });
        document.addEventListener('click', function() { userDropdown.classList.remove('active'); });
    }

    var themeToggle = document.getElementById('themeToggle');
    var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    if (themeToggle) {
        themeToggle.innerHTML = currentTheme === 'dark' ? '\u2600' : '\u263E';
        themeToggle.addEventListener('click', function() {
            var theme = document.documentElement.getAttribute('data-theme');
            var newTheme = theme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('jacha_theme', newTheme);
            themeToggle.innerHTML = newTheme === 'dark' ? '\u2600' : '\u263E';
        });
    }
})();

function openAjustar(id, producto, cantidad, alerta) {
    document.getElementById('aj_id').value = id;
    document.getElementById('aj_producto').textContent = producto;
    document.getElementById('aj_cantidad').value = cantidad;
    document.getElementById('modalAjustar').classList.add('active');
}
function openTransferir(idVariante, producto, stock, idOrigen) {
    document.getElementById('tr_id_variante').value = idVariante;
    document.getElementById('tr_id_origen').value = idOrigen;
    document.getElementById('tr_producto').textContent = producto;
    document.getElementById('tr_stock').textContent = stock + ' unidades disponibles';
    document.getElementById('tr_cantidad').value = '';
    document.getElementById('modalTransferir').classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
    }
});
</script>
</body>
</html>
