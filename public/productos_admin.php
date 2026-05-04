<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$db = getDB();

// Verificar que sea emprendedor
$stmt = $db->prepare("
    SELECT r.id_rol 
    FROM usuario_roles ur 
    JOIN roles r ON ur.id_rol = r.id_rol 
    WHERE ur.id_usuario = ? AND r.nombre_rol = 'Emprendedor'
");
$stmt->execute([$usuario['id']]);
if (!$stmt->fetch()) {
    header('Location: dashboard_principal.php?error=No tienes permisos de vendedor');
    exit;
}

// Obtener todos los negocios del usuario
$stmt = $db->prepare("
    SELECT e.*, p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario
    FROM emprendimientos e
    LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
    LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
    WHERE e.id_propietario = ?
    ORDER BY e.id_emprendimiento DESC
");
$stmt->execute([$usuario['id']]);
$negocios = $stmt->fetchAll();

// Negocio seleccionado
$id_emprendimiento = $_GET['id_emprendimiento'] ?? 0;
$negocio_seleccionado = null;
$productos = [];

if ($id_emprendimiento) {
    foreach ($negocios as $n) {
        if ($n['id_emprendimiento'] == $id_emprendimiento) {
            $negocio_seleccionado = $n;
            break;
        }
    }
    
    if ($negocio_seleccionado) {
        $stmt = $db->prepare("SELECT * FROM productos WHERE id_emprendimiento = ? ORDER BY id_producto DESC");
        $stmt->execute([$id_emprendimiento]);
        $productos = $stmt->fetchAll();
    }
}

// Procesar formulario
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $negocio_seleccionado) {
    $id_producto = $_POST['id_producto'] ?? 0;
    $nombre = trim($_POST['nombre'] ?? '');
    $precio_base = floatval($_POST['precio_base'] ?? 0);
    $descripcion = trim($_POST['descripcion'] ?? '');
    $estado = $_POST['estado'] ?? 'Borrador';
    $stock = intval($_POST['stock'] ?? 0);
    
    // Atributos dinámicos - se guardan en JSON
    $atributos = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'attr_') === 0 && !empty($value)) {
            $attr_name = substr($key, 5);
            $atributos[$attr_name] = trim($value);
        }
    }
    $atributos_json = !empty($atributos) ? json_encode($atributos, JSON_UNESCAPED_UNICODE) : null;
    
    // Subir imagen
    $imagen_url = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/productos/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $nombre_archivo = 'prod_' . uniqid() . '.' . $extension;
        $ruta = $upload_dir . $nombre_archivo;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
            $imagen_url = 'uploads/productos/' . $nombre_archivo;
        }
    }
    
    if (empty($nombre)) {
        $error = 'El nombre del producto es obligatorio';
    } elseif ($precio_base <= 0) {
        $error = 'El precio debe ser mayor a 0';
    } else {
        if ($id_producto > 0) {
            // Actualizar
            if ($imagen_url) {
                $stmt = $db->prepare("
                    UPDATE productos 
                    SET nombre = ?, precio_base = ?, descripcion_larga = ?, 
                        atributos = ?, estado = ?, stock = ?, imagen_url = ?
                    WHERE id_producto = ? AND id_emprendimiento = ?
                ");
                $stmt->execute([$nombre, $precio_base, $descripcion, $atributos_json, $estado, $stock, $imagen_url, $id_producto, $id_emprendimiento]);
            } else {
                $stmt = $db->prepare("
                    UPDATE productos 
                    SET nombre = ?, precio_base = ?, descripcion_larga = ?, 
                        atributos = ?, estado = ?, stock = ?
                    WHERE id_producto = ? AND id_emprendimiento = ?
                ");
                $stmt->execute([$nombre, $precio_base, $descripcion, $atributos_json, $estado, $stock, $id_producto, $id_emprendimiento]);
            }
            $mensaje = 'Producto actualizado correctamente';
        } else {
            // Crear
            $stmt = $db->prepare("
                INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, atributos, estado, stock, imagen_url)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$id_emprendimiento, $nombre, $precio_base, $descripcion, $atributos_json, $estado, $stock, $imagen_url]);
            $mensaje = 'Producto creado correctamente';
        }
        header('Location: productos_admin.php?id_emprendimiento=' . $id_emprendimiento . '&success=1');
        exit;
    }
}

