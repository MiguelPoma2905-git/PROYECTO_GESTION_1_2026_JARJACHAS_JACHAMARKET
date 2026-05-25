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

        /* ===== LEFT COLUMN ===== */
        .left-col { display: flex; flex-direction: column; gap: 20px; }

        .preview-card {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 20px;
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
            padding: 3px 10px; border-radius: 4px;
        }

        /* Mini preview mockup */
        .mini-preview {
            position: relative;
            padding: 32px 28px 28px;
            overflow: hidden;
        }
        .mini-preview::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 20% 30%, rgba(108,140,255,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(108,140,255,0.03) 0%, transparent 50%);
            pointer-events: none;
        }
        .mini-preview .mph {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 16px; border-radius: 10px; margin-bottom: 20px;
            position: relative; z-index: 1;
        }
        .mini-preview .mph-l { display: flex; align-items: center; gap: 10px; }
        .mini-preview .mph-l .mico {
            width: 24px; height: 24px; border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
        }
        .mini-preview .mph-l .mname { font-size: 13px; font-weight: 600; }
        .mini-preview .mph-r { display: flex; gap: 8px; }
        .mini-preview .mph-r .mdot {
            width: 20px; height: 20px; border-radius: 5px;
        }
        .mini-preview .mhero {
            text-align: center; padding: 16px 0 12px; position: relative; z-index: 1;
        }
        .mini-preview .mhero .mbadge {
            display: inline-block; font-size: 8px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 3px 10px; border-radius: 3px; margin-bottom: 8px;
        }
        .mini-preview .mhero h4 { font-size: 18px; font-weight: 700; margin-bottom: 2px; }
        .mini-preview .mhero p { font-size: 10px; opacity: 0.5; line-height: 1.5; }
        .mini-preview .mgrid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; position: relative; z-index: 1; margin-top: 4px; }
        .mini-preview .mcard {
            border-radius: 10px; padding: 12px; position: relative; overflow: hidden;
        }
        .mini-preview .mcard .mimg {
            height: 50px; border-radius: 6px; margin-bottom: 8px;
        }
        .mini-preview .mcard .mcard-h { font-size: 11px; font-weight: 600; margin-bottom: 4px; }
        .mini-preview .mcard .mcard-sub { font-size: 9px; opacity: 0.4; margin-bottom: 6px; }
        .mini-preview .mcard .mcard-bot { display: flex; align-items: center; justify-content: space-between; }
        .mini-preview .mcard .mcard-bot .price { font-size: 13px; font-weight: 700; }
        .mini-preview .mcard .mcard-bot .price small { font-size: 8px; font-weight: 400; opacity: 0.4; }
        .mini-preview .mcard .mcard-bot .mbtn {
            font-size: 9px; font-weight: 600; padding: 4px 12px;
            border-radius: 5px; cursor: default;
            border: none;
        }
        .mini-preview .mfoot {
            text-align: center; padding: 16px 0 4px; position: relative; z-index: 1;
            font-size: 9px; opacity: 0.15; letter-spacing: 0.5px;
        }

        .preview-type-dark .mph { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); }
        .preview-type-dark .mph-l .mname { color: #e8edf5; }
        .preview-type-dark .mph-r .mdot { border: 1px solid rgba(255,255,255,0.1); }
        .preview-type-dark .mbadge { color: #2C6FBB; background: rgba(44,111,187,0.12); border: 1px solid rgba(44,111,187,0.2); }
        .preview-type-dark .mhero h4 { color: #e8edf5; }
        .preview-type-dark .mhero p { color: #e8edf5; }
        .preview-type-dark .mcard { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); }
        .preview-type-dark .mcard .mimg { background: linear-gradient(135deg, #1a2a44, #0F1A2E); }
        .preview-type-dark .mcard .mcard-h { color: #e8edf5; }
        .preview-type-dark .mcard .mcard-sub { color: #e8edf5; }
        .preview-type-dark .mcard .price { color: #e8edf5; }
        .preview-type-dark .mcard .mbtn { background: #2C6FBB; color: #fff; }
        .preview-type-dark .mfoot { color: #e8edf5; }

        .preview-type-light { }
        .preview-type-light .mph { background: linear-gradient(135deg, var(--pc), color-mix(in srgb, var(--pc) 70%, #000)); }
        .preview-type-light .mph-l .mname { color: #fff; }
        .preview-type-light .mph-r .mdot { border: 1px solid rgba(255,255,255,0.15); }
        .preview-type-light .mbadge { color: var(--pc); background: rgba(255,255,255,0.8); border: 1px solid rgba(0,0,0,0.06); }
        .preview-type-light .mhero h4 { color: var(--tc, #1A1A2E); }
        .preview-type-light .mhero p { color: var(--tc, #1A1A2E); }
        .preview-type-light .mcard { background: #fff; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 2px 12px rgba(0,0,0,0.04); }
        .preview-type-light .mcard .mimg { background: linear-gradient(135deg, var(--pc), var(--sc)); opacity: 0.12; }
        .preview-type-light .mcard .mcard-h { color: #1A1A2E; }
        .preview-type-light .mcard .mcard-sub { color: #1A1A2E; }
        .preview-type-light .mcard .price { color: var(--pc); }
        .preview-type-light .mcard .mbtn { background: var(--pc); color: #fff; }
        .preview-type-light .mfoot { color: #1A1A2E; }

        .preview-type-tech .mph { background: linear-gradient(135deg, var(--pc), var(--sc)); }
        .preview-type-tech .mph-l .mname { color: #fff; }
        .preview-type-tech .mph-r .mdot { border: 1px solid rgba(255,255,255,0.15); }
        .preview-type-tech .mbadge { color: var(--pc); background: rgba(255,255,255,0.85); border: 1px solid rgba(0,0,0,0.04); }
        .preview-type-tech .mhero h4 { background: linear-gradient(135deg, var(--tc), var(--pc)); -webkit-background-clip:text; background-clip:text; color:transparent; }
        .preview-type-tech .mhero p { color: var(--tc); }
        .preview-type-tech .mcard { background: #fff; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 2px 16px rgba(26,115,232,0.06); }
        .preview-type-tech .mcard .mimg { background: linear-gradient(135deg, var(--pc), var(--sc)); opacity: 0.12; }
        .preview-type-tech .mcard .mcard-h { color: #1A1A2E; }
        .preview-type-tech .mcard .mcard-sub { color: #1A1A2E; }
        .preview-type-tech .mcard .price { color: var(--pc); }
        .preview-type-tech .mcard .mbtn { background: var(--pc); color: #fff; }
        .preview-type-tech .mfoot { color: #1A1A2E; }

        /* Info panels */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .info-panel {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 16px;
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
            width: 28px; height: 28px; border-radius: 6px;
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

        /* Features */
        .features-list { display: flex; flex-direction: column; gap: 8px; }
        .feature-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 12px; color: var(--text, #f0f0f0); padding: 6px 0;
        }
        .feature-item i {
            width: 18px; text-align: center; font-size: 13px;
        }
        .feature-item .f-dot {
            width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
        }

        /* ===== RIGHT COLUMN ===== */
        .form-card {
            background: var(--card-bg, #141414);
            border: 1px solid var(--border, rgba(255,255,255,0.06));
            border-radius: 20px;
            padding: 32px;
        }
        .form-card .hdr { margin-bottom: 28px; }
        .form-card .hdr h1 {
            font-size: 24px; font-weight: 700; color: var(--text, #f0f0f0);
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
        .form-group label .req { color: #ef4444; }
        .form-group .field {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px; transition: all .2s;
        }
        .form-group .field:focus-within {
            border-color: #6c8cff;
            box-shadow: 0 0 0 3px rgba(108,140,255,0.08);
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

        .btn-submit {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #6c8cff, #5a7ae8);
            color: #fff; border: none; border-radius: 12px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: all .25s; font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 4px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108,140,255,0.25);
        }
        .error-msg {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.15);
            border-radius: 10px; padding: 12px 16px;
            font-size: 12px; color: #ef4444;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        @media (max-width: 820px) {
            .main-grid { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
            body { padding: 16px; }
            .form-row { grid-template-columns: 1fr; }
            .preview-card .card-hdr { padding: 14px 18px; }
            .mini-preview { padding: 20px 18px 18px; }
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
                    <?php
                    $pid = (int)$plantilla['id_plantilla'];
                    $pc = htmlspecialchars($plantilla['color_primario'] ?? '#1A3A5C');
                    $sc = htmlspecialchars($plantilla['color_secundario'] ?? '#2C6FBB');
                    $tc = htmlspecialchars($plantilla['color_texto'] ?? '#1A1A2E');
                    ?>
                    <div class="mini-preview preview-type-<?= $pid === 6 || $pid === 10 || $pid === 11 ? 'dark' : ($pid === 4 ? 'tech' : 'light') ?>"
                         style="--pc:<?= $pc ?>;--sc:<?= $sc ?>;--tc:<?= $tc ?>;background:<?= $pid === 6 || $pid === 10 || $pid === 11 ? '#0F1A2E' : ($pid === 4 ? '#F0F4FF' : '#FDFBF7') ?>">
                        <div class="mph">
                            <div class="mph-l">
                                <div class="mico" style="background:<?= $pc ?>;color:#fff">🏪</div>
                                <span class="mname">Tu Negocio</span>
                            </div>
                            <div class="mph-r">
                                <div class="mdot" style="background:<?= $pc ?>"></div>
                                <div class="mdot" style="background:<?= $sc ?>"></div>
                            </div>
                        </div>
                        <div class="mhero">
                            <div class="mbadge">✦ <?= htmlspecialchars($plantilla['nombre']) ?></div>
                            <h4>Tu Negocio Aqu&iacute;</h4>
                            <p>Productos de calidad para tus clientes</p>
                        </div>
                        <div class="mgrid">
                            <div class="mcard">
                                <div class="mimg"></div>
                                <div class="mcard-h">Producto Premium</div>
                                <div class="mcard-sub">Marca l&iacute;der</div>
                                <div class="mcard-bot">
                                    <div class="price"><small>Bs.</small> 299</div>
                                    <button class="mbtn">A&ntilde;adir</button>
                                </div>
                            </div>
                            <div class="mcard">
                                <div class="mimg"></div>
                                <div class="mcard-h">Producto Cl&aacute;sico</div>
                                <div class="mcard-sub">Marca original</div>
                                <div class="mcard-bot">
                                    <div class="price"><small>Bs.</small> 149</div>
                                    <button class="mbtn">A&ntilde;adir</button>
                                </div>
                            </div>
                        </div>
                        <div class="mfoot">&copy; 2026 Tu Negocio</div>
                    </div>
                </div>

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
                                <div class="swatch" style="background:<?= $pid === 6 || $pid === 10 || $pid === 11 ? '#0F1A2E' : ($pid === 4 ? '#F0F4FF' : '#FDFBF7') ?>"></div>
                                <span class="clabel">Fondo</span>
                                <span class="cval"><?= $pid === 6 || $pid === 10 || $pid === 11 ? '#0F1A2E' : ($pid === 4 ? '#F0F4FF' : '#FDFBF7') ?></span>
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
                        <?php
                        $fontName = match($pid) {
                            6 => 'Inter',
                            4 => 'DM Sans',
                            7 => 'Playfair Display',
                            8 => 'Josefin Sans',
                            9 => 'Merriweather',
                            10 => 'Playfair Display',
                            11 => 'Oswald',
                            12 => 'Quicksand',
                            default => 'Inter'
                        };
                        ?>
                        <div class="font-display" style="font-family:'<?= $fontName ?>',sans-serif">Aa</div>
                        <div class="font-sub"><?= $fontName ?> &middot; Sistema sans-serif moderna</div>
                        <div style="margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.05)">
                            <div style="font-size:11px;color:var(--text-muted,#888);line-height:1.6">
                                <strong style="color:var(--text,#f0f0f0)">Modo:</strong>
                                <?= $pid === 6 || $pid === 10 || $pid === 11 ? 'Oscuro (dark)' : ($pid === 4 ? 'Claro tecnol&oacute;gico' : 'Claro cl&aacute;sico') ?>
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
                                    ['icon' => 'a-images', 'label' => 'Muestra tus creaciones', 'color' => '#8B6914'],
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
                <form method="POST" action="<?= BASE_URL ?>/crear-negocio?plantilla=<?= $_GET['plantilla'] ?? $plantilla['id_plantilla'] ?>">
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
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-rocket"></i> Crear negocio
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>