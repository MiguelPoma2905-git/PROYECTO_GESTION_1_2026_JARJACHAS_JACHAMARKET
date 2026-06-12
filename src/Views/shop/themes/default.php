<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#C0392B') ?>;
        --ts: <?= $p('color_secundario', '#2C3E50') ?>;
        --tb: <?= $p('color_fondo', '#FDFBF7') ?>;
        --tt: <?= $p('color_texto', '#1A1A2E') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(255,255,255,0.7);
    }
    [data-theme="dark"] { --tgl: rgba(30,30,40,0.85); }
    body {
        font-family:var(--ef);
        background:var(--tb); color:var(--tt); min-height:100vh; margin:0;
    }
    .g-hdr {
        background:linear-gradient(135deg,var(--tp),color-mix(in srgb,var(--tp) 70%,#000));
        padding:16px 32px; display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        box-shadow:0 4px 24px rgba(0,0,0,0.18); backdrop-filter:blur(12px);
    }
    .g-hdr-l { display:flex; align-items:center; gap:16px; }
    .g-hdr h2 { font-size:18px; font-weight:700; color:#fff; }
    .g-logo { height:36px; width:auto; border-radius:4px; object-fit:contain; }
    .g-hdr .back { color:rgba(255,255,255,0.8); text-decoration:none; font-size:13px; font-weight:500; transition:all .2s; }
    .g-hdr .back:hover { color:#fff; }
    .g-hero { text-align:center; padding:60px 32px 0; position:relative; }
    .g-hero::after {
        content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
        width:80px; height:3px; background:var(--tp); border-radius:4px; opacity:0.3;
    }
    .g-title {
        font-family:'Cormorant Garamond',serif;
        font-size:44px; font-weight:500; color:var(--ts);
        margin-bottom:8px; letter-spacing:-.5px;
    }
    .g-desc { font-size:15px; color:var(--tt); opacity:0.6; max-width:600px; margin:0 auto 48px; line-height:1.7; }
    .g-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; }
    .g-count { text-align:center; font-size:13px; color:var(--tt); opacity:0.4; margin-bottom:32px; letter-spacing:.5px; text-transform:uppercase; font-weight:500; }
    .g-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(270px,1fr)); gap:28px; }
    .g-card {
        background:var(--tgl); backdrop-filter:blur(8px);
        border-radius:20px; overflow:hidden;
        box-shadow:0 4px 20px rgba(0,0,0,0.06);
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        border:1px solid transparent;
        animation:gFU .5s ease both;
    }
    [data-theme="dark"] .g-card { background:var(--tgl); border-color:rgba(255,255,255,0.04); }
    .g-card:hover { transform:translateY(-8px); box-shadow:0 16px 48px rgba(0,0,0,0.1); border-color:color-mix(in srgb,var(--tp) 20%,transparent); }
        .g-card-img {
            position:relative; overflow:hidden; height:230px;
            background:linear-gradient(135deg,var(--tp) 0%,var(--ts) 100%);
            flex-shrink:0;
        }
    .g-card-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s; display:block; }
    .g-card:hover .g-card-img img { transform:scale(1.06); }
    .g-card-brand {
        position:absolute; top:12px; left:12px;
        background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);
        padding:4px 12px; border-radius:6px;
        font-size:10px; font-weight:600; letter-spacing:1px;
        text-transform:uppercase; color:#fff;
    }
    .g-card-body { padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
    .g-card-body h3 { font-size:16px; font-weight:600; color:var(--tt); margin-bottom:4px; line-height:1.3; }
    .g-price { font-size:24px; font-weight:700; color:var(--tp); margin:8px 0 16px; letter-spacing:-.5px; }
    .g-price small { font-size:14px; font-weight:500; opacity:0.6; }
    .g-btn {
        width:100%; padding:13px;
        background:linear-gradient(135deg,var(--tp),color-mix(in srgb,var(--tp) 75%,#000));
        color:#fff; border:none; border-radius:12px; font-size:14px; font-weight:600;
        cursor:pointer; transition:all .3s; margin-top:auto; position:relative; overflow:hidden;
    }
    .g-btn::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent);
        opacity:0; transition:opacity .3s;
    }
    .g-btn:hover { transform:translateY(-3px); box-shadow:0 8px 28px color-mix(in srgb,var(--tp) 40%,transparent); }
    .g-btn:hover::after { opacity:1; }
    .g-btn:active { transform:translateY(0); }
    .g-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.3; font-size:12px; border-top:1px solid; margin-top:40px; }
    .g-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.5; }
    .g-wm {
        position:fixed; bottom:12px; right:16px;
        display:flex; align-items:center; gap:6px;
        background:var(--tgl); backdrop-filter:blur(8px);
        padding:4px 12px 4px 8px; border-radius:20px;
        opacity:0.5; pointer-events:none; z-index:9999;
    }
    .g-wm img { height:16px; width:auto; opacity:0.5; }
    .btn-edit {
        position:fixed; bottom:24px; left:24px; z-index:10000;
        background:linear-gradient(135deg,var(--tp),color-mix(in srgb,var(--tp) 70%,#000));
        color:#fff; border:none; border-radius:30px;
        padding:12px 24px; font-size:14px; font-weight:600; cursor:pointer;
        box-shadow:0 6px 24px rgba(0,0,0,0.2); transition:all .3s;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px; backdrop-filter:blur(8px);
    }
    .btn-edit:hover { transform:translateY(-3px); box-shadow:0 10px 40px color-mix(in srgb,var(--tp) 50%,transparent); }
    @keyframes gFU { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .g-card:nth-child(1){animation-delay:0.04s}
    .g-card:nth-child(2){animation-delay:0.08s}
    .g-card:nth-child(3){animation-delay:0.12s}
    .g-card:nth-child(4){animation-delay:0.16s}
    .g-card:nth-child(5){animation-delay:0.20s}
    .g-card:nth-child(6){animation-delay:0.24s}
    .g-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; }
    .g-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:var(--tgl); backdrop-filter:blur(8px); border:1px solid transparent; border-radius:12px; font-size:12px; color:var(--tt); opacity:0.7; box-shadow:0 2px 12px rgba(0,0,0,0.04); }
    .g-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .g-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    @media(max-width:768px){
        .g-ctn{padding:0 16px 40px} .g-hero{padding:40px 16px 0}
        .g-title{font-size:30px} .g-grid{grid-template-columns:1fr;gap:20px}
        .g-hdr{padding:14px 20px} .g-card-img{height:190px}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="g-hdr">
        <div class="g-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="g-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <a href="javascript:history.back()" class="back">&larr; Volver</a>
    </div>
    <div class="g-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat"<?php endif; ?>>
        <h1 class="g-title"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p class="g-desc"><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="g-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="g-count"><?= count($productos) ?> producto(s)</div>
        <div class="g-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
            ?>
            <div class="g-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <div class="g-card-img">
                    <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                    <?php if ($atributos && isset($atributos['marca'])): ?>
                        <span class="g-card-brand"><?= htmlspecialchars($atributos['marca']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="g-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <div class="g-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                    <?php if ($es_propietario): ?>
                    <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="g-btn" style="text-decoration:none;display:block;text-align:center"><i class="fas fa-pen"></i> Editar</a>
                    <?php else: ?>
                    <button class="g-btn" onclick="mostrarCompra(this)">Agregar al carrito</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="g-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="g-contact">
        <div class="g-contact-inner">
            <?php if (!empty($emprendimiento['telefono'])): ?>
            <span><i class="fas fa-phone" style="color:var(--tp)"></i> <?= htmlspecialchars($emprendimiento['telefono']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['direccion'])): ?>
            <span><i class="fas fa-map-pin" style="color:var(--tp)"></i> <?= htmlspecialchars($sucursal['direccion']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['ciudad'])): ?>
            <span><i class="fas fa-city" style="color:var(--tp)"></i> <?= htmlspecialchars($sucursal['ciudad']) ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="g-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></p>
    </div>
    <div class="g-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
<?php endif; ?>
