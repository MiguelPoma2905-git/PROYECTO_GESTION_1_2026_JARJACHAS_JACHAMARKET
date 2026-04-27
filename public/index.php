<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$usuario = $_SESSION['usuario'] ?? null;
$isLoggedIn = $usuario !== null;
$isVendedor = $isLoggedIn && $usuario['rol'] === 'Emprendedor';
$isCliente = $isLoggedIn && $usuario['rol'] === 'Cliente';
$isRepartidor = $isLoggedIn && $usuario['rol'] === 'Repartidor';

$db = getDB();

// Obtener productos destacados
$stmt = $db->prepare("
    SELECT p.*, e.nombre_comercial, p.precio_base as precio
    FROM productos p
    JOIN emprendimientos e ON p.id_emprendimiento = e.id_emprendimiento
    WHERE p.estado = 'Publicado'
    LIMIT 12
");
$stmt->execute();
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Jacha Marketplace - Potenciando emprendimientos bolivianos</title>
    <link rel="stylesheet" href="assets/css/plantilla_base.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #1a4147, #fa7136);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 0 0 30px 30px;
            margin-bottom: 30px;
        }
        
        .hero h1 {
            font-size: 32px;
            margin-bottom: 16px;
        }
        
        .categorias {
            display: flex;
            overflow-x: auto;
            gap: 12px;
            padding: 16px 0;
            scrollbar-width: thin;
        }
        
        .categoria-item {
            background: white;
            padding: 8px 20px;
            border-radius: 30px;
            white-space: nowrap;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .productos-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 16px 0;
        }
        
        .producto-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .producto-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }
        
        .producto-info {
            padding: 12px;
        }
        
        .producto-precio {
            color: #fa7136;
            font-size: 20px;
            font-weight: bold;
        }
        
        .welcome-banner {
            background: rgba(44,62,80,0.05);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        @media (min-width: 481px) {
            .productos-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        
        @media (min-width: 769px) {
            .productos-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
            }
            
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo">
                JACHA<span>Market</span>
            </div>
            <button class="menu-toggle" id="menuToggle">☰</button>
            <nav class="nav-menu" id="navMenu">
                <a href="index.php">Inicio</a>
                <?php if ($isVendedor): ?>
                <a href="dashboard_vendedor.php">Mi Tienda</a>
                <a href="productos_admin.php">Productos</a>
                <a href="pedidos_admin.php">Pedidos</a>
                <a href="plantillas.php">Personalizar Tienda</a>
                <?php elseif ($isRepartidor): ?>
                <a href="dashboard_repartidor.php">Entregas</a>
                <?php elseif ($isCliente): ?>
                <a href="mis_pedidos.php">Mis Pedidos</a>
                <a href="carrito.php">Carrito 🛒</a>
                <?php endif; ?>
                <?php if ($isLoggedIn): ?>
                <a href="perfil.php">Mi Perfil</a>
                <a href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
                <a href="registro.php">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="hero">
            <h1>🏔️ Potencia tu Emprendimiento</h1>
            <p>La plataforma que conecta talento boliviano con el mundo digital</p>
            <?php if (!$isLoggedIn): ?>
            <a href="registro.php" class="btn btn-primary" style="margin-top: 20px;">Comenzar Ahora</a>
            <?php endif; ?>
        </section>
        
        <div class="container">
            <?php if ($isLoggedIn): ?>
            <div class="welcome-banner">
                ¡Bienvenido/a, <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong>!
                <?php if ($isVendedor): ?>
                <br><small>📊 ¿Listo para vender? <a href="productos_admin.php">Agrega tus productos</a></small>
                <?php elseif ($isRepartidor): ?>
                <br><small>🚚 Hay pedidos esperando por ti</small>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <h2>📦 Productos Destacados</h2>
            
            <div class="categorias">
                <span class="categoria-item">Todos</span>
                <span class="categoria-item">Moda</span>
                <span class="categoria-item">Artesanía</span>
                <span class="categoria-item">Comida</span>
                <span class="categoria-item">Tecnología</span>
            </div>
            
            <div class="productos-grid">
                <?php if (count($productos) > 0): ?>
                    <?php foreach ($productos as $producto): ?>
                    <div class="producto-card">
                        <div class="producto-img">
                            🛍️
                        </div>
                        <div class="producto-info">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="producto-precio">Bs. <?php echo number_format($producto['precio'], 2); ?></p>
                            <p style="font-size: 12px; color: #666;"><?php echo htmlspecialchars($producto['nombre_comercial']); ?></p>
                            <a href="producto.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Ver Detalle</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; grid-column: 1/-1;">
                        <p>📭 No hay productos disponibles aún.</p>
                        <?php if ($isVendedor): ?>
                        <a href="productos_admin.php" class="btn btn-primary">Agregar mi primer producto</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <div class="brand-watermark">
        JACHA Marketplace - Potenciando emprendimientos bolivianos | 
        <span style="color:#C0392B">❤️</span> <span style="color:#2C3E50">💙</span>
    </div>
    
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }
        
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navMenu.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>