<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#16A34A') ?>;
        --ts: <?= $p('color_secundario', '#22C55E') ?>;
        --tb: <?= $p('color_fondo', '#0A0F0D') ?>;
        --tt: <?= $p('color_texto', '#E8F0EA') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(22,163,74,0.08);
        --tgh: rgba(22,163,74,0.18);
        --cart-w: 400px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:var(--tb); color:var(--tt); min-height:100vh; }
    body::before { content:''; position:fixed; inset:0; background:radial-gradient(ellipse at 30% 20%, rgba(22,163,74,0.06) 0%, transparent 50%), radial-gradient(ellipse at 70% 80%, rgba(34,197,94,0.04) 0%, transparent 50%); pointer-events:none; z-index:0; }
    .t11-hdr {
        background:rgba(10,15,13,0.95); backdrop-filter:blur(16px);
        padding:14px 40px; display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        border-bottom:2px solid rgba(22,163,74,0.15);
    }
    .t11-hdr-l { display:flex; align-items:center; gap:14px; }
    .t11-hdr-l h2 { font-size:18px; font-weight:800; color:var(--tt); letter-spacing:0; text-transform:uppercase; }
    .t11-logo { height:34px; width:auto; border-radius:4px; object-fit:cover; }
    .t11-hdr .back { color:var(--tt); opacity:0.4; text-decoration:none; font-size:12px; font-weight:600; transition:all .2s; }
    .t11-hdr .back:hover { opacity:1; color:var(--ts); }
    .t11-hdr-r { display:flex; align-items:center; gap:10px; }
    .t11-cart-btn { position:relative; background:rgba(255,255,255,0.04); border:1px solid rgba(22,163,74,0.15); border-radius:4px; padding:8px 14px; color:var(--tt); cursor:pointer; transition:all .2s; font-size:13px; font-weight:600; display:flex; align-items:center; gap:6px; text-transform:uppercase; letter-spacing:.5px; }
    .t11-cart-btn:hover { border-color:var(--ts); background:rgba(34,197,94,0.06); color:var(--ts); }
    .t11-cart-badge { position:absolute; top:-6px; right:-6px; background:var(--tp); color:#fff; font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:4px; display:none; align-items:center; justify-content:center; border:2px solid var(--tb); }
    .t11-hero { text-align:center; padding:60px 32px 0; position:relative; z-index:1; }
    .t11-hero h1 { font-size:44px; font-weight:900; color:var(--tt); margin-bottom:8px; letter-spacing:-1px; text-transform:uppercase; }
    .t11-hero h1::after { content:' 💪'; }
    .t11-hero p { font-size:14px; color:var(--tt); opacity:0.5; max-width:540px; margin:0 auto 44px; line-height:1.7; font-weight:300; }
    .t11-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; position:relative; z-index:1; }
    .t11-count { text-align:center; font-size:10px; color:var(--ts); letter-spacing:3px; text-transform:uppercase; font-weight:700; margin-bottom:24px; }
    .t11-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(270px,1fr)); gap:24px; }
    .t11-card {
        background:rgba(255,255,255,0.03); border:1px solid rgba(22,163,74,0.08);
        border-radius:0; overflow:hidden;
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        position:relative; animation:t11FU .5s ease both;
    }
    .t11-card:hover { transform:translateY(-6px); border-color:rgba(34,197,94,0.2); box-shadow:0 16px 48px rgba(0,0,0,0.3); }
        .t11-card-img {
            width:100%; height:220px; object-fit:cover;
            background:linear-gradient(135deg,var(--tp),var(--ts));
            display:block; transition:transform .5s;
        }
    .t11-card:hover .t11-card-img { transform:scale(1.04); }
    .t11-card-body { padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
    .t11-card-body h3 { font-size:15px; font-weight:700; color:var(--tt); margin-bottom:2px; line-height:1.3; text-transform:uppercase; letter-spacing:.5px; }
    .t11-stock-bar { height:4px; background:rgba(255,255,255,0.06); border-radius:2px; margin:8px 0 6px; overflow:hidden; }
    .t11-stock-fill { height:100%; background:linear-gradient(90deg,var(--tp),var(--ts)); border-radius:2px; transition:width .4s; }
    .t11-stock-label { font-size:9px; color:var(--tt); opacity:0.35; text-transform:uppercase; letter-spacing:1px; }
    .t11-tags { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px; }
    .t11-tag { font-size:9px; color:var(--ts); background:rgba(34,197,94,0.06); padding:2px 8px; border:1px solid rgba(34,197,94,0.1); text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
    .t11-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:14px; border-top:1px solid rgba(22,163,74,0.06); }
    .t11-price { font-size:22px; font-weight:800; color:var(--ts); letter-spacing:-.3px; }
    .t11-price small { font-size:12px; font-weight:500; opacity:0.4; }
    .t11-btn { padding:10px 24px; background:var(--tp); color:#fff; border:none; font-size:11px; font-weight:700; cursor:pointer; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; text-transform:uppercase; letter-spacing:1px; }
    .t11-btn:hover { background:var(--ts); transform:translateY(-2px); box-shadow:0 4px 20px rgba(34,197,94,0.2); }
    .t11-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.3; grid-column:1/-1; }
    .t11-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; position:relative; z-index:1; }
    .t11-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:rgba(255,255,255,0.03); border:1px solid rgba(22,163,74,0.08); font-size:12px; color:var(--tt); opacity:0.7; }
    .t11-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t11-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    .t11-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.2; font-size:11px; border-top:1px solid; margin-top:40px; border-color:rgba(22,163,74,0.06); text-transform:uppercase; letter-spacing:2px; }
    .t11-wm { position:fixed; bottom:16px; right:20px; display:flex; align-items:center; gap:8px; opacity:0.2; pointer-events:none; z-index:9999; background:rgba(0,0,0,0.4); padding:6px 14px 6px 10px; border-radius:4px; }
    .t11-wm img { height:14px; width:auto; opacity:0.5; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--tp); color:#fff; border:none; padding:10px 22px; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 4px 20px rgba(0,0,0,0.3); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; letter-spacing:1px; }
    .btn-edit:hover { background:var(--ts); transform:translateY(-3px); box-shadow:0 8px 32px rgba(34,197,94,0.2); }
    .t11-wa { position:fixed; bottom:24px; right:24px; z-index:9999; width:50px; height:50px; border-radius:0; background:#25D366; color:#fff; border:none; font-size:22px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 20px rgba(37,211,102,0.3); transition:all .3s; text-decoration:none; }
    .t11-wa:hover { transform:scale(1.1); }
    @keyframes t11FU { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .t11-card:nth-child(1){animation-delay:0.04s} .t11-card:nth-child(2){animation-delay:0.08s} .t11-card:nth-child(3){animation-delay:0.12s} .t11-card:nth-child(4){animation-delay:0.16s} .t11-card:nth-child(5){animation-delay:0.20s} .t11-card:nth-child(6){animation-delay:0.24s}
    .t11-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:99997; display:none; }
    .t11-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:rgba(10,15,13,0.98); border-left:1px solid rgba(22,163,74,0.1); z-index:99998; display:none; flex-direction:column; animation:t11SI .3s ease; }
    .t11-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid rgba(22,163,74,0.08); flex-shrink:0; }
    .t11-cart-hdr h3 { font-size:17px; font-weight:700; color:var(--tt); text-transform:uppercase; letter-spacing:1px; }
    .t11-cart-hdr span { font-size:11px; color:var(--tt); opacity:0.35; }
    .t11-cart-close { background:none; border:none; color:var(--tt); opacity:0.3; font-size:20px; cursor:pointer; }
    .t11-cart-close:hover { opacity:1; color:var(--ts); }
    .t11-cart-body { flex:1; overflow-y:auto; padding:16px 24px; }
    .t11-cart-empty { text-align:center; padding:60px 20px; color:var(--tt); opacity:0.25; }
    .t11-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(22,163,74,0.06); }
    .t11-cart-item-img { width:60px; height:60px; border-radius:0; overflow:hidden; flex-shrink:0; background:rgba(255,255,255,0.04); }
    .t11-cart-item-img img { width:100%; height:100%; object-fit:cover; }
    .t11-cart-item-info { flex:1; min-width:0; }
    .t11-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--tt); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-transform:uppercase; letter-spacing:.5px; }
    .t11-cart-item-info .p { font-size:14px; font-weight:700; color:var(--ts); }
    .t11-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
    .t11-cart-qty button { width:26px; height:26px; border:1px solid rgba(22,163,74,0.15); background:rgba(255,255,255,0.04); color:var(--tt); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
    .t11-cart-qty button:hover { border-color:var(--ts); }
    .t11-cart-qty span { font-size:13px; font-weight:600; color:var(--tt); min-width:20px; text-align:center; }
    .t11-cart-item-del { background:none; border:none; color:rgba(22,163,74,0.3); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; }
    .t11-cart-item-del:hover { color:var(--ts); }
    .t11-cart-foot { border-top:1px solid rgba(22,163,74,0.06); padding:20px 24px; flex-shrink:0; }
    .t11-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
    .t11-cart-total span { font-size:11px; color:var(--tt); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
    .t11-cart-total strong { font-size:20px; font-weight:700; color:var(--tt); }
    .t11-cart-checkout { width:100%; padding:14px; background:var(--tp); color:#fff; border:none; font-size:14px; font-weight:700; cursor:pointer; transition:all .3s; text-transform:uppercase; letter-spacing:1px; }
    .t11-cart-checkout:hover { background:var(--ts); }
    .t11-cart-checkout:disabled { opacity:.4; cursor:not-allowed; }
    @keyframes t11SI { from{transform:translateX(100%)} to{transform:translateX(0)} }
    .t11-notif { position:fixed; top:20px; right:20px; z-index:99999; padding:14px 24px; font-size:13px; font-weight:600; max-width:340px; background:rgba(10,15,13,0.95); border:1px solid rgba(22,163,74,0.15); display:none; animation:t11NF .3s ease; text-transform:uppercase; letter-spacing:.5px; }
    .t11-notif.success { color:#22C55E; border-left:4px solid var(--ts); }
    .t11-notif.error { color:#ef4444; border-left:4px solid #ef4444; }
    @keyframes t11NF { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:768px){
        .t11-hdr{padding:12px 20px} .t11-hero{padding:40px 20px 0}
        .t11-hero h1{font-size:28px} .t11-ctn{padding:0 16px 40px}
        .t11-grid{grid-template-columns:1fr;gap:20px} .t11-card-img{height:200px}
        :root{--cart-w:100vw} .t11-hdr-l h2{font-size:14px}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t11-hdr">
        <div class="t11-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t11-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="t11-hdr-r">
            <?php if (!$es_propietario): ?>
            <button class="t11-cart-btn" onclick="abrirCarrito()"><i class="fas fa-dumbbell"></i> <span id="t11CartBadge" class="t11-cart-badge">0</span></button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr; Volver</a>
        </div>
    </div>
    <div class="t11-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.55),rgba(0,0,0,0.55)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat;padding:80px 32px 40px"<?php endif; ?>>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t11-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t11-count"><?= count($productos) ?> producto(s)</div>
        <div class="t11-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
                $stockPct = min(100, max(0, ($producto['stock'] / 30) * 100));
            ?>
            <div class="t11-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t11-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <div class="t11-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <div class="t11-stock-bar"><div class="t11-stock-fill" style="width:<?= $stockPct ?>%"></div></div>
                    <div class="t11-stock-label">Stock: <?= $producto['stock'] ?> unidades</div>
                    <?php if ($atributos): ?>
                    <div class="t11-tags">
                        <?php foreach ($atributos as $key => $val): ?>
                            <span class="t11-tag"><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t11-card-bot">
                        <div class="t11-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t11-btn" style="text-decoration:none">Editar</a>
                        <?php else: ?>
                        <button class="t11-btn" onclick="agregarAlCarrito(this)">Añadir</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t11-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t11-contact">
        <div class="t11-contact-inner">
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
    <div class="t11-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Full fit 💪</p>
    </div>
    <div class="t11-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if (!empty($emprendimiento['telefono'])): ?>
    <a href="https://wa.me/591<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $emprendimiento['telefono'] ?? '71234567')) ?>?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20productos" target="_blank" class="t11-wa" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <?php endif; ?>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit"><i class="fas fa-pen"></i> Editar</a>
    <?php endif; ?>
    <?php if (!$es_propietario): ?>
    <div class="t11-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="t11-cart-drawer" id="cartDrawer">
        <div class="t11-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="t11-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="t11-cart-body" id="cartBody">
            <div class="t11-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="t11-cart-foot" id="cartFoot" style="display:none">
            <div class="t11-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="t11-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <div id="t11Notif" class="t11-notif"></div>
    <?php endif; ?>
    <script>
    let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');

    function guardarCarrito() { localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito)); actualizarCarritoUI(); }

    function actualizarCarritoUI() {
        const badge = document.getElementById('t11CartBadge');
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
        if (carrito.length === 0) { body.innerHTML = '<div class="t11-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>'; if (foot) foot.style.display = 'none'; return; }
        if (foot) foot.style.display = 'block';
        let html = '', total = 0;
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            html += '<div class="t11-cart-item"><div class="t11-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div><div class="t11-cart-item-info"><h4>' + escHtml(item.nombre) + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div><div class="t11-cart-qty"><button onclick="cambiarCantidad(' + idx + ',-1)">-</button><span>' + item.cantidad + '</span><button onclick="cambiarCantidad(' + idx + ',1)">+</button></div></div><button class="t11-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button></div>';
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
        const el = document.getElementById('t11Notif'); if (!el) return;
        el.textContent = msg; el.className = 't11-notif ' + type; el.style.display = 'block';
        clearTimeout(el._t); el._t = setTimeout(() => { el.style.display = 'none'; }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() { actualizarCarritoUI(); });
    </script>
<?php endif; ?>
