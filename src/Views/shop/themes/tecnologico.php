<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#1A73E8') ?>;
        --ts: <?= $p('color_secundario', '#0D47A1') ?>;
        --tb: <?= $p('color_fondo', '#F0F4FF') ?>;
        --tt: <?= $p('color_texto', '#1A1A2E') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(26,115,232,0.10);
        --tgh: rgba(26,115,232,0.15);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family:var(--ef);
        background:var(--tb); color:var(--tt);
        min-height:100vh;
    }
    .t4-hdr {
        background:linear-gradient(135deg,var(--tp),var(--ts));
        padding:18px 40px;
        display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        box-shadow:0 4px 30px rgba(0,0,0,0.15);
    }
    .t4-hdr-l { display:flex; align-items:center; gap:16px; }
    .t4-hdr h2 { font-size:20px; font-weight:700; color:#fff; letter-spacing:-.3px; }
    .t4-logo { height:36px; width:auto; border-radius:4px; object-fit:contain; }
    .t4-hdr .back {
        color:rgba(255,255,255,0.75); text-decoration:none;
        font-size:13px; font-weight:500; transition:all .2s;
        display:flex; align-items:center; gap:4px;
    }
    .t4-hdr .back:hover { color:#fff; gap:6px; }
    .t4-hero {
        position:relative; text-align:center; padding:64px 32px 0;
        overflow:hidden;
    }
    .t4-hero::before {
        content:''; position:absolute; top:-60%; left:-20%;
        width:140%; height:140%;
        background:radial-gradient(ellipse at 30% 50%,var(--tgl) 0%,transparent 60%);
        pointer-events:none;
    }
    .t4-hero::after {
        content:''; position:absolute; bottom:0; left:50%; transform:translateX(-50%);
        width:120px; height:4px;
        background:linear-gradient(90deg,transparent,var(--tp),transparent);
        border-radius:2px;
    }
    .t4-hero h1 {
        font-size:46px; font-weight:700; letter-spacing:-1px;
        background:linear-gradient(135deg,var(--tt),var(--tp));
        -webkit-background-clip:text; background-clip:text; color:transparent;
        margin-bottom:12px; position:relative;
    }
    .t4-hero p {
        font-size:15px; color:var(--tt); opacity:0.55;
        max-width:580px; margin:0 auto 52px; line-height:1.7;
    }
    .t4-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; }
    .t4-count {
        text-align:center; font-size:12px; color:var(--tt); opacity:0.35;
        margin-bottom:28px; letter-spacing:1px; text-transform:uppercase; font-weight:600;
    }
    .t4-grid {
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
        gap:28px;
    }
    .t4-card {
        background:#fff; border-radius:20px; overflow:hidden;
        box-shadow:0 2px 20px rgba(0,0,0,0.04);
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        border:1px solid rgba(0,0,0,0.04);
        position:relative;
        animation:t4FU .5s ease both;
    }
    .t4-card::before {
        content:''; position:absolute; top:0; left:0; right:0;
        height:4px;
        background:linear-gradient(90deg,var(--tp),var(--ts));
        opacity:0; transition:opacity .4s;
    }
    .t4-card:hover {
        transform:translateY(-8px);
        box-shadow:0 16px 48px var(--tgl);
        border-color:transparent;
    }
    .t4-card:hover::before { opacity:1; }
    .t4-card-img {
        width:100%; height:210px; object-fit:cover;
        background:linear-gradient(135deg,var(--tp),var(--ts));
        opacity:0.12; display:block; transition:transform .5s;
    }
    .t4-card:hover .t4-card-img { transform:scale(1.05); }
    .t4-card-body { padding:22px 24px 24px; flex:1; display:flex; flex-direction:column; }
    .t4-card-cat {
        font-size:10px; font-weight:600; letter-spacing:1.5px;
        text-transform:uppercase; color:var(--tp); margin-bottom:6px;
    }
    .t4-card-body h3 {
        font-size:16px; font-weight:600; color:var(--tt);
        margin-bottom:4px; line-height:1.3;
    }
    .t4-tags {
        display:flex; gap:6px; flex-wrap:wrap; margin:8px 0 12px;
    }
    .t4-tag {
        font-size:10px; color:var(--tt); opacity:0.4;
        background:var(--tgl); padding:3px 10px; border-radius:4px;
    }
    .t4-card-bot {
        display:flex; align-items:center; justify-content:space-between;
        margin-top:auto; padding-top:14px;
        border-top:1px solid rgba(0,0,0,0.05);
    }
    .t4-price { font-size:24px; font-weight:700; color:var(--tp); letter-spacing:-.5px; }
    .t4-price small { font-size:13px; font-weight:500; opacity:0.5; }
    .t4-btn {
        padding:10px 22px; background:var(--tp); color:#fff;
        border:none; border-radius:10px; font-size:13px; font-weight:600;
        cursor:pointer; transition:all .3s;
    }
    .t4-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px var(--tgh); }
    .t4-empty {
        text-align:center; padding:80px 20px; color:var(--tt); opacity:0.45;
        grid-column:1/-1;
    }
    .t4-foot {
        text-align:center; padding:32px; color:var(--tt); opacity:0.25;
        font-size:12px; border-top:1px solid; margin-top:40px;
        border-color:rgba(0,0,0,0.06);
    }
    .t4-wm {
        position:fixed; bottom:12px; right:16px;
        display:flex; align-items:center; gap:6px;
        background:rgba(255,255,255,0.85);
        backdrop-filter:blur(8px); padding:4px 12px 4px 8px;
        border-radius:20px; opacity:0.4; pointer-events:none; z-index:9999;
    }
    .t4-wm img { height:16px; width:auto; opacity:0.4; }
    .btn-edit {
        position:fixed; bottom:24px; left:24px; z-index:10000;
        background:var(--tp); color:#fff; border:none; border-radius:12px;
        padding:12px 24px; font-size:13px; font-weight:600; cursor:pointer;
        box-shadow:0 6px 24px rgba(0,0,0,0.15);
        transition:all .3s; text-decoration:none;
        display:inline-flex; align-items:center; gap:8px;
    }
    .btn-edit:hover { transform:translateY(-2px); box-shadow:0 8px 32px var(--tgh); }
    @keyframes t4FU { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .t4-card:nth-child(1){animation-delay:0.04s}
    .t4-card:nth-child(2){animation-delay:0.08s}
    .t4-card:nth-child(3){animation-delay:0.12s}
    .t4-card:nth-child(4){animation-delay:0.16s}
    .t4-card:nth-child(5){animation-delay:0.20s}
    .t4-card:nth-child(6){animation-delay:0.24s}
    .t4-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; }
    .t4-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:#fff; border:1px solid rgba(0,0,0,0.04); border-radius:12px; font-size:12px; color:var(--tt); opacity:0.7; box-shadow:0 2px 12px var(--tgl); }
    .t4-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t4-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    @media(max-width:768px){
        .t4-hdr{padding:14px 20px}
        .t4-hero{padding:40px 20px 0}
        .t4-hero h1{font-size:30px}
        .t4-ctn{padding:0 16px 40px}
        .t4-grid{grid-template-columns:1fr;gap:20px}
        .t4-card-img{height:180px}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t4-hdr">
        <div class="t4-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t4-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <a href="javascript:history.back()" class="back">&larr; Volver</a>
    </div>
    <div class="t4-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat"<?php endif; ?>>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t4-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t4-count"><?= count($productos) ?> producto(s)</div>
        <div class="t4-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
            ?>
            <div class="t4-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t4-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <div class="t4-card-body">
                    <?php if ($atributos && isset($atributos['marca'])): ?>
                        <div class="t4-card-cat"><?= htmlspecialchars($atributos['marca']) ?></div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if ($atributos): ?>
                    <div class="t4-tags">
                        <?php foreach ($atributos as $key => $val):
                            if ($key === 'marca') continue; ?>
                            <span class="t4-tag"><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t4-card-bot">
                        <div class="t4-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t4-btn" style="text-decoration:none"><i class="fas fa-pen"></i> Editar</a>
                        <?php else: ?>
                        <button class="t4-btn" onclick="mostrarCompra(this)">Agregar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t4-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t4-contact">
        <div class="t4-contact-inner">
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

    <div class="t4-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></p>
    </div>
    <div class="t4-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
<?php endif; ?>
