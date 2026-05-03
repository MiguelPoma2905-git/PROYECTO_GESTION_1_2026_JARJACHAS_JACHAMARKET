<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$usuario = $_SESSION['usuario'] ?? null;
$isLoggedIn = $usuario !== null;

$db = getDB();
$stmt = $db->prepare("SELECT id_plantilla, nombre, descripcion, color_primario, color_secundario FROM plantillas WHERE activo = 1");
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
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #080808;
            --surface: #101010;
            --surface2: #141414;
            --border: rgba(255,255,255,0.07);
            --border-hi: rgba(255,255,255,0.14);
            --text: #ebebeb;
            --text-muted: #888;
            --text-dim: #555;
            --white: #ffffff;
            --glow: rgba(255,255,255,0.06);
            --radius: 16px;
            --radius-sm: 10px;
            --shadow-sm: 0 2px 12px rgba(0,0,0,0.5);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.6);
            --shadow-lg: 0 20px 56px rgba(0,0,0,0.7);
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        .main-header {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(8,8,8,0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 48px;
            height: 72px;
            max-width: 1440px;
            margin: 0 auto;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-img {
            height: 34px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .logo {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 22px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--white);
            text-decoration: none;
        }

        .logo span {
            font-weight: 300;
            color: var(--text-muted);
            font-size: 18px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            color: var(--white);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            cursor: pointer;
        }

        .nav-menu {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .nav-menu a:hover {
            color: var(--white);
        }

        .btn-nav-outline {
            padding: 8px 22px;
            border: 1px solid var(--border-hi);
            border-radius: var(--radius-sm);
        }

        .btn-nav-primary {
            padding: 9px 26px;
            background: var(--white);
            color: var(--bg) !important;
            border-radius: var(--radius-sm);
            font-weight: 500 !important;
            box-shadow: 0 0 20px rgba(255,255,255,0.08);
        }

        /* Hero de página */
        .page-hero {
            padding: 80px 48px 40px;
            text-align: center;
            max-width: 1440px;
            margin: 0 auto;
        }

        .page-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 400;
            color: var(--white);
            margin-bottom: 16px;
        }

        .page-hero p {
            font-size: 16px;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Grid de plantillas */
        .plantillas-section {
            padding: 40px 48px 100px;
            max-width: 1440px;
            margin: 0 auto;
        }

        .plantillas-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .plantilla-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .plantilla-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hi);
            box-shadow: var(--shadow-lg);
        }

        .plantilla-preview {
            height: 200px;
            background: linear-gradient(135deg, var(--surface2), var(--surface));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 1px solid var(--border);
        }

        .color-swatches {
            display: flex;
            gap: 12px;
        }

        .color-swatch {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .plantilla-info {
            padding: 24px;
        }

        .plantilla-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--white);
        }

        .plantilla-info p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-elegir {
            display: block;
            width: 100%;
            padding: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-hi);
            border-radius: var(--radius-sm);
            color: var(--white);
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-elegir:hover {
            background: var(--white);
            color: var(--bg);
            border-color: var(--white);
        }

        /* Modal para login/registro */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--surface);
            border: 1px solid var(--border-hi);
            border-radius: 24px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-lg);
        }

        .modal-content h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            margin-bottom: 16px;
            color: var(--white);
        }

        .modal-content p {
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .modal-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .modal-btn {
            padding: 12px 24px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .modal-btn-primary {
            background: var(--white);
            color: var(--bg);
        }

        .modal-btn-primary:hover {
            background: #e0e0e0;
        }

        .modal-btn-secondary {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-hi);
            color: var(--white);
        }

        .modal-btn-secondary:hover {
            background: rgba(255,255,255,0.1);
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .close-modal:hover {
            color: var(--white);
        }

        .footer {
            background: var(--bg);
            padding: 64px 48px 40px;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .footer-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            color: var(--white);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 24px;
        }

        .footer-logo span {
            color: var(--text-muted);
            font-weight: 300;
        }

        .footer-copy {
            font-size: 12px;
            color: var(--text-dim);
        }

        @media (max-width: 1024px) {
            .plantillas-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .page-hero {
                padding: 60px 32px 30px;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 0 20px;
            }
            .menu-toggle {
                display: block;
            }
            .nav-menu {
                display: none;
                position: absolute;
                top: 72px;
                left: 0;
                right: 0;
                background: rgba(8,8,8,0.98);
                backdrop-filter: blur(24px);
                flex-direction: column;
                padding: 28px;
                gap: 20px;
                border-bottom: 1px solid var(--border);
            }
            .nav-menu.active {
                display: flex;
            }
            .plantillas-section {
                padding: 40px 20px 80px;
            }
            .plantillas-grid {
                grid-template-columns: 1fr;
            }
            .page-hero h1 {
                font-size: 36px;
            }
            .modal-buttons {
                flex-direction: column;
            }
        }

        @media (min-width: 769px) {
            .nav-menu {
                display: flex !important;
            }
        }
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
                <a href="plantillas_disponibles.php" class="btn-nav-outline">Plantillas</a>
                <?php if ($isLoggedIn): ?>
                    <a href="dashboard_vendedor.php">Mi tienda</a>
                    <a href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn-nav-outline">Iniciar sesión</a>
                    <a href="registro.php" class="btn-nav-primary">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <h1>Elige la plantilla de tu negocio</h1>
            <p>Selecciona el ambiente que mejor represente la esencia de tu emprendimiento. Cada plantilla está diseñada para adaptarse a tu marca.</p>
        </section>

        <section class="plantillas-section">
            <div class="plantillas-grid">
                <?php foreach ($plantillas as $plantilla): ?>
                <div class="plantilla-card">
                    <div class="plantilla-preview">
                        <div class="color-swatches">
                            <div class="color-swatch" style="background: <?php echo $plantilla['color_primario']; ?>;"></div>
                            <div class="color-swatch" style="background: <?php echo $plantilla['color_secundario']; ?>;"></div>
                        </div>
                    </div>
                    <div class="plantilla-info">
                        <h3><?php echo htmlspecialchars($plantilla['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($plantilla['descripcion']); ?></p>
                        <button class="btn-elegir" onclick="mostrarModal(<?php echo $plantilla['id_plantilla']; ?>, '<?php echo htmlspecialchars($plantilla['nombre']); ?>')">Elegir esta plantilla</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Modal para usuarios no logueados -->
    <div class="modal" id="authModal">
        <div class="modal-content">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h3>Personaliza tu tienda</h3>
            <p>Para elegir y personalizar esta plantilla, necesitas tener una cuenta. Es rápido y gratuito.</p>
            <div class="modal-buttons">
                <a href="login.php" class="modal-btn modal-btn-primary">Iniciar sesión</a>
                <a href="registro.php" class="modal-btn modal-btn-secondary">Crear cuenta</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <a href="index.php" class="footer-logo">JACHA<span>market</span></a>
        <p class="footer-copy">© 2026 Jacha Marketplace - Potenciando emprendimientos bolivianos</p>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        const modal = document.getElementById('authModal');
        let selectedPlantillaId = null;
        let selectedPlantillaNombre = null;

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

        function mostrarModal(plantillaId, plantillaNombre) {
            <?php if (!$isLoggedIn): ?>
                selectedPlantillaId = plantillaId;
                selectedPlantillaNombre = plantillaNombre;
                modal.classList.add('active');
            <?php else: ?>
                window.location.href = 'plantillas.php?plantilla=' + plantillaId;
            <?php endif; ?>
        }

        function cerrarModal() {
            modal.classList.remove('active');
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                cerrarModal();
            }
        }
    </script>
</body>
</html>