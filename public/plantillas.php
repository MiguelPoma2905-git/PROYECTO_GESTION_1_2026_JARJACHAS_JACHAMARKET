<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Verificar que sea vendedor
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Emprendedor') {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$db = getDB();

// Obtener emprendimiento del usuario
$stmt = $db->prepare("
    SELECT * FROM emprendimientos WHERE id_propietario = ?
");
$stmt->execute([$usuario['id']]);
$emprendimiento = $stmt->fetch();

if (!$emprendimiento) {
    // Redirigir a crear emprendimiento
    header('Location: crear_emprendimiento.php');
    exit;
}

// Obtener personalización actual o crear una
$stmt = $db->prepare("
    SELECT p.*, pe.* 
    FROM personalizacion_emprendimiento pe
    JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
    WHERE pe.id_emprendimiento = ?
");
$stmt->execute([$emprendimiento['id_emprendimiento']]);
$personalizacion = $stmt->fetch();

if (!$personalizacion) {
    $stmt = $db->prepare("
        INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla)
        SELECT ?, id_plantilla FROM plantillas LIMIT 1
    ");
    $stmt->execute([$emprendimiento['id_emprendimiento']]);
    header('Location: plantillas.php');
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
    $color_texto = $_POST['color_texto'] ?? null;
    $modo_oscuro = isset($_POST['modo_oscuro']) ? 1 : 0;
    
    $stmt = $db->prepare("
        UPDATE personalizacion_emprendimiento 
        SET id_plantilla = ?, color_primario = ?, color_secundario = ?, 
            color_fondo = ?, color_texto = ?, modo_oscuro = ?
        WHERE id_emprendimiento = ?
    ");
    $stmt->execute([$id_plantilla, $color_primario, $color_secundario, 
                    $color_fondo, $color_texto, $modo_oscuro, 
                    $emprendimiento['id_emprendimiento']]);
    
    header('Location: plantillas.php?success=1');
    exit;
}

// Marca de agua: se mostrará en todas las páginas de la tienda del vendedor
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalizar Mi Tienda - Jacha</title>
    <link rel="stylesheet" href="assets/css/plantilla_base.css">
    <style>
        .editor-container {
            display: grid;
            gap: 30px;
            padding: 20px;
        }
        
        .preview-area {
            background: var(--preview-bg, #FDFBF7);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .preview-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .preview-header {
            background: var(--preview-primary, #fa7136);
            padding: 20px;
            color: white;
        }
        
        .preview-btn {
            background: var(--preview-secondary, #1a4147);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
        }
        
        .controls-area {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .plantilla-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }
        
        .plantilla-option {
            padding: 20px;
            border: 2px solid #eee;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .plantilla-option.selected {
            border-color: #fa7136;
            background: rgba(250, 113, 54, 0.05);
        }
        
        /* Editor completo solo en desktop */
        .full-editor {
            display: none;
        }
        
        @media (min-width: 769px) {
            .editor-container {
                grid-template-columns: 1fr 1fr;
            }
            
            .full-editor {
                display: block;
            }
        }
        
        .mobile-editor {
            display: block;
        }
        
        @media (min-width: 769px) {
            .mobile-editor {
                display: none;
            }
        }
        
        .color-input {
            width: 60px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="brand-watermark" style="text-align: center; padding: 8px; background: rgba(0,0,0,0.05);">
        JACHA Marketplace - Personalización de Tienda | 
        <span style="color:#fa7136">🟠</span> <span style="color:#1a4147">💚</span>
    </div>
    
    <div class="container">
        <h1>🎨 Personaliza tu Tienda</h1>
        <p>Elige una plantilla y ajusta los colores para reflejar la identidad de tu negocio</p>
        
        <?php if (isset($_GET['success'])): ?>
        <div style="background: #4CAF50; color: white; padding: 12px; border-radius: 8px; margin: 16px 0;">
            ✓ Cambios guardados correctamente
        </div>
        <?php endif; ?>
        
        <div class="editor-container">
            <!-- Vista previa en vivo -->
            <div class="preview-area" id="previewArea" 
                 style="--preview-primary: <?php echo $personalizacion['color_primario'] ?? '#fa7136'; ?>; 
                        --preview-secondary: <?php echo $personalizacion['color_secundario'] ?? '#1a4147'; ?>;
                        --preview-bg: <?php echo $personalizacion['color_fondo'] ?? '#FDFBF7'; ?>">
                <div class="preview-card">
                    <div class="preview-header">
                        <h3><?php echo htmlspecialchars($emprendimiento['nombre_comercial']); ?></h3>
                        <p>Vista previa de tu tienda</p>
                    </div>
                    <div style="padding: 20px;">
                        <div style="display: flex; gap: 12px; margin-bottom: 16px;">
                            <div style="width: 80px; height: 80px; background: #e0e0e0; border-radius: 12px;"></div>
                            <div>
                                <h4>Producto Ejemplo</h4>
                                <p>Precio: Bs. 150.00</p>
                            </div>
                        </div>
                        <button class="preview-btn">Agregar al Carrito 🛒</button>
                    </div>
                </div>
                <p style="font-size: 12px; margin-top: 12px; text-align: center; opacity: 0.7;">
                    Vista previa en tiempo real
                </p>
            </div>
            
            <!-- Controles -->
            <div class="controls-area">
                <h3>📋 Selecciona una Plantilla</h3>
                <div class="plantilla-selector">
                    <?php foreach ($plantillas as $plantilla): ?>
                    <div class="plantilla-option <?php echo $personalizacion['id_plantilla'] == $plantilla['id_plantilla'] ? 'selected' : ''; ?>" 
                         data-id="<?php echo $plantilla['id_plantilla']; ?>"
                         data-primary="<?php echo $plantilla['color_primario']; ?>"
                         data-secondary="<?php echo $plantilla['color_secundario']; ?>">
                        <h4><?php echo htmlspecialchars($plantilla['nombre']); ?></h4>
                        <p style="font-size: 12px;"><?php echo htmlspecialchars($plantilla['descripcion']); ?></p>
                        <div style="display: flex; gap: 4px; justify-content: center; margin-top: 8px;">
                            <span style="display: inline-block; width: 20px; height: 20px; background: <?php echo $plantilla['color_primario']; ?>; border-radius: 4px;"></span>
                            <span style="display: inline-block; width: 20px; height: 20px; background: <?php echo $plantilla['color_secundario']; ?>; border-radius: 4px;"></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST" id="personalizacionForm">
                    <input type="hidden" name="id_plantilla" id="id_plantilla" value="<?php echo $personalizacion['id_plantilla']; ?>">
                    
                    <!-- Editor completo (desktop) -->
                    <div class="full-editor">
                        <h3>🎨 Personalización Avanzada</h3>
                        <div class="form-group">
                            <label>Color Principal</label>
                            <input type="color" name="color_primario" id="color_primario" 
                                   value="<?php echo $personalizacion['color_primario'] ?? '#fa7136'; ?>"
                                   class="color-input">
                        </div>
                        <div class="form-group">
                            <label>Color Secundario</label>
                            <input type="color" name="color_secundario" id="color_secundario" 
                                   value="<?php echo $personalizacion['color_secundario'] ?? '#1a4147'; ?>"
                                   class="color-input">
                        </div>
                        <div class="form-group">
                            <label>Color de Fondo</label>
                            <input type="color" name="color_fondo" id="color_fondo" 
                                   value="<?php echo $personalizacion['color_fondo'] ?? '#FDFBF7'; ?>"
                                   class="color-input">
                        </div>
                        <div class="form-group">
                            <label>Modo Oscuro</label>
                            <label class="switch">
                                <input type="checkbox" name="modo_oscuro" id="modo_oscuro" 
                                       <?php echo $personalizacion['modo_oscuro'] ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Editor minimalista (móvil) -->
                    <div class="mobile-editor">
                        <h3>📱 Opciones Rápidas (Móvil)</h3>
                        <div class="opcion-rapida">
                            <label>🎨 Color Principal</label>
                            <input type="color" name="color_primario_mobile" id="color_primario_mobile" 
                                   value="<?php echo $personalizacion['color_primario'] ?? '#fa7136'; ?>"
                                   onchange="document.getElementById('color_primario').value = this.value; actualizarPreview();">
                        </div>
                        <div class="opcion-rapida">
                            <label>🌈 Color Secundario</label>
                            <input type="color" name="color_secundario_mobile" id="color_secundario_mobile" 
                                   value="<?php echo $personalizacion['color_secundario'] ?? '#1a4147'; ?>"
                                   onchange="document.getElementById('color_secundario').value = this.value; actualizarPreview();">
                        </div>
                        <p style="font-size: 12px; color: #666; margin-top: 12px;">
                            💡 Para personalización completa, usa una computadora
                        </p>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                        💾 Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
        
        <div style="margin-top: 40px; padding: 20px; background: rgba(250,113,54,0.1); border-radius: 12px;">
            <h3>🔗 Tu tienda estará disponible en:</h3>
            <code style="background: white; padding: 8px 12px; border-radius: 6px; display: block; margin-top: 8px;">
                <?php echo BASE_URL; ?>tienda/<?php echo $emprendimiento['id_emprendimiento']; ?>
            </code>
            <p style="margin-top: 12px; font-size: 14px;">
                Comparte este enlace con tus clientes para que vean tu tienda personalizada
            </p>
        </div>
    </div>
    
    <script>
        // Actualizar vista previa en tiempo real
        function actualizarPreview() {
            const primary = document.getElementById('color_primario').value;
            const secondary = document.getElementById('color_secundario').value;
            const bg = document.getElementById('color_fondo')?.value || '#FDFBF7';
            
            const previewArea = document.getElementById('previewArea');
            previewArea.style.setProperty('--preview-primary', primary);
            previewArea.style.setProperty('--preview-secondary', secondary);
            previewArea.style.setProperty('--preview-bg', bg);
        }
        
        // Selección de plantilla
        document.querySelectorAll('.plantilla-option').forEach(opt => {
            opt.addEventListener('click', () => {
                // Remover selección anterior
                document.querySelectorAll('.plantilla-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                
                const id = opt.dataset.id;
                const primary = opt.dataset.primary;
                const secondary = opt.dataset.secondary;
                
                document.getElementById('id_plantilla').value = id;
                document.getElementById('color_primario').value = primary;
                document.getElementById('color_secundario').value = secondary;
                
                // Actualizar selects móviles
                if (document.getElementById('color_primario_mobile')) {
                    document.getElementById('color_primario_mobile').value = primary;
                    document.getElementById('color_secundario_mobile').value = secondary;
                }
                
                actualizarPreview();
            });
        });
        
        // Event listeners para cambios de color
        const colorInputs = ['color_primario', 'color_secundario', 'color_fondo'];
        colorInputs.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('change', actualizarPreview);
            }
        });
        
        // Inicializar vista previa
        actualizarPreview();
    </script>
</body>
</html>