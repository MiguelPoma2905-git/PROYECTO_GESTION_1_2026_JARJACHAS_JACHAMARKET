<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($plantilla['nombre']) ?> - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg, #0d0d0d);
            color: var(--text, #f0f0f0);
            min-height: 100vh;
        }
        .page-wrap { max-width: 1100px; margin: 0 auto; padding: 32px 20px; }
        .top-bar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 32px;
        }
        .top-bar .logo img { height: 30px; width: auto; opacity: 0.7; }
        .top-bar .back-link {
            font-size: 13px; color: var(--text-muted, #888);
            text-decoration: none; display: flex; align-items: center; gap: 6px;
            transition: color .2s;
        }
        .top-bar .back-link:hover { color: var(--text, #f0f0f0); }

        .hero-img {
            width: 100%; height: 360px; border-radius: 24px; overflow: hidden;
            position: relative; margin-bottom: 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .hero-img img { width: 100%; height: 100%; object-fit: cover; }
        .hero-img .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
        }
        .hero-img .badge {
            position: absolute; top: 24px; left: 24px;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(8px);
            padding: 6px 16px; border-radius: 8px;
            font-size: 11px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: #fff;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 36px;
        }
        .content-grid .full { grid-column: 1 / -1; }

        .panel {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 20px; padding: 28px;
        }
        .panel h3 {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-muted, #888);
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .panel h1 {
            font-size: 28px; font-weight: 700; color: var(--text, #f0f0f0);
            margin-bottom: 8px;
        }
        .panel .desc {
            font-size: 14px; color: var(--text-muted, #888);
            line-height: 1.7;
        }

        .color-blocks { display: flex; gap: 12px; flex-wrap: wrap; }
        .color-blocks .cb {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: var(--text, #f0f0f0);
        }
        .color-blocks .cb .swatch {
            width: 36px; height: 36px; border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .color-blocks .cb .cl { opacity: 0.5; font-size: 11px; }
        .color-blocks .cb .cv { font-family: monospace; font-size: 11px; opacity: 0.7; }

        .feat-list { display: flex; flex-direction: column; gap: 10px; }
        .feat-list .fi {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: var(--text, #f0f0f0);
            padding: 4px 0;
        }
        .feat-list .fi i { width: 18px; text-align: center; font-size: 14px; }

        .rubro-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(108,140,255,0.1); border: 1px solid rgba(108,140,255,0.15);
            color: #6c8cff; padding: 6px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 500; margin-bottom: 16px;
        }

        .action-btns { display: flex; gap: 16px; margin-top: 8px; }
        .btn-primary {
            flex: 1; padding: 16px 24px;
            background: linear-gradient(135deg, #6c8cff, #5a7ae8);
            color: #fff; border: none; border-radius: 14px;
            font-size: 15px; font-weight: 600; cursor: pointer;
            transition: all .25s; text-align: center; text-decoration: none;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108,140,255,0.25);
        }
        .btn-secondary {
            padding: 16px 24px;
            background: rgba(255,255,255,0.04); border: 1px solid var(--border, rgba(255,255,255,0.06));
            color: var(--text, #f0f0f0); border-radius: 14px;
            font-size: 14px; font-weight: 500; cursor: pointer;
            transition: all .25s; text-decoration: none;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.08);
        }

        @media (max-width: 768px) {
            .content-grid { grid-template-columns: 1fr; }
            .hero-img { height: 240px; }
            .action-btns { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="top-bar">
            <a href="<?= BASE_URL ?>" class="logo">
                <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha">
            </a>
            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="back-link">
                <i class="fas fa-arrow-left"></i> Todas las plantillas
            </a>
        </div>

        <div class="hero-img">
            <img src="<?= BASE_URL ?>/assets/images/plantillas/plantilla_<?= $plantilla['id_plantilla'] ?>.jpg" alt="<?= htmlspecialchars($plantilla['nombre']) ?>">
            <div class="overlay"></div>
            <div class="badge"><?= htmlspecialchars($plantilla['nombre']) ?></div>
        </div>

        <div class="content-grid">
            <div class="panel">
                <h1><?= htmlspecialchars($plantilla['nombre']) ?></h1>
                <p class="desc"><?= htmlspecialchars($plantilla['descripcion'] ?? 'Plantilla profesional para tu negocio') ?></p>
            </div>
            <div class="panel">
                <h3><i class="fas fa-palette"></i> Colores de la plantilla</h3>
                <div class="color-blocks">
                    <div class="cb">
                        <div class="swatch" style="background:<?= $plantilla['color_primario'] ?>"></div>
                        <div><div class="cl">Primario</div><div class="cv"><?= $plantilla['color_primario'] ?></div></div>
                    </div>
                    <div class="cb">
                        <div class="swatch" style="background:<?= $plantilla['color_secundario'] ?>"></div>
                        <div><div class="cl">Secundario</div><div class="cv"><?= $plantilla['color_secundario'] ?></div></div>
                    </div>
                    <div class="cb">
                        <div class="swatch" style="background:<?= $plantilla['color_fondo'] ?? '#FDFBF7' ?>"></div>
                        <div><div class="cl">Fondo</div><div class="cv"><?= $plantilla['color_fondo'] ?? '#FDFBF7' ?></div></div>
                    </div>
                    <div class="cb">
                        <div class="swatch" style="background:<?= $plantilla['color_texto'] ?? '#2D2D2D' ?>"></div>
                        <div><div class="cl">Texto</div><div class="cv"><?= $plantilla['color_texto'] ?? '#2D2D2D' ?></div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <?php
            $pid = (int)$plantilla['id_plantilla'];
            $rubros = [
                1 => ['Rubro', 'Tiendas generales, negocios versátiles', '#C0392B'],
                2 => ['Rubro', 'Moda, ropa, accesorios elegantes', '#2C3E50'],
                3 => ['Rubro', 'Artesanías, decoración, productos hechos a mano', '#8B4513'],
                4 => ['Rubro', 'Tecnología, electrónica, informática', '#3498DB'],
                5 => ['Rubro', 'Restaurantes, cafeterías, comida', '#E67E22'],
                6 => ['Rubro', 'Electrodomésticos, hogar, tecnología', '#1A3A5C'],
                7 => ['Rubro', 'Ropa, calzado, accesorios de moda', '#D4A5A5'],
                8 => ['Rubro', 'Restaurantes, cafeterías, negocios de comida', '#E67E22'],
                9 => ['Rubro', 'Artesanías, decoración, productos hechos a mano', '#8B6914'],
                10 => ['Rubro', 'Belleza, cosméticos, cuidado personal', '#9B59B6'],
                11 => ['Rubro', 'Deportes, fitness, vida saludable', '#2ECC71'],
                12 => ['Rubro', 'Muebles, decoración del hogar, regalos', '#7BAE7F'],
            ];
            $rubro = $rubros[$pid] ?? ['Rubro', 'General', '#6c8cff'];

            $featuresByPid = [
                6 => [
                    ['icon' => 'fa-moon', 'text' => 'Tema oscuro inmersivo', 'color' => '#6c8cff'],
                    ['icon' => 'fa-shopping-cart', 'text' => 'Carrito de compras completo', 'color' => '#6c8cff'],
                    ['icon' => 'fa-images', 'text' => 'Galería de imágenes con lightbox', 'color' => '#6c8cff'],
                    ['icon' => 'fa-balance-scale', 'text' => 'Comparación de productos', 'color' => '#6c8cff'],
                    ['icon' => 'fa-heart', 'text' => 'Lista de deseos (wishlist)', 'color' => '#6c8cff'],
                    ['icon' => 'fa-sliders-h', 'text' => 'Filtros avanzados por marca y precio', 'color' => '#6c8cff'],
                    ['icon' => 'fa-question-circle', 'text' => 'Sección de preguntas frecuentes (FAQ)', 'color' => '#6c8cff'],
                    ['icon' => 'fa-whatsapp', 'text' => 'Botón directo a WhatsApp', 'color' => '#6c8cff'],
                ],
                4 => [
                    ['icon' => 'fa-sun', 'text' => 'Diseño claro y moderno', 'color' => '#3498DB'],
                    ['icon' => 'fa-bolt', 'text' => 'Compra rápida en 1 clic', 'color' => '#3498DB'],
                    ['icon' => 'fa-palette', 'text' => 'Gradientes y sombras profesionales', 'color' => '#3498DB'],
                    ['icon' => 'fa-th-large', 'text' => 'Grid adaptable de productos', 'color' => '#3498DB'],
                    ['icon' => 'fa-mobile-alt', 'text' => 'Totalmente responsive', 'color' => '#3498DB'],
                ],
                7 => [
                    ['icon' => 'fa-tshirt', 'text' => 'Diseño elegante para moda', 'color' => '#D4A5A5'],
                    ['icon' => 'fa-bolt', 'text' => 'Compra rápida en 1 clic', 'color' => '#D4A5A5'],
                    ['icon' => 'fa-camera', 'text' => 'Galería de productos destacada', 'color' => '#D4A5A5'],
                    ['icon' => 'fa-heart', 'text' => 'Lista de deseos', 'color' => '#D4A5A5'],
                    ['icon' => 'fa-mobile-alt', 'text' => 'Adaptable a móviles', 'color' => '#D4A5A5'],
                ],
            ];
            $features = $featuresByPid[$pid] ?? [
                ['icon' => 'fa-paint-brush', 'text' => 'Diseño profesional y único', 'color' => '#6c8cff'],
                ['icon' => 'fa-bolt', 'text' => 'Compra rápida en 1 clic', 'color' => '#6c8cff'],
                ['icon' => 'fa-cog', 'text' => 'Altamente personalizable', 'color' => '#6c8cff'],
                ['icon' => 'fa-mobile-alt', 'text' => 'Adaptable a dispositivos móviles', 'color' => '#6c8cff'],
            ];
            ?>
            <div class="panel">
                <h3><i class="fas fa-tag"></i> Informaci&oacute;n</h3>
                <div class="rubro-tag"><i class="fas fa-store"></i> <?= $rubro[0] ?>: <?= $rubro[1] ?></div>
                <div class="desc" style="margin-bottom:16px">
                    <strong style="color:var(--text)">Tipograf&iacute;a por defecto:</strong><br>
                    <span style="font-size:18px;font-weight:500;display:block;margin:8px 0">Inter</span>
                    <span style="font-size:12px;color:var(--text-muted,#888)">Sistema sans-serif moderna, legible en todos los tama&ntilde;os</span>
                </div>
                <div class="desc">
                    <strong style="color:var(--text)">Modo visual:</strong><br>
                    <span style="font-size:13px;color:var(--text-muted,#888)">
                        <?php
                        echo match($pid) {
                            6 => 'Oscuro (dark mode)',
                            4 => 'Claro tecnol&oacute;gico',
                            default => 'Claro cl&aacute;sico'
                        };
                        ?>
                    </span>
                </div>
            </div>
            <div class="panel">
                <h3><i class="fas fa-star"></i> Caracter&iacute;sticas</h3>
                <div class="feat-list">
                    <?php foreach ($features as $f): ?>
                    <div class="fi">
                        <i class="fas <?= $f['icon'] ?>" style="color:<?= $f['color'] ?>"></i>
                        <span><?= $f['text'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="panel full">
                <h3><i class="fas fa-database"></i> Datos que se guardan en la base de datos</h3>
                <div class="desc" style="display:grid;grid-template-columns:1fr 1fr;gap:8px 24px;margin-top:8px">
                    <div><span style="color:var(--text-muted,#888)"><i class="fas fa-store"></i> emprendimientos</span><br>nombre_comercial, nit, telefono, descripcion</div>
                    <div><span style="color:var(--text-muted,#888)"><i class="fas fa-palette"></i> personalizacion_emprendimiento</span><br>colores, tipografia, modo_oscuro, faqs</div>
                    <div><span style="color:var(--text-muted,#888)"><i class="fas fa-map-pin"></i> sucursales</span><br>direccion, ciudad</div>
                    <div><span style="color:var(--text-muted,#888)"><i class="fas fa-box"></i> productos</span><br>nombre, precio, stock, atributos, imagenes</div>
                </div>
            </div>
        </div>

        <div class="action-btns">
            <?php if ($is_vendedor): ?>
            <a href="<?= BASE_URL ?>/crear-negocio?plantilla=<?= $plantilla['id_plantilla'] ?>" class="btn-primary">
                <i class="fas fa-rocket"></i> Usar esta plantilla
            </a>
            <?php elseif (!$is_logged_in): ?>
            <a href="<?= BASE_URL ?>/login" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Iniciar sesi&oacute;n para usar
            </a>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/perfil" class="btn-primary">
                <i class="fas fa-user"></i> Obtener rol de emprendedor
            </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="btn-secondary">
                <i class="fas fa-th"></i> Ver todas las plantillas
            </a>
        </div>
    </div>
</body>
</html>