// Obtener producto para editar
$producto_editar = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit']) && $negocio_seleccionado) {
    $stmt = $db->prepare("SELECT * FROM productos WHERE id_producto = ? AND id_emprendimiento = ?");
    $stmt->execute([$_GET['edit'], $id_emprendimiento]);
    $producto_editar = $stmt->fetch();
    if ($producto_editar && $producto_editar['atributos']) {
        $producto_editar['atributos_arr'] = json_decode($producto_editar['atributos'], true);
    }
}

// Eliminar producto
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && $negocio_seleccionado) {
    $id_producto = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM productos WHERE id_producto = ? AND id_emprendimiento = ?");
    if ($stmt->execute([$id_producto, $id_emprendimiento])) {
        header('Location: productos_admin.php?id_emprendimiento=' . $id_emprendimiento . '&deleted=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Gestionar Productos - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #e8e8e8;
            line-height: 1.5;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.06;
            pointer-events: none;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 40px 32px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: #fff; text-decoration: none; }
        .logo span { color: #888; font-weight: 300; }
        .back-btn { color: #888; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .back-btn:hover { color: #fff; }
        h1 { font-size: 28px; font-weight: 500; margin-bottom: 8px; }
        .subtitle { color: #888; font-size: 14px; }
        
        /* Selector de negocios */
        .negocios-bar {
            background: #121212;
            border: 1px solid #2a2a2a;
            border-radius: 20px;
            padding: 8px;
            margin-bottom: 32px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .negocio-tab {
            padding: 12px 24px;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: #888;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .negocio-tab:hover { background: #1a1a1a; color: #fff; }
        .negocio-tab.active { background: #fff; color: #0a0a0a; }
        .negocio-color { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }
        
        .success { background: rgba(76,175,80,0.12); border-left: 3px solid #4caf50; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #4caf50; }
        .error { background: rgba(255,107,107,0.12); border-left: 3px solid #ff6b6b; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #ff6b6b; }
        
        .btn-primary { background: #fff; color: #0a0a0a; padding: 10px 24px; border-radius: 30px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; display: inline-block; border: none; cursor: pointer; }
        .btn-primary:hover { background: #e0e0e0; transform: translateY(-2px); }
        .btn-outline { background: none; border: 1px solid #3a3a3a; color: #e0e0e0; padding: 10px 24px; border-radius: 30px; cursor: pointer; transition: all 0.2s; }
        .btn-outline:hover { border-color: #fff; color: #fff; }
        .btn-danger { background: none; border: 1px solid #ff6b6b; color: #ff6b6b; padding: 6px 12px; border-radius: 8px; cursor: pointer; font-size: 12px; transition: all 0.2s; }
        .btn-danger:hover { background: rgba(255,107,107,0.1); }
        
        .form-card, .table-card { background: #121212; border: 1px solid #2a2a2a; border-radius: 24px; padding: 32px; margin-bottom: 32px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 500; color: #aaa; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 14px; background: #1a1a1a; border: 1px solid #2a2a2a;
            border-radius: 12px; font-size: 14px; color: #fff; transition: all 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #fff; }
        textarea { resize: vertical; min-height: 80px; }
        
        .dynamic-fields { background: #0d0d0d; border-radius: 16px; padding: 20px; margin-top: 20px; border: 1px dashed #3a3a3a; }
        .dynamic-fields h3 { font-size: 14px; margin-bottom: 16px; color: #aaa; font-weight: 500; letter-spacing: 0.5px; }
        .add-attr-btn { background: none; border: 1px dashed #3a3a3a; color: #888; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-size: 12px; margin-top: 12px; transition: all 0.2s; }
        .add-attr-btn:hover { border-color: #fff; color: #fff; }
        .attr-row { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
        .attr-name { flex: 1; }
        .attr-value { flex: 2; }
        .remove-attr { background: none; border: none; color: #ff6b6b; cursor: pointer; font-size: 18px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 16px; font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #2a2a2a; }
        td { padding: 16px; font-size: 13px; border-bottom: 1px solid #2a2a2a; vertical-align: middle; }
        .product-img { width: 48px; height: 48px; background: #1a1a1a; border-radius: 10px; object-fit: cover; }
        .actions { display: flex; gap: 8px; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .status-Publicado { background: rgba(76,175,80,0.15); color: #4caf50; }
        .status-Borrador { background: rgba(255,193,7,0.15); color: #ffc107; }
        .status-Oculto { background: rgba(136,136,136,0.15); color: #888; }
        
        .empty-state { text-align: center; padding: 60px; color: #666; }
        .empty-state p { margin-bottom: 16px; }
        
        .watermark {
            position: fixed;
            bottom: 12px;
            right: 12px;
            font-size: 10px;
            color: rgba(255,255,255,0.03);
            pointer-events: none;
            font-family: monospace;
        }
        
        @media (max-width: 768px) { 
            .form-grid { grid-template-columns: 1fr; } 
            .container { padding: 24px 20px; } 
            th, td { padding: 12px; }
            .negocio-tab { padding: 8px 16px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="dashboard_principal.php" class="back-btn">← Volver al dashboard</a>
                <h1>Gestionar Productos</h1>
                <p class="subtitle">Administra el catálogo de tus negocios</p>
            </div>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
        <div class="success">✓ Producto guardado correctamente</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
        <div class="success">✓ Producto eliminado correctamente</div>
        <?php endif; ?>
        
        <!-- Selector de negocios -->
        <?php if (count($negocios) > 0): ?>
        <div class="negocios-bar">
            <?php foreach ($negocios as $negocio): ?>
            <a href="?id_emprendimiento=<?php echo $negocio['id_emprendimiento']; ?>" class="negocio-tab <?php echo ($id_emprendimiento == $negocio['id_emprendimiento']) ? 'active' : ''; ?>">
                <span class="negocio-color" style="background: <?php echo $negocio['color_primario'] ?? '#fff'; ?>;"></span>
                <?php echo htmlspecialchars($negocio['nombre_comercial']); ?>
                <small style="font-size: 10px; opacity: 0.7;">(<?php echo $negocio['plantilla_nombre'] ?? 'Sin plantilla'; ?>)</small>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!$negocio_seleccionado): ?>
            <div class="table-card">
                <div class="empty-state">
                    <p>🏪 Selecciona un negocio para gestionar sus productos</p>
                    <?php if (count($negocios) == 0): ?>
                        <p style="font-size: 13px; margin-top: 8px;">No tienes negocios creados. Crea uno desde el dashboard.</p>
                        <a href="plantillas_disponibles.php" class="btn-primary" style="margin-top: 16px;">+ Crear mi primer negocio</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Botón para nuevo producto -->
            <div style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
                <button class="btn-primary" id="showFormBtn">+ Nuevo producto</button>
            </div>
            
            <!-- Formulario de producto -->
            <div class="form-card" id="productForm" style="<?php echo !$producto_editar ? 'display: none;' : ''; ?>">
                <h2 style="margin-bottom: 24px; font-size: 22px; font-weight: 500;"><?php echo $producto_editar ? '✏️ Editar producto' : '✨ Nuevo producto'; ?></h2>
                <form method="POST" enctype="multipart/form-data" id="productoForm">
                    <input type="hidden" name="id_producto" value="<?php echo $producto_editar['id_producto'] ?? 0; ?>">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nombre del producto *</label>
                            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($producto_editar['nombre'] ?? ''); ?>" placeholder="Ej: Laptop Gamer Pro">
                        </div>
                        <div class="form-group">
                            <label>Precio (Bs) *</label>
                            <input type="number" step="0.01" name="precio_base" required value="<?php echo $producto_editar['precio_base'] ?? ''; ?>" placeholder="0.00">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Stock / Cantidad disponible</label>
                        <input type="number" name="stock" value="<?php echo $producto_editar['stock'] ?? 0; ?>" placeholder="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Descripción del producto</label>
                        <textarea name="descripcion" placeholder="Describe las características principales..."><?php echo htmlspecialchars($producto_editar['descripcion_larga'] ?? ''); ?></textarea>
                    </div>
                    
                    <!-- Atributos dinámicos -->
                    <div class="dynamic-fields">
                        <h3>📋 Características adicionales (opcional)</h3>
                        <div id="attributesContainer">
                            <?php 
                            $atributos_existentes = [];
                            if ($producto_editar && isset($producto_editar['atributos_arr']) && is_array($producto_editar['atributos_arr'])) {
                                $atributos_existentes = $producto_editar['atributos_arr'];
                            }
                            foreach ($atributos_existentes as $nombre_attr => $valor_attr): 
                            ?>
                            <div class="attr-row">
                                <input type="text" class="attr-name" name="attr_nombre[]" placeholder="Ej: Marca" value="<?php echo htmlspecialchars($nombre_attr); ?>">
                                <input type="text" class="attr-value" name="attr_valor[]" placeholder="Valor" value="<?php echo htmlspecialchars($valor_attr); ?>">
                                <button type="button" class="remove-attr" onclick="this.parentElement.remove()">✕</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="add-attr-btn" id="addAttrBtn">+ Agregar característica</button>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Imagen del producto</label>
                            <input type="file" name="imagen" accept="image/*" id="imagenInput">
                            <?php if (!empty($producto_editar['imagen_url'])): ?>
                                <div style="margin-top: 12px;">
                                    <img src="<?php echo $producto_editar['imagen_url']; ?>" style="height: 60px; border-radius: 8px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Estado de publicación</label>
                            <select name="estado">
                                <option value="Publicado" <?php echo ($producto_editar['estado'] ?? '') === 'Publicado' ? 'selected' : ''; ?>>Publicado (visible en tienda)</option>
                                <option value="Borrador" <?php echo ($producto_editar['estado'] ?? '') === 'Borrador' ? 'selected' : ''; ?>>Borrador (no visible)</option>
                                <option value="Oculto" <?php echo ($producto_editar['estado'] ?? '') === 'Oculto' ? 'selected' : ''; ?>>Oculto (oculto temporalmente)</option>
                            </select>
                        </div>
                    </div>
                    
                    <?php if ($error): ?>
                    <div class="error" style="margin-bottom: 20px;">❌ <?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px;">💾 Guardar producto</button>
                    <button type="button" class="btn-outline" style="width: 100%; margin-top: 12px;" id="cancelFormBtn">Cancelar</button>
                </form>
            </div>
            
            <!-- Lista de productos -->
            <div class="table-card">
                <h2 style="margin-bottom: 20px; font-size: 18px; font-weight: 500;">📦 Productos de <?php echo htmlspecialchars($negocio_seleccionado['nombre_comercial']); ?></h2>
                <?php if (count($productos) > 0): ?>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><img src="<?php echo $producto['imagen_url'] ?: 'assets/images/placeholder.png'; ?>" class="product-img" onerror="this.src='assets/images/placeholder.png'">
    
                                <td><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong><br><small style="color:#666;">ID: #<?php echo $producto['id_producto']; ?></small></td>
                                <td>Bs. <?php echo number_format($producto['precio_base'], 2); ?></td>
                                <td><?php echo $producto['stock'] ?? 0; ?> unidades</td>
                                <td><span class="status-badge status-<?php echo $producto['estado']; ?>"><?php echo $producto['estado']; ?></span></td>
                                <td class="actions">
                                    <a href="?id_emprendimiento=<?php echo $id_emprendimiento; ?>&edit=<?php echo $producto['id_producto']; ?>" class="btn-primary" style="padding: 6px 12px; font-size: 12px;">✏️ Editar</a>
                                    <a href="?id_emprendimiento=<?php echo $id_emprendimiento; ?>&action=delete&id=<?php echo $producto['id_producto']; ?>" class="btn-danger" onclick="return confirm('¿Eliminar este producto permanentemente?')">🗑️ Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <p>📭 No tienes productos en este negocio</p>
                    <button class="btn-primary" onclick="document.getElementById('productForm').style.display='block'; document.getElementById('productForm').scrollIntoView({behavior:'smooth'});">+ Agregar mi primer producto</button>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="watermark">⚡ JACHA</div>
    
    <script>
        // Mostrar/ocultar formulario
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
                // Limpiar campos si es necesario
                window.location.href = 'productos_admin.php?id_emprendimiento=<?php echo $id_emprendimiento; ?>';
            };
        }
        
        <?php if ($producto_editar): ?>
        formDiv.style.display = 'block';
        <?php endif; ?>
        
        // Atributos dinámicos
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
        
        // Convertir atributos al formato correcto al enviar el formulario
        const productoForm = document.getElementById('productoForm');
        if (productoForm) {
            productoForm.addEventListener('submit', function(e) {
                const attrNames = document.querySelectorAll('.attr-name');
                const attrValues = document.querySelectorAll('.attr-value');
                
                // Eliminar inputs duplicados que no sean del patrón attr_nombre/attr_valor
                for (let i = 0; i < attrNames.length; i++) {
                    const name = attrNames[i].value.trim();
                    const value = attrValues[i].value.trim();
                    
                    if (name && value) {
                        // Crear inputs ocultos con los nombres reales
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
</body>
</html>