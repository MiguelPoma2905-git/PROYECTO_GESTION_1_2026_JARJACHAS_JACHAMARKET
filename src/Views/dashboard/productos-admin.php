<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Gestionar Productos - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        .product-form { background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:32px;margin-bottom:32px }
        .product-form .form-row { display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px }
        .product-form .form-group { margin-bottom:20px }
        .product-form label { display:block;margin-bottom:6px;font-size:12px;color:var(--text-muted);font-weight:500 }
        .product-form input,.product-form textarea,.product-form select { width:100%;padding:12px 14px;background:var(--bg);border:1px solid var(--border);border-radius:10px;font-size:14px;color:var(--text);transition:border-color 0.2s }
        .product-form input:focus,.product-form textarea:focus,.product-form select:focus { outline:none;border-color:var(--border-hi) }
        .product-form textarea { resize:vertical;min-height:80px;font-family:inherit }
        .dynamic-fields { background:#0d0d0d;border-radius:16px;padding:20px;margin-top:20px;border:1px dashed #3a3a3a }
        .dynamic-fields h3 { font-size:14px;margin-bottom:16px;color:#aaa;font-weight:500;letter-spacing:0.5px }
        .add-attr-btn { background:none;border:1px dashed #3a3a3a;color:#888;padding:8px 16px;border-radius:20px;cursor:pointer;font-size:12px;margin-top:12px;transition:all 0.2s }
        .add-attr-btn:hover { border-color:#fff;color:#fff }
        .attr-row { display:flex;gap:12px;margin-bottom:12px;align-items:center }
        .attr-name { flex:1 }
        .attr-value { flex:2 }
        .remove-attr { background:none;border:none;color:#ff6b6b;cursor:pointer;font-size:18px }
        .error-msg { background:rgba(255,107,107,0.12);border-left:3px solid #ff6b6b;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:13px;color:#ff6b6b }
        .status-badge { display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:600 }
        .status-Publicado { background:rgba(76,175,80,0.15);color:#4caf50 }
        .status-Borrador { background:rgba(255,193,7,0.15);color:#ffc107 }
        .status-Oculto { background:rgba(136,136,136,0.15);color:#888 }
        @media (max-width:768px) { .product-form .form-row { grid-template-columns:1fr } }
    </style>
</head>
<body>
    <div class="container" style="max-width:1400px;margin:0 auto;padding:40px 32px">
        <div class="page-header">
            <div>
                <a href="<?= BASE_URL ?>/dashboard" class="back-link">← Volver al dashboard</a>
                <h1>Gestionar Productos</h1>
                <p class="subtitle">Administra el cat&aacute;logo de tus negocios</p>
            </div>
            <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="margin-left:auto">&#9790;</button>
        </div>
        
        <?php if ($mensaje): ?>
        <div class="success-msg">✓ <?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
        <div class="success-msg">✓ Producto eliminado correctamente</div>
        <?php endif; ?>
        
        <?php if (count($negocios) > 0): ?>
        <div class="negocios-bar">
            <?php foreach ($negocios as $negocio): ?>
            <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $negocio['id_emprendimiento'] ?>" class="negocio-tab <?= ($id_emprendimiento == $negocio['id_emprendimiento']) ? 'active' : '' ?>">
                <span class="negocio-color" style="width:12px;height:12px;border-radius:50%;display:inline-block;background: <?= $negocio['color_primario'] ?? '#fff' ?>;"></span>
                <?= htmlspecialchars($negocio['nombre_comercial']) ?>
                <small style="font-size: 10px; opacity: 0.7;">(<?= $negocio['plantilla_nombre'] ?? 'Sin plantilla' ?>)</small>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!$negocio_seleccionado): ?>
            <div class="product-form">
                <div class="text-center" style="padding:40px;color:var(--text-dim)">
                    <p>Selecciona un negocio para gestionar sus productos</p>
                    <?php if (count($negocios) == 0): ?>
                        <p style="margin-top: 8px; font-size: 13px;">No tienes negocios creados. Crea uno desde el dashboard.</p>
                        <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-primary" style="display:inline-block;margin-top:16px">+ Crear mi primer negocio</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="flex-end" style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
                <button class="btn-primary" id="showFormBtn">+ Nuevo producto</button>
            </div>
            
            <div class="product-form" id="productForm" style="<?= !$producto_editar ? 'display: none;' : '' ?>">
                <h2 style="margin-bottom: 24px; font-size: 22px; font-weight: 500;"><?= $producto_editar ? 'Editar producto' : 'Nuevo producto' ?></h2>
                <form method="POST" enctype="multipart/form-data" id="productoForm" action="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>">
                    <input type="hidden" name="id_producto" value="<?= $producto_editar['id_producto'] ?? 0 ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre del producto *</label>
                            <input type="text" name="nombre" required value="<?= htmlspecialchars($producto_editar['nombre'] ?? '') ?>" placeholder="Ej: Laptop Gamer Pro">
                        </div>
                        <div class="form-group">
                            <label>Precio (Bs) *</label>
                            <input type="number" step="0.01" name="precio_base" required value="<?= $producto_editar['precio_base'] ?? '' ?>" placeholder="0.00">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Stock / Cantidad disponible</label>
                        <input type="number" name="stock" value="<?= $producto_editar['stock'] ?? 0 ?>" placeholder="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Descripci&oacute;n del producto</label>
                        <textarea name="descripcion" placeholder="Describe las caracter&iacute;sticas principales..."><?= htmlspecialchars($producto_editar['descripcion_larga'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="dynamic-fields">
                        <h3>Caracter&iacute;sticas adicionales (opcional)</h3>
                        <div id="attributesContainer">
                            <?php
                            $atributos_existentes = [];
                            if ($producto_editar && isset($producto_editar['atributos_arr']) && is_array($producto_editar['atributos_arr'])) {
                                $atributos_existentes = $producto_editar['atributos_arr'];
                            }
                            foreach ($atributos_existentes as $nombre_attr => $valor_attr):
                            ?>
                            <div class="attr-row">
                                <input type="text" class="attr-name" name="attr_nombre[]" placeholder="Ej: Marca" value="<?= htmlspecialchars($nombre_attr) ?>">
                                <input type="text" class="attr-value" name="attr_valor[]" placeholder="Valor" value="<?= htmlspecialchars($valor_attr) ?>">
                                <button type="button" class="remove-attr" onclick="this.parentElement.remove()">✕</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="add-attr-btn" id="addAttrBtn">+ Agregar caracter&iacute;stica</button>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Imagen del producto</label>
                            <input type="file" name="imagen" accept="image/*" id="imagenInput">
                            <?php if (!empty($producto_editar['imagen_url'])): ?>
                                <div style="margin-top: 12px;">
                                    <img src="<?= BASE_URL ?>/<?= $producto_editar['imagen_url'] ?>" style="width:80px;height:80px;border-radius:10px;object-fit:cover;background:#1a1a1a;">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Estado de publicaci&oacute;n</label>
                            <select name="estado">
                                <option value="Publicado" <?= ($producto_editar['estado'] ?? '') === 'Publicado' ? 'selected' : '' ?>>Publicado (visible en tienda)</option>
                                <option value="Borrador" <?= ($producto_editar['estado'] ?? '') === 'Borrador' ? 'selected' : '' ?>>Borrador (no visible)</option>
                                <option value="Oculto" <?= ($producto_editar['estado'] ?? '') === 'Oculto' ? 'selected' : '' ?>>Oculto (oculto temporalmente)</option>
                            </select>
                        </div>
                    </div>
                    
                    <?php if ($error): ?>
                    <div class="error-msg" style="margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px;">Guardar producto</button>
                    <button type="button" class="btn-secondary" style="width: 100%; margin-top: 12px;" id="cancelFormBtn">Cancelar</button>
                </form>
            </div>
            
            <div class="table-card" style="background:var(--surface);border:1px solid var(--border);border-radius:24px;padding:32px;margin-bottom:32px">
                <h2 style="margin-bottom: 20px; font-size: 18px; font-weight: 500;">Productos de <?= htmlspecialchars($negocio_seleccionado['nombre_comercial']) ?></h2>
                <?php if (count($productos) > 0): ?>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><img src="<?= BASE_URL ?>/<?= $producto['imagen_url'] ?: 'assets/images/placeholder_producto.jpg' ?>" class="product-img" style="width:48px;height:48px;background:#1a1a1a;border-radius:10px;object-fit:cover" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'"></td>
                                <td><strong><?= htmlspecialchars($producto['nombre']) ?></strong><br><small style="color:#666;">ID: #<?= $producto['id_producto'] ?></small></td>
                                <td>Bs. <?= number_format($producto['precio_base'], 2) ?></td>
                                <td><?= $producto['stock'] ?? 0 ?> unidades</td>
                                <td><span class="status-badge status-<?= $producto['estado'] ?>"><?= $producto['estado'] ?></span></td>
                                <td class="actions" style="display:flex;gap:8px">
                                    <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>&edit=<?= $producto['id_producto'] ?>" class="btn-action btn-edit">Editar</a>
                                    <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>&action=delete&id=<?= $producto['id_producto'] ?>" class="btn-action btn-delete" onclick="return confirm('¿Eliminar este producto permanentemente?')">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center" style="padding:60px;color:var(--text-dim)">
                    <p>No tienes productos en este negocio</p>
                    <button class="btn-primary" style="margin-top:16px" onclick="document.getElementById('productForm').style.display='block'; document.getElementById('productForm').scrollIntoView({behavior:'smooth'});">+ Agregar mi primer producto</button>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
    
    <script>
        const showBtn = document.getElementById('showFormBtn');
        const formDiv = document.getElementById('productForm');
        const cancelBtn = document.getElementById('cancelFormBtn');
        
        if (showBtn) {
            showBtn.onclick = () => {
                formDiv.style.display = 'block';
                formDiv.scrollIntoView({ behavior: 'smooth' });
            };
        }
        if (cancelBtn) {
            cancelBtn.onclick = () => {
                formDiv.style.display = 'none';
                window.location.href = '<?= BASE_URL ?>/productos?id_emprendimiento=<?= $id_emprendimiento ?>';
            };
        }
        
        <?php if ($producto_editar): ?>
        formDiv.style.display = 'block';
        <?php endif; ?>
        
        const addBtn = document.getElementById('addAttrBtn');
        const container = document.getElementById('attributesContainer');
        
        function addAttributeRow(nombre = '', valor = '') {
            const row = document.createElement('div');
            row.className = 'attr-row';
            row.innerHTML = `
                <input type="text" class="attr-name" name="attr_nombre[]" placeholder="Ej: Marca, Talla, Color" value="${escapeHtml(nombre)}" style="flex:1;">
                <input type="text" class="attr-value" name="attr_valor[]" placeholder="Valor" value="${escapeHtml(valor)}" style="flex:2;">
                <button type="button" class="remove-attr" onclick="this.parentElement.remove()">✕</button>
            `;
            container.appendChild(row);
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }
        
        if (addBtn) {
            addBtn.onclick = () => addAttributeRow();
        }
        
        const productoForm = document.getElementById('productoForm');
        if (productoForm) {
            productoForm.addEventListener('submit', function(e) {
                const attrNames = document.querySelectorAll('.attr-name');
                const attrValues = document.querySelectorAll('.attr-value');
                
                for (let i = 0; i < attrNames.length; i++) {
                    const name = attrNames[i].value.trim();
                    const value = attrValues[i].value.trim();
                    
                    if (name && value) {
                        const hiddenName = document.createElement('input');
                        hiddenName.type = 'hidden';
                        hiddenName.name = 'attr_' + name;
                        hiddenName.value = value;
                        productoForm.appendChild(hiddenName);
                    }
                }
            });
        }
    </script>
    <script>
        (function() {
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
    </script>
</body>
</html>
