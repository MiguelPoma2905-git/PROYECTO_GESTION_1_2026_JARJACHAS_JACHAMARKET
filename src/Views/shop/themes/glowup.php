<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#7B2D8E') ?>;
        --ts: <?= $p('color_secundario', '#9B59B6') ?>;
        --tb: <?= $p('color_fondo', '#0D0D1A') ?>;
        --tt: <?= $p('color_texto', '#F0E6F6') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(123,45,142,0.10);
        --tgh: rgba(123,45,142,0.22);
        --tgo: rgba(212,175,55,0.12);
        --cart-w: 420px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:var(--tb); color:var(--tt); min-height:100vh; overflow-x:hidden; }
    body::before { content:''; position:fixed; inset:0; background:radial-gradient(ellipse at 20% 10%, rgba(123,45,142,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 90%, rgba(212,175,55,0.04) 0%, transparent 50%); pointer-events:none; z-index:0; }
    .t10-hdr {
        background:rgba(13,13,26,0.92); backdrop-filter:blur(20px);
        padding:14px 40px; display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        border-bottom:1px solid rgba(123,45,142,0.15);
    }
    .t10-hdr-l { display:flex; align-items:center; gap:14px; }
    .t10-hdr-l h2 { font-size:17px; font-weight:700; color:var(--tt); letter-spacing:1px; text-transform:uppercase; }
    .t10-logo { height:34px; width:auto; border-radius:50%; object-fit:cover; border:2px solid rgba(212,175,55,0.2); }
    .t10-hdr .back { color:var(--tt); opacity:0.4; text-decoration:none; font-size:12px; transition:all .2s; }
    .t10-hdr .back:hover { opacity:1; color:var(--ts); }
    .t10-hdr-r { display:flex; align-items:center; gap:10px; }
    .t10-cart-btn { position:relative; background:rgba(255,255,255,0.04); border:1px solid rgba(123,45,142,0.2); border-radius:10px; padding:8px 14px; color:var(--tt); cursor:pointer; transition:all .2s; font-size:13px; display:flex; align-items:center; gap:6px; backdrop-filter:blur(4px); }
    .t10-cart-btn:hover { border-color:var(--ts); background:rgba(155,89,182,0.08); }
    .t10-cart-badge { position:absolute; top:-6px; right:-6px; background:linear-gradient(135deg,var(--ts),var(--tp)); color:#fff; font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:none; align-items:center; justify-content:center; border:2px solid var(--tb); }
    .t10-hero { text-align:center; padding:60px 32px 0; position:relative; z-index:1; }
    .t10-hero h1 { font-size:42px; font-weight:700; color:var(--tt); margin-bottom:8px; letter-spacing:2px; text-transform:uppercase; }
    .t10-hero h1 span { background:linear-gradient(135deg,var(--tt),var(--ts)); -webkit-background-clip:text; background-clip:text; color:transparent; }
    .t10-hero p { font-size:14px; color:var(--tt); opacity:0.5; max-width:500px; margin:0 auto 44px; line-height:1.7; }
    .t10-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; position:relative; z-index:1; }
    .t10-count { text-align:center; font-size:10px; color:var(--ts); letter-spacing:3px; text-transform:uppercase; font-weight:600; margin-bottom:24px; }
    .t10-count::before { content:'✦ '; } .t10-count::after { content:' ✦'; }
    .t10-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:28px; }
    .t10-card {
        background:rgba(255,255,255,0.04); backdrop-filter:blur(16px);
        border-radius:20px; overflow:hidden;
        border:1px solid rgba(123,45,142,0.1);
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        position:relative; animation:t10FU .5s ease both;
        box-shadow:0 8px 32px rgba(0,0,0,0.2);
    }
    .t10-card::before { content:''; position:absolute; inset:-1px; border-radius:21px; background:linear-gradient(135deg,rgba(212,175,55,0.15),rgba(123,45,142,0.15),rgba(212,175,55,0.05)); opacity:0; transition:opacity .4s; pointer-events:none; z-index:-1; }
    .t10-card:hover { transform:translateY(-8px); box-shadow:0 20px 60px rgba(0,0,0,0.3), 0 0 30px var(--tgl); border-color:rgba(155,89,182,0.2); }
    .t10-card:hover::before { opacity:1; }
    .t10-card-img {
        width:100%; height:220px; object-fit:cover;
        background:linear-gradient(135deg,var(--tp),var(--ts)); opacity:0.15;
        display:block; transition:transform .6s;
    }
    .t10-card:hover .t10-card-img { transform:scale(1.05); }
    .t10-card-body { padding:22px 22px 24px; flex:1; display:flex; flex-direction:column; }
    .t10-card-body h3 { font-size:15px; font-weight:600; color:var(--tt); margin-bottom:2px; line-height:1.3; }
    .t10-stars { display:flex; gap:2px; margin:4px 0 8px; }
    .t10-star { font-size:11px; color:rgba(255,255,255,0.08); }
    .t10-star.filled { color:rgba(212,175,55,0.8); }
    .t10-rating-count { font-size:9px; color:var(--tt); opacity:0.3; margin-left:4px; }
    .t10-tags { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px; }
    .t10-tag { font-size:9px; color:var(--ts); background:rgba(155,89,182,0.08); padding:3px 9px; border-radius:4px; border:1px solid rgba(155,89,182,0.1); }
    .t10-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:14px; border-top:1px solid rgba(123,45,142,0.08); }
    .t10-price { font-size:20px; font-weight:700; color:var(--tt); letter-spacing:-.3px; }
    .t10-price small { font-size:12px; font-weight:500; opacity:0.4; }
    .t10-btn { padding:10px 22px; background:linear-gradient(135deg,var(--ts),var(--tp)); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .t10-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px var(--tgh); }
    .t10-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.3; grid-column:1/-1; }
    .t10-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; position:relative; z-index:1; }
    .t10-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:rgba(255,255,255,0.04); backdrop-filter:blur(12px); border:1px solid rgba(123,45,142,0.1); border-radius:16px; font-size:12px; color:var(--tt); opacity:0.7; }
    .t10-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t10-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    .t10-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.2; font-size:11px; border-top:1px solid; margin-top:40px; border-color:rgba(123,45,142,0.08); }
    .t10-wm { position:fixed; bottom:16px; right:20px; display:flex; align-items:center; gap:8px; opacity:0.25; pointer-events:none; z-index:9999; background:rgba(0,0,0,0.3); padding:6px 14px 6px 10px; border-radius:20px; backdrop-filter:blur(4px); }
    .t10-wm img { height:14px; width:auto; opacity:0.5; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:linear-gradient(135deg,var(--ts),var(--tp)); color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 6px 24px var(--tgh); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .btn-edit:hover { transform:translateY(-3px); box-shadow:0 8px 32px var(--tgh); }
    .t10-wa { position:fixed; bottom:24px; right:24px; z-index:9999; width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg,#25D366,#128C7E); color:#fff; border:none; font-size:22px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 20px rgba(37,211,102,0.3); transition:all .3s; text-decoration:none; }
    .t10-wa:hover { transform:scale(1.1); box-shadow:0 8px 30px rgba(37,211,102,0.4); }
    @keyframes t10FU { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .t10-card:nth-child(1){animation-delay:0.03s} .t10-card:nth-child(2){animation-delay:0.06s} .t10-card:nth-child(3){animation-delay:0.09s} .t10-card:nth-child(4){animation-delay:0.12s} .t10-card:nth-child(5){animation-delay:0.15s} .t10-card:nth-child(6){animation-delay:0.18s}
    .t10-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(6px); z-index:99997; display:none; }
    .t10-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:rgba(13,13,26,0.98); border-left:1px solid rgba(123,45,142,0.15); z-index:99998; display:none; flex-direction:column; animation:t10SI .3s ease; backdrop-filter:blur(20px); }
    .t10-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid rgba(123,45,142,0.1); flex-shrink:0; }
    .t10-cart-hdr h3 { font-size:17px; font-weight:700; color:var(--tt); text-transform:uppercase; letter-spacing:1px; }
    .t10-cart-hdr span { font-size:11px; color:var(--tt); opacity:0.35; }
    .t10-cart-close { background:none; border:none; color:var(--tt); opacity:0.3; font-size:20px; cursor:pointer; }
    .t10-cart-close:hover { opacity:1; color:var(--ts); }
    .t10-cart-body { flex:1; overflow-y:auto; padding:16px 24px; }
    .t10-cart-empty { text-align:center; padding:60px 20px; color:var(--tt); opacity:0.25; }
    .t10-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(123,45,142,0.06); }
    .t10-cart-item-img { width:60px; height:60px; border-radius:10px; overflow:hidden; flex-shrink:0; background:rgba(255,255,255,0.04); }
    .t10-cart-item-img img { width:100%; height:100%; object-fit:cover; }
    .t10-cart-item-info { flex:1; min-width:0; }
    .t10-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--tt); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .t10-cart-item-info .p { font-size:14px; font-weight:700; color:var(--ts); }
    .t10-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
    .t10-cart-qty button { width:26px; height:26px; border-radius:6px; border:1px solid rgba(123,45,142,0.15); background:rgba(255,255,255,0.04); color:var(--tt); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
    .t10-cart-qty button:hover { border-color:var(--ts); background:rgba(155,89,182,0.1); }
    .t10-cart-qty span { font-size:13px; font-weight:600; color:var(--tt); min-width:20px; text-align:center; }
    .t10-cart-item-del { background:none; border:none; color:rgba(155,89,182,0.3); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; }
    .t10-cart-item-del:hover { color:var(--ts); }
    .t10-cart-foot { border-top:1px solid rgba(123,45,142,0.08); padding:20px 24px; flex-shrink:0; }
    .t10-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
    .t10-cart-total span { font-size:11px; color:var(--tt); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
    .t10-cart-total strong { font-size:20px; font-weight:700; color:var(--tt); }
    .t10-cart-checkout { width:100%; padding:14px; background:linear-gradient(135deg,var(--ts),var(--tp)); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; transition:all .3s; }
    .t10-cart-checkout:hover { transform:translateY(-2px); box-shadow:0 8px 24px var(--tgh); }
    .t10-cart-checkout:disabled { opacity:.4; cursor:not-allowed; transform:none; }
    @keyframes t10SI { from{transform:translateX(100%)} to{transform:translateX(0)} }
    .t10-notif { position:fixed; top:20px; right:20px; z-index:99999; padding:14px 24px; border-radius:10px; font-size:13px; font-weight:500; max-width:340px; background:rgba(13,13,26,0.95); backdrop-filter:blur(12px); border:1px solid rgba(123,45,142,0.2); display:none; animation:t10NF .3s ease; }
    .t10-notif.success { color:#2d7a4a; border-left:4px solid #2d7a4a; }
    .t10-notif.error { color:var(--ts); border-left:4px solid var(--ts); }
    @keyframes t10NF { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:768px){
        .t10-hdr{padding:12px 20px} .t10-hero{padding:40px 20px 0}
        .t10-hero h1{font-size:28px} .t10-ctn{padding:0 16px 40px}
        .t10-grid{grid-template-columns:1fr;gap:20px} .t10-card-img{height:190px}
        :root{--cart-w:100vw}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t10-hdr">
        <div class="t10-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t10-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="t10-hdr-r">
            <?php if (!$es_propietario): ?>
            <button class="t10-cart-btn" onclick="abrirCarrito()"><i class="fas fa-shopping-bag"></i> <span id="t10CartBadge" class="t10-cart-badge">0</span></button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr; Volver</a>
        </div>
    </div>
    <div class="t10-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.55),rgba(0,0,0,0.55)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat;padding:80px 32px 40px"<?php endif; ?>>
        <h1><span><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></span></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t10-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t10-count"><?= count($productos) ?> producto(s)</div>
        <div class="t10-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
                $valoracion = floatval($atributos['valoracion'] ?? 0);
                $totalVotos = intval($atributos['total_votos'] ?? 0);
            ?>
            <div class="t10-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t10-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <div class="t10-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if ($valoracion > 0): ?>
                    <div class="t10-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="t10-star <?= $i <= $valoracion ? 'filled' : '' ?>">★</span>
                        <?php endfor; ?>
                        <?php if ($totalVotos > 0): ?><span class="t10-rating-count">(<?= $totalVotos ?>)</span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($atributos): ?>
                    <div class="t10-tags">
                        <?php foreach ($atributos as $key => $val):
                            if (in_array($key, ['valoracion','total_votos'])) continue; ?>
                            <span class="t10-tag"><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t10-card-bot">
                        <div class="t10-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t10-btn" style="text-decoration:none"><i class="fas fa-pen"></i> Editar</a>
                        <?php else: ?>
                        <button class="t10-btn" onclick="agregarAlCarrito(this)">Añadir</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t10-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t10-contact">
        <div class="t10-contact-inner">
            <?php if (!empty($emprendimiento['telefono'])): ?>
            <span><i class="fas fa-phone" style="color:var(--ts)"></i> <?= htmlspecialchars($emprendimiento['telefono']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['direccion'])): ?>
            <span><i class="fas fa-map-pin" style="color:var(--ts)"></i> <?= htmlspecialchars($sucursal['direccion']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['ciudad'])): ?>
            <span><i class="fas fa-city" style="color:var(--ts)"></i> <?= htmlspecialchars($sucursal['ciudad']) ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="t10-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Glow up ✨</p>
    </div>
    <div class="t10-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if (!empty($emprendimiento['telefono'])): ?>
    <a href="https://wa.me/591<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $emprendimiento['telefono'] ?? '71234567')) ?>?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20productos" target="_blank" class="t10-wa" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <?php endif; ?>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit"><i class="fas fa-pen"></i> Editar</a>
    <?php endif; ?>
    <?php if (!$es_propietario): ?>
    <div class="t10-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="t10-cart-drawer" id="cartDrawer">
        <div class="t10-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="t10-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="t10-cart-body" id="cartBody">
            <div class="t10-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="t10-cart-foot" id="cartFoot" style="display:none">
            <div class="t10-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="t10-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <div id="t10Notif" class="t10-notif"></div>
    <?php endif; ?>
    <script>
    let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');

    function guardarCarrito() { localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito)); actualizarCarritoUI(); }

    function actualizarCarritoUI() {
        const badge = document.getElementById('t10CartBadge');
        const count = carrito.reduce((s,i) => s + i.cantidad, 0);
        if (badge) { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
        const label = document.getElementById('cartCountLabel');
        if (label) label.textContent = count + ' producto(s)';
        renderCarrito();
    }

    function escHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

    function renderCarrito() {
        const body = document.getElementById('cartBody');
        const foot = document.getElementById('cartFoot');
        if (!body) return;
        if (carrito.length === 0) { body.innerHTML = '<div class="t10-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>'; if (foot) foot.style.display = 'none'; return; }
        if (foot) foot.style.display = 'block';
        let html = '', total = 0;
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            html += '<div class="t10-cart-item"><div class="t10-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div><div class="t10-cart-item-info"><h4>' + escHtml(item.nombre) + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div><div class="t10-cart-qty"><button onclick="cambiarCantidad(' + idx + ',-1)">-</button><span>' + item.cantidad + '</span><button onclick="cambiarCantidad(' + idx + ',1)">+</button></div></div><button class="t10-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button></div>';
        });
        body.innerHTML = html;
        document.getElementById('cartTotal').textContent = 'Bs. ' + total.toFixed(2);
    }

    function agregarAlCarrito(btn) {
        if (ES_PROPIETARIO) { mostrarNotif('Eres el dueño', 'error'); return; }
        const card = btn.closest('[data-id]');
        if (!card) return;
        const id = parseInt(card.dataset.id), nombre = card.dataset.nombre, precio = parseFloat(card.dataset.precio), stock = parseInt(card.dataset.stock || '0');
        const imgEl = card.querySelector('img'); const img = imgEl ? imgEl.getAttribute('src')?.replace(BASE + '/', '') || '' : '';
        const existe = carrito.findIndex(i => i.id === id);
        if (existe >= 0) { const nc = carrito[existe].cantidad + 1; if (nc > stock) { mostrarNotif('Stock: ' + stock, 'error'); return; } carrito[existe].cantidad = nc; }
        else { if (stock < 1) { mostrarNotif('Agotado', 'error'); return; } carrito.push({ id, nombre, precio, cantidad:1, stock, img }); }
        guardarCarrito(); mostrarNotif('✓ ' + nombre + ' añadido', 'success');
    }

    function cambiarCantidad(idx, delta) {
        if (idx < 0 || idx >= carrito.length) return;
        const item = carrito[idx]; const nueva = item.cantidad + delta;
        if (nueva < 1) carrito.splice(idx, 1);
        else if (nueva > item.stock) { mostrarNotif('Stock: ' + item.stock, 'error'); return; }
        else item.cantidad = nueva;
        guardarCarrito();
    }

    function eliminarDelCarrito(idx) { carrito.splice(idx, 1); guardarCarrito(); }
    function abrirCarrito() { document.getElementById('cartDrawer').style.display = 'flex'; document.getElementById('cartOverlay').style.display = 'block'; renderCarrito(); }
    function cerrarCarrito() { document.getElementById('cartDrawer').style.display = 'none'; document.getElementById('cartOverlay').style.display = 'none'; }

    function checkoutCarrito() {
        if (carrito.length === 0) return;
        const btn = document.getElementById('cartCheckoutBtn'); btn.disabled = true; btn.textContent = 'Procesando...';
        const data = new URLSearchParams();
        data.set('items', JSON.stringify(carrito.map(i => ({ id: i.id, cantidad: i.cantidad }))));
        data.set('total', carrito.reduce((s,i) => s + i.precio * i.cantidad, 0));
        fetch(BASE + '/pedido/comprar-rapido', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:data.toString() })
        .then(r => r.json()).then(res => {
            if (res.success) { mostrarNotif('✓ Pedido: ' + (res.codigo || '#OK'), 'success'); carrito = []; guardarCarrito(); cerrarCarrito(); }
            else { mostrarNotif('✗ ' + (res.error || 'Error'), 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; }
        }).catch(() => { mostrarNotif('✗ Error', 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; });
    }

    function mostrarNotif(msg, type) {
        const el = document.getElementById('t10Notif'); if (!el) return;
        el.textContent = msg; el.className = 't10-notif ' + type; el.style.display = 'block';
        clearTimeout(el._t); el._t = setTimeout(() => { el.style.display = 'none'; }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() { actualizarCarritoUI(); });
    </script>
<?php endif; ?>
