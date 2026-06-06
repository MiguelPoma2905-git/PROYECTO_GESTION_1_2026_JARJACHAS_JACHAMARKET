<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($plantilla['nombre']) ?> - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .page-wrap { max-width:1000px; margin:0 auto; padding:32px 20px; }

        .top-line { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
        .top-line .logo img { height:30px; width:auto; opacity:0.85; }
        .top-line .back-link { font-size:13px; color:var(--text-muted); text-decoration:none; display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:3px; background:var(--card-bg); border:1px solid var(--border); }
        .top-line .back-link:hover { color:var(--text); border-color:var(--border-hi); }

        .hero-img {
            width:100%; height:360px; border-radius:4px; overflow:hidden;
            position:relative; margin-bottom:32px;
        }
        .hero-img img { width:100%; height:100%; object-fit:cover; }
        .hero-img .overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%); }
        .hero-img .badge { position:absolute; top:20px; left:20px; background:rgba(0,0,0,0.5); padding:6px 14px; border-radius:3px; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#fff; }

        .content-grid { display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-bottom:28px; }
        .content-grid .full { grid-column:1/-1; }

        .panel { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:28px; }
        .panel h3 { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-dim); margin-bottom:16px; display:flex; align-items:center; gap:8px; }
        .panel h1 { font-family:Georgia,var(--font-serif); font-size:28px; font-weight:400; color:var(--text); margin-bottom:8px; }
        .panel .desc { font-size:13px; color:var(--text-dim); line-height:1.7; }

        .color-blocks { display:flex; gap:16px; flex-wrap:wrap; }
        .color-blocks .cb { display:flex; align-items:center; gap:10px; font-size:12px; color:var(--text); }
        .color-blocks .cb .swatch { width:36px; height:36px; border-radius:3px; border:1px solid var(--border); }
        .color-blocks .cb .cl { font-size:10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.3px; }
        .color-blocks .cb .cv { font-family:monospace; font-size:11px; color:var(--text-muted); }

        .feat-list { display:flex; flex-direction:column; gap:10px; }
        .feat-list .fi { display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-muted); padding:4px 0; }
        .feat-list .fi i { width:18px; text-align:center; font-size:13px; color:var(--text-muted); }

        .rubro-tag { display:inline-flex; align-items:center; gap:6px; background:rgba(128,128,128,0.06); border:1px solid var(--border); color:var(--text-muted); padding:6px 14px; border-radius:3px; font-size:12px; font-weight:500; margin-bottom:16px; }

        .action-btns { display:flex; gap:12px; margin-top:8px; }
        .btn-primary { flex:1; padding:14px 24px; background:var(--text); color:var(--bg); border:none; border-radius:4px; font-size:14px; font-weight:600; cursor:pointer; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; font-family:var(--font-sans); }
        .btn-secondary { padding:14px 24px; background:transparent; border:1px solid var(--border); color:var(--text-muted); border-radius:4px; font-size:13px; font-weight:500; cursor:pointer; text-decoration:none; display:flex; align-items:center; gap:8px; font-family:var(--font-sans); }
        .btn-secondary:hover { color:var(--text); border-color:var(--border-hi); }

        .db-table { display:grid; grid-template-columns:1fr 1fr; gap:8px 24px; margin-top:8px; }
        .db-table .db-item { font-size:12px; color:var(--text-dim); }
        .db-table .db-item strong { color:var(--text-muted); font-weight:500; }
        .db-table .db-item i { margin-right:4px; }

        @media(max-width:768px){
            .content-grid{grid-template-columns:1fr;}
            .hero-img{height:200px;}
            .action-btns{flex-direction:column;}
            .db-table{grid-template-columns:1fr;}
        }
        [data-theme="light"] .logo img { filter:brightness(0); }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="top-line">
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
                1 => ['Rubro', 'Tiendas generales, negocios versatiles', '#C0392B'],
                2 => ['Rubro', 'Moda, ropa, accesorios elegantes', '#2C3E50'],
                3 => ['Rubro', 'Artesanias, decoracion, productos hechos a mano', '#8B4513'],
                4 => ['Rubro', 'Tecnologia, electronica, informatica', '#3498DB'],
                5 => ['Rubro', 'Restaurantes, cafeterias, comida', '#E67E22'],
                6 => ['Rubro', 'Electrodomesticos, hogar, tecnologia', '#1A3A5C'],
                7 => ['Rubro', 'Ropa, calzado, accesorios de moda', '#D4A5A5'],
                8 => ['Rubro', 'Restaurantes, cafeterias, negocios de comida', '#E67E22'],
                9 => ['Rubro', 'Artesanias, decoracion, productos hechos a mano', '#8B6914'],
                10 => ['Rubro', 'Belleza, cosmeticos, cuidado personal', '#9B59B6'],
                11 => ['Rubro', 'Deportes, fitness, vida saludable', '#2ECC71'],
                12 => ['Rubro', 'Muebles, decoracion del hogar, regalos', '#7BAE7F'],
            ];
            $rubro = $rubros[$pid] ?? ['Rubro', 'General', '#6c8cff'];

            $featuresByPid = [
                6 => [
                    ['icon' => 'fa-moon', 'text' => 'Tema oscuro inmersivo'],
                    ['icon' => 'fa-shopping-cart', 'text' => 'Carrito de compras completo'],
                    ['icon' => 'fa-images', 'text' => 'Galeria de imagenes con lightbox'],
                    ['icon' => 'fa-balance-scale', 'text' => 'Comparacion de productos'],
                    ['icon' => 'fa-heart', 'text' => 'Lista de deseos (wishlist)'],
                    ['icon' => 'fa-sliders-h', 'text' => 'Filtros avanzados por marca y precio'],
                    ['icon' => 'fa-question-circle', 'text' => 'Seccion de preguntas frecuentes (FAQ)'],
                    ['icon' => 'fa-whatsapp', 'text' => 'Boton directo a WhatsApp'],
                ],
                4 => [
                    ['icon' => 'fa-sun', 'text' => 'Diseno claro y moderno'],
                    ['icon' => 'fa-bolt', 'text' => 'Compra rapida en 1 clic'],
                    ['icon' => 'fa-palette', 'text' => 'Gradientes y sombras profesionales'],
                    ['icon' => 'fa-th-large', 'text' => 'Grid adaptable de productos'],
                    ['icon' => 'fa-mobile-alt', 'text' => 'Totalmente responsive'],
                ],
                7 => [
                    ['icon' => 'fa-tshirt', 'text' => 'Diseno elegante para moda'],
                    ['icon' => 'fa-bolt', 'text' => 'Compra rapida en 1 clic'],
                    ['icon' => 'fa-camera', 'text' => 'Galeria de productos destacada'],
                    ['icon' => 'fa-heart', 'text' => 'Lista de deseos'],
                    ['icon' => 'fa-mobile-alt', 'text' => 'Adaptable a moviles'],
                ],
            ];
            $features = $featuresByPid[$pid] ?? [
                ['icon' => 'fa-paint-brush', 'text' => 'Diseno profesional y unico'],
                ['icon' => 'fa-bolt', 'text' => 'Compra rapida en 1 clic'],
                ['icon' => 'fa-cog', 'text' => 'Altamente personalizable'],
                ['icon' => 'fa-mobile-alt', 'text' => 'Adaptable a dispositivos moviles'],
            ];
            ?>
            <div class="panel">
                <h3><i class="fas fa-tag"></i> Informacion</h3>
                <div class="rubro-tag"><i class="fas fa-store"></i> <?= $rubro[0] ?>: <?= $rubro[1] ?></div>
                <div class="desc" style="margin-bottom:16px">
                    <strong style="color:var(--text)">Tipografia por defecto:</strong><br>
                    <span style="font-size:18px;font-weight:500;display:block;margin:8px 0">Inter</span>
                    <span style="font-size:12px;color:var(--text-dim)">Sistema sans-serif moderna, legible en todos los tamanos</span>
                </div>
                <div class="desc">
                    <strong style="color:var(--text)">Modo visual:</strong><br>
                    <span style="font-size:13px;color:var(--text-dim)">
                        <?php
                        echo match($pid) {
                            6 => 'Oscuro (dark mode)',
                            4 => 'Claro tecnologico',
                            default => 'Claro clasico'
                        };
                        ?>
                    </span>
                </div>
            </div>
            <div class="panel">
                <h3><i class="fas fa-star"></i> Caracteristicas</h3>
                <div class="feat-list">
                    <?php foreach ($features as $f): ?>
                    <div class="fi">
                        <i class="fas <?= $f['icon'] ?>"></i>
                        <span><?= $f['text'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="panel full">
                <h3><i class="fas fa-database"></i> Datos que se guardan en la base de datos</h3>
                <div class="db-table">
                    <div class="db-item"><strong><i class="fas fa-store"></i> emprendimientos</strong><br>nombre_comercial, nit, telefono, descripcion</div>
                    <div class="db-item"><strong><i class="fas fa-palette"></i> personalizacion_emprendimiento</strong><br>colores, tipografia, modo_oscuro, faqs</div>
                    <div class="db-item"><strong><i class="fas fa-map-pin"></i> sucursales</strong><br>direccion, ciudad</div>
                    <div class="db-item"><strong><i class="fas fa-box"></i> productos</strong><br>nombre, precio, stock, atributos, imagenes</div>
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
                <i class="fas fa-sign-in-alt"></i> Iniciar sesion para usar
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

    <script>
        (function(){
            var theme = localStorage.getItem('jacha_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</body>
</html>