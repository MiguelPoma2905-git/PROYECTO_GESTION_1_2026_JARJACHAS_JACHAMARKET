<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#111827') ?>;
        --ts: <?= $p('color_secundario', '#2563EB') ?>;
        --tb: <?= $p('color_fondo', '#F5F7FB') ?>;
        --tt: <?= $p('color_texto', '#111827') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tm-card: rgba(255,255,255,0.82);
        --tm-line: rgba(17,24,39,0.08);
        --tm-soft: rgba(37,99,235,0.10);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:radial-gradient(circle at top left,var(--tm-soft),transparent 34%),var(--tb); color:var(--tt); min-height:100vh; }
    .m1-shell { max-width:1220px; margin:0 auto; padding:24px; }
    .m1-nav { display:flex; align-items:center; justify-content:space-between; gap:20px; padding:14px 0 28px; }
    .m1-brand { display:flex; align-items:center; gap:12px; min-width:0; }
    .m1-logo { width:42px; height:42px; border-radius:14px; object-fit:cover; box-shadow:0 10px 30px rgba(0,0,0,0.10); }
    .m1-brand h2 { font-size:17px; font-weight:800; letter-spacing:-.4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .m1-back { color:var(--tt); opacity:.56; text-decoration:none; font-size:13px; font-weight:700; }
    .m1-back:hover { opacity:1; }
    .m1-hero { display:grid; grid-template-columns:1.1fr .9fr; gap:34px; align-items:stretch; margin-bottom:34px; }
    .m1-copy { background:linear-gradient(135deg,var(--tp),color-mix(in srgb,var(--tp) 72%,#000)); border-radius:32px; padding:46px; color:#fff; min-height:300px; display:flex; flex-direction:column; justify-content:center; position:relative; overflow:hidden; }
    .m1-copy::after { content:''; position:absolute; right:-80px; bottom:-90px; width:260px; height:260px; border-radius:50%; background:rgba(255,255,255,.12); }
    .m1-kicker { font-size:11px; letter-spacing:2.6px; text-transform:uppercase; opacity:.64; font-weight:800; margin-bottom:14px; }
    .m1-copy h1 { font-size:54px; line-height:.95; letter-spacing:-2.6px; max-width:720px; position:relative; z-index:1; }
    .m1-copy p { margin-top:18px; max-width:560px; font-size:15px; line-height:1.75; opacity:.72; position:relative; z-index:1; }
    .m1-side { display:grid; gap:16px; }
    .m1-side-card { background:var(--tm-card); border:1px solid var(--tm-line); border-radius:24px; padding:24px; backdrop-filter:blur(12px); box-shadow:0 20px 60px rgba(15,23,42,.06); }
    .m1-side-card strong { display:block; font-size:34px; letter-spacing:-1px; color:var(--ts); }
    .m1-side-card span { color:var(--tt); opacity:.55; font-size:13px; }
    .m1-contact { display:flex; gap:10px; flex-wrap:wrap; margin-top:14px; }
    .m1-pill { padding:8px 12px; border-radius:999px; background:var(--tm-soft); color:var(--ts); font-size:12px; font-weight:700; }
    .m1-section { display:flex; align-items:end; justify-content:space-between; gap:16px; margin:18px 0 20px; }
    .m1-section h3 { font-size:24px; letter-spacing:-.8px; }
    .m1-section span { font-size:12px; color:var(--tt); opacity:.48; text-transform:uppercase; letter-spacing:1.5px; font-weight:800; }
    .m1-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; }
    .m1-card { background:var(--tm-card); border:1px solid var(--tm-line); border-radius:28px; overflow:hidden; backdrop-filter:blur(14px); box-shadow:0 18px 50px rgba(15,23,42,.06); transition:transform .28s, box-shadow .28s, border-color .28s; animation:m1Up .45s ease both; }
    .m1-card:hover { transform:translateY(-7px); box-shadow:0 28px 70px rgba(15,23,42,.13); border-color:color-mix(in srgb,var(--ts) 32%,transparent); }
    .m1-img { height:210px; background:linear-gradient(135deg,var(--ts),var(--tp)); position:relative; overflow:hidden; }
    .m1-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s; }
    .m1-card:hover .m1-img img { transform:scale(1.06); }
    .m1-stock { position:absolute; top:14px; left:14px; padding:6px 10px; border-radius:999px; background:rgba(255,255,255,.86); color:var(--tp); font-size:11px; font-weight:800; }
    .m1-body { padding:20px; display:flex; flex-direction:column; gap:12px; min-height:190px; }
    .m1-body h4 { font-size:17px; line-height:1.25; letter-spacing:-.4px; }
    .m1-tags { display:flex; gap:6px; flex-wrap:wrap; min-height:24px; }
    .m1-tag { font-size:10px; padding:4px 9px; border-radius:999px; background:var(--tm-soft); color:var(--ts); font-weight:700; }
    .m1-bottom { margin-top:auto; display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .m1-price { font-size:24px; font-weight:900; color:var(--tp); letter-spacing:-.8px; }
    .m1-price small { font-size:12px; opacity:.45; font-weight:700; }
    .m1-btn { border:0; background:var(--ts); color:#fff; border-radius:16px; padding:12px 16px; font-size:12px; font-weight:900; cursor:pointer; text-decoration:none; transition:transform .25s, box-shadow .25s; white-space:nowrap; }
    .m1-btn:hover { transform:translateY(-2px); box-shadow:0 14px 30px color-mix(in srgb,var(--ts) 32%,transparent); }
    .m1-empty { grid-column:1/-1; padding:80px 20px; text-align:center; opacity:.45; }
    .m1-foot { text-align:center; padding:44px 0 18px; color:var(--tt); opacity:.38; font-size:12px; }
    .m1-edit { position:fixed; left:24px; bottom:24px; z-index:10000; background:var(--tp); color:#fff; border-radius:999px; padding:12px 20px; font-size:13px; font-weight:800; text-decoration:none; box-shadow:0 18px 40px rgba(0,0,0,.18); }
    @keyframes m1Up { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:820px){ .m1-shell{padding:18px} .m1-hero{grid-template-columns:1fr} .m1-copy{padding:34px 26px;border-radius:26px;min-height:260px} .m1-copy h1{font-size:38px} .m1-section{align-items:flex-start;flex-direction:column} .m1-grid{grid-template-columns:1fr} }
</style>
<?php elseif ($themePart === 'html'): ?>
    <main class="m1-shell">
        <nav class="m1-nav">
            <div class="m1-brand">
                <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="m1-logo" alt="Logo">
                <?php endif; ?>
                <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
            </div>
            <a href="javascript:history.back()" class="m1-back">&larr; Volver</a>
        </nav>

        <section class="m1-hero">
            <div class="m1-copy"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(135deg,rgba(17,24,39,.82),rgba(17,24,39,.55)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat"<?php endif; ?>>
                <div class="m1-kicker">Nueva tienda digital</div>
                <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
                <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
            </div>
            <aside class="m1-side">
                <div class="m1-side-card"><strong><?= count($productos) ?></strong><span>productos publicados</span></div>
                <div class="m1-side-card">
                    <span>Contacto de tienda</span>
                    <div class="m1-contact">
                        <?php if (!empty($emprendimiento['telefono'])): ?><span class="m1-pill"><i class="fas fa-phone"></i> <?= htmlspecialchars($emprendimiento['telefono']) ?></span><?php endif; ?>
                        <?php if (!empty($sucursal['ciudad'])): ?><span class="m1-pill"><i class="fas fa-location-dot"></i> <?= htmlspecialchars($sucursal['ciudad']) ?></span><?php endif; ?>
                    </div>
                </div>
            </aside>
        </section>

        <section class="m1-section"><h3>Catalogo destacado</h3><span><?= count($productos) ?> resultado(s)</span></section>
        <section class="m1-grid">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $producto): $atributos = json_decode($producto['atributos'] ?? '{}', true); ?>
                <article class="m1-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                    <div class="m1-img">
                        <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        <span class="m1-stock"><?= (int)$producto['stock'] ?> disp.</span>
                    </div>
                    <div class="m1-body">
                        <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                        <?php if ($atributos): ?>
                        <div class="m1-tags">
                            <?php foreach (array_slice($atributos, 0, 3) as $val): ?><span class="m1-tag"><?= htmlspecialchars($val) ?></span><?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="m1-bottom">
                            <div class="m1-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                            <?php if ($es_propietario): ?>
                            <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="m1-btn">Editar</a>
                            <?php else: ?>
                            <button class="m1-btn" onclick="mostrarCompra(this)">Comprar</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="m1-empty">No hay productos disponibles en esta tienda aun.</div>
            <?php endif; ?>
        </section>

        <footer class="m1-foot">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></footer>
    </main>
    <?php if ($es_propietario): ?><a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="m1-edit">Editar negocio</a><?php endif; ?>
<?php endif; ?>
