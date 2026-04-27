<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$db = getDB();

// Verificar si es vendedor o mostrar mensaje
$esVendedor = ($usuario['rol'] === 'Emprendedor');

// Obtener emprendimientos del usuario (puede tener varios)
$stmt = $db->prepare("SELECT * FROM emprendimientos WHERE id_propietario = ? ORDER BY id_emprendimiento DESC");
$stmt->execute([$usuario['id']]);
$emprendimientos = $stmt->fetchAll();

$tieneNegocio = count($emprendimientos) > 0;
$negocioActivo = $tieneNegocio ? $emprendimientos[0] : null;

// Si tiene negocio, obtener estadísticas
$totalProductos = 0;
$pedidosHoy = 0;
$ventasMes = 0;
$ultimosPedidos = [];

if ($tieneNegocio) {
    // Total productos
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM productos WHERE id_emprendimiento = ?");
    $stmt->execute([$negocioActivo['id_emprendimiento']]);
    $totalProductos = $stmt->fetch()['total'];
    
    // Pedidos hoy
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM pedidos p
        JOIN sucursales s ON p.id_sucursal_origen = s.id_sucursal
        WHERE s.id_emprendimiento = ? AND DATE(p.fecha_creacion) = CURDATE()
    ");
    $stmt->execute([$negocioActivo['id_emprendimiento']]);
    $pedidosHoy = $stmt->fetch()['total'];
    
    // Ventas del mes
    $stmt = $db->prepare("
        SELECT COALESCE(SUM(p.total), 0) as total
        FROM pedidos p
        JOIN sucursales s ON p.id_sucursal_origen = s.id_sucursal
        WHERE s.id_emprendimiento = ? 
        AND MONTH(p.fecha_creacion) = MONTH(CURDATE())
        AND YEAR(p.fecha_creacion) = YEAR(CURDATE())
        AND p.estado_pago = 'Completado'
    ");
    $stmt->execute([$negocioActivo['id_emprendimiento']]);
    $ventasMes = $stmt->fetch()['total'];
    
    // Últimos pedidos
    $stmt = $db->prepare("
        SELECT p.*, u.nombres, u.apellidos,
               CASE 
                   WHEN p.estado_logistico = 'Recibido' THEN 'Recibido'
                   WHEN p.estado_logistico = 'Preparando' THEN 'Preparando'
                   WHEN p.estado_logistico = 'En_Ruta' THEN 'En camino'
                   WHEN p.estado_logistico = 'Entregado' THEN 'Entregado'
                   ELSE p.estado_logistico
               END as estado_texto
        FROM pedidos p
        JOIN sucursales s ON p.id_sucursal_origen = s.id_sucursal
        JOIN usuarios u ON p.id_cliente = u.id_usuario
        WHERE s.id_emprendimiento = ?
        ORDER BY p.fecha_creacion DESC
        LIMIT 5
    ");
    $stmt->execute([$negocioActivo['id_emprendimiento']]);
    $ultimosPedidos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #2D2D2D;
            color: #e8e8e8;
            min-height: 100vh;
        }
        
        /* ============================================
           SIDEBAR - Estilo Notion
           ============================================ */
        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100%;
            background: #252525;
            z-index: 1000;
            transition: left 0.25s ease;
            border-right: 1px solid #3a3a3a;
        }
        
        .sidebar.open {
            left: 0;
        }
        
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #3a3a3a;
        }
        
        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #fa7136;
        }
        
        .sidebar-header p {
            font-size: 12px;
            color: #8a8a8a;
            margin-top: 4px;
        }
        
        .sidebar-nav {
            padding: 20px 12px;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #b0b0b0;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.15s ease;
            font-size: 14px;
        }
        
        .sidebar-nav a:hover {
            background: #353535;
            color: #ffffff;
        }
        
        .sidebar-nav a.active {
            background: rgba(250,113,54,0.12);
            color: #fa7136;
        }
        
        /* ============================================
           MAIN CONTENT
           ============================================ */
        .main-content {
            min-height: 100vh;
            transition: margin-left 0.25s ease;
        }
        
        /* Top Bar - Tres líneas a la izquierda, usuario a la derecha */
        .top-bar {
            background: #2D2D2D;
            border-bottom: 1px solid #3a3a3a;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .menu-btn {
            background: none;
            border: none;
            color: #b0b0b0;
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.15s ease;
        }
        
        .menu-btn:hover {
            background: #3a3a3a;
            color: #ffffff;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #e0e0e0;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: #fa7136;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: white;
        }
        
        .logout-icon {
            background: none;
            border: none;
            color: #8a8a8a;
            cursor: pointer;
            font-size: 18px;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }
        
        .logout-icon:hover {
            background: #3a3a3a;
            color: #fa7136;
        }
        
        /* Container */
        .container {
            padding: 32px 24px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Welcome Section */
        .welcome-section {
            margin-bottom: 32px;
        }
        
        .welcome-section h1 {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
        }
        
        .welcome-section p {
            font-size: 14px;
            color: #8a8a8a;
        }
        
        /* Create Business Card - Para cuando no tiene negocio */
        .create-business-card {
            background: linear-gradient(135deg, #1a1a1a, #252525);
            border: 1px solid #3a3a3a;
            border-radius: 20px;
            padding: 48px 32px;
            text-align: center;
            margin-bottom: 32px;
        }
        
        .create-business-card .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .create-business-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff;
        }
        
        .create-business-card p {
            font-size: 14px;
            color: #8a8a8a;
            margin-bottom: 24px;
        }
        
        .btn-create {
            background: #fa7136;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-create:hover {
            background: #e05a2a;
            transform: translateY(-1px);
        }
        
        /* Stats Grid - Notion style */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .stat-card {
            background: #252525;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #353535;
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            border-color: #fa7136;
        }
        
        .stat-title {
            font-size: 13px;
            font-weight: 500;
            color: #8a8a8a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #ffffff;
        }
        
        .stat-unit {
            font-size: 14px;
            color: #8a8a8a;
            font-weight: 400;
            margin-left: 4px;
        }
        
        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 32px 0 20px 0;
        }
        
        .section-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
        }
        
        .section-header a {
            color: #8a8a8a;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.15s ease;
        }
        
        .section-header a:hover {
            color: #fa7136;
        }
        
        /* Quick Actions - Grid 2x2 */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .action-card {
            background: #252525;
            border: 1px solid #353535;
            border-radius: 16px;
            padding: 20px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .action-card:hover {
            border-color: #fa7136;
            transform: translateY(-2px);
        }
        
        .action-icon {
            font-size: 28px;
        }
        
        .action-card h4 {
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
        }
        
        .action-card p {
            font-size: 12px;
            color: #8a8a8a;
        }
        
        /* Table */
        .table-container {
            background: #252525;
            border-radius: 16px;
            border: 1px solid #353535;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 16px;
            font-size: 12px;
            font-weight: 500;
            color: #8a8a8a;
            border-bottom: 1px solid #353535;
        }
        
        td {
            padding: 16px;
            font-size: 13px;
            border-bottom: 1px solid #353535;
            color: #e0e0e0;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .status-recibido { background: rgba(250,113,54,0.12); color: #fa7136; }
        .status-preparando { background: rgba(52,152,219,0.12); color: #5dade2; }
        .status-en_camino { background: rgba(241,196,15,0.12); color: #f1c40f; }
        .status-entregado { background: rgba(46,204,113,0.12); color: #58d68d; }
        
        .empty-state {
            text-align: center;
            padding: 60px 32px;
            color: #8a8a8a;
        }
        
        .empty-state p:first-child {
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .empty-state p:last-child {
            font-size: 12px;
        }
        
        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 999;
            display: none;
        }
        
        .overlay.active {
            display: block;
        }
        
        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 12px;
            right: 12px;
            font-size: 10px;
            color: rgba(250,113,54,0.15);
            z-index: 1000;
            pointer-events: none;
            font-weight: 500;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .container {
                padding: 20px 16px;
            }
            
            .welcome-section h1 {
                font-size: 24px;
            }
        }
        
        @media (min-width: 1024px) {
            .sidebar {
                left: 0;
            }
            
            .menu-btn {
                display: none;
            }
            
            .main-content {
                margin-left: 280px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>JACHA</h2>
            <p>Panel de control</p>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard_vendedor.php" class="active">
                <span>📊</span> Dashboard
            </a>
            <a href="#">
                <span>🏪</span> Mis negocios
            </a>
            <a href="#">
                <span>📦</span> Productos
            </a>
            <a href="#">
                <span>🛒</span> Pedidos
            </a>
            <a href="plantillas.php">
                <span>🎨</span> Personalizar
            </a>
            <a href="#">
                <span>📈</span> Reportes
            </a>
            <a href="logout.php" style="margin-top: 40px;">
                <span>🚪</span> Cerrar sesión
            </a>
        </nav>
    </div>
    
    <div class="overlay" id="overlay"></div>
    
    <div class="main-content">
        <div class="top-bar">
            <button class="menu-btn" id="menuBtn">☰</button>
            <div class="user-menu">
                <span class="user-name"><?php echo htmlspecialchars($usuario['nombre']); ?></span>
                <div class="user-avatar">
                    <?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?>
                </div>
                <a href="logout.php" class="logout-icon" title="Cerrar sesión">🚪</a>
            </div>
        </div>
        
        <div class="container">
            <div class="welcome-section">
                <h1>Hola, <?php echo htmlspecialchars($usuario['nombre']); ?></h1>
                <p>Bienvenido a tu panel de control</p>
            </div>
            
            <?php if (!$tieneNegocio): ?>
                <!-- Estado: Usuario vendedor sin negocio creado -->
                <div class="create-business-card">
                    <div class="icon">🏪</div>
                    <h3>Crea tu primer negocio</h3>
                    <p>Comienza a vender tus productos en minutos</p>
                    <a href="crear_emprendimiento.php" class="btn-create">
                        <span>+</span> Crear negocio
                    </a>
                </div>
                
                <!-- Quick actions deshabilitadas -->
                <div class="quick-actions">
                    <div class="action-card" style="opacity: 0.5;">
                        <div class="action-icon">➕</div>
                        <h4>Nuevo producto</h4>
                        <p>Crea tu negocio primero</p>
                    </div>
                    <div class="action-card" style="opacity: 0.5;">
                        <div class="action-icon">🎨</div>
                        <h4>Personalizar</h4>
                        <p>Crea tu negocio primero</p>
                    </div>
                    <div class="action-card" style="opacity: 0.5;">
                        <div class="action-icon">📋</div>
                        <h4>Pedidos</h4>
                        <p>Crea tu negocio primero</p>
                    </div>
                    <div class="action-card" style="opacity: 0.5;">
                        <div class="action-icon">📊</div>
                        <h4>Reportes</h4>
                        <p>Crea tu negocio primero</p>
                    </div>
                </div>
            <?php else: ?>
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-title">📦 Productos</div>
                        <div class="stat-value"><?php echo $totalProductos; ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">🛒 Pedidos hoy</div>
                        <div class="stat-value"><?php echo $pedidosHoy; ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">💰 Ventas del mes</div>
                        <div class="stat-value">Bs. <?php echo number_format($ventasMes, 2); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">⭐ Valoración</div>
                        <div class="stat-value">4.8</div>
                        <div class="stat-unit">/5</div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="section-header">
                    <h2>Acciones rápidas</h2>
                </div>
                <div class="quick-actions">
                    <a href="#" class="action-card">
                        <div class="action-icon">➕</div>
                        <h4>Nuevo producto</h4>
                        <p>Agregar a tu catálogo</p>
                    </a>
                    <a href="plantillas.php" class="action-card">
                        <div class="action-icon">🎨</div>
                        <h4>Personalizar</h4>
                        <p>Cambia colores y plantilla</p>
                    </a>
                    <a href="#" class="action-card">
                        <div class="action-icon">📋</div>
                        <h4>Ver pedidos</h4>
                        <p>Gestiona tus ventas</p>
                    </a>
                    <a href="#" class="action-card">
                        <div class="action-icon">📊</div>
                        <h4>Reportes</h4>
                        <p>Analiza tu negocio</p>
                    </a>
                </div>
                
                <!-- Últimos pedidos -->
                <div class="section-header">
                    <h2>Últimos pedidos</h2>
                    <a href="#">Ver todos →</a>
                </div>
                <div class="table-container">
                    <?php if (count($ultimosPedidos) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimosPedidos as $pedido): ?>
                            <tr>
                                <td>#<?php echo str_pad($pedido['id_pedido'], 6, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($pedido['nombres'] . ' ' . $pedido['apellidos']); ?></td>
                                <td>Bs. <?php echo number_format($pedido['total'], 2); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '_', $pedido['estado_texto'])); ?>">
                                        <?php echo $pedido['estado_texto']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($pedido['fecha_creacion'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-state">
                        <p>Cuando recibas tu primer pedido, aparecerá aquí</p>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="watermark">
        JACHA Marketplace
    </div>
    
    <script>
        // Sidebar toggle
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
        
        if (menuBtn) {
            menuBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
        }
        
        // Cerrar sidebar en móvil al hacer click
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>