<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#8B6B4A') ?>;
        --ts: <?= $p('color_secundario', '#6D4F33') ?>;
        --tb: <?= $p('color_fondo', '#F5F0E8') ?>;
        --tt: <?= $p('color_texto', '#2C2416') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(139,107,74,0.10);
        --tgh: rgba(139,107,74,0.20);
        --cart-w: 400px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:var(--tb); color:var(--tt); min-height:100vh; }
    body::before { content:''; position:fixed; inset:0; background:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%238B6B4A' fill-opacity='0.03'%3E%3Cpath d='M20 0L40 20L20 40L0 20Z'/%3E%3C/g%3E%3C/svg%3E"); pointer-events:none; z-index:0; }
    .t9-hdr {
        background:#fff; padding:16px 40px;
        display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        border-bottom:2px solid var(--tgl);
    }
    .t9-hdr-l { display:flex; align-items:center; gap:14px; }
    .t9-hdr-l h2 { font-size:17px; font-weight:600; color:var(--tt); letter-spacing:0; }
    .t9-logo { height:34px; width:auto; border-radius:4px; object-fit:cover; }
    .t9-hdr .back { color:var(--tt); opacity:0.4; text-decoration:none; font-size:12px; transition:all .2s; }
    .t9-hdr .back:hover { opacity:1; color:var(--tp); }
    .t9-hdr-r { display:flex; align-items:center; gap:10px; }
    .t9-cart-btn { position:relative; background:var(--tgl); border:1px solid rgba(139,107,74,0.15); border-radius:8px; padding:8px 14px; color:var(--tp); cursor:pointer; transition:all .2s; font-size:13px; display:flex; align-items:center; gap:6px; }
    .t9-cart-btn:hover { background:var(--tgh); }
    .t9-cart-badge { position:absolute; top:-6px; right:-6px; background:var(--tp); color:#fff; font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:none; align-items:center; justify-content:center; border:2px solid #fff; }
    .t9-hero { text-align:center; padding:56px 32px 0; position:relative; }
    .t9-hero::after { content:'✧'; display:block; font-size:24px; color:var(--tp); opacity:0.2; margin-top:8px; }
    .t9-hero h1 { font-size:36px; font-weight:400; color:var(--tt); margin-bottom:8px; letter-spacing:2px; text-transform:uppercase; }
    .t9-hero p { font-size:14px; color:var(--tt); opacity:0.5; max-width:520px; margin:0 auto 44px; line-height:1.7; }
    .t9-ctn { max-width:1200px; margin:0 auto; padding:0 32px 60px; position:relative; z-index:1; }
    .t9-count { text-align:center; font-size:10px; color:var(--tp); letter-spacing:3px; text-transform:uppercase; font-weight:600; margin-bottom:24px; }
    .t9-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:28px; }
    .t9-card {
        background:#fff; border-radius:4px; overflow:hidden;
        box-shadow:0 2px 12px rgba(0,0,0,0.04);
        transition:all .4s ease;
        display:flex; flex-direction:column;
        border:1px solid rgba(139,107,74,0.1);
        position:relative; animation:t9FU .5s ease both;
    }
    .t9-card::before {
        content:''; position:absolute; top:-1px; left:-1px; right:-1px; bottom:-1px;
        border:1px dashed var(--tp); opacity:0; border-radius:4px;
        transition:opacity .4s; pointer-events:none;
    }
    .t9-card:hover { transform:translateY(-4px); box-shadow:0 12px 36px var(--tgl); }
    .t9-card:hover::before { opacity:0.3; }
    .t9-card-img {
        width:100%; height:220px; object-fit:cover;
        background:var(--tgl); display:block; transition:transform .6s;
    }
    .t9-card:hover .t9-card-img { transform:scale(1.03); }
    .t9-card-body { padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
    .t9-card-body h3 { font-size:15px; font-weight:600; color:var(--tt); margin-bottom:4px; line-height:1.3; }
    .t9-craft { font-size:11px; color:var(--tp); opacity:0.5; margin-bottom:8px; font-style:italic; }
    .t9-tags { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px; }
    .t9-tag { font-size:9px; color:var(--tt); opacity:0.6; background:var(--tgl); padding:3px 10px; border-radius:2px; letter-spacing:.5px; }
    .t9-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:12px; border-top:1px solid rgba(139,107,74,0.08); }
    .t9-price { font-size:20px; font-weight:700; color:var(--tp); letter-spacing:-.3px; }
    .t9-price small { font-size:12px; font-weight:500; opacity:0.5; }
    .t9-btn { padding:9px 20px; background:transparent; color:var(--tp); border:1px solid var(--tp); border-radius:2px; font-size:11px; font-weight:600; cursor:pointer; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; text-transform:uppercase; letter-spacing:1px; }
    .t9-btn:hover { background:var(--tp); color:#fff; }
    .t9-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.4; grid-column:1/-1; }
    .t9-contact { max-width:1200px; margin:0 auto; padding:20px 32px 0; position:relative; z-index:1; }
    .t9-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:#fff; border:1px solid rgba(139,107,74,0.1); border-radius:4px; font-size:12px; color:var(--tt); opacity:0.7; }
    .t9-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t9-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    .t9-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.25; font-size:11px; border-top:1px solid; margin-top:40px; border-color:rgba(139,107,74,0.08); font-style:italic; }
    .t9-wm { position:fixed; bottom:12px; right:16px; display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.85); backdrop-filter:blur(8px); padding:4px 12px 4px 8px; border-radius:4px; opacity:0.4; pointer-events:none; z-index:9999; }
    .t9-wm img { height:16px; width:auto; opacity:0.4; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--tp); color:#fff; border:none; border-radius:2px; padding:11px 22px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 6px 24px rgba(0,0,0,0.12); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; letter-spacing:1px; }
    .btn-edit:hover { transform:translateY(-2px); box-shadow:0 8px 32px var(--tgh); }
    @keyframes t9FU { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .t9-card:nth-child(1){animation-delay:0.04s} .t9-card:nth-child(2){animation-delay:0.08s} .t9-card:nth-child(3){animation-delay:0.12s} .t9-card:nth-child(4){animation-delay:0.16s} .t9-card:nth-child(5){animation-delay:0.20s} .t9-card:nth-child(6){animation-delay:0.24s}
    .t9-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.3); z-index:99997; display:none; }
    .t9-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:#fff; z-index:99998; display:none; flex-direction:column; animation:t9SI .3s ease; }
    .t9-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid rgba(139,107,74,0.08); flex-shrink:0; }
    .t9-cart-hdr h3 { font-size:17px; font-weight:600; color:var(--tt); }
    .t9-cart-hdr span { font-size:11px; color:var(--tt); opacity:0.35; }
    .t9-cart-close { background:none; border:none; color:var(--tt); opacity:0.3; font-size:20px; cursor:pointer; }
    .t9-cart-close:hover { opacity:1; color:var(--tp); }
    .t9-cart-body { flex:1; overflow-y:auto; padding:16px 24px; }
    .t9-cart-empty { text-align:center; padding:60px 20px; color:var(--tt); opacity:0.3; }
    .t9-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(139,107,74,0.06); }
    .t9-cart-item-img { width:60px; height:60px; border-radius:4px; overflow:hidden; flex-shrink:0; background:var(--tgl); }
    .t9-cart-item-img img { width:100%; height:100%; object-fit:cover; }
    .t9-cart-item-info { flex:1; min-width:0; }
    .t9-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--tt); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .t9-cart-item-info .p { font-size:14px; font-weight:700; color:var(--tp); }
    .t9-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
    .t9-cart-qty button { width:26px; height:26px; border-radius:2px; border:1px solid rgba(139,107,74,0.12); background:var(--tgl); color:var(--tt); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
    .t9-cart-qty button:hover { border-color:var(--tp); }
    .t9-cart-qty span { font-size:13px; font-weight:600; color:var(--tt); min-width:20px; text-align:center; }
    .t9-cart-item-del { background:none; border:none; color:rgba(139,107,74,0.3); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; }
    .t9-cart-item-del:hover { color:var(--tp); }
    .t9-cart-foot { border-top:1px solid rgba(139,107,74,0.06); padding:20px 24px; flex-shrink:0; }
    .t9-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
    .t9-cart-total span { font-size:11px; color:var(--tt); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
    .t9-cart-total strong { font-size:20px; font-weight:700; color:var(--tt); }
    .t9-cart-checkout { width:100%; padding:14px; background:var(--tp); color:#fff; border:none; border-radius:2px; font-size:14px; font-weight:600; cursor:pointer; transition:all .3s; letter-spacing:1px; text-transform:uppercase; }
    .t9-cart-checkout:hover { background:var(--ts); }
    .t9-cart-checkout:disabled { opacity:.4; cursor:not-allowed; }
    @keyframes t9SI { from{transform:translateX(100%)} to{transform:translateX(0)} }
    .t9-notif { position:fixed; top:20px; right:20px; z-index:99999; padding:14px 24px; border-radius:4px; font-size:13px; font-weight:500; max-width:340px; box-shadow:0 8px 32px rgba(0,0,0,0.12); display:none; animation:t9NF .3s ease; }
    .t9-notif.success { background:#fff; color:#2d7a4a; border-left:4px solid #2d7a4a; }
    .t9-notif.error { background:#fff; color:var(--tp); border-left:4px solid var(--tp); }
    @keyframes t9NF { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:768px){
        .t9-hdr{padding:14px 20px} .t9-hero{padding:36px 20px 0}
        .t9-hero h1{font-size:26px} .t9-ctn{padding:0 16px 40px}
        .t9-grid{grid-template-columns:1fr;gap:20px} .t9-card-img{height:200px}
        :root{--cart-w:100vw}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t9-hdr">
        <div class="t9-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t9-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="t9-hdr-r">
            <?php if (!$es_propietario): ?>
            <button class="t9-cart-btn" onclick="abrirCarrito()"><i class="fas fa-shopping-bag"></i> Carrito<span id="t9CartBadge" class="t9-cart-badge">0</span></button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr; Volver</a>
        </div>
    </div>
    <div class="t9-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat;padding:80px 32px 40px"<?php endif; ?>>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t9-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t9-count"><?= count($productos) ?> producto(s)</div>
        <div class="t9-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
            ?>
            <div class="t9-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t9-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <div class="t9-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if ($atributos && isset($atributos['material'])): ?>
                        <div class="t9-craft">Hecho en <?= htmlspecialchars($atributos['material']) ?></div>
                    <?php endif; ?>
                    <?php if ($atributos): ?>
                    <div class="t9-tags">
                        <?php foreach ($atributos as $key => $val):
                            if ($key === 'material') continue; ?>
                            <span class="t9-tag"><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t9-card-bot">
                        <div class="t9-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t9-btn" style="text-decoration:none">Editar</a>
                        <?php else: ?>
                        <button class="t9-btn" onclick="agregarAlCarrito(this)">Añadir</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t9-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t9-contact">
        <div class="t9-contact-inner">
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
    <div class="t9-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Hecho a mano con ❤️</p>
    </div>
    <div class="t9-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
    <?php if (!$es_propietario): ?>
    <div class="t9-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="t9-cart-drawer" id="cartDrawer">
        <div class="t9-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="t9-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="t9-cart-body" id="cartBody">
            <div class="t9-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="t9-cart-foot" id="cartFoot" style="display:none">
            <div class="t9-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="t9-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <div id="t9Notif" class="t9-notif"></div>
    <?php endif; ?>
    <script>
    let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');

    function guardarCarrito() { localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito)); actualizarCarritoUI(); }

    function actualizarCarritoUI() {
        const badge = document.getElementById('t9CartBadge');
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
        if (carrito.length === 0) { body.innerHTML = '<div class="t9-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>'; if (foot) foot.style.display = 'none'; return; }
        if (foot) foot.style.display = 'block';
        let html = '', total = 0;
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            html += '<div class="t9-cart-item"><div class="t9-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div><div class="t9-cart-item-info"><h4>' + escHtml(item.nombre) + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div><div class="t9-cart-qty"><button onclick="cambiarCantidad(' + idx + ',-1)">-</button><span>' + item.cantidad + '</span><button onclick="cambiarCantidad(' + idx + ',1)">+</button></div></div><button class="t9-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button></div>';
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
        const el = document.getElementById('t9Notif'); if (!el) return;
        el.textContent = msg; el.className = 't9-notif ' + type; el.style.display = 'block';
        clearTimeout(el._t); el._t = setTimeout(() => { el.style.display = 'none'; }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() { actualizarCarritoUI(); });
    </script>
<?php endif; ?>
