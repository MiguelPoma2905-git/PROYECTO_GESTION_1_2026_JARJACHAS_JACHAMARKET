<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#231F20') ?>;
        --ts: <?= $p('color_secundario', '#B08D57') ?>;
        --tb: <?= $p('color_fondo', '#FBF8F1') ?>;
        --tt: <?= $p('color_texto', '#241E18') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --el-paper: rgba(255,255,255,0.88);
        --el-line: rgba(36,30,24,0.12);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:linear-gradient(180deg,var(--tb),color-mix(in srgb,var(--tb) 86%,#fff)); color:var(--tt); min-height:100vh; }
    .e2-wrap { max-width:1180px; margin:0 auto; padding:24px; }
    .e2-top { display:flex; align-items:center; justify-content:space-between; padding:14px 0 34px; border-bottom:1px solid var(--el-line); }
    .e2-brand { display:flex; align-items:center; gap:14px; }
    .e2-logo { width:44px; height:44px; border-radius:50%; object-fit:cover; border:1px solid var(--ts); padding:3px; background:#fff; }
    .e2-brand h2 { font-family:'Cormorant Garamond',serif; font-size:26px; font-weight:500; color:var(--tp); }
    .e2-back { color:var(--tp); text-decoration:none; font-size:12px; letter-spacing:1.8px; text-transform:uppercase; opacity:.58; }
    .e2-back:hover { opacity:1; color:var(--ts); }
    .e2-hero { padding:60px 0 48px; text-align:center; position:relative; }
    .e2-hero::before { content:''; display:block; width:70px; height:1px; background:var(--ts); margin:0 auto 24px; }
    .e2-eyebrow { color:var(--ts); font-size:11px; letter-spacing:3.5px; text-transform:uppercase; font-weight:700; margin-bottom:14px; }
    .e2-hero h1 { font-family:'Cormorant Garamond',serif; font-size:68px; line-height:.94; font-weight:400; color:var(--tp); max-width:860px; margin:0 auto; }
    .e2-hero p { max-width:620px; margin:22px auto 0; color:var(--tt); opacity:.58; line-height:1.85; font-size:15px; }
    .e2-banner { height:220px; border-radius:2px; overflow:hidden; background:linear-gradient(135deg,var(--tp),var(--ts)); margin-bottom:44px; position:relative; }
    .e2-banner img { width:100%; height:100%; object-fit:cover; opacity:.66; display:block; }
    .e2-banner::after { content:''; position:absolute; inset:18px; border:1px solid rgba(255,255,255,.42); pointer-events:none; }
    .e2-meta { display:flex; justify-content:center; gap:14px; flex-wrap:wrap; margin-top:-20px; margin-bottom:36px; }
    .e2-meta span { background:var(--el-paper); border:1px solid var(--el-line); padding:9px 14px; border-radius:999px; font-size:12px; color:var(--tt); opacity:.74; }
    .e2-title-row { display:flex; justify-content:space-between; align-items:center; gap:18px; margin-bottom:22px; }
    .e2-title-row h3 { font-family:'Cormorant Garamond',serif; font-size:34px; font-weight:500; color:var(--tp); }
    .e2-title-row span { color:var(--ts); font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:700; }
    .e2-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(270px,1fr)); gap:26px; }
    .e2-card { background:var(--el-paper); border:1px solid var(--el-line); position:relative; transition:transform .35s, box-shadow .35s, border-color .35s; animation:e2In .5s ease both; }
    .e2-card:hover { transform:translateY(-6px); box-shadow:0 24px 60px rgba(36,30,24,.10); border-color:color-mix(in srgb,var(--ts) 50%,transparent); }
    .e2-img { height:260px; overflow:hidden; background:color-mix(in srgb,var(--ts) 12%,#fff); }
    .e2-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .65s; }
    .e2-card:hover .e2-img img { transform:scale(1.045); }
    .e2-badge { position:absolute; top:14px; right:14px; background:rgba(255,255,255,.86); border:1px solid var(--el-line); padding:6px 10px; color:var(--ts); font-size:10px; letter-spacing:1.4px; text-transform:uppercase; font-weight:800; }
    .e2-body { padding:22px; display:flex; flex-direction:column; min-height:190px; }
    .e2-body h4 { font-family:'Cormorant Garamond',serif; font-size:25px; font-weight:500; line-height:1.05; color:var(--tp); margin-bottom:10px; }
    .e2-attrs { display:flex; flex-wrap:wrap; gap:7px; margin-bottom:16px; }
    .e2-attr { color:var(--tt); opacity:.52; border-bottom:1px solid color-mix(in srgb,var(--ts) 35%,transparent); font-size:11px; padding-bottom:2px; }
    .e2-bottom { margin-top:auto; display:flex; align-items:center; justify-content:space-between; gap:12px; border-top:1px solid var(--el-line); padding-top:16px; }
    .e2-price { color:var(--tp); font-size:24px; font-weight:700; }
    .e2-price small { font-size:12px; color:var(--ts); font-weight:700; }
    .e2-btn { background:transparent; color:var(--tp); border:1px solid var(--ts); padding:10px 15px; font-size:11px; letter-spacing:1.7px; text-transform:uppercase; font-weight:800; cursor:pointer; text-decoration:none; transition:all .25s; }
    .e2-btn:hover { background:var(--tp); border-color:var(--tp); color:#fff; }
    .e2-empty { grid-column:1/-1; text-align:center; padding:80px 20px; opacity:.45; }
    .e2-foot { border-top:1px solid var(--el-line); margin-top:46px; padding:26px 0 8px; text-align:center; font-size:12px; color:var(--tt); opacity:.42; }
    .e2-edit { position:fixed; left:24px; bottom:24px; z-index:10000; background:var(--tp); color:#fff; border:1px solid var(--ts); padding:12px 20px; font-size:12px; letter-spacing:1.2px; text-transform:uppercase; text-decoration:none; }
    @keyframes e2In { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:760px){ .e2-wrap{padding:18px} .e2-top{padding-bottom:24px} .e2-brand h2{font-size:21px} .e2-hero{padding:42px 0 34px} .e2-hero h1{font-size:42px} .e2-banner{height:170px} .e2-title-row{align-items:flex-start;flex-direction:column} .e2-grid{grid-template-columns:1fr} }
</style>
<?php elseif ($themePart === 'html'): ?>
    <main class="e2-wrap">
        <header class="e2-top">
            <div class="e2-brand">
                <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="e2-logo" alt="Logo">
                <?php endif; ?>
                <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
            </div>
            <a href="javascript:history.back()" class="e2-back">Volver</a>
        </header>

        <section class="e2-hero">
            <div class="e2-eyebrow">Coleccion seleccionada</div>
            <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
            <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
        </section>

        <?php if (!empty($emprendimiento['banner_personalizado'])): ?>
        <div class="e2-banner"><img src="<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>" alt="Banner"></div>
        <?php else: ?>
        <div class="e2-banner"></div>
        <?php endif; ?>

        <div class="e2-meta">
            <span><?= count($productos) ?> productos</span>
            <?php if (!empty($emprendimiento['telefono'])): ?><span><i class="fas fa-phone"></i> <?= htmlspecialchars($emprendimiento['telefono']) ?></span><?php endif; ?>
            <?php if (!empty($sucursal['direccion'])): ?><span><i class="fas fa-location-dot"></i> <?= htmlspecialchars($sucursal['direccion']) ?></span><?php endif; ?>
        </div>

        <section class="e2-title-row"><h3>Productos destacados</h3><span>Disponible ahora</span></section>
        <section class="e2-grid">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $producto): $atributos = json_decode($producto['atributos'] ?? '{}', true); ?>
                <article class="e2-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                    <div class="e2-img"><img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'" alt="<?= htmlspecialchars($producto['nombre']) ?>"></div>
                    <span class="e2-badge"><?= (int)$producto['stock'] ?> disp.</span>
                    <div class="e2-body">
                        <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                        <?php if ($atributos): ?>
                        <div class="e2-attrs">
                            <?php foreach (array_slice($atributos, 0, 3) as $val): ?><span class="e2-attr"><?= htmlspecialchars($val) ?></span><?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="e2-bottom">
                            <div class="e2-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                            <?php if ($es_propietario): ?>
                            <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="e2-btn">Editar</a>
                            <?php else: ?>
                            <button class="e2-btn" onclick="mostrarCompra(this)">Comprar</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="e2-empty">No hay productos disponibles en esta tienda aun.</div>
            <?php endif; ?>
        </section>

        <footer class="e2-foot">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Experiencia elegante.</footer>
    </main>
    <?php if ($es_propietario): ?><a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="e2-edit">Editar negocio</a><?php endif; ?>
<?php endif; ?>
