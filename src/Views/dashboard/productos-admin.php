<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Gestionar Productos - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        body { font-family:'Inter',system-ui,sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }
        .wrap { max-width:1400px; margin:0 auto; padding:40px 32px; }

        .page-hdr { display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; }
        .page-hdr-left h1 { font-family:'Cormorant Garamond',serif; font-size:32px; font-weight:600; color:var(--text); margin-bottom:2px; }
        .page-hdr-left .sub { font-size:13px; color:var(--text-muted); }
        .page-hdr-left .back { color:var(--text-muted); text-decoration:none; font-size:12px; display:inline-flex; align-items:center; gap:5px; margin-bottom:10px; transition:color .2s; }
        .page-hdr-left .back:hover { color:var(--text); }
        .theme-tog { background:none; border:1px solid var(--border); color:var(--text-muted); width:36px; height:36px; border-radius:4px; cursor:pointer; font-size:15px; display:flex; align-items:center; justify-content:center; transition:all .2s; flex-shrink:0; }
        .theme-tog:hover { border-color:var(--text); color:var(--text); }

        .msg { border-radius:3px; padding:12px 16px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .msg-success { background:rgba(107,143,113,0.1); border:1px solid rgba(107,143,113,0.15); color:#6b8f71; }
        .msg-error { background:rgba(154,90,90,0.1); border:1px solid rgba(154,90,90,0.15); color:#9a5a5a; }

        .nb-bar { display:flex; gap:8px; margin-bottom:28px; flex-wrap:wrap; }
        .nb-tab { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; text-decoration:none; color:var(--text-muted); font-size:13px; font-weight:500; transition:all .2s; }
        .nb-tab:hover { border-color:var(--border-hi); color:var(--text); }
        .nb-tab.active { background:var(--text); color:var(--bg); border-color:var(--text); }
        .nb-tab .dot { width:10px; height:10px; border-radius:50%; display:inline-block; flex-shrink:0; }
        .nb-tab small { font-size:10px; opacity:0.6; }

        .f-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:28px; margin-bottom:28px; }
        .f-card h2 { font-family:'Cormorant Garamond',serif; font-size:24px; font-weight:500; color:var(--text); margin-bottom:20px; }
        .f-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
        .f-grp { margin-bottom:16px; }
        .f-grp label { display:block; margin-bottom:5px; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); }
        .f-grp input,.f-grp textarea,.f-grp select { width:100%; padding:11px 13px; background:rgba(255,255,255,0.03); border:1px solid var(--border); border-radius:3px; font-size:13px; color:var(--text); font-family:inherit; transition:border-color .2s; }
        .f-grp input:focus,.f-grp textarea:focus,.f-grp select:focus { outline:none; border-color:rgba(255,255,255,0.25); }
        .f-grp textarea { resize:vertical; min-height:80px; }
        .f-grp img { width:80px; height:80px; border-radius:3px; object-fit:cover; background:var(--card-bg); margin-top:8px; display:block; border:1px solid var(--border); }
        .f-grp select { appearance:none; -webkit-appearance:none; -moz-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23888'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; cursor:pointer; }
        .f-grp select option { background:var(--bg); color:var(--text); }
        .f-grp input[type="file"] { padding:9px 13px; cursor:pointer; }
        .f-grp input[type="file"]::file-selector-button { padding:6px 14px; background:var(--text); color:var(--bg); border:none; border-radius:3px; font-size:11px; font-weight:600; cursor:pointer; font-family:inherit; margin-right:10px; transition:opacity .2s; }
        .f-grp input[type="file"]::file-selector-button:hover { opacity:0.85; }
        .f-grp input[type="number"] { -moz-appearance:textfield; }
        .f-grp input[type="number"]::-webkit-inner-spin-button,.f-grp input[type="number"]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }

        .df { background:rgba(255,255,255,0.02); border-radius:3px; padding:20px; margin-top:16px; border:1px dashed var(--border); }
        .df h3 { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:14px; }
        .a-row { display:flex; gap:10px; margin-bottom:10px; align-items:center; }
        .a-row input { padding:10px 12px; background:rgba(255,255,255,0.03); border:1px solid var(--border); border-radius:3px; font-size:13px; color:var(--text); font-family:inherit; transition:border-color .2s; }
        .a-row input:focus { outline:none; border-color:rgba(255,255,255,0.25); }
        .a-row .an { flex:1; }
        .a-row .av { flex:2; }
        .a-rm { background:none; border:none; color:#9a5a5a; cursor:pointer; font-size:14px; padding:6px; transition:color .2s; }
        .a-rm:hover { color:#c0392b; }
        .a-add { background:none; border:1px dashed var(--border); color:var(--text-muted); padding:8px 16px; border-radius:3px; cursor:pointer; font-size:12px; margin-top:10px; transition:all .2s; font-family:inherit; }
        .a-add:hover { border-color:var(--text); color:var(--text); }

        .btn-p { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:12px 22px; background:var(--text); color:var(--bg); border:none; border-radius:4px; font-size:13px; font-weight:600; cursor:pointer; transition:opacity .2s; font-family:inherit; text-decoration:none; }
        .btn-p:hover { opacity:0.85; }
        .btn-s { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:12px 22px; background:none; color:var(--text-muted); border:1px solid var(--border); border-radius:4px; font-size:13px; font-weight:500; cursor:pointer; transition:all .2s; font-family:inherit; text-decoration:none; }
        .btn-s:hover { border-color:var(--border-hi); color:var(--text); }
        .btn-full { width:100%; margin-top:16px; }

        .t-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:24px; margin-bottom:32px; overflow:hidden; }
        .t-card h2 { font-family:'Cormorant Garamond',serif; font-size:20px; font-weight:500; color:var(--text); margin-bottom:16px; }
        .twrap { overflow-x:auto; }
        table.dt { width:100%; border-collapse:collapse; }
        .dt th { text-align:left; padding:14px 16px; font-size:10px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); background:rgba(255,255,255,0.02); white-space:nowrap; }
        .dt td { padding:14px 16px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        .dt tbody tr:last-child td { border-bottom:none; }
        .dt tbody tr:hover { background:rgba(255,255,255,0.015); }
        .dt .pimg { width:44px; height:44px; border-radius:3px; object-fit:cover; display:block; background:var(--card-bg); border:1px solid var(--border); }

        .sb { display:inline-block; padding:3px 10px; border-radius:3px; font-size:10px; font-weight:600; }
        .sb-Publicado { background:rgba(107,143,113,0.15); color:#6b8f71; }
        .sb-Borrador { background:rgba(154,138,74,0.15); color:#9a8a4a; }
        .sb-Oculto { background:rgba(107,127,143,0.15); color:#6b7f8f; }

        .acts { display:flex; gap:6px; white-space:nowrap; }
        .ba { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:3px; font-size:11px; font-weight:500; text-decoration:none; transition:opacity .2s; }
        .ba:hover { opacity:0.8; }
        .ba-edit { background:rgba(107,127,143,0.12); color:#6b7f8f; }
        .ba-del { background:rgba(154,90,90,0.12); color:#9a5a5a; }

        .es { padding:60px 20px; color:var(--text-dim); text-align:center; }
        .es p { font-size:13px; color:var(--text-muted); }

        .wm { position:fixed; bottom:20px; right:20px; opacity:0.06; pointer-events:none; z-index:0; }
        .wm img { height:40px; width:auto; }

        @media(max-width:768px){
            .wrap { padding:20px 16px; }
            .f-row { grid-template-columns:1fr; }
            .page-hdr { flex-direction:column; align-items:flex-start; gap:12px; }
            .nb-bar { overflow-x:auto; flex-wrap:nowrap; padding-bottom:4px; -webkit-overflow-scrolling:touch; }
            .dt td,.dt th { padding:10px 12px; }
            .acts { flex-direction:column; gap:4px; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="page-hdr">
        <div class="page-hdr-left">
            <a href="<?= BASE_URL ?>/dashboard" class="back"><i class="fas fa-arrow-left"></i> Volver al dashboard</a>
            <h1>Gestionar Productos</h1>
            <div class="sub">Administra el cat&aacute;logo de tus negocios</div>
        </div>
        <button class="theme-tog" id="themeToggle" title="Cambiar tema"><i class="fas fa-moon"></i></button>
    </div>

    <?php if ($mensaje): ?>
    <div class="msg msg-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
    <div class="msg msg-success"><i class="fas fa-check-circle"></i> Producto eliminado correctamente</div>
    <?php endif; ?>

    <?php if (count($negocios) > 0): ?>
    <div class="nb-bar">
        <?php foreach ($negocios as $negocio): ?>
        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="nb-tab <?= ($id_emprendimiento == $negocio['id_emprendimiento']) ? 'active' : '' ?>">
            <span class="dot" style="background:<?= $negocio['color_primario'] ?? '#888' ?>"></span>
            <?= htmlspecialchars($negocio['nombre_comercial']) ?>
            <small>(<?= $negocio['plantilla_nombre'] ?? 'Sin plantilla' ?>)</small>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!$negocio_seleccionado): ?>
        <div class="f-card">
            <div class="es">
                <p>Selecciona un negocio para gestionar sus productos</p>
                <?php if (count($negocios) == 0): ?>
                    <p style="margin-top:8px;font-size:13px;">No tienes negocios creados. Crea uno desde el dashboard.</p>
                    <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-p" style="margin-top:16px"><i class="fas fa-plus"></i> Crear mi primer negocio</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div style="display:flex;justify-content:flex-end;margin-bottom:24px;">
            <button class="btn-p" id="showFormBtn"><i class="fas fa-plus"></i> Nuevo producto</button>
        </div>

        <div class="f-card" id="productForm" style="<?= !$producto_editar ? 'display:none' : '' ?>">
            <h2><?= $producto_editar ? 'Editar producto' : 'Nuevo producto' ?></h2>
            <form method="POST" enctype="multipart/form-data" id="productoForm" action="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>">
                <input type="hidden" name="id_producto" value="<?= $producto_editar['id_producto'] ?? 0 ?>">

                <div class="f-row">
                    <div class="f-grp">
                        <label>Nombre del producto <span style="color:#9a5a5a">*</span></label>
                        <input type="text" name="nombre" required value="<?= htmlspecialchars($producto_editar['nombre'] ?? '') ?>" placeholder="Ej: Laptop Gamer Pro">
                    </div>
                    <div class="f-grp">
                        <label>Precio (Bs) <span style="color:#9a5a5a">*</span></label>
                        <input type="number" step="0.01" name="precio_base" required value="<?= $producto_editar['precio_base'] ?? '' ?>" placeholder="0.00">
                    </div>
                </div>

                <div class="f-grp">
                    <label>Stock / Cantidad disponible</label>
                    <input type="number" name="stock" value="<?= $producto_editar['stock'] ?? 0 ?>" placeholder="0">
                </div>

                <div class="f-grp">
                    <label>Descripci&oacute;n del producto</label>
                    <textarea name="descripcion" placeholder="Describe las caracter&iacute;sticas principales..."><?= htmlspecialchars($producto_editar['descripcion_larga'] ?? '') ?></textarea>
                </div>

                <div class="df">
                    <h3><i class="fas fa-list"></i> Caracter&iacute;sticas adicionales (opcional)</h3>
                    <div id="attributesContainer">
                        <?php
                        $atributos_existentes = [];
                        if ($producto_editar && isset($producto_editar['atributos_arr']) && is_array($producto_editar['atributos_arr'])) {
                            $atributos_existentes = $producto_editar['atributos_arr'];
                        }
                        foreach ($atributos_existentes as $nombre_attr => $valor_attr):
                        ?>
                        <div class="a-row">
                            <input type="text" class="an" name="attr_nombre[]" placeholder="Ej: Marca" value="<?= htmlspecialchars($nombre_attr) ?>">
                            <input type="text" class="av" name="attr_valor[]" placeholder="Valor" value="<?= htmlspecialchars($valor_attr) ?>">
                            <button type="button" class="a-rm" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="a-add" id="addAttrBtn"><i class="fas fa-plus"></i> Agregar caracter&iacute;stica</button>
                </div>

                <div class="f-row">
                    <div class="f-grp">
                        <label><i class="fas fa-image"></i> Imagen del producto</label>
                        <input type="file" name="imagen" accept="image/*" id="imagenInput">
                        <?php if (!empty($producto_editar['imagen_url'])): ?>
                            <img src="<?= BASE_URL ?>/<?= $producto_editar['imagen_url'] ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="f-grp">
                        <label><i class="fas fa-toggle-on"></i> Estado de publicaci&oacute;n</label>
                        <select name="estado">
                            <option value="Publicado" <?= ($producto_editar['estado'] ?? '') === 'Publicado' ? 'selected' : '' ?>>Publicado (visible en tienda)</option>
                            <option value="Borrador" <?= ($producto_editar['estado'] ?? '') === 'Borrador' ? 'selected' : '' ?>>Borrador (no visible)</option>
                            <option value="Oculto" <?= ($producto_editar['estado'] ?? '') === 'Oculto' ? 'selected' : '' ?>>Oculto (oculto temporalmente)</option>
                        </select>
                    </div>
                </div>

                <?php if ($error): ?>
                <div class="msg msg-error" style="margin-bottom:16px"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <button type="submit" class="btn-p btn-full"><i class="fas fa-save"></i> Guardar producto</button>
                <button type="button" class="btn-s btn-full" id="cancelFormBtn"><i class="fas fa-times"></i> Cancelar</button>
            </form>
        </div>

        <div class="t-card">
            <h2>Productos de <?= htmlspecialchars($negocio_seleccionado['nombre_comercial']) ?></h2>
            <?php if (count($productos) > 0): ?>
            <div class="twrap">
                <table class="dt">
                    <thead>
                        <tr><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><img src="<?= BASE_URL ?>/<?= $producto['imagen_url'] ?: 'assets/images/placeholder_producto.jpg' ?>" class="pimg" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'"></td>
                            <td><strong><?= htmlspecialchars($producto['nombre']) ?></strong><br><span style="font-size:11px;color:var(--text-dim)">ID: #<?= $producto['id_producto'] ?></span></td>
                            <td>Bs. <?= number_format($producto['precio_base'], 2) ?></td>
                            <td><?= $producto['stock'] ?? 0 ?></td>
                            <td><span class="sb sb-<?= $producto['estado'] ?>"><?= $producto['estado'] ?></span></td>
                            <td><div class="acts">
                                <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>&edit=<?= $producto['id_producto'] ?>" class="ba ba-edit"><i class="fas fa-pen"></i> Editar</a>
                                <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>&action=delete&id=<?= $producto['id_producto'] ?>" class="ba ba-del" onclick="return confirm('¿Eliminar este producto permanentemente?')"><i class="fas fa-trash"></i> Eliminar</a>
                            </div></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="es">
                <p>No tienes productos en este negocio</p>
                <button class="btn-p" style="margin-top:16px" onclick="document.getElementById('productForm').style.display='block';document.getElementById('productForm').scrollIntoView({behavior:'smooth'});"><i class="fas fa-plus"></i> Agregar mi primer producto</button>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<span class="wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

<script>
(function(){
    var showBtn = document.getElementById('showFormBtn');
    var formDiv = document.getElementById('productForm');
    var cancelBtn = document.getElementById('cancelFormBtn');
    if (showBtn) {
        showBtn.onclick = function() {
            formDiv.style.display = 'block';
            formDiv.scrollIntoView({ behavior: 'smooth' });
        };
    }
    if (cancelBtn) {
        cancelBtn.onclick = function() {
            formDiv.style.display = 'none';
            window.location.href = '<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>';
        };
    }
    <?php if ($producto_editar): ?>
    formDiv.style.display = 'block';
    <?php endif; ?>

    var addBtn = document.getElementById('addAttrBtn');
    var container = document.getElementById('attributesContainer');
    function addAttributeRow(nombre, valor) {
        nombre = nombre || '';
        valor = valor || '';
        var row = document.createElement('div');
        row.className = 'a-row';
        row.innerHTML = '<input type="text" class="an" name="attr_nombre[]" placeholder="Ej: Marca, Talla, Color" value="' + esc(nombre) + '">'
            + '<input type="text" class="av" name="attr_valor[]" placeholder="Valor" value="' + esc(valor) + '">'
            + '<button type="button" class="a-rm" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>';
        container.appendChild(row);
    }
    function esc(str) { if (!str) return ''; return str.replace(/[&<>]/g, function(m){ if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m; }); }
    if (addBtn) { addBtn.onclick = function() { addAttributeRow(); }; }

    var pf = document.getElementById('productoForm');
    if (pf) {
        pf.addEventListener('submit', function() {
            var names = document.querySelectorAll('.a-row .an');
            var vals = document.querySelectorAll('.a-row .av');
            for (var i = 0; i < names.length; i++) {
                var n = names[i].value.trim();
                var v = vals[i].value.trim();
                if (n && v) {
                    var h = document.createElement('input');
                    h.type = 'hidden';
                    h.name = 'attr_' + n;
                    h.value = v;
                    pf.appendChild(h);
                }
            }
        });
    }

    var tt = document.getElementById('themeToggle');
    var ct = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', ct);
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
})();
</script>
</body>
</html>
