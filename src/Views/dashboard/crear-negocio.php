<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear negocio - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            padding: 32px 16px;
        }
        .page-wrap { max-width: 1100px; margin: 0 auto; }

        .top-bar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px;
        }
        .top-bar .logo img { height: 30px; width: auto; opacity: 0.7; }
        [data-theme="light"] .top-bar .logo img { filter: brightness(0); }
        .top-bar .back-link {
            font-size: 13px; color: var(--text-muted, #888);
            text-decoration: none; display: flex; align-items: center; gap: 6px;
            transition: color .2s;
        }
        .top-bar .back-link:hover { color: var(--text, #f0f0f0); }

        .main-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 28px;
            align-items: start;
        }

        .left-col { display: flex; flex-direction: column; gap: 20px; }

        .preview-card {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 4px;
            overflow: hidden;
        }
        .preview-card .card-hdr {
            padding: 18px 24px 14px;
            border-bottom: 1px solid var(--border, rgba(255,255,255,0.06));
            display: flex; align-items: center; justify-content: space-between;
        }
        .preview-card .card-hdr h3 {
            font-size: 13px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-muted, #888);
        }
        .preview-card .card-hdr span {
            font-size: 10px; color: var(--text-dim, #555);
            background: rgba(255,255,255,0.04);
            padding: 3px 10px; border-radius: 3px;
        }

        .plantilla-img {
            display: block; width: 100%; height: auto;
            border-bottom: 1px solid var(--border, rgba(255,255,255,0.06));
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .info-panel {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 4px;
            padding: 20px;
        }
        .info-panel h4 {
            font-size: 10px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-muted, #888);
            margin-bottom: 14px; display: flex; align-items: center; gap: 6px;
        }
        .color-list { display: flex; flex-direction: column; gap: 8px; }
        .color-row {
            display: flex; align-items: center; gap: 10px;
            font-size: 12px; color: var(--text, #f0f0f0);
        }
        .color-row .swatch {
            width: 28px; height: 28px; border-radius: 3px;
            border: 1px solid rgba(255,255,255,0.08); flex-shrink: 0;
        }
        .color-row .clabel { opacity: 0.5; min-width: 70px; font-size: 11px; }
        .color-row .cval { font-family: monospace; font-size: 11px; opacity: 0.7; }

        .font-display {
            font-size: 20px; font-weight: 500;
            padding: 8px 0 4px;
            letter-spacing: -0.3px;
        }
        .font-sub {
            font-size: 11px; color: var(--text-muted, #888); opacity: 0.6;
        }

        .features-list { display: flex; flex-direction: column; gap: 8px; }
        .feature-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 12px; color: var(--text, #f0f0f0); padding: 6px 0;
        }
        .feature-item i {
            width: 18px; text-align: center; font-size: 13px;
        }

        .form-card {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 4px;
            padding: 32px;
        }
        .form-card .hdr { margin-bottom: 28px; }
        .form-card .hdr h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px; font-weight: 700; color: var(--text, #f0f0f0);
            margin-bottom: 4px;
        }
        .form-card .hdr p { font-size: 13px; color: var(--text-muted, #888); }

        .form-group { margin-bottom: 18px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: block; font-size: 10px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
            color: var(--text-muted, #888); margin-bottom: 5px;
        }
        .form-group label .req { color: #9a5a5a; }
        .form-group .field {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 3px; transition: border-color .2s;
        }
        .form-group .field:focus-within {
            border-color: rgba(255,255,255,0.25);
        }
        .form-group .field i {
            padding: 0 0 0 13px; color: #555;
            font-size: 13px; opacity: 0.5;
        }
        .form-group .field input,
        .form-group .field textarea {
            width: 100%; background: none; border: none;
            padding: 12px 13px; font-size: 13px;
            color: var(--text, #f0f0f0); font-family: inherit; outline: none;
        }
        .form-group .field input::placeholder,
        .form-group .field textarea::placeholder { color: #555; }
        .form-group .field textarea { resize: vertical; min-height: 80px; }

        .portada-upload { margin-bottom:18px; }
        .portada-upload label { display:block;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted,#888);margin-bottom:8px; }
        .portada-upload .drop-zone { border:1.5px dashed rgba(255,255,255,0.12);border-radius:4px;padding:20px;text-align:center;cursor:pointer;transition:all .2s;background:rgba(255,255,255,0.02); }
        .portada-upload .drop-zone:hover { border-color:rgba(255,255,255,0.25);background:rgba(255,255,255,0.04); }
        .portada-upload .drop-zone i { font-size:28px;color:var(--text-muted,#888);margin-bottom:8px;opacity:0.4; }
        .portada-upload .drop-zone p { font-size:12px;color:var(--text-muted,#888); }
        .portada-upload .drop-zone small { font-size:10px;color:var(--text-dim,#555); }
        .portada-upload .portada-preview { display:none;margin-top:10px;border-radius:3px;overflow:hidden;position:relative;max-height:160px; }
        .portada-upload .portada-preview img { width:100%;height:140px;object-fit:cover;display:block;border-radius:3px;border:1px solid rgba(255,255,255,0.08); }
        .portada-upload .portada-preview .remove-portada { position:absolute;top:6px;right:6px;width:28px;height:28px;border-radius:50%;background:rgba(0,0,0,0.6);color:#fff;border:none;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s; }
        .portada-upload .portada-preview .remove-portada:hover { background:rgba(200,50,50,0.8); }
        .btn-submit {
            width: 100%; padding: 14px;
            background: #555;
            color: #fff; border: none; border-radius: 4px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: background .2s; font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 4px;
        }
        .btn-submit:hover { background: #666; }
        .error-msg {
            background: rgba(200,50,50,0.1);
            border: 1px solid rgba(200,50,50,0.15);
            border-radius: 3px; padding: 12px 16px;
            font-size: 12px; color: #9a5a5a;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        @media (max-width: 820px) {
            .main-grid { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
            body { padding: 16px; }
            .form-row { grid-template-columns: 1fr; }
            .preview-card .card-hdr { padding: 14px 18px; }
            .form-card { padding: 24px; }
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
                <i class="fas fa-arrow-left"></i> Volver a plantillas
            </a>
        </div>

        <?php if ($error): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="main-grid">
            <!-- LEFT: Preview + Info -->
            <div class="left-col">
                <div class="preview-card">
                    <div class="card-hdr">
                        <h3><i class="fas fa-eye"></i> Vista previa</h3>
                        <span><?= htmlspecialchars($plantilla['nombre']) ?></span>
                    </div>
                    <img class="plantilla-img" src="<?= BASE_URL ?>/assets/images/plantillas/plantilla_<?= (int)$plantilla['id_plantilla'] ?>.jpg" alt="<?= htmlspecialchars($plantilla['nombre']) ?>">
                </div>

                <?php
                $pid = (int)$plantilla['id_plantilla'];
                $pc = htmlspecialchars($plantilla['color_primario'] ?? '#1A3A5C');
                $sc = htmlspecialchars($plantilla['color_secundario'] ?? '#2C6FBB');
                $tc = htmlspecialchars($plantilla['color_texto'] ?? '#1A1A2E');
                $isDark = in_array($pid, [6, 10, 11]);
                $isTech = $pid === 4;
                $fbg = $isDark ? '#0F1A2E' : ($isTech ? '#F0F4FF' : '#FDFBF7');
                $fontName = match($pid) {
                    6 => 'Inter', 4 => 'DM Sans', 7 => 'Playfair Display',
                    8 => 'Josefin Sans', 9 => 'Merriweather',
                    10 => 'Playfair Display', 11 => 'Oswald',
                    12 => 'Quicksand', default => 'Inter'
                };
                $fontDesc = $isDark ? 'Moderna sans-serif, ideal para lectura en oscuro' : ($isTech ? 'Sans-serif geom&eacute;trica con car&aacute;cter tecnol&oacute;gico' : 'Tipograf&iacute;a vers&aacute;til y moderna');
                $modeLabel = $isDark ? 'Oscuro (dark)' : ($isTech ? 'Claro tecnol&oacute;gico' : 'Claro cl&aacute;sico');
                ?>
                <div class="info-grid">
                    <div class="info-panel">
                        <h4><i class="fas fa-palette"></i> Colores</h4>
                        <div class="color-list">
                            <div class="color-row">
                                <div class="swatch" style="background:<?= $pc ?>"></div>
                                <span class="clabel">Primario</span>
                                <span class="cval"><?= $pc ?></span>
                            </div>
                            <div class="color-row">
                                <div class="swatch" style="background:<?= $sc ?>"></div>
                                <span class="clabel">Secundario</span>
                                <span class="cval"><?= $sc ?></span>
                            </div>
                            <div class="color-row">
                                <div class="swatch" style="background:<?= $fbg ?>"></div>
                                <span class="clabel">Fondo</span>
                                <span class="cval"><?= $fbg ?></span>
                            </div>
                            <div class="color-row">
                                <div class="swatch" style="background:<?= $tc ?>"></div>
                                <span class="clabel">Texto</span>
                                <span class="cval"><?= $tc ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="info-panel">
                        <h4><i class="fas fa-font"></i> Tipograf&iacute;a</h4>
                        <div class="font-display" style="font-family:'<?= $fontName ?>',sans-serif">Aa</div>
                        <div class="font-sub"><?= $fontName ?> &middot; <?= $fontDesc ?></div>
                        <div style="margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.05)">
                            <div style="font-size:11px;color:var(--text-muted,#888);line-height:1.6">
                                <strong style="color:var(--text,#f0f0f0)">Modo:</strong>
                                <?= $modeLabel ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-panel" style="grid-column:1/-1">
                        <h4><i class="fas fa-star"></i> Caracter&iacute;sticas de esta plantilla</h4>
                        <div class="features-list">
                            <?php $features = match($pid) {
                                6 => [
                                    ['icon' => 'fa-moon', 'label' => 'Tema oscuro inmersivo', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-shopping-cart', 'label' => 'Carrito de compras completo', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-images', 'label' => 'Galer&iacute;a de im&aacute;genes con lightbox', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-balance-scale', 'label' => 'Comparaci&oacute;n de productos', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-heart', 'label' => 'Lista de deseos (wishlist)', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-sliders-h', 'label' => 'Filtros avanzados por marca, precio y m&aacute;s', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-question-circle', 'label' => 'Secci&oacute;n de preguntas frecuentes (FAQ)', 'color' => '#6c8cff'],
                                    ['icon' => 'fa-whatsapp', 'label' => 'Bot&oacute;n directo a WhatsApp', 'color' => '#6c8cff'],
                                ],
                                4 => [
                                    ['icon' => 'fa-sun', 'label' => 'Dise&ntilde;o claro y moderno', 'color' => '#1A73E8'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#1A73E8'],
                                    ['icon' => 'fa-palette', 'label' => 'Gradientes y sombras profesionales', 'color' => '#1A73E8'],
                                    ['icon' => 'fa-th-large', 'label' => 'Grid adaptable de productos', 'color' => '#1A73E8'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Totalmente responsive', 'color' => '#1A73E8'],
                                ],
                                7 => [
                                    ['icon' => 'fa-tshirt', 'label' => 'Dise&ntilde;o elegante para moda', 'color' => '#D4A5A5'],
                                    ['icon' => 'fa-heart', 'label' => 'Lista de deseos', 'color' => '#D4A5A5'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#D4A5A5'],
                                    ['icon' => 'fa-camera', 'label' => 'Galer&iacute;a de productos destacada', 'color' => '#D4A5A5'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#D4A5A5'],
                                ],
                                8 => [
                                    ['icon' => 'fa-utensils', 'label' => 'Estilo acogedor para restaurantes', 'color' => '#E67E22'],
                                    ['icon' => 'fa-star', 'label' => 'Valoraciones y rese&ntilde;as', 'color' => '#E67E22'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#E67E22'],
                                    ['icon' => 'fa-tag', 'label' => 'Ofertas y promociones', 'color' => '#E67E22'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#E67E22'],
                                ],
                                9 => [
                                    ['icon' => 'fa-hand-sparkles', 'label' => 'Estilo artesanal &uacute;nico', 'color' => '#8B6914'],
                                    ['icon' => 'fa-palette', 'label' => 'Colores tierra c&aacute;lidos', 'color' => '#8B6914'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#8B6914'],
                                    ['icon' => 'fa-images', 'label' => 'Muestra tus creaciones', 'color' => '#8B6914'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#8B6914'],
                                ],
                                10 => [
                                    ['icon' => 'fa-sparkles', 'label' => 'Dise&ntilde;o glamuroso y moderno', 'color' => '#9B59B6'],
                                    ['icon' => 'fa-star', 'label' => 'Valoraciones de clientes', 'color' => '#9B59B6'],
                                    ['icon' => 'fa-gem', 'label' => 'Estilo premium con tonos dorados', 'color' => '#9B59B6'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#9B59B6'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#9B59B6'],
                                ],
                                11 => [
                                    ['icon' => 'fa-dumbbell', 'label' => 'Estilo deportivo y energ&eacute;tico', 'color' => '#2ECC71'],
                                    ['icon' => 'fa-fire', 'label' => 'Visual audaz y moderno', 'color' => '#2ECC71'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#2ECC71'],
                                    ['icon' => 'fa-trophy', 'label' => 'Muestra logros y metas', 'color' => '#2ECC71'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#2ECC71'],
                                ],
                                12 => [
                                    ['icon' => 'fa-home', 'label' => 'Estilo acogedor para el hogar', 'color' => '#7BAE7F'],
                                    ['icon' => 'fa-couch', 'label' => 'Exhibici&oacute;n de muebles y decoraci&oacute;n', 'color' => '#7BAE7F'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#7BAE7F'],
                                    ['icon' => 'fa-heart', 'label' => 'Lista de deseos', 'color' => '#7BAE7F'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#7BAE7F'],
                                ],
                                default => [
                                    ['icon' => 'fa-paint-brush', 'label' => 'Dise&ntilde;o vers&aacute;til y elegante', 'color' => '#C0392B'],
                                    ['icon' => 'fa-bolt', 'label' => 'Compra r&aacute;pida en 1 clic', 'color' => '#C0392B'],
                                    ['icon' => 'fa-cog', 'label' => 'Altamente personalizable', 'color' => '#C0392B'],
                                    ['icon' => 'fa-mobile-alt', 'label' => 'Adaptable a m&oacute;viles', 'color' => '#C0392B'],
                                ]
                            }; ?>
                            <?php foreach ($features as $f): ?>
                            <div class="feature-item">
                                <i class="fas <?= $f['icon'] ?>" style="color:<?= $f['color'] ?>"></i>
                                <span><?= $f['label'] ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form -->
            <div class="form-card">
                <div class="hdr">
                    <h1>Crear nuevo negocio</h1>
                    <p>Completa los datos de tu emprendimiento</p>
                </div>
                <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>/crear-negocio?plantilla=<?= $_GET['plantilla'] ?? $plantilla['id_plantilla'] ?>">
                    <div class="form-group full">
                        <label>Nombre comercial <span class="req">*</span></label>
                        <div class="field">
                            <i class="fas fa-store"></i>
                            <input type="text" name="nombre_comercial" required placeholder="Ej: Tecnolog&iacute;a Plus">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>NIT</label>
                            <div class="field">
                                <i class="fas fa-file-invoice"></i>
                                <input type="text" name="nit" placeholder="Ej: 1020304050">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tel&eacute;fono</label>
                            <div class="field">
                                <i class="fas fa-phone"></i>
                                <input type="text" name="telefono" placeholder="Ej: 71234567">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <div class="field">
                                <i class="fas fa-city"></i>
                                <input type="text" name="ciudad" placeholder="Ej: La Paz">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Direcci&oacute;n</label>
                            <div class="field">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" name="direccion" placeholder="Ej: Av. 16 de Julio #1542">
                            </div>
                        </div>
                    </div>
                    <div class="form-group full">
                        <label>Descripci&oacute;n del negocio</label>
                        <div class="field">
                            <i class="fas fa-align-left" style="align-self:flex-start;padding-top:13px"></i>
                            <textarea name="descripcion" placeholder="Cu&eacute;ntanos sobre tu emprendimiento..."></textarea>
                        </div>
                    </div>
                    <div class="portada-upload">
                        <label><i class="fas fa-image"></i> Foto de portada (recomendado)</label>
                        <div class="drop-zone" id="dropZone">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Haz clic o arrastra una imagen aqu&iacute;</p>
                            <small>JPG, PNG o WEBP &middot; M&aacute;ximo 5MB</small>
                        </div>
                        <input type="file" name="portada" id="portadaInput" accept="image/jpeg,image/png,image/webp" style="display:none">
                        <div class="portada-preview" id="portadaPreview">
                            <img id="portadaImg" src="" alt="Portada">
                            <button type="button" class="remove-portada" id="removePortada">&times;</button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-rocket"></i> Crear negocio
                    </button>
                    <script>
                    (function(){
                        var dropZone = document.getElementById('dropZone');
                        var input = document.getElementById('portadaInput');
                        var preview = document.getElementById('portadaPreview');
                        var img = document.getElementById('portadaImg');
                        var removeBtn = document.getElementById('removePortada');
                        dropZone.addEventListener('click', function(){ input.click(); });
                        dropZone.addEventListener('dragover', function(e){ e.preventDefault(); dropZone.style.borderColor='rgba(255,255,255,0.4)'; });
                        dropZone.addEventListener('dragleave', function(){ dropZone.style.borderColor='rgba(255,255,255,0.12)'; });
                        dropZone.addEventListener('drop', function(e){ e.preventDefault(); dropZone.style.borderColor='rgba(255,255,255,0.12)'; if(e.dataTransfer.files.length) input.files=e.dataTransfer.files; showPreview(); });
                        input.addEventListener('change', showPreview);
                        removeBtn.addEventListener('click', function(){ input.value=''; preview.style.display='none'; dropZone.style.display='block'; });
                        function showPreview(){ if(input.files&&input.files[0]){ var reader=new FileReader(); reader.onload=function(e){ img.src=e.target.result; preview.style.display='block'; dropZone.style.display='none'; }; reader.readAsDataURL(input.files[0]); } }
                    })();
                    </script>
                </form>
            </div>
        </div>
    </div>
</body>
</html>