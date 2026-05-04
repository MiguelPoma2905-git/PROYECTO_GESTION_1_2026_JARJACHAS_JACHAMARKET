<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$usuario = $_SESSION['usuario'] ?? null;
$isLoggedIn = $usuario !== null;
$isVendedor = $isLoggedIn && ($_SESSION['rol_activo'] ?? '') === 'Emprendedor';

$mensaje_error = '';
$mostrar_selector = true;

if (!$isLoggedIn) {
    $mostrar_selector = false;
    $mensaje_error = 'Debes iniciar sesión para elegir una plantilla.';
} elseif (!$isVendedor) {
    $mostrar_selector = false;
    $mensaje_error = 'Necesitas ser emprendedor para crear una tienda.';
}

$db = getDB();
$stmt = $db->prepare("SELECT * FROM plantillas WHERE activo = 1");
$stmt->execute();
$plantillas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Plantillas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: #0a0a0a;
            color: #ebebeb;
            min-height: 100vh;
            position: relative;
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
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 48px; }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: #fff; text-decoration: none; }
        .logo span { color: #888; font-weight: 300; }
        .back-btn { color: #888; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .back-btn:hover { color: #fff; }
        h1 { font-family: Georgia, serif; font-size: 36px; font-weight: 400; margin-bottom: 16px; text-align: center; }
        .subtitle { text-align: center; color: #888; margin-bottom: 48px; }
        
        .plantillas-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .plantilla-card { 
            background: #121212; border: 1px solid #2a2a2a; border-radius: 24px; 
            overflow: hidden; transition: all 0.3s; cursor: pointer; position: relative;
        }
        .plantilla-card:hover { transform: translateY(-6px); border-color: #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        
        /* Destacar plantilla tecnológica */
        .plantilla-card.tech-highlight { 
            border: 2px solid #3498db; 
            box-shadow: 0 0 30px rgba(52,152,219,0.3);
        }
        .plantilla-card.tech-highlight::before {
            content: '⚡ NUEVA';
            position: absolute;
            top: 16px;
            right: 16px;
            background: #3498db;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 1px;
            z-index: 10;
        }
        
        .plantilla-preview { height: 200px; background: linear-gradient(135deg, #1a1a1a, #0a0a0a); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #2a2a2a; position: relative; overflow: hidden; }
        .plantilla-preview.tech-bg { background: linear-gradient(135deg, #0a1628, #0a0a1a); }
        .icon-preview { font-size: 64px; transition: transform 0.3s; }
        .plantilla-card:hover .icon-preview { transform: scale(1.1); }
        .color-preview { display: flex; gap: 16px; margin-top: 20px; }
        .color-circle { width: 40px; height: 40px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
        
        .plantilla-info { padding: 24px; }
        .plantilla-info h3 { font-size: 22px; font-weight: 500; margin-bottom: 8px; color: #fff; }
        .plantilla-info p { font-size: 13px; color: #888; line-height: 1.5; margin-bottom: 20px; }
        .tech-badge { display: inline-block; background: rgba(52,152,219,0.2); color: #3498db; font-size: 11px; padding: 4px 12px; border-radius: 20px; margin-bottom: 12px; }
        .btn-elegir { display: block; width: 100%; padding: 12px; background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; color: #fff; text-align: center; font-size: 14px; font-weight: 500; transition: all 0.2s; cursor: pointer; }
        .btn-elegir:hover { background: #fff; color: #0a0a0a; border-color: #fff; }
        
        .error-message { text-align: center; padding: 60px 40px; background: #121212; border: 1px solid #2a2a2a; border-radius: 24px; max-width: 500px; margin: 0 auto; }
        .error-message h3 { font-size: 24px; margin-bottom: 16px; color: #fff; }
        .error-message p { color: #888; margin-bottom: 24px; }
        .btn-error { background: #fff; color: #0a0a0a; padding: 12px 28px; border-radius: 30px; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-error:hover { background: #e0e0e0; transform: translateY(-2px); }
        
        @media (max-width: 1024px) { .plantillas-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .plantillas-grid { grid-template-columns: 1fr; } .container { padding: 24px 20px; } h1 { font-size: 28px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="index.php" class="logo">JACHA<span>market</span></a>
            <a href="dashboard_principal.php" class="back-btn">← Volver al panel</a>
        </div>
        
        <h1>Elige la plantilla de tu negocio</h1>
        <p class="subtitle">Selecciona el diseño que mejor represente la esencia de tu emprendimiento</p>
        
        <?php if (!$mostrar_selector): ?>
            <div class="error-message">
                <h3>⚠️ No puedes seleccionar una plantilla</h3>
                <p><?php echo $mensaje_error; ?></p>
                <?php if (!$isLoggedIn): ?>
                    <a href="login.php" class="btn-error">Iniciar sesión</a>
                <?php else: ?>
                    <a href="perfil.php" class="btn-error">Ir a mi perfil</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="plantillas-grid">
                <?php foreach ($plantillas as $plantilla): 
                    $isTech = ($plantilla['nombre'] === 'Tecnológico');
                ?>
                <div class="plantilla-card <?php echo $isTech ? 'tech-highlight' : ''; ?>" data-id="<?php echo $plantilla['id_plantilla']; ?>" data-nombre="<?php echo htmlspecialchars($plantilla['nombre']); ?>">
                    <div class="plantilla-preview <?php echo $isTech ? 'tech-bg' : ''; ?>">
                        <div class="icon-preview">
                            <?php if ($isTech): ?>
                                🖥️
                            <?php elseif ($plantilla['nombre'] === 'Gastronómico'): ?>
                                🍕
                            <?php elseif ($plantilla['nombre'] === 'Moderno'): ?>
                                🏪
                            <?php elseif ($plantilla['nombre'] === 'Elegante'): ?>
                                ✨
                            <?php else: ?>
                                🏔️
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="plantilla-info">
                        <?php if ($isTech): ?>
                            <div class="tech-badge">⚡ ESPECIALIZADA</div>
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($plantilla['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($plantilla['descripcion']); ?></p>
                        <button class="btn-elegir" onclick="elegirPlantilla(<?php echo $plantilla['id_plantilla']; ?>, '<?php echo htmlspecialchars($plantilla['nombre']); ?>')">Usar esta plantilla</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function elegirPlantilla(id, nombre) {
            if (confirm(`¿Quieres crear un nuevo negocio con la plantilla "${nombre}"?`)) {
                window.location.href = 'crear_negocio.php?plantilla=' + id;
            }
        }
    </script>
</body>
</html>