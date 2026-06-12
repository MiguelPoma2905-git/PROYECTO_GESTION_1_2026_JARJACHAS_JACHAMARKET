<?php if ($themePart === 'css'): ?>
<style>
    :root {
        --tp: <?= $p('color_primario', '#E05A2A') ?>;
        --ts: <?= $p('color_secundario', '#C94D22') ?>;
        --tb: <?= $p('color_fondo', '#FFF8F0') ?>;
        --tt: <?= $p('color_texto', '#2C1810') ?>;
        --ef: '<?= $tipografia ?>', system-ui, sans-serif;
        --tgl: rgba(224,90,42,0.08);
        --tgh: rgba(224,90,42,0.18);
        --cart-w: 400px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:var(--ef); background:var(--tb); color:var(--tt); min-height:100vh; }
    .t8-hdr {
        background:linear-gradient(135deg,var(--tp),var(--ts));
        padding:14px 40px; display:flex; align-items:center; justify-content:space-between;
        position:sticky; top:0; z-index:100;
        box-shadow:0 4px 24px rgba(0,0,0,0.12);
    }
    .t8-hdr-l { display:flex; align-items:center; gap:14px; }
    .t8-hdr-l h2 { font-size:18px; font-weight:700; color:#fff; letter-spacing:-.3px; }
    .t8-logo { height:34px; width:auto; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,0.2); }
    .t8-hdr .back { color:rgba(255,255,255,0.7); text-decoration:none; font-size:12px; transition:all .2s; }
    .t8-hdr .back:hover { color:#fff; }
    .t8-hdr-r { display:flex; align-items:center; gap:10px; }
    .t8-cart-btn { position:relative; background:rgba(255,255,255,0.15); backdrop-filter:blur(4px); border:none; border-radius:50%; width:36px; height:36px; color:#fff; cursor:pointer; transition:all .2s; font-size:15px; display:flex; align-items:center; justify-content:center; }
    .t8-cart-btn:hover { background:rgba(255,255,255,0.25); }
    .t8-cart-badge { position:absolute; top:-4px; right:-4px; background:#fff; color:var(--tp); font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:none; align-items:center; justify-content:center; border:2px solid var(--tp); }
    .t8-hero { text-align:center; padding:52px 32px 0; position:relative; }
    .t8-hero h1 { font-size:38px; font-weight:800; color:var(--tt); margin-bottom:6px; letter-spacing:-.5px; }
    .t8-hero h1::before { content:'🍽️ '; }
    .t8-hero p { font-size:14px; color:var(--tt); opacity:0.6; max-width:540px; margin:0 auto 40px; line-height:1.7; }
    .t8-ctn { max-width:1100px; margin:0 auto; padding:0 32px 60px; }
    .t8-count { text-align:center; font-size:11px; color:var(--tp); letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:20px; }
    .t8-count::before { content:'📍 '; }
    .t8-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:32px; }
    .t8-card {
        background:#fff; border-radius:24px; overflow:hidden;
        box-shadow:0 4px 20px rgba(0,0,0,0.05);
        transition:all .4s cubic-bezier(.4,0,.2,1);
        display:flex; flex-direction:column;
        border:1px solid rgba(0,0,0,0.04);
        position:relative; animation:t8FU .5s ease both;
    }
    .t8-card:hover { transform:translateY(-6px); box-shadow:0 16px 48px var(--tgl); }
        .t8-card-img {
            width:100%; height:200px; object-fit:cover;
            background:linear-gradient(135deg,var(--tp),var(--ts));
            display:block; transition:transform .5s;
        }
    .t8-card:hover .t8-card-img { transform:scale(1.04); }
    .t8-card-body { padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
    .t8-card-body h3 { font-size:16px; font-weight:700; color:var(--tt); margin-bottom:2px; line-height:1.3; }
    .t8-desc { font-size:12px; color:var(--tt); opacity:0.5; margin-bottom:8px; line-height:1.5; }
    .t8-tags { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px; }
    .t8-tag { font-size:9px; color:var(--tp); background:var(--tgl); padding:3px 10px; border-radius:20px; font-weight:600; }
    .t8-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:12px; border-top:1px solid rgba(0,0,0,0.05); }
    .t8-price { font-size:22px; font-weight:700; color:var(--tp); letter-spacing:-.3px; }
    .t8-price small { font-size:12px; font-weight:500; opacity:0.5; }
    .t8-btn { padding:10px 22px; background:var(--tp); color:#fff; border:none; border-radius:50px; font-size:12px; font-weight:600; cursor:pointer; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .t8-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px var(--tgh); }
    .t8-empty { text-align:center; padding:80px 20px; color:var(--tt); opacity:0.4; grid-column:1/-1; }
    .t8-contact { max-width:1100px; margin:0 auto; padding:20px 32px 0; }
    .t8-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:#fff; border:1px solid rgba(0,0,0,0.04); border-radius:16px; font-size:12px; color:var(--tt); opacity:0.7; box-shadow:0 2px 12px var(--tgl); }
    .t8-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .t8-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    .t8-foot { text-align:center; padding:32px; color:var(--tt); opacity:0.25; font-size:11px; border-top:1px solid; margin-top:40px; border-color:rgba(0,0,0,0.05); }
    .t8-foot p::after { content:' 🍴'; }
    .t8-wm { position:fixed; bottom:12px; right:16px; display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.85); backdrop-filter:blur(8px); padding:4px 12px 4px 8px; border-radius:20px; opacity:0.4; pointer-events:none; z-index:9999; }
    .t8-wm img { height:16px; width:auto; opacity:0.4; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--tp); color:#fff; border:none; border-radius:50px; padding:10px 22px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 6px 24px var(--tgh); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .btn-edit:hover { transform:translateY(-2px); box-shadow:0 8px 32px var(--tgh); }
    @keyframes t8FU { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .t8-card:nth-child(1){animation-delay:0.04s} .t8-card:nth-child(2){animation-delay:0.08s} .t8-card:nth-child(3){animation-delay:0.12s} .t8-card:nth-child(4){animation-delay:0.16s} .t8-card:nth-child(5){animation-delay:0.20s} .t8-card:nth-child(6){animation-delay:0.24s}
    .t8-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.35); backdrop-filter:blur(4px); z-index:99997; display:none; }
    .t8-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:#fff; z-index:99998; display:none; flex-direction:column; animation:t8SI .3s ease; }
    .t8-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid rgba(0,0,0,0.04); flex-shrink:0; background:var(--tp); }
    .t8-cart-hdr h3 { font-size:17px; font-weight:700; color:#fff; }
    .t8-cart-hdr span { font-size:11px; color:rgba(255,255,255,0.6); }
    .t8-cart-close { background:none; border:none; color:rgba(255,255,255,0.5); font-size:20px; cursor:pointer; }
    .t8-cart-close:hover { color:#fff; }
    .t8-cart-body { flex:1; overflow-y:auto; padding:16px 24px; background:#fff; }
    .t8-cart-empty { text-align:center; padding:60px 20px; color:var(--tt); opacity:0.3; }
    .t8-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(0,0,0,0.04); }
    .t8-cart-item-img { width:60px; height:60px; border-radius:12px; overflow:hidden; flex-shrink:0; background:var(--tgl); }
    .t8-cart-item-img img { width:100%; height:100%; object-fit:cover; }
    .t8-cart-item-info { flex:1; min-width:0; }
    .t8-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--tt); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .t8-cart-item-info .p { font-size:14px; font-weight:700; color:var(--tp); }
    .t8-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
    .t8-cart-qty button { width:26px; height:26px; border-radius:50%; border:1px solid rgba(0,0,0,0.08); background:var(--tgl); color:var(--tt); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
    .t8-cart-qty button:hover { border-color:var(--tp); background:var(--tgh); color:var(--tp); }
    .t8-cart-qty span { font-size:13px; font-weight:600; color:var(--tt); min-width:20px; text-align:center; }
    .t8-cart-item-del { background:none; border:none; color:rgba(224,90,42,0.3); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; }
    .t8-cart-item-del:hover { color:var(--tp); }
    .t8-cart-foot { border-top:1px solid rgba(0,0,0,0.04); padding:20px 24px; flex-shrink:0; background:#fff; }
    .t8-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
    .t8-cart-total span { font-size:11px; color:var(--tt); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
    .t8-cart-total strong { font-size:20px; font-weight:700; color:var(--tt); }
    .t8-cart-checkout { width:100%; padding:14px; background:var(--tp); color:#fff; border:none; border-radius:50px; font-size:14px; font-weight:600; cursor:pointer; transition:all .3s; }
    .t8-cart-checkout:hover { transform:translateY(-2px); box-shadow:0 8px 24px var(--tgh); }
    .t8-cart-checkout:disabled { opacity:.4; cursor:not-allowed; transform:none; box-shadow:none; }
    @keyframes t8SI { from{transform:translateX(100%)} to{transform:translateX(0)} }
    .t8-notif { position:fixed; top:20px; right:20px; z-index:99999; padding:14px 24px; border-radius:50px; font-size:13px; font-weight:500; max-width:340px; box-shadow:0 8px 32px rgba(0,0,0,0.12); display:none; animation:t8NF .3s ease; backdrop-filter:blur(8px); }
    .t8-notif.success { background:#fff; color:#2d7a4a; border-left:4px solid #2d7a4a; }
    .t8-notif.error { background:#fff; color:var(--tp); border-left:4px solid var(--tp); }
    @keyframes t8NF { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    @media(max-width:768px){
        .t8-hdr{padding:12px 20px} .t8-hero{padding:36px 20px 0}
        .t8-hero h1{font-size:28px} .t8-ctn{padding:0 16px 40px}
        .t8-grid{grid-template-columns:1fr;gap:24px} .t8-card-img{height:180px}
        :root{--cart-w:100vw}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
    <div class="t8-hdr">
        <div class="t8-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="t8-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="t8-hdr-r">
            <?php if (!$es_propietario): ?>
            <button class="t8-cart-btn" onclick="abrirCarrito()"><i class="fas fa-shopping-bag"></i><span id="t8CartBadge" class="t8-cart-badge">0</span></button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr; Volver</a>
        </div>
    </div>
    <div class="t8-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat;padding:80px 32px 40px"<?php endif; ?>>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="t8-ctn">
        <?php if (count($productos) > 0): ?>
        <div class="t8-count"><?= count($productos) ?> producto(s)</div>
        <div class="t8-grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
            ?>
            <div class="t8-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>">
                <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="t8-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                <div class="t8-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if (!empty($producto['descripcion'])): ?>
                    <div class="t8-desc"><?= htmlspecialchars(mb_substr($producto['descripcion'], 0, 80)) ?></div>
                    <?php endif; ?>
                    <?php if ($atributos): ?>
                    <div class="t8-tags">
                        <?php foreach ($atributos as $key => $val): ?>
                            <span class="t8-tag"><?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="t8-card-bot">
                        <div class="t8-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="t8-btn" style="text-decoration:none"><i class="fas fa-pen"></i> Editar</a>
                        <?php else: ?>
                        <button class="t8-btn" onclick="agregarAlCarrito(this)">🍽️ Agregar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="t8-empty"><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="t8-contact">
        <div class="t8-contact-inner">
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
    <div class="t8-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Buen provecho</p>
    </div>
    <div class="t8-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
    <?php if (!$es_propietario): ?>
    <div class="t8-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="t8-cart-drawer" id="cartDrawer">
        <div class="t8-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="t8-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="t8-cart-body" id="cartBody">
            <div class="t8-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="t8-cart-foot" id="cartFoot" style="display:none">
            <div class="t8-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="t8-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <div id="t8Notif" class="t8-notif"></div>
    <?php endif; ?>
    <script>
    let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');

    function guardarCarrito() { localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito)); actualizarCarritoUI(); }

    function actualizarCarritoUI() {
        const badge = document.getElementById('t8CartBadge');
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
        if (carrito.length === 0) { body.innerHTML = '<div class="t8-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>'; if (foot) foot.style.display = 'none'; return; }
        if (foot) foot.style.display = 'block';
        let html = '', total = 0;
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            html += '<div class="t8-cart-item"><div class="t8-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div><div class="t8-cart-item-info"><h4>' + escHtml(item.nombre) + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div><div class="t8-cart-qty"><button onclick="cambiarCantidad(' + idx + ',-1)">-</button><span>' + item.cantidad + '</span><button onclick="cambiarCantidad(' + idx + ',1)">+</button></div></div><button class="t8-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button></div>';
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
        if (existe >= 0) { const nc = carrito[existe].cantidad + 1; if (nc > stock) { mostrarNotif('Stock máximo: ' + stock, 'error'); return; } carrito[existe].cantidad = nc; }
        else { if (stock < 1) { mostrarNotif('Agotado', 'error'); return; } carrito.push({ id, nombre, precio, cantidad:1, stock, img }); }
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
            if (res.success) { mostrarNotif('✓ Pedido: ' + (res.codigo || '#OK'), 'success'); carrito = []; guardarCarrito(); cerrarCarrito(); }
            else { mostrarNotif('✗ ' + (res.error || 'Error'), 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; }
        }).catch(() => { mostrarNotif('✗ Error de conexión', 'error'); btn.disabled = false; btn.textContent = 'Ir a pagar'; });
    }

    function mostrarNotif(msg, type) {
        const el = document.getElementById('t8Notif'); if (!el) return;
        el.textContent = msg; el.className = 't8-notif ' + type; el.style.display = 'block';
        clearTimeout(el._t); el._t = setTimeout(() => { el.style.display = 'none'; }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() { actualizarCarritoUI(); });
    </script>
<?php endif; ?>
