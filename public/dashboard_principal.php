<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$db = getDB();

// Obtener avatar del usuario
$stmt = $db->prepare("SELECT avatar FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$usuario['id']]);
$avatar_usuario = $stmt->fetchColumn();

// Si no tiene avatar, usar uno por defecto
if (empty($avatar_usuario)) {
    $avatar_usuario = 'assets/avatars/default/avatar_1.png';
}

// Obtener todos los roles del usuario
$stmt = $db->prepare("
    SELECT r.id_rol, r.nombre_rol 
    FROM usuario_roles ur
    JOIN roles r ON ur.id_rol = r.id_rol
    WHERE ur.id_usuario = ?
");
$stmt->execute([$usuario['id']]);
$roles_usuario = $stmt->fetchAll();

$roles_nombres = array_column($roles_usuario, 'nombre_rol');

// Determinar rol activo
if (!isset($_SESSION['rol_activo']) || !in_array($_SESSION['rol_activo'], $roles_nombres)) {
    $_SESSION['rol_activo'] = $roles_nombres[0] ?? 'Cliente';
}
$rol_activo = $_SESSION['rol_activo'];

// Cambiar rol via GET
if (isset($_GET['cambiar_rol']) && in_array($_GET['cambiar_rol'], $roles_nombres)) {
    $_SESSION['rol_activo'] = $_GET['cambiar_rol'];
    $rol_activo = $_GET['cambiar_rol'];
    header('Location: dashboard_principal.php');
    exit;
}

// Obtener negocios del usuario (si es emprendedor)
$mis_negocios = [];
if (in_array('Emprendedor', $roles_nombres)) {
    $stmt = $db->prepare("
        SELECT e.*, p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario,
               (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos
        FROM emprendimientos e
        LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
        LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
        WHERE e.id_propietario = ?
        ORDER BY e.id_emprendimiento DESC
    ");
    $stmt->execute([$usuario['id']]);
    $mis_negocios = $stmt->fetchAll();
}

// Obtener negocios de OTROS (para cliente)
$otros_negocios = [];
if (in_array('Cliente', $roles_nombres)) {
    $stmt = $db->prepare("
        SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, 
               p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario,
               (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos
        FROM emprendimientos e
        LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
        LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
        WHERE e.estado = 'Aprobado' AND e.id_propietario != ?
        ORDER BY e.id_emprendimiento DESC
        LIMIT 12
    ");
    $stmt->execute([$usuario['id']]);
    $otros_negocios = $stmt->fetchAll();
}

// Estadísticas generales
$stats = [];
$stmt = $db->query("SELECT COUNT(*) as total FROM emprendimientos WHERE estado = 'Aprobado'");
$stats['total_negocios'] = $stmt->fetch()['total'];
$stmt = $db->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Activo'");
$stats['total_usuarios'] = $stmt->fetch()['total'];
$stmt = $db->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'Publicado'");
$stats['total_productos'] = $stmt->fetch()['total'];

$inicial = strtoupper(substr($usuario['nombre'], 0, 1));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #0a0a0a;
            --surface: #121212;
            --surface2: #1a1a1a;
            --surface3: #222222;
            --border: rgba(255,255,255,0.06);
            --border-hi: rgba(255,255,255,0.1);
            --text: #e8e8e8;
            --text-muted: #888;
            --text-dim: #555;
            --white: #ffffff;
            --glow: rgba(255,255,255,0.04);
            --glow-strong: rgba(255,255,255,0.08);
            --radius: 16px;
            --radius-sm: 10px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.4);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.5);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.6);
            --shadow-glow: 0 0 30px rgba(255,255,255,0.03);
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100%;
            background: linear-gradient(180deg, var(--surface) 0%, var(--surface2) 100%);
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 24px;
            right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-hi), transparent);
        }

        .logo-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logo-img {
            height: 32px;
            width: auto;
            filter: brightness(0) invert(1);
            transition: filter 0.3s ease;
        }

        .logo-link:hover .logo-img {
            filter: brightness(0) invert(1) drop-shadow(0 0 6px rgba(255,255,255,0.3));
        }

        .logo-text {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--white);
            letter-spacing: 0.02em;
        }

        .logo-text span {
            font-weight: 300;
            color: var(--text-muted);
            font-size: 17px;
        }

        .sidebar-header p {
            font-size: 11px;
            color: var(--text-dim);
            margin-top: 12px;
            padding-left: 38px;
        }

        /* Rol selector en sidebar */
        .rol-selector {
            margin: 20px 16px;
            padding: 16px;
            background: var(--surface2);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.02), var(--shadow-sm);
        }

        .rol-selector h4 {
            font-size: 10px;
            color: var(--text-dim);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .rol-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .rol-btn {
            flex: 1;
            padding: 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--surface);
            color: var(--text-muted);
            text-decoration: none;
        }

        .rol-btn.active {
            background: var(--white);
            color: var(--bg);
            box-shadow: 0 2px 8px rgba(255,255,255,0.15);
        }

        .rol-btn:hover:not(.active) {
            background: var(--surface3);
            color: var(--white);
        }

        .sidebar-nav {
            padding: 16px 12px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            font-size: 13px;
            position: relative;
        }

        .sidebar-nav a:hover {
            background: var(--surface2);
            color: var(--white);
            transform: translateX(4px);
        }

        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(255,255,255,0.05), transparent);
            color: var(--white);
            border-left: 2px solid var(--white);
        }

        /* Main content */
        .main-content {
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Top Bar con efecto vidrio */
        .top-bar {
            background: rgba(10,10,10,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .menu-btn {
            background: none;
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            padding: 8px 14px;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .menu-btn:hover {
            border-color: var(--border-hi);
            color: var(--white);
            background: var(--glow);
        }

        /* User dropdown - siempre a la derecha */
        .user-dropdown {
            position: relative;
            margin-left: auto;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 40px;
            transition: all 0.2s;
            background: var(--surface);
            border: 1px solid var(--border);
        }

        .user-trigger:hover {
            background: var(--surface2);
            border-color: var(--border-hi);
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            background: linear-gradient(135deg, var(--white), #d0d0d0);
            color: var(--bg);
            box-shadow: 0 2px 8px rgba(255,255,255,0.1);
            transition: transform 0.2s;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-trigger:hover .user-avatar {
            transform: scale(1.05);
        }

        .dropdown-arrow {
            font-size: 10px;
            color: var(--text-muted);
            transition: transform 0.2s;
        }

        .user-trigger:hover .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Dropdown menu */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            box-shadow: var(--shadow-lg);
            z-index: 101;
        }

        .user-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--surface2);
            color: var(--white);
        }

        .dropdown-item.logout {
            color: #ff6b6b;
        }

        .dropdown-item.logout:hover {
            background: rgba(255,107,107,0.1);
            color: #ff6b6b;
        }

        /* Container */
        .container {
            padding: 40px 36px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 44px;
            position: relative;
        }

        .welcome-section h1 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 34px;
            font-weight: 400;
            margin-bottom: 10px;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .welcome-section p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .welcome-section p strong {
            color: var(--white);
            font-weight: 500;
            background: linear-gradient(135deg, var(--white), #aaa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 52px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            border-color: var(--border-hi);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md), var(--shadow-glow);
        }

        .stat-card h3 {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 38px;
            font-weight: 400;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 44px 0 28px;
        }

        .section-header h2 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 24px;
            font-weight: 400;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .btn-create {
            background: var(--white);
            color: var(--bg);
            padding: 9px 22px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(255,255,255,0.1);
        }

        .btn-create:hover {
            background: #e8e8e8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255,255,255,0.15);
        }

        /* Negocios Grid */
        .negocios-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .negocio-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .negocio-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.03), transparent);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .negocio-card:hover::after {
            opacity: 1;
        }

        .negocio-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hi);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(255,255,255,0.03);
        }

        .negocio-preview {
            height: 130px;
            background: linear-gradient(135deg, var(--surface2), var(--surface));
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .negocio-colors {
            display: flex;
            gap: 12px;
        }

        .negocio-color {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }

        .negocio-card:hover .negocio-color {
            transform: scale(1.05);
        }

        .negocio-info {
            padding: 22px;
        }

        .negocio-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--white);
        }

        .negocio-info p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .negocio-tag {
            font-size: 10px;
            color: var(--text-dim);
            background: var(--surface2);
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .btn-visitar {
            display: block;
            padding: 11px;
            text-align: center;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 12px;
            text-decoration: none;
            color: var(--text);
            font-size: 12px;
            font-weight: 500;
            margin-top: 14px;
            transition: all 0.2s;
        }

        .btn-visitar:hover {
            background: var(--white);
            color: var(--bg);
            border-color: var(--white);
        }

        .empty-state {
            text-align: center;
            padding: 70px;
            color: var(--text-dim);
            grid-column: 1/-1;
        }

        .empty-state p {
            font-size: 13px;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 14px;
            right: 14px;
            font-size: 9px;
            color: rgba(255,255,255,0.03);
            pointer-events: none;
            font-family: monospace;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .negocios-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        }

        @media (max-width: 768px) {
            .container { padding: 24px 20px; }
            .negocios-grid { grid-template-columns: 1fr; gap: 16px; }
            .stats-grid { grid-template-columns: 1fr; gap: 12px; }
            .welcome-section h1 { font-size: 28px; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .menu-btn { display: block; }
            .sidebar { left: -280px; }
            .sidebar.open { left: 0; }
            .top-bar { padding: 12px 20px; }
            .user-name { display: none; }
            .user-trigger { padding: 4px; }
            .user-dropdown { margin-left: auto; }
        }

        @media (min-width: 769px) {
            .sidebar { left: 0; }
            .menu-btn { display: none; }
            .main-content { margin-left: 280px; }
            .user-dropdown { margin-left: auto; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="index.php" class="logo-link">
                <img src="assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
                <div class="logo-text">JACHA<span>market</span></div>
            </a>
            <p>Panel de control</p>
        </div>
        
        <!-- Selector de rol (si tiene múltiples roles) -->
        <?php if (count($roles_usuario) > 1): ?>
        <div class="rol-selector">
            <h4>Cambiar rol</h4>
            <div class="rol-buttons">
                <?php foreach ($roles_usuario as $rol): ?>
                <a href="?cambiar_rol=<?php echo $rol['nombre_rol']; ?>" class="rol-btn <?php echo $rol_activo === $rol['nombre_rol'] ? 'active' : ''; ?>">
                    <?php 
                        if ($rol['nombre_rol'] === 'Cliente') echo 'Cliente';
                        elseif ($rol['nombre_rol'] === 'Emprendedor') echo 'Vendedor';
                        else echo $rol['nombre_rol'];
                    ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <nav class="sidebar-nav">
            <a href="dashboard_principal.php" class="active">Dashboard</a>
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <a href="productos_admin.php">Productos</a>
                <a href="pedidos_admin.php">Pedidos</a>
                <a href="plantillas.php">Personalizar</a>
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <a href="dashboard_repartidor.php">Entregas</a>
                <a href="historial_entregas.php">Historial</a>
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <a href="mis_pedidos.php">Mis pedidos</a>
                <a href="favoritos.php">Favoritos</a>
            <?php endif; ?>
            <a href="perfil.php">Configuración</a>
            <a href="logout.php" style="margin-top: 40px;">Cerrar sesión</a>
        </nav>
    </div>
    
    <div class="overlay" id="overlay"></div>
    
    <div class="main-content">
        <div class="top-bar">
            <button class="menu-btn" id="menuBtn">☰</button>
            
            <!-- User dropdown - a la derecha -->
            <div class="user-dropdown" id="userDropdown">
                <div class="user-trigger" id="userTrigger">
                    <span class="user-name"><?php echo htmlspecialchars($usuario['nombre']); ?></span>
                    <div class="user-avatar">
                        <?php if (!empty($avatar_usuario) && file_exists($avatar_usuario)): ?>
                            <img src="<?php echo $avatar_usuario; ?>" alt="Avatar">
                        <?php else: ?>
                            <?php echo $inicial; ?>
                        <?php endif; ?>
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-menu">
                    <a href="perfil.php" class="dropdown-item">
                        ⚙️ Configuración
                    </a>
                    <a href="logout.php" class="dropdown-item logout">
                        🚪 Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="welcome-section">
                <h1>Hola, <?php echo htmlspecialchars($usuario['nombre']); ?></h1>
                <p>Estás viendo el panel como <strong><?php echo $rol_activo; ?></strong></p>
            </div>
            
            <!-- Estadísticas globales -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Negocios activos</h3>
                    <div class="value"><?php echo $stats['total_negocios']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Usuarios</h3>
                    <div class="value"><?php echo $stats['total_usuarios']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Productos</h3>
                    <div class="value"><?php echo $stats['total_productos']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Valoración</h3>
                    <div class="value">4.8</div>
                </div>
            </div>
            
            <!-- VISTA SEGÚN ROL ACTIVO -->
            <?php if ($rol_activo === 'Emprendedor'): ?>
                <!-- ========== VISTA EMPRENDEDOR ========== -->
                <div class="section-header">
                    <h2>Mis negocios</h2>
                    <a href="crear_emprendimiento.php" class="btn-create">+ Nuevo negocio</a>
                </div>
                <div class="negocios-grid">
                    <?php if (count($mis_negocios) > 0): ?>
                        <?php foreach ($mis_negocios as $negocio): ?>
                        <div class="negocio-card" onclick="window.location.href='tienda.php?id=<?php echo $negocio['id_emprendimiento']; ?>'">
                            <div class="negocio-preview">
                                <div class="negocio-colors">
                                    <div class="negocio-color" style="background: <?php echo $negocio['color_primario'] ?: '#ffffff'; ?>;"></div>
                                    <div class="negocio-color" style="background: <?php echo $negocio['color_secundario'] ?: '#888888'; ?>;"></div>
                                </div>
                            </div>
                            <div class="negocio-info">
                                <h3><?php echo htmlspecialchars($negocio['nombre_comercial']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 60)); ?>...</p>
                                <span class="negocio-tag">📦 <?php echo $negocio['total_productos']; ?> productos</span>
                                <span class="negocio-tag">🎨 <?php echo $negocio['plantilla_nombre'] ?? 'Moderno'; ?></span>
                                <div class="btn-visitar">Administrar tienda</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No tienes negocios creados</p>
                            <a href="crear_emprendimiento.php" class="btn-create" style="display: inline-block; margin-top: 16px;">+ Crear mi primer negocio</a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Cliente'): ?>
                <!-- ========== VISTA CLIENTE ========== -->
                <div class="section-header">
                    <h2>Descubre negocios</h2>
                </div>
                <div class="negocios-grid">
                    <?php if (count($otros_negocios) > 0): ?>
                        <?php foreach ($otros_negocios as $negocio): ?>
                        <div class="negocio-card" onclick="window.location.href='tienda.php?id=<?php echo $negocio['id_emprendimiento']; ?>'">
                            <div class="negocio-preview">
                                <div class="negocio-colors">
                                    <div class="negocio-color" style="background: <?php echo $negocio['color_primario'] ?: '#ffffff'; ?>;"></div>
                                    <div class="negocio-color" style="background: <?php echo $negocio['color_secundario'] ?: '#888888'; ?>;"></div>
                                </div>
                            </div>
                            <div class="negocio-info">
                                <h3><?php echo htmlspecialchars($negocio['nombre_comercial']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($negocio['descripcion'] ?? '', 0, 60)); ?>...</p>
                                <span class="negocio-tag">📦 <?php echo $negocio['total_productos']; ?> productos</span>
                                <span class="negocio-tag">🎨 <?php echo $negocio['plantilla_nombre'] ?? 'Moderno'; ?></span>
                                <div class="btn-visitar">Ver tienda</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No hay negocios disponibles aún</p>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($rol_activo === 'Repartidor'): ?>
                <!-- ========== VISTA REPARTIDOR ========== -->
                <div class="section-header">
                    <h2>Entregas pendientes</h2>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Pedidos hoy</h3>
                        <div class="value">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Ganancias mes</h3>
                        <div class="value">Bs. 0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Calificación</h3>
                        <div class="value">5.0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Entregas</h3>
                        <div class="value">0</div>
                    </div>
                </div>
                <div class="empty-state">
                    <p>No hay pedidos de entrega disponibles</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="watermark">JACHA</div>
    
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
        
        document.querySelectorAll('.sidebar-nav a, .rol-btn').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 769) toggleSidebar();
            });
        });
        
        // User dropdown
        const userDropdown = document.getElementById('userDropdown');
        const userTrigger = document.getElementById('userTrigger');
        
        if (userTrigger) {
            userTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
            });
            
            document.addEventListener('click', () => {
                userDropdown.classList.remove('active');
            });
        }
    </script>
</body>
</html>