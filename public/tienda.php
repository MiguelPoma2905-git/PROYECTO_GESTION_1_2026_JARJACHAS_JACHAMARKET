<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$id_emprendimiento = $_GET['id'] ?? 0;
if (!$id_emprendimiento) {
    header('Location: index.php');
    exit;
}

$db = getDB();

// Obtener datos del emprendimiento
$stmt = $db->prepare("
    SELECT e.*, p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario, pe.color_fondo
    FROM emprendimientos e
    LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
    LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
    WHERE e.id_emprendimiento = ? AND e.estado = 'Aprobado'
");
$stmt->execute([$id_emprendimiento]);
$emprendimiento = $stmt->fetch();

if (!$emprendimiento) {
    header('Location: index.php');
    exit;
}

// Obtener productos
$stmt = $db->prepare("SELECT * FROM productos WHERE id_emprendimiento = ? AND estado = 'Publicado' ORDER BY id_producto DESC");
$stmt->execute([$id_emprendimiento]);
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo htmlspecialchars($emprendimiento['nombre_comercial']); ?> - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: <?php echo $emprendimiento['color_fondo'] ?? '#0a0a0a'; ?>;
            color: #e8e8e8;
            line-height: 1.5;
        }
        .header {
            background: <?php echo $emprendimiento['color_primario'] ?? '#1a1a1a'; ?>;
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: #fff; text-decoration: none; }
        .logo span { color: #ddd; font-weight: 300; }
        .back-btn { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 14px; }
        .back-btn:hover { color: #fff; }
        .container { max-width: 1400px; margin: 0 auto; padding: 40px 32px; }
        .shop-title { font-size: 36px; font-weight: 400; margin-bottom: 8px; }
        .shop-desc { color: #aaa; margin-bottom: 40px; }
        
        .productos-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .producto-card {
            background: rgba(18,18,18,0.8);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .producto-card:hover { transform: translateY(-4px); border-color: <?php echo $emprendimiento['color_primario'] ?? '#fff'; ?>; }
        .producto-img { width: 100%; height: 200px; background: #1a1a1a; object-fit: cover; }
        .producto-info { padding: 20px; }
        .producto-info h3 { font-size: 18px; margin-bottom: 8px; }
        .producto-precio { font-size: 22px; font-weight: 600; color: <?php echo $emprendimiento['color_primario'] ?? '#fff'; ?>; margin: 12px 0; }
        .btn-comprar {
            display: block; width: 100%; padding: 10px; background: <?php echo $emprendimiento['color_secundario'] ?? '#333'; ?>;
            color: white; text-align: center; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s;
        }
        .btn-comprar:hover { opacity: 0.8; }
        
        .footer { text-align: center; padding: 40px; border-top: 1px solid rgba(255,255,255,0.08); margin-top: 40px; }
        .watermark {
            position: fixed; bottom: 12px; right: 12px; font-size: 10px;
            color: rgba(255,255,255,0.15); pointer-events: none; font-family: monospace;
        }
        @media (max-width: 1024px) { .productos-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .productos-grid { grid-template-columns: 1fr; } .container { padding: 24px 20px; } }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="logo">JACHA<span>market</span></a>
        <a href="javascript:history.back()" class="back-btn">← Volver</a>
    </div>
    
    <div class="container">
        <h1 class="shop-title"><?php echo htmlspecialchars($emprendimiento['nombre_comercial']); ?></h1>
        <p class="shop-desc"><?php echo htmlspecialchars($emprendimiento['descripcion']); ?></p>
        
        <?php if (count($productos) > 0): ?>
        <div class="productos-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'], true);
            ?>
            <div class="producto-card">
                <img src="<?php echo $producto['imagen_url'] ?: 'assets/images/placeholder.png'; ?>" class="producto-img" onerror="this.src='assets/images/placeholder.png'">
                <div class="producto-info">
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <?php if ($atributos && isset($atributos['marca'])): ?>
                        <small style="color:#888;"><?php echo htmlspecialchars($atributos['marca']); ?></small>
                    <?php endif; ?>
                    <div class="producto-precio">Bs. <?php echo number_format($producto['precio_base'], 2); ?></div>
                    <button class="btn-comprar" onclick="alert('Funcionalidad en desarrollo')">Agregar al carrito</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 80px; color: #888;">
            <p>No hay productos disponibles en esta tienda aún.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        <p>© 2026 Jacha Marketplace</p>
    </div>
    <div class="watermark">⚡ JACHA</div>
</body>
</html>