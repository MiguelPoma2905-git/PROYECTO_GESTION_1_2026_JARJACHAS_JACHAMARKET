<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?= urlencode(preg_replace('/[^a-zA-Z0-9\s\-]/', '', $emprendimiento['tipografia'] ?? 'Inter')) ?>:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<?php
$tid = (int)($emprendimiento['id_plantilla'] ?? 0);
$p = fn($k, $d = '') => htmlspecialchars($emprendimiento[$k] ?? $d);
$tipografia = htmlspecialchars($emprendimiento['tipografia'] ?? 'Inter');

$themeFile = match($tid) {
    6 => 'electrodomesticos.php',
    4 => 'tecnologico.php',
    7 => 'modaviva.php',
    8 => 'sabores.php',
    9 => 'artesano.php',
    10 => 'glowup.php',
    11 => 'fullfit.php',
    12 => 'hogardulce.php',
    default => 'default.php',
};

/* Shared modal and notification styles */
?>
    <style>
        .modal-overlay { position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:99998;display:none;align-items:center;justify-content:center; }
        .modal-box { background:var(--eb, #1a1a2e);border:1px solid var(--ebo, rgba(255,255,255,0.06));border-radius:20px;padding:32px;max-width:420px;width:90%;position:relative;animation:fU .3s ease; }
        .modal-box h3 { font-size:20px;font-weight:600;color:var(--et, #fff);margin-bottom:6px; }
        .modal-box p { font-size:13px;color:var(--et, #fff);opacity:0.5;margin-bottom:20px; }
        .modal-box label { display:block;font-size:11px;color:var(--et, #fff);opacity:0.45;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600; }
        .modal-box input,.modal-box select { width:100%;background:rgba(255,255,255,0.04);border:1px solid var(--ebo, rgba(255,255,255,0.06));border-radius:10px;padding:12px 14px;color:var(--et, #fff);font-size:13px;margin-bottom:16px; }
        .modal-box input:focus,.modal-box select:focus { outline:none;border-color:var(--es, #555); }
        .modal-box select option { background:#1a1a2e;color:var(--et, #fff); }
        .modal-btn { width:100%;padding:14px;background:var(--es, #555);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all .3s; }
        .modal-btn:hover { transform:translateY(-2px); }
        .modal-btn:disabled { opacity:.5;cursor:not-allowed;transform:none; }
        .modal-close { position:absolute;top:16px;right:20px;background:none;border:none;color:rgba(255,255,255,0.3);font-size:20px;cursor:pointer; }
        .modal-close:hover { color:#fff; }
        .notif { position:fixed;top:24px;right:24px;z-index:99999;background:rgba(0,0,0,0.9);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:16px 24px;color:#fff;font-size:13px;display:none;animation:fU .3s ease;max-width:360px; }
        .notif.success { border-left:3px solid #4caf50; }
        .notif.error { border-left:3px solid #e74c3c; }
        .notif.show { display:block; }
        @keyframes fU { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes slideIn { from{transform:translateX(100%)} to{transform:translateX(0)} }
        @keyframes slideOut { from{transform:translateX(0)} to{transform:translateX(100%)} }
    </style>
<?php $themePart = 'css'; include "themes/{$themeFile}"; ?>
</head>
<body>
<?php $themePart = 'html'; include "themes/{$themeFile}"; ?>

<!-- Modal de compra rápida -->
<div class="modal-overlay" id="modalCompra">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal()">&times;</button>
        <h3 id="modalProdNombre">Producto</h3>
        <p id="modalProdPrecio">Bs. 0.00</p>
        <input type="hidden" id="modalProdId" value="0">

        <label>Cantidad</label>
        <input type="number" id="modalCantidad" value="1" min="1" max="99">

        <label>Dirección de entrega</label>
        <input type="text" id="modalDireccion" placeholder="Ej: Calle Comercio #123, La Paz">

        <label>Método de pago</label>
        <select id="modalPago" onchange="toggleQR()">
            <option value="QR">QR</option>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Transferencia">Transferencia</option>
        </select>

        <div id="qrSection" style="text-align:center;padding:16px 0;margin-bottom:16px">
            <p style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:8px">Escanea para pagar</p>
            <img id="qrImg" src="" alt="Código QR" style="width:180px;height:180px;border-radius:12px;background:#fff;padding:12px;display:none;margin:0 auto">
            <p id="qrRef" style="font-size:10px;color:rgba(255,255,255,0.3);margin-top:8px"></p>
        </div>

        <?php if (!$es_propietario): ?>
        <button class="modal-btn" id="modalBtnConfirmar" onclick="confirmarCompra()">Confirmar compra</button>
        <?php endif; ?>
    </div>
</div>

<!-- Notificación -->
<div class="notif" id="notificacion"></div>

<script>
const BASE = '<?= BASE_URL ?>';
const TIENDA_ID = <?= $emprendimiento['id_emprendimiento'] ?>;
const ES_PROPIETARIO = <?= json_encode($es_propietario) ?>;

/* Shared functions for all themes */

function generarQR() {
    const id = document.getElementById('modalProdId').value;
    const total = document.getElementById('modalProdPrecio').textContent.replace('Bs. ', '');
    const ref = 'JACHA-' + Date.now().toString(36).toUpperCase();
    const data = 'PAGO|' + ref + '|' + total + '|' + id;
    const qrSrc = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(data);
    document.getElementById('qrImg').src = qrSrc;
    document.getElementById('qrImg').style.display = 'block';
    document.getElementById('qrRef').textContent = 'Ref: ' + ref;
}

function toggleQR() {
    const pago = document.getElementById('modalPago').value;
    const qrSection = document.getElementById('qrSection');
    if (pago === 'QR') {
        qrSection.style.display = 'block';
        generarQR();
    } else {
        qrSection.style.display = 'none';
    }
}

function mostrarCompra(btn) {
    if (ES_PROPIETARIO) { mostrarNotificacion('Eres el dueño de esta tienda', 'error'); return; }
    const card = btn.closest('[data-id]');
    if (!card) return;
    const id = card.dataset.id;
    const nombre = card.dataset.nombre;
    const precio = card.dataset.precio;
    const stock = parseInt(card.dataset.stock || '0');

    if (stock < 1) {
        mostrarNotificacion('Producto agotado', 'error');
        return;
    }

    document.getElementById('modalProdId').value = id;
    document.getElementById('modalProdNombre').textContent = nombre;
    document.getElementById('modalProdPrecio').textContent = 'Bs. ' + parseFloat(precio).toFixed(2);
    document.getElementById('modalCantidad').value = 1;
    document.getElementById('modalCantidad').max = stock;
    document.getElementById('modalDireccion').value = '';
    document.getElementById('modalPago').value = 'QR';
    document.getElementById('modalBtnConfirmar').disabled = false;
    document.getElementById('qrSection').style.display = 'block';
    generarQR();

    document.getElementById('modalCompra').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalCompra').style.display = 'none';
}

document.getElementById('modalCompra').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});

function mostrarNotificacion(msg, tipo) {
    const n = document.getElementById('notificacion');
    n.textContent = msg;
    n.className = 'notif ' + tipo + ' show';
    setTimeout(() => { n.className = 'notif'; }, 4000);
}

function confirmarCompra() {
    if (ES_PROPIETARIO) { mostrarNotificacion('Eres el dueño de esta tienda', 'error'); return; }
    const btn = document.getElementById('modalBtnConfirmar');
    const cantidad = parseInt(document.getElementById('modalCantidad').value) || 1;
    const maxStock = parseInt(document.getElementById('modalCantidad').max) || 0;

    if (cantidad < 1 || (maxStock > 0 && cantidad > maxStock)) {
        mostrarNotificacion('Cantidad no disponible (máx: ' + maxStock + ')', 'error');
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Procesando...';

    const data = new URLSearchParams();
    data.set('producto_id', document.getElementById('modalProdId').value);
    data.set('cantidad', cantidad);
    data.set('direccion', document.getElementById('modalDireccion').value);
    data.set('metodo_pago', document.getElementById('modalPago').value);

    fetch(BASE + '/pedido/comprar-rapido', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: data.toString()
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            mostrarNotificacion('✓ Pedido creado: ' + (res.codigo || '#OK'), 'success');
            cerrarModal();
        } else {
            mostrarNotificacion('✗ ' + (res.error || 'Error al crear pedido'), 'error');
            btn.disabled = false;
            btn.textContent = 'Confirmar compra';
        }
    })
    .catch(err => {
        mostrarNotificacion('✗ Error de conexión', 'error');
        btn.disabled = false;
        btn.textContent = 'Confirmar compra';
    });
}
</script>
</body>
</html>
