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
    header('Location: dashboard_principal.php?error=No tienes permisos');
    exit;
}

$id_emprendimiento = $_GET['id_emprendimiento'] ?? 0;

if (!$id_emprendimiento) {
    header('Location: dashboard_principal.php');
    exit;
}

// Verificar que el emprendimiento pertenece al usuario
$stmt = $db->prepare("
    SELECT * FROM emprendimientos 
    WHERE id_emprendimiento = ? AND id_propietario = ?
");
$stmt->execute([$id_emprendimiento, $usuario['id']]);
$emprendimiento = $stmt->fetch();

if (!$emprendimiento) {
    header('Location: dashboard_principal.php');
    exit;
}

// Obtener personalización actual
$stmt = $db->prepare("
    SELECT p.*, pe.* 
    FROM personalizacion_emprendimiento pe
    JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
    WHERE pe.id_emprendimiento = ?
");
$stmt->execute([$id_emprendimiento]);
$personalizacion = $stmt->fetch();

if (!$personalizacion) {
    $stmt = $db->prepare("
        INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla)
        SELECT ?, id_plantilla FROM plantillas LIMIT 1
    ");
    $stmt->execute([$id_emprendimiento]);
    header('Location: plantillas.php?id_emprendimiento=' . $id_emprendimiento);
    exit;
}

// Obtener todas las plantillas
$stmt = $db->prepare("SELECT * FROM plantillas WHERE activo = 1");
$stmt->execute();
$plantillas = $stmt->fetchAll();

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_plantilla = $_POST['id_plantilla'] ?? $personalizacion['id_plantilla'];
    $color_primario = $_POST['color_primario'] ?? null;
    $color_secundario = $_POST['color_secundario'] ?? null;
    $color_fondo = $_POST['color_fondo'] ?? null;
    $modo_oscuro = isset($_POST['modo_oscuro']) ? 1 : 0;
    
    $stmt = $db->prepare("
        UPDATE personalizacion_emprendimiento 
        SET id_plantilla = ?, color_primario = ?, color_secundario = ?, 
            color_fondo = ?, modo_oscuro = ?
        WHERE id_emprendimiento = ?
    ");
    $stmt->execute([$id_plantilla, $color_primario, $color_secundario, 
                    $color_fondo, $modo_oscuro, $id_emprendimiento]);
    
    header('Location: plantillas.php?id_emprendimiento=' . $id_emprendimiento . '&success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Personalizar Mi Tienda - Jacha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #e8e8e8;
            min-height: 100vh;
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
            opacity: 0.08;
            pointer-events: none;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 40px 32px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: #fff; text-decoration: none; }
        .logo span { color: #888; font-weight: 300; }
        .back-btn { color: #888; text-decoration: none; font-size: 14px; }
        .back-btn:hover { color: #fff; }
        h1 { font-family: Georgia, serif; font-size: 32px; font-weight: 400; margin-bottom: 12px; }
        .subtitle { color: #888; margin-bottom: 40px; }
        
        .editor-container { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .preview-area { background: #121212; border-radius: 24px; padding: 24px; border: 1px solid #2a2a2a; }
        .preview-card { background: var(--preview-bg, #fff); border-radius: 20px; overflow: hidden; }
        .preview-header { background: var(--preview-primary, #fa7136); padding: 24px; color: white; }
        .preview-header h3 { font-size: 20px; font-weight: 500; }
        .preview-content { padding: 24px; }
        .product-preview { display: flex; gap: 16px; margin-bottom: 20px; }
        .product-img { width: 80px; height: 80px; background: #e0e0e0; border-radius: 12px; }
        .preview-btn { background: var(--preview-secondary, #1a4147); color: white; padding: 10px 20px; border: none; border-radius: 30px; cursor: pointer; }
        
        .controls-area { background: #121212; border-radius: 24px; padding: 24px; border: 1px solid #2a2a2a; }
        .plantilla-selector { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 16px; margin-bottom: 32px; }
        .plantilla-option { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; padding: 16px; text-align: center; cursor: pointer; transition: all 0.2s; }
        .plantilla-option:hover { transform: translateY(-2px); border-color: #fff; }
        .plantilla-option.selected { border-color: #fff; background: rgba(255,255,255,0.05); }
        .plantilla-option h4 { font-size: 14px; margin-bottom: 8px; }
        .color-preview { display: flex; gap: 6px; justify-content: center; margin-top: 8px; }
        .color-dot { width: 20px; height: 20px; border-radius: 50%; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; color: #aaa; margin-bottom: 8px; }
        input[type="color"] { width: 60px; height: 40px; border: 1px solid #2a2a2a; border-radius: 8px; background: #1a1a1a; cursor: pointer; }
        
        .btn-save { background: #fff; color: #0a0a0a; padding: 14px 28px; border: none; border-radius: 30px; font-size: 15px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 20px; transition: all 0.2s; }
        .btn-save:hover { background: #e0e0e0; transform: translateY(-2px); }
        
        .success-message { background: rgba(255,255,255,0.05); border-left: 3px solid #fff; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #fff; }
        
        @media (max-width: 900px) { .editor-container { grid-template-columns: 1fr; } .container { padding: 24px 20px; } h1 { font-size: 28px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="index.php" class="logo">JACHA<span>market</span></a>
            <a href="dashboard_principal.php" class="back-btn">← Volver al panel</a>
        </div>
        
        <h1>Personaliza tu tienda</h1>
        <p class="subtitle">Elige una plantilla y ajusta los colores para <?php echo htmlspecialchars($emprendimiento['nombre_comercial']); ?></p>
        
        <?php if (isset($_GET['success'])): ?>
        <div class="success-message">✓ Cambios guardados correctamente</div>
        <?php endif; ?>
        
        <div class="editor-container">
            <div class="preview-area" id="previewArea" 
                 style="--preview-primary: <?php echo $personalizacion['color_primario'] ?? '#fa7136'; ?>; 
                        --preview-secondary: <?php echo $personalizacion['color_secundario'] ?? '#1a4147'; ?>;
                        --preview-bg: <?php echo $personalizacion['color_fondo'] ?? '#ffffff'; ?>">
                <div class="preview-card">
                    <div class="preview-header">
                        <h3><?php echo htmlspecialchars($emprendimiento['nombre_comercial']); ?></h3>
                        <p>Vista previa de tu tienda</p>
                    </div>
                    <div class="preview-content">
                        <div class="product-preview">
                            <div class="product-img"></div>
                            <div><h4>Producto ejemplo</h4><p>Precio: Bs. 150.00</p></div>
                        </div>
                        <button class="preview-btn">Agregar al carrito</button>
                    </div>
                </div>
            </div>
            
            <div class="controls-area">
                <h3 style="margin-bottom: 16px;">Selecciona una plantilla</h3>
                <div class="plantilla-selector">
                    <?php foreach ($plantillas as $plantilla): ?>
                    <div class="plantilla-option <?php echo $personalizacion['id_plantilla'] == $plantilla['id_plantilla'] ? 'selected' : ''; ?>" 
                         data-id="<?php echo $plantilla['id_plantilla']; ?>"
                         data-primary="<?php echo $plantilla['color_primario']; ?>"
                         data-secondary="<?php echo $plantilla['color_secundario']; ?>">
                        <h4><?php echo htmlspecialchars($plantilla['nombre']); ?></h4>
                        <div class="color-preview">
                            <div class="color-dot" style="background: <?php echo $plantilla['color_primario']; ?>;"></div>
                            <div class="color-dot" style="background: <?php echo $plantilla['color_secundario']; ?>;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST">
                    <input type="hidden" name="id_plantilla" id="id_plantilla" value="<?php echo $personalizacion['id_plantilla']; ?>">
                    <div class="form-group">
                        <label>Color principal</label>
                        <input type="color" name="color_primario" id="color_primario" value="<?php echo $personalizacion['color_primario'] ?? '#fa7136'; ?>">
                    </div>
                    <div class="form-group">
                        <label>Color secundario</label>
                        <input type="color" name="color_secundario" id="color_secundario" value="<?php echo $personalizacion['color_secundario'] ?? '#1a4147'; ?>">
                    </div>
                    <div class="form-group">
                        <label>Color de fondo</label>
                        <input type="color" name="color_fondo" id="color_fondo" value="<?php echo $personalizacion['color_fondo'] ?? '#ffffff'; ?>">
                    </div>
                    <button type="submit" class="btn-save">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function actualizarPreview() {
            const primary = document.getElementById('color_primario').value;
            const secondary = document.getElementById('color_secundario').value;
            const bg = document.getElementById('color_fondo').value;
            const previewArea = document.getElementById('previewArea');
            previewArea.style.setProperty('--preview-primary', primary);
            previewArea.style.setProperty('--preview-secondary', secondary);
            previewArea.style.setProperty('--preview-bg', bg);
        }
        
        document.querySelectorAll('.plantilla-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.plantilla-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                document.getElementById('id_plantilla').value = opt.dataset.id;
                document.getElementById('color_primario').value = opt.dataset.primary;
                document.getElementById('color_secundario').value = opt.dataset.secondary;
                actualizarPreview();
            });
        });
        
        document.getElementById('color_primario').addEventListener('change', actualizarPreview);
        document.getElementById('color_secundario').addEventListener('change', actualizarPreview);
        document.getElementById('color_fondo').addEventListener('change', actualizarPreview);
        actualizarPreview();
    </script>
</body>
</html>