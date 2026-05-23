<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#D44A6E') ?>;
        --ts: <?= $p('color_secundario', '#B8325A') ?>;
        --tb: <?= $p('color_fondo', '#FDF8FA') ?>;
        --tt: <?= $p('color_texto', '#2D1B2E') ?>;
        --ef: '<?= $tipografia ?>', 'Playfair Display', Georgia, serif;
        --tgl: rgba(212,74,110,0.08);
        --tgh: rgba(212,74,110,0.18);
        --cart-w: 400px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:var(--tb); color:var(--tt); min-height:100vh; }
    .t7-hdr {
        background:#fff; padding:16px 40px;
        display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        box-shadow:0 2px 24px rgba(0,0,0,0.04);
        border-bottom:2px solid var(--tgl);
    }
    .t7-hdr-l { display:flex; align-items:center; gap:14px; }
    .t7-hdr-l h2 { font-size:18px; font-weight:600; color:var(--tt); letter-spacing:-.3px; font-family:'Playfair Display',Georgia,serif; }
    .t7-logo { height:34px; width:auto; border-radius:50%; object-fit:cover; }
    .t7-hdr .back { color:var(--tt); opacity:0.4; text-decoration:none; font-size:12px; transition:all .2s; }
    .t7-hdr .back:hover { opacity:1; color:var(--tp); }
    .t7-hdr-r { display:flex; align-items:center; gap:10px; }
    .t7-cart-btn { position:relative; background:var(--tgl); border:none; border-radius:50%; width:38px; height:38px; color:var(--tp); cursor:pointer; transition:all .2s; font-size:16px; display:flex; align-items:center; justify-content:center; }
    .t7-cart-btn:hover { background:var(--tgh); }
    .t7-cart-badge { position:absolute; top:-4px; right:-4px; background:var(--tp); color:#fff; font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:none; align-items:center; justify-content:center; border:2px solid #fff; }
    .t7-hero { text-align:center; padding:56px 32px 0; position:relative; }
    .t7-hero::before {
        content:'✦'; position:absolute; top:24px; left:50%; transform:translateX(-50%);
        font-size:20px; color:var(--tp); opacity:0.3;
    }
    .t7-hero h1 {
        font-size:40px; font-weight:400; font-family:'Playfair Display',Georgia,serif;
        color:var(--tt); margin-bottom:8px; letter-spacing:0px;
    }
    .t7-hero p { font-size:14px; color:var(--tt); opacity:0.5; max-width:520px; margin:0 auto 44px; line-height:1.7; font-style:italic; }
    .t7-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; }
    .t7-count { text-align:center; font-size:11px; color:var(--tp); letter-spacing:3px; text-transform:uppercase; font-weight:500; margin-bottom:24px; }
    .t7-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:24px; }
    .t7-card {
        background:#fff; border-radius:16px; overflow:hidden;
        box-shadow:0 2px 16px rgba(0,0,0,0.04);
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        border:1px solid rgba(0,0,0,0.04);
        position:relative; animation:t7FU .5s ease both;
    }
    .t7-card:hover { transform:translateY(-6px); box-shadow:0 12px 40px var(--tgl); border-color:color-mix(in srgb,var(--tp) 15%,transparent); }
    .t7-card-img {
        width:100%; height:240px; object-fit:cover;
        background:linear-gradient(135deg,var(--tp),var(--ts));
        opacity:0.1; display:block; transition:transform .5s;
    }
    .t7-card:hover .t7-card-img { transform:scale(1.04); }
    .t7-wish { position:absolute; top:12px; right:12px; background:rgba(255,255,255,0.85); backdrop-filter:blur(4px); width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--tt); opacity:0.5; font-size:15px; transition:all .2s; border:none; z-index:2; }
    .t7-wish:hover { opacity:1; color:var(--tp); }
    .t7-wish.active { opacity:1; color:var(--tp); background:rgba(212,74,110,0.12); }
    .t7-card-body { padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
    .t7-card-body h3 { font-size:15px; font-weight:600; color:var(--tt); margin-bottom:3px; line-height:1.3; }
    .t7-size { font-size:11px; color:var(--tt); opacity:0.45; margin-bottom:8px; }
    .t7-tags { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px; }
    .t7-tag { font-size:9px; color:var(--tp); background:var(--tgl); padding:3px 9px; border-radius:3px; letter-spacing:.5px; text-transform:uppercase; font-weight:500; }
    .t7-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:12px; border-top:1px solid rgba(0,0,0,0.05); }
    .t7-price { font-size:20px; font-weight:700; color:var(--tp); letter-spacing:-.3px; }
    .t7-price small { font-size:12px; font-weight:500; opacity:0.5; }
    .t7-btn { padding:9px 20px; background:var(--tp); color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .t7-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px var(--tgh); }
    .t7-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.4; grid-column:1/-1; }
    .t7-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; }
    .t7-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:#fff; border:1px solid rgba(0,0,0,0.04); border-radius:12px; font-size:12px; color:var(--tt); opacity:0.7; box-shadow:0 2px 12px var(--tgl); }
    .t7-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t7-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    .t7-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.25; font-size:11px; border-top:1px solid; margin-top:40px; border-color:rgba(0,0,0,0.05); font-style:italic; }
    .t7-wm { position:fixed; bottom:12px; right:16px; display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.85); backdrop-filter:blur(8px); padding:4px 12px 4px 8px; border-radius:20px; opacity:0.4; pointer-events:none; z-index:9999; }
    .t7-wm img { height:16px; width:auto; opacity:0.4; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--tp); color:#fff; border:none; border-radius:10px; padding:11px 22px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 6px 24px var(--tgh); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .btn-edit:hover { transform:translateY(-2px); box-shadow:0 8px 32px var(--tgh); }
    @keyframes t7FU { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .t7-card:nth-child(1){animation-delay:0.04s} .t7-card:nth-child(2){animation-delay:0.08s} .t7-card:nth-child(3){animation-delay:0.12s} .t7-card:nth-child(4){animation-delay:0.16s} .t7-card:nth-child(5){animation-delay:0.20s} .t7-card:nth-child(6){animation-delay:0.24s}
    .t7-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.3); backdrop-filter:blur(4px); z-index:99997; display:none; }
    .t7-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:#fff; border-left:1px solid rgba(0,0,0,0.06); z-index:99998; display:none; flex-direction:column; animation:t7SI .3s ease; }
    .t7-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid rgba(0,0,0,0.04); flex-shrink:0; }
    .t7-cart-hdr h3 { font-size:17px; font-weight:600; color:var(--tt); font-family:'Playfair Display',Georgia,serif; }
    .t7-cart-hdr span { font-size:11px; color:var(--tt); opacity:0.35; }
    .t7-cart-close { background:none; border:none; color:var(--tt); opacity:0.3; font-size:20px; cursor:pointer; }
    .t7-cart-close:hover { opacity:1; color:var(--tp); }
    .t7-cart-body { flex:1; overflow-y:auto; padding:16px 24px; }
    .t7-cart-empty { text-align:center; padding:60px 20px; color:var(--tt); opacity:0.3; }
    .t7-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(0,0,0,0.04); }
    .t7-cart-item-img { width:60px; height:60px; border-radius:10px; overflow:hidden; flex-shrink:0; background:var(--tgl); }
    .t7-cart-item-img img { width:100%; height:100%; object-fit:cover; }
    .t7-cart-item-info { flex:1; min-width:0; }
    .t7-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--tt); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .t7-cart-item-info .p { font-size:14px; font-weight:700; color:var(--tp); }
    .t7-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
    .t7-cart-qty button { width:26px; height:26px; border-radius:6px; border:1px solid rgba(0,0,0,0.08); background:var(--tgl); color:var(--tt); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
    .t7-cart-qty button:hover { border-color:var(--tp); }
    .t7-cart-qty span { font-size:13px; font-weight:600; color:var(--tt); min-width:20px; text-align:center; }
    .t7-cart-item-del { background:none; border:none; color:rgba(212,74,110,0.3); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; }
    .t7-cart-item-del:hover { color:var(--tp); }
    .t7-cart-foot { border-top:1px solid rgba(0,0,0,0.04); padding:20px 24px; flex-shrink:0; }
    .t7-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
    .t7-cart-total span { font-size:11px; color:var(--tt); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
    .t7-cart-total strong { font-size:20px; font-weight:700; color:var(--tt); }
    .t7-cart-checkout { width:100%; padding:14px; background:var(--tp); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; transition:all .3s; }
    .t7-cart-checkout:hover { transform:translateY(-2px); box-shadow:0 8px 24px var(--tgh); }
    .t7-cart-checkout:disabled { opacity:.4; cursor:not-allowed; transform:none; box-shadow:none; }
    @keyframes t7SI { from{transform:translateX(100%)} to{transform:translateX(0)} }
    .t7-notif { position:fixed; top:20px; right:20px; z-index:99999; padding:14px 24px; border-radius:10px; font-size:13px; font-weight:500; max-width:340px; box-shadow:0 8px 32px rgba(0,0,0,0.12); display:none; animation:t7NF .3s ease; backdrop-filter:blur(8px); }
    .t7-notif.success { background:#fff; color:#2d7a4a; border-left:4px solid #2d7a4a; }
    .t7-notif.error { background:#fff; color:#d44a6e; border-left:4px solid var(--tp); }
    @keyframes t7NF { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:768px){
        .t7-hdr{padding:14px 20px} .t7-hero{padding:40px 20px 0}
        .t7-hero h1{font-size:30px} .t7-ctn{padding:0 16px 40px}
        .t7-grid{grid-template-columns:1fr;gap:20px} .t7-card-img{height:200px}
        :root{--cart-w:100vw}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t7-hdr">
        <div class="t7-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t7-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="t7-hdr-r">
            <?php if (!$es_propietario): ?>
            <button class="t7-cart-btn" onclick="abrirCarrito()"><i class="fas fa-shopping-bag"></i><span id="t7CartBadge" class="t7-cart-badge">0</span></button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr; Volver</a>
        </div>
    </div>
    <div class="t7-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat;padding:80px 32px 40px"<?php endif; ?>>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t7-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t7-count"><?= count($productos) ?> producto(s)</div>
        <div class="t7-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
            ?>
            <div class="t7-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t7-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <?php if (!$es_propietario): ?>
                <button class="t7-wish" onclick="toggleWishlist(this)" data-id="<?= $producto['id_producto'] ?>">♡</button>
                <?php endif; ?>
                <div class="t7-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if ($atributos && isset($atributos['talla'])): ?>
                        <div class="t7-size">Talla: <?= htmlspecialchars($atributos['talla']) ?></div>
                    <?php elseif ($atributos && isset($atributos['tamano'])): ?>
                        <div class="t7-size">Tamaño: <?= htmlspecialchars($atributos['tamano']) ?></div>
                    <?php endif; ?>
                    <?php if ($atributos): ?>
                    <div class="t7-tags">
                        <?php foreach ($atributos as $key => $val):
                            if (in_array($key, ['talla','tamano'])) continue; ?>
                            <span class="t7-tag"><?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t7-card-bot">
                        <div class="t7-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t7-btn" style="text-decoration:none"><i class="fas fa-pen"></i> Editar</a>
                        <?php else: ?>
                        <button class="t7-btn" onclick="agregarAlCarrito(this)"><i class="fas fa-shopping-bag"></i> Agregar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t7-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t7-contact">
        <div class="t7-contact-inner">
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
    <div class="t7-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Hecho con amor.</p>
    </div>
    <div class="t7-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
    <?php if (!$es_propietario): ?>
    <div class="t7-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="t7-cart-drawer" id="cartDrawer">
        <div class="t7-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="t7-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="t7-cart-body" id="cartBody">
            <div class="t7-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="t7-cart-foot" id="cartFoot" style="display:none">
            <div class="t7-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="t7-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <div id="t7Notif" class="t7-notif"></div>
    <?php endif; ?>
    <script>
    let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');
    let wishlist = JSON.parse(localStorage.getItem('jacha_wish_' + TIENDA_ID) || '[]');

    function guardarCarrito() { localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito)); actualizarCarritoUI(); }

    function actualizarCarritoUI() {
        const badge = document.getElementById('t7CartBadge');
        const count = carrito.reduce((s,i) => s + i.cantidad, 0);
        if (badge) { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
        const label = document.getElementById('cartCountLabel');
        if (label) label.textContent = count + ' producto(s)';
        renderCarrito();
    }

    function renderCarrito() {
        const body = document.getElementById('cartBody');
        const foot = document.getElementById('cartFoot');
        if (!body) return;
        if (carrito.length === 0) { body.innerHTML = '<div class="t7-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>'; if (foot) foot.style.display = 'none'; return; }
        if (foot) foot.style.display = 'block';
        let html = '', total = 0;
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            html += '<div class="t7-cart-item"><div class="t7-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div><div class="t7-cart-item-info"><h4>' + item.nombre + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div><div class="t7-cart-qty"><button onclick="cambiarCantidad(' + idx + ',-1)">-</button><span>' + item.cantidad + '</span><button onclick="cambiarCantidad(' + idx + ',1)">+</button></div></div><button class="t7-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button></div>';
        });
        body.innerHTML = html;
        document.getElementById('cartTotal').textContent = 'Bs. ' + total.toFixed(2);
    }

    function agregarAlCarrito(btn) {
        if (ES_PROPIETARIO) { mostrarNotif('Eres el dueño de esta tienda', 'error'); return; }
        const card = btn.closest('[data-id]');
        if (!card) return;
        const id = parseInt(card.dataset.id), nombre = card.dataset.nombre, precio = parseFloat(card.dataset.precio), stock = parseInt(card.dataset.stock || '0');
        const imgEl = card.querySelector('img'); const img = imgEl ? imgEl.getAttribute('src')?.replace(BASE + '/', '') || '' : '';
        const existe = carrito.findIndex(i => i.id === id);
        if (existe >= 0) { const nc = carrito[existe].cantidad + 1; if (nc > stock) { mostrarNotif('Stock máximo: ' + stock, 'error'); return; } carrito[existe].cantidad = nc; }
        else { if (stock < 1) { mostrarNotif('Producto agotado', 'error'); return; } carrito.push({ id, nombre, precio, cantidad:1, stock, img }); }
        guardarCarrito(); mostrarNotif('✓ ' + nombre + ' añadido', 'success');
    }

    function cambiarCantidad(idx, delta) {
        if (idx < 0 || idx >= carrito.length) return;
        const item = carrito[idx]; const nueva = item.cantidad + delta;
        if (nueva < 1) carrito.splice(idx, 1);
        else if (nueva > item.stock) { mostrarNotif('Stock máximo: ' + item.stock, 'error'); return; }
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
            if (res.success) { mostrarNotif('✓ Pedido creado: ' + (res.codigo || '#OK'), 'success'); carrito = []; guardarCarrito(); cerrarCarrito(); }
            else { mostrarNotif('✗ ' + (res.error || 'Error'), 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; }
        }).catch(() => { mostrarNotif('✗ Error de conexión', 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; });
    }

    function toggleWishlist(btn) {
        const id = parseInt(btn.dataset.id); const idx = wishlist.indexOf(id);
        if (idx >= 0) { wishlist.splice(idx, 1); btn.classList.remove('active'); btn.textContent = '♡'; }
        else { wishlist.push(id); btn.classList.add('active'); btn.textContent = '♥'; }
        localStorage.setItem('jacha_wish_' + TIENDA_ID, JSON.stringify(wishlist));
    }

    function mostrarNotif(msg, type) {
        const el = document.getElementById('t7Notif'); if (!el) return;
        el.textContent = msg; el.className = 't7-notif ' + type; el.style.display = 'block';
        clearTimeout(el._t); el._t = setTimeout(() => { el.style.display = 'none'; }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() { actualizarCarritoUI();
        document.querySelectorAll('.t7-wish').forEach(btn => {
            const id = parseInt(btn.dataset.id); if (wishlist.includes(id)) { btn.classList.add('active'); btn.textContent = '♥'; }
        });
    });
    </script>
<?php endif; ?>
