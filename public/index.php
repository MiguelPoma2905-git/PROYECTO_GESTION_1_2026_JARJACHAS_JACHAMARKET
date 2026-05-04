<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$usuario = $_SESSION['usuario'] ?? null;
$isLoggedIn = $usuario !== null;
$rol_activo = $_SESSION['rol_activo'] ?? ($usuario['rol'] ?? 'Cliente');
$isVendedor = $isLoggedIn && $rol_activo === 'Emprendedor';
$isCliente = $isLoggedIn && $rol_activo === 'Cliente';
$isRepartidor = $isLoggedIn && $rol_activo === 'Repartidor';

$db = getDB();

// Obtener emprendimientos destacados
$stmt = $db->prepare("
    SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, 
           p.nombre as plantilla_nombre, p.color_primario, p.color_secundario
    FROM emprendimientos e
    JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
    JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
    WHERE e.estado = 'Aprobado'
    LIMIT 6
");
$stmt->execute();
$escaparates = $stmt->fetchAll();

$stmt = $db->prepare("SELECT id_plantilla, nombre, descripcion, color_primario, color_secundario FROM plantillas WHERE activo = 1");
$stmt->execute();
$ambientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Jacha Marketplace - Potenciando emprendimientos bolivianos</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        /* Mantén tus estilos actuales de index.php - son correctos */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #080808; --surface: #101010; --surface2: #141414;
            --border: rgba(255,255,255,0.07); --border-hi: rgba(255,255,255,0.14);
            --text: #ebebeb; --text-muted: #888; --text-dim: #555;
            --white: #ffffff; --glow: rgba(255,255,255,0.06);
            --radius: 16px; --radius-sm: 10px;
            --shadow-sm: 0 2px 12px rgba(0,0,0,0.5);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.6);
            --shadow-lg: 0 20px 56px rgba(0,0,0,0.7);
        }
        body { font-family: 'DM Sans', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.55; -webkit-font-smoothing: antialiased; }
        .main-header { position: sticky; top: 0; z-index: 200; background: rgba(8,8,8,0.92); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
        .header-content { display: flex; justify-content: space-between; align-items: center; padding: 0 48px; height: 72px; max-width: 1440px; margin: 0 auto; }
        .logo-wrapper { display: flex; align-items: center; gap: 8px; }
        .logo-img { height: 34px; width: auto; filter: brightness(0) invert(1); }
        .logo { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 22px; font-weight: 500; letter-spacing: 0.04em; color: var(--white); text-decoration: none; }
        .logo span { font-weight: 300; color: var(--text-muted); font-size: 18px; }
        .menu-toggle { display: none; background: none; border: 1px solid var(--border); color: var(--white); padding: 8px 16px; border-radius: var(--radius-sm); cursor: pointer; }
        .nav-menu { display: flex; gap: 40px; align-items: center; }
        .nav-menu a { text-decoration: none; font-size: 14px; font-weight: 400; color: var(--text-muted); transition: color 0.2s; }
        .nav-menu a:hover { color: var(--white); }
        .btn-nav-outline { padding: 8px 22px; border: 1px solid var(--border-hi); border-radius: var(--radius-sm); }
        .btn-nav-primary { padding: 9px 26px; background: var(--white); color: var(--bg) !important; border-radius: var(--radius-sm); font-weight: 500 !important; box-shadow: 0 0 20px rgba(255,255,255,0.08); }
        .btn-nav-primary:hover { background: #e8e8e8; transform: translateY(-1px); }
        /* Resto de estilos de index.php (hero, features, etc.)... */
        .hero { min-height: 90vh; display: flex; align-items: center; padding: 0 48px; max-width: 1440px; margin: 0 auto; gap: 60px; }
        .hero-text { flex: 1; }
        .hero-badge { display: inline-block; font-size: 11px; font-weight: 500; letter-spacing: 3px; text-transform: uppercase; color: var(--text-muted); background: rgba(255,255,255,0.04); padding: 6px 14px; border-radius: 4px; margin-bottom: 28px; }
        .hero-text h1 { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 64px; font-weight: 400; line-height: 1.12; color: var(--white); margin-bottom: 24px; }
        .hero-text h1 em { font-style: italic; color: rgba(255,255,255,0.85); }
        .hero-desc { font-size: 16px; color: var(--text-muted); max-width: 480px; margin-bottom: 40px; line-height: 1.7; }
        .hero-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
        .btn-primary { display: inline-block; padding: 14px 36px; background: var(--white); color: var(--bg); text-decoration: none; border-radius: var(--radius-sm); font-weight: 500; transition: all 0.2s; box-shadow: 0 4px 20px rgba(255,255,255,0.1); }
        .btn-primary:hover { background: #e0e0e0; transform: translateY(-2px); }
        .btn-secondary { display: inline-block; padding: 14px 36px; background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); color: var(--white); text-decoration: none; border-radius: var(--radius-sm); font-weight: 400; border: 1px solid var(--border-hi); transition: all 0.2s; }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); transform: translateY(-2px); }
        .hero-carousel { flex: 1; position: relative; min-height: 500px; border-radius: 24px; overflow: hidden; background: var(--surface); border: 1px solid var(--border); box-shadow: var(--shadow-lg); }
        .carousel-container { position: relative; width: 100%; height: 100%; min-height: 500px; }
        .carousel-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1); pointer-events: none; }
        .carousel-slide.active { opacity: 1; pointer-events: auto; }
        .carousel-image { width: 100%; height: 100%; object-fit: cover; }
        .carousel-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #1a1a1a, #0a0a0a); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px; color: var(--text-muted); }
        .carousel-placeholder .color-preview { display: flex; gap: 12px; margin-top: 16px; }
        .carousel-placeholder .color-circle { width: 40px; height: 40px; border-radius: 50%; }
        .carousel-caption { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); padding: 40px 24px 24px; color: white; }
        .carousel-caption h3 { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 500; margin-bottom: 4px; }
        .carousel-caption p { font-size: 13px; opacity: 0.7; }
        .carousel-indicators { position: absolute; bottom: 20px; right: 24px; display: flex; gap: 8px; z-index: 10; }
        .indicator { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.3); cursor: pointer; transition: all 0.3s; }
        .indicator.active { background: var(--white); width: 24px; border-radius: 4px; }
        .stats-bar { background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 0 48px; }
        .stats-inner { max-width: 1440px; margin: 0 auto; display: flex; justify-content: space-between; }
        .stat-item { flex: 1; padding: 40px 24px; text-align: center; border-right: 1px solid var(--border); }
        .stat-item:last-child { border-right: none; }
        .stat-number { font-family: 'Cormorant Garamond', serif; font-size: 40px; font-weight: 500; color: var(--white); margin-bottom: 8px; }
        .stat-label { font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-dim); }
        .features { padding: 100px 48px; max-width: 1440px; margin: 0 auto; }
        .section-header { text-align: center; margin-bottom: 64px; }
        .section-label { font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 16px; }
        .section-title { font-family: 'Cormorant Garamond', serif; font-size: 44px; font-weight: 400; color: var(--white); }
        .features-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px; background: var(--border); border-radius: 20px; overflow: hidden; }
        .feature-card { background: var(--surface); padding: 48px 32px; transition: background 0.3s; position: relative; overflow: hidden; }
        .feature-card:hover { background: var(--surface2); }
        .feature-image { width: 100%; height: 160px; background: var(--surface2); border-radius: 12px; margin-bottom: 24px; overflow: hidden; position: relative; }
        .feature-image::before { content: ''; position: absolute; top: 50%; left: 50%; width: 140%; height: 140%; transform: translate(-50%, -50%); background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; pointer-events: none; z-index: 1; transition: all 0.3s ease; }
        .feature-card:hover .feature-image::before { background: radial-gradient(circle, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0) 70%); }
        .feature-img { width: 100%; height: 100%; object-fit: cover; position: relative; z-index: 2; filter: brightness(0.92) contrast(1.05); transition: all 0.3s ease; }
        .feature-card:hover .feature-img { filter: brightness(1.05) contrast(1.1); transform: scale(1.02); }
        .feature-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 500; margin-bottom: 12px; color: var(--white); }
        .feature-card p { font-size: 13px; color: var(--text-muted); line-height: 1.6; }
        .escaparates-section { padding: 80px 48px; background: var(--surface); border-top: 1px solid var(--border); }
        .escaparates-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; max-width: 1440px; margin: 0 auto; }
        .escaparate-card { background: var(--bg); border: 1px solid var(--border); border-radius: 20px; overflow: hidden; transition: all 0.3s; cursor: pointer; }
        .escaparate-card:hover { transform: translateY(-6px); border-color: var(--border-hi); box-shadow: var(--shadow-lg); }
        .escaparate-preview { height: 160px; background: linear-gradient(135deg, var(--surface2), var(--surface)); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--border); }
        .escaparate-colors { display: flex; gap: 12px; }
        .escaparate-color { width: 40px; height: 40px; border-radius: 8px; }
        .escaparate-info { padding: 24px; }
        .escaparate-info h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--white); }
        .escaparate-info p { font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 16px; }
        .escaparate-tag { display: inline-block; font-size: 11px; color: var(--text-dim); background: var(--surface2); padding: 4px 12px; border-radius: 20px; }
        .btn-visitar { display: block; width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-hi); border-radius: var(--radius-sm); color: var(--white); text-align: center; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; margin-top: 16px; cursor: pointer; }
        .btn-visitar:hover { background: var(--white); color: var(--bg); border-color: var(--white); }
        .footer { background: var(--bg); padding: 64px 48px 40px; border-top: 1px solid var(--border); text-align: center; }
        .footer-logo { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: var(--white); text-decoration: none; display: inline-block; margin-bottom: 24px; }
        .footer-logo span { color: var(--text-muted); font-weight: 300; }
        .footer-copy { font-size: 12px; color: var(--text-dim); }
        @media (max-width: 1200px) { .features-grid { grid-template-columns: repeat(2, 1fr); } .escaparates-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 1024px) { .hero { flex-direction: column; padding: 60px 32px; gap: 48px; } .hero-text { text-align: center; } .hero-text h1 { font-size: 52px; } .hero-desc { margin-left: auto; margin-right: auto; } .hero-buttons { justify-content: center; } }
        @media (max-width: 900px) { .features-grid { grid-template-columns: 1fr; gap: 1px; } .stats-inner { flex-wrap: wrap; } .stat-item { min-width: 140px; border-right: none; border-bottom: 1px solid var(--border); } .stat-item:last-child { border-bottom: none; } .escaparates-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .header-content { padding: 0 20px; } .menu-toggle { display: block; } .nav-menu { display: none; position: absolute; top: 72px; left: 0; right: 0; background: rgba(8,8,8,0.98); backdrop-filter: blur(24px); flex-direction: column; padding: 28px; gap: 20px; border-bottom: 1px solid var(--border); } .nav-menu.active { display: flex; } .hero { padding: 40px 20px; } .hero-text h1 { font-size: 40px; } .features { padding: 60px 20px; } .escaparates-section { padding: 60px 20px; } .footer { padding: 48px 20px 32px; } .hero-carousel { min-height: 380px; } .carousel-container { min-height: 380px; } }
        @media (min-width: 769px) { .nav-menu { display: flex !important; } }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <div class="logo-wrapper">
                <img src="assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
                <a href="index.php" class="logo">JACHA<span>market</span></a>
            </div>
            <button class="menu-toggle" id="menuToggle">☰</button>
            <nav class="nav-menu" id="navMenu">
                <a href="index.php">Inicio</a>
                <a href="db_demo.php" class="btn-nav-outline">Demostración BD</a>
                <a href="plantillas_disponibles.php">Plantillas</a>
                <?php if ($isLoggedIn): ?>
                    <a href="dashboard_principal.php">Mi panel</a>
                    <a href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn-nav-outline">Iniciar sesión</a>
                    <a href="registro.php" class="btn-nav-primary">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero section -->
        <section class="hero">
            <div class="hero-text">
                <span class="hero-badge">Bolivia · 2026</span>
                <h1>Potencia tu <em>emprendimiento</em><br>en el mundo digital</h1>
                <p class="hero-desc">
                    La plataforma que conecta el talento boliviano con clientes de todo el país.
                    Crea tu tienda online, gestiona tus ventas y haz crecer tu negocio.
                </p>
                <div class="hero-buttons">
                    <?php if (!$isLoggedIn): ?>
                        <a href="registro.php" class="btn-primary">Comenzar ahora</a>
                        <a href="#escaparates" class="btn-secondary">Explorar negocios</a>
                    <?php else: ?>
                        <a href="dashboard_principal.php" class="btn-primary">Ir a mi panel</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="hero-carousel">
                <div class="carousel-container" id="carouselContainer">
                    <?php foreach ($ambientes as $index => $ambiente): ?>
                    <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                        <?php
                        $imgPath = "assets/images/ambiente_" . strtolower($ambiente['nombre']) . ".jpg";
                        $fallbackPath = "assets/images/ambiente_" . strtolower($ambiente['nombre']) . ".png";
                        if (file_exists($imgPath) || file_exists($fallbackPath)):
                        ?>
                            <img src="<?php echo file_exists($imgPath) ? $imgPath : $fallbackPath; ?>" alt="<?php echo htmlspecialchars($ambiente['nombre']); ?>" class="carousel-image">
                        <?php else: ?>
                            <div class="carousel-placeholder">
                                <div class="color-preview">
                                    <div class="color-circle" style="background: <?php echo $ambiente['color_primario']; ?>;"></div>
                                    <div class="color-circle" style="background: <?php echo $ambiente['color_secundario']; ?>;"></div>
                                </div>
                                <p style="font-size: 12px;"><?php echo htmlspecialchars($ambiente['descripcion']); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="carousel-caption">
                            <h3><?php echo htmlspecialchars($ambiente['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($ambiente['descripcion']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-indicators" id="carouselIndicators">
                    <?php foreach ($ambientes as $index => $ambiente): ?>
                    <div class="indicator <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Stats bar -->
        <div class="stats-bar">
            <div class="stats-inner">
                <div class="stat-item"><div class="stat-number">+500</div><div class="stat-label">Emprendedores</div></div>
                <div class="stat-item"><div class="stat-number">+2.4k</div><div class="stat-label">Productos</div></div>
                <div class="stat-item"><div class="stat-number">9</div><div class="stat-label">Departamentos</div></div>
                <div class="stat-item"><div class="stat-number">Bolivia</div><div class="stat-label">Mercado nacional</div></div>
            </div>
        </div>

        <!-- Features -->
        <section class="features">
            <div class="section-header">
                <div class="section-label">Plataforma</div>
                <?php if ($isCliente): ?>
                    <h2 class="section-title">Descubre, explora<br>y adquiere productos únicos</h2>
                <?php elseif ($isVendedor): ?>
                    <h2 class="section-title">Gestiona, personaliza<br>y haz crecer tu negocio</h2>
                <?php else: ?>
                    <h2 class="section-title">Construye tu identidad<br>digital con nuestras plantillas</h2>
                <?php endif; ?>
            </div>
            <div class="features-grid">
                <?php if ($isCliente): ?>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_1.png" alt="Descubre productos" class="feature-img" onerror="this.style.display='none'"></div><h3>Descubre nuevos productos</h3><p>Explora un catálogo diverso de emprendimientos bolivianos.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_2.png" alt="Compra segura" class="feature-img" onerror="this.style.display='none'"></div><h3>Compra con confianza</h3><p>Proceso de pago simple y seguimiento de tus pedidos.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_3.png" alt="Apoya lo local" class="feature-img" onerror="this.style.display='none'"></div><h3>Apoya el talento local</h3><p>Cada compra contribuye al crecimiento de emprendedores.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_4.png" alt="Seguimiento" class="feature-img" onerror="this.style.display='none'"></div><h3>Sigue tus negocios favoritos</h3><p>Organiza los emprendimientos que te interesan.</p></div>
                <?php elseif ($isVendedor): ?>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_1.png" alt="Tu tienda" class="feature-img" onerror="this.style.display='none'"></div><h3>Crea tu tienda online</h3><p>Configura tu espacio de venta en minutos.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_2.png" alt="Inventario" class="feature-img" onerror="this.style.display='none'"></div><h3>Administra tu inventario</h3><p>Controla stock y organiza tus ventas.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_3.png" alt="Entregas" class="feature-img" onerror="this.style.display='none'"></div><h3>Coordina tus entregas</h3><p>Gestiona envíos y mantén informados a tus clientes.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_4.png" alt="Análisis" class="feature-img" onerror="this.style.display='none'"></div><h3>Analiza tu rendimiento</h3><p>Visualiza ventas y toma decisiones informadas.</p></div>
                <?php else: ?>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_1.png" alt="Ambientes" class="feature-img" onerror="this.style.display='none'"></div><h3>Crea el ambiente de tu negocio</h3><p>Selecciona la plantilla que mejor refleje tu marca.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_2.png" alt="Personalización" class="feature-img" onerror="this.style.display='none'"></div><h3>Personalización total</h3><p>Cambia colores, tipografías y sube tu logo.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_3.png" alt="URL pública" class="feature-img" onerror="this.style.display='none'"></div><h3>URL pública única</h3><p>Comparte tu tienda en redes sociales.</p></div>
                    <div class="feature-card"><div class="feature-image"><img src="assets/images/vent_4.png" alt="Seguimiento" class="feature-img" onerror="this.style.display='none'"></div><h3>Conecta con tus clientes</h3><p>Construye una comunidad fiel alrededor de tu marca.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Escaparates -->
        <section class="escaparates-section" id="escaparates">
            <div class="section-header">
                <div class="section-label">Inspiración</div>
                <h2 class="section-title">Escaparates destacados</h2>
                <p style="color: var(--text-muted); max-width: 600px; margin: 16px auto 0; font-size: 14px;">Descubre negocios creados por emprendedores bolivianos</p>
            </div>
            <div class="escaparates-grid">
                <?php if (count($escaparates) > 0): ?>
                    <?php foreach ($escaparates as $escaparate): ?>
                    <div class="escaparate-card" data-id="<?php echo $escaparate['id_emprendimiento']; ?>" data-nombre="<?php echo htmlspecialchars($escaparate['nombre_comercial']); ?>">
                        <div class="escaparate-preview"><div class="escaparate-colors"><div class="escaparate-color" style="background: <?php echo $escaparate['color_primario']; ?>;"></div><div class="escaparate-color" style="background: <?php echo $escaparate['color_secundario']; ?>;"></div></div></div>
                        <div class="escaparate-info"><h3><?php echo htmlspecialchars($escaparate['nombre_comercial']); ?></h3><p><?php echo htmlspecialchars(substr($escaparate['descripcion'], 0, 80)) . '...'; ?></p><span class="escaparate-tag">Plantilla <?php echo htmlspecialchars($escaparate['plantilla_nombre']); ?></span><div class="btn-visitar">Ver escaparate</div></div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; grid-column: 1/-1; padding: 60px; color: var(--text-dim);"><p>Próximamente, nuevos negocios</p></div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <a href="index.php" class="footer-logo">JACHA<span>market</span></a>
        <p class="footer-copy">© 2026 Jacha Marketplace - Potenciando emprendimientos bolivianos</p>
    </footer>

    <div class="modal" id="authModal"><div class="modal-content"><span class="close-modal" onclick="cerrarAuthModal()">&times;</span><h3>Descubre este negocio</h3><p>Para visualizar los escaparates, necesitas iniciar sesión.</p><div class="modal-buttons"><a href="login.php" class="modal-btn modal-btn-primary">Iniciar sesión</a><a href="registro.php" class="modal-btn modal-btn-secondary">Crear cuenta</a></div></div></div>

    <script>
        // Carrusel
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.indicator');
        let currentIndex = 0, interval;
        function showSlide(index) { slides.forEach((s,i)=>s.classList.toggle('active',i===index)); indicators.forEach((ind,i)=>ind.classList.toggle('active',i===index)); currentIndex=index; }
        function nextSlide() { showSlide((currentIndex+1)%slides.length); }
        function startCarousel() { if(interval) clearInterval(interval); interval = setInterval(nextSlide,5000); }
        indicators.forEach(i=>i.addEventListener('click',()=>{ showSlide(parseInt(i.getAttribute('data-index'))); startCarousel(); }));
        if(slides.length>0) startCarousel();
        
        // Menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        if(menuToggle) menuToggle.addEventListener('click',()=>navMenu.classList.toggle('active'));
        document.querySelectorAll('.nav-menu a').forEach(l=>l.addEventListener('click',()=>{if(window.innerWidth<=768)navMenu.classList.remove('active');}));
        
        // Modal escaparatas
        const authModal = document.getElementById('authModal');
        const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        function handleEscaparateClick(e){
            let card = e.target.closest('.escaparate-card');
            if(!card) return;
            const id = card.getAttribute('data-id');
            if(!id) return;
            if(!isLoggedIn){
                authModal.classList.add('active');
                return;
            }
            window.location.href = 'tienda.php?id=' + id;
        }
        document.querySelectorAll('.escaparate-card').forEach(c=>c.addEventListener('click',handleEscaparateClick));
        function cerrarAuthModal(){ authModal.classList.remove('active'); }
        window.onclick = function(e){ if(e.target === authModal) cerrarAuthModal(); }
    </script>
</body>
</html>