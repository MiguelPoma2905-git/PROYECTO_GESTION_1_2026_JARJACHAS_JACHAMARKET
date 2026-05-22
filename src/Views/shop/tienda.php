<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?= urlencode($emprendimiento['tipografia'] ?? 'Inter') ?>:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<?php
$tid = (int)($emprendimiento['id_plantilla'] ?? 0);
$p = fn($k, $d = '') => htmlspecialchars($emprendimiento[$k] ?? $d);
$tipografia = htmlspecialchars($emprendimiento['tipografia'] ?? 'Inter');

if ($tid === 6):
?>
    <style>
        :root {
            --ep: <?= $p('color_primario', '#1A3A5C') ?>;
            --es: <?= $p('color_secundario', '#2C6FBB') ?>;
            --eb: <?= $p('color_fondo', '#0F1A2E') ?>;
            --et: <?= $p('color_texto', '#E8EDF5') ?>;
            --ef: '<?= $tipografia ?>', system-ui, sans-serif;
            --esu: rgba(255,255,255,0.04);
            --ebo: rgba(255,255,255,0.06);
            --egl: rgba(44,111,187,0.15);
            --cart-w: 420px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:var(--ef); background:var(--eb); color:var(--et); min-height:100vh; overflow-x:hidden; }
        body::before { content:''; position:fixed; inset:0; background:radial-gradient(ellipse at 20% 20%, rgba(44,111,187,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 80%, rgba(26,58,92,0.12) 0%, transparent 50%); pointer-events:none; z-index:0; }
        .modal-overlay { position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:99998;display:none;align-items:center;justify-content:center; }
        .modal-box { background:var(--eb);border:1px solid var(--ebo);border-radius:20px;padding:32px;max-width:420px;width:90%;position:relative;animation:fU .3s ease; }
        .modal-box h3 { font-size:20px;font-weight:600;color:var(--et);margin-bottom:6px; }
        .modal-box p { font-size:13px;color:var(--et);opacity:0.5;margin-bottom:20px; }
        .modal-box label { display:block;font-size:11px;color:var(--et);opacity:0.45;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600; }
        .modal-box input,.modal-box select { width:100%;background:rgba(255,255,255,0.04);border:1px solid var(--ebo);border-radius:10px;padding:12px 14px;color:var(--et);font-size:13px;margin-bottom:16px; }
        .modal-box input:focus,.modal-box select:focus { outline:none;border-color:var(--es); }
        .modal-box select option { background:#1a1a2e;color:var(--et); }
        .modal-btn { width:100%;padding:14px;background:var(--es);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all .3s; }
        .modal-btn:hover { background:#3a7fcf;transform:translateY(-2px); }
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

        .e6-hdr { position:sticky; top:0; z-index:100; background:rgba(15,26,46,0.95); backdrop-filter:blur(20px); border-bottom:1px solid var(--ebo); padding:14px 40px; display:flex; align-items:center; justify-content:space-between; }
        .e6-hdr-l { display:flex; align-items:center; gap:20px; }
        .e6-hdr-l h2 { font-size:17px; font-weight:700; color:var(--et); }
        .e6-logo { height:36px; width:auto; border-radius:4px; object-fit:contain; }
        .e6-hdr .back { color:var(--et); opacity:0.5; text-decoration:none; font-size:12px; transition:all .2s; }
        .e6-hdr .back:hover { opacity:1; }
        .e6-hdr-r { display:flex; align-items:center; gap:12px; }
        .e6-search { background:rgba(255,255,255,0.06); border:1px solid var(--ebo); border-radius:8px; padding:8px 14px; color:var(--et); font-size:12px; width:200px; transition:all .2s; }
        .e6-search:focus { outline:none; border-color:var(--es); width:260px; background:rgba(255,255,255,0.08); }
        .e6-search::placeholder { color:var(--et); opacity:0.25; }
        .e6-cart-btn { position:relative; background:rgba(255,255,255,0.06); border:1px solid var(--ebo); border-radius:8px; padding:8px 14px; color:var(--et); cursor:pointer; transition:all .2s; font-size:14px; display:flex; align-items:center; gap:6px; }
        .e6-cart-btn:hover { border-color:var(--es); background:rgba(44,111,187,0.1); }
        .e6-cart-badge { position:absolute; top:-6px; right:-6px; background:#ef4444; color:#fff; font-size:9px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:flex; align-items:center; justify-content:center; border:2px solid var(--eb); display:none; }

        .e6-hero { position:relative; z-index:1; text-align:center; padding:60px 40px 40px; max-width:900px; margin:0 auto; }
        .e6-hero h1 { font-size:44px; font-weight:700; letter-spacing:-1px; color:var(--et); margin-bottom:8px; }
        .e6-hero h1 span { color:var(--es); }
        .e6-hero p { font-size:14px; color:var(--et); opacity:0.5; line-height:1.7; max-width:600px; margin:0 auto; }
        .e6-badge { display:inline-flex; align-items:center; gap:6px; font-size:10px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--es); background:rgba(44,111,187,0.1); padding:5px 14px; border-radius:4px; margin-bottom:20px; border:1px solid rgba(44,111,187,0.2); }

        .e6-ctn { position:relative; z-index:1; max-width:1200px; margin:0 auto; padding:0 40px 60px; }
        .e6-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
        .e6-cats { display:flex; gap:8px; flex-wrap:wrap; }
        .e6-cat { padding:7px 18px; border-radius:6px; font-size:11px; font-weight:600; letter-spacing:.3px; text-transform:uppercase; cursor:pointer; background:var(--esu); border:1px solid var(--ebo); color:var(--et); opacity:0.5; transition:all .2s; }
        .e6-cat:hover { border-color:var(--es); opacity:1; background:rgba(44,111,187,0.08); }
        .e6-cat.active { background:var(--es); color:#fff; opacity:1; border-color:var(--es); }
        .e6-sort { display:flex; align-items:center; gap:8px; }
        .e6-sort label { font-size:10px; color:var(--et); opacity:0.35; text-transform:uppercase; letter-spacing:.5px; }
        .e6-sort select { background:rgba(255,255,255,0.04); border:1px solid var(--ebo); border-radius:6px; padding:6px 10px; color:var(--et); opacity:0.7; font-size:11px; cursor:pointer; }
        .e6-sort select:focus { outline:none; border-color:var(--es); }
        .e6-sort select option { background:#12121a; color:var(--et); }
        .e6-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .e6-card { background:var(--esu); border:1px solid var(--ebo); border-radius:16px; overflow:hidden; transition:all .4s cubic-bezier(.4,0,.2,1); position:relative; }
        .e6-card::before { content:''; position:absolute; inset:0; border-radius:16px; background:linear-gradient(135deg,rgba(44,111,187,0.05),transparent); opacity:0; transition:opacity .4s; pointer-events:none; }
        .e6-card:hover { transform:translateY(-6px); border-color:rgba(44,111,187,0.3); box-shadow:0 20px 60px rgba(0,0,0,0.4), 0 0 40px var(--egl); }
        .e6-card:hover::before { opacity:1; }
        .e6-card-img-w { position:relative; overflow:hidden; height:220px; background:linear-gradient(135deg,#1a2a44,#0F1A2E); }
        .e6-card-img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .4s; }
        .e6-card:hover .e6-card-img { transform:scale(1.05); }
        .e6-card-brand-tag { position:absolute; top:12px; left:12px; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px); padding:4px 12px; border-radius:4px; font-size:9px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#fff; }
        .e6-card-stock-tag { position:absolute; top:12px; right:12px; padding:4px 10px; border-radius:4px; font-size:9px; font-weight:600; }
        .e6-card-stock-tag.ok { background:rgba(16,185,129,0.15); color:#10b981; }
        .e6-card-stock-tag.low { background:rgba(239,68,68,0.15); color:#ef4444; }
        .e6-card-body { padding:20px; position:relative; z-index:1; }
        .e6-br { font-size:10px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--es); margin-bottom:6px; }
        .e6-card-body h3 { font-size:15px; font-weight:600; color:var(--et); margin-bottom:6px; line-height:1.3; }
        .e6-specs { display:flex; gap:10px; margin-bottom:12px; flex-wrap:wrap; }
        .e6-spec { font-size:10px; color:var(--et); opacity:0.4; display:flex; align-items:center; gap:4px; background:rgba(255,255,255,0.03); padding:2px 8px; border-radius:4px; }
        .e6-spec::before { content:'›'; color:var(--es); font-weight:700; opacity:1; }
        .e6-card-bot { display:flex; align-items:center; justify-content:space-between; margin-top:12px; padding-top:12px; border-top:1px solid var(--ebo); }
        .e6-price { font-size:22px; font-weight:700; color:var(--et); }
        .e6-price small { font-size:12px; font-weight:400; color:var(--et); opacity:0.4; }
        .e6-btn { padding:9px 20px; background:var(--es); color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; transition:all .3s; display:flex; align-items:center; gap:6px; }
        .e6-btn:hover { background:#3a7fcf; transform:translateY(-2px); box-shadow:0 6px 20px rgba(44,111,187,0.3); }
        .e6-btn-out { background:transparent; border:1px solid var(--ebo); color:var(--et); opacity:0.5; }
        .e6-btn-out:hover { border-color:var(--es); opacity:1; color:var(--et); background:rgba(44,111,187,0.08); box-shadow:none; transform:none; }
        .e6-empty { grid-column:1/-1; text-align:center; padding:60px; color:var(--et); opacity:0.3; }
        .e6-empty i { font-size:36px; margin-bottom:12px; opacity:0.3; }

        .e6-banner { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:32px; }
        .e6-banner-item { background:var(--esu); border:1px solid var(--ebo); border-radius:12px; padding:20px; text-align:center; }
        .e6-banner-item i { font-size:24px; color:var(--es); margin-bottom:8px; }
        .e6-banner-item h4 { font-size:13px; font-weight:600; color:var(--et); margin-bottom:4px; }
        .e6-banner-item p { font-size:11px; color:var(--et); opacity:0.4; }
        .e6-foot { position:relative; z-index:1; text-align:center; padding:32px; border-top:1px solid var(--ebo); color:var(--et); opacity:0.2; font-size:11px; }
        .e6-wm { position:fixed; bottom:16px; right:20px; display:flex; align-items:center; gap:8px; opacity:0.2; pointer-events:none; z-index:9999; background:rgba(0,0,0,0.3); padding:6px 14px 6px 10px; border-radius:20px; backdrop-filter:blur(4px); }
        .e6-wm img { height:14px; width:auto; opacity:0.5; }
        .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--es); color:#fff; border:none; border-radius:8px; padding:10px 20px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 4px 20px rgba(44,111,187,0.3); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
        .btn-edit:hover { transform:translateY(-3px); box-shadow:0 8px 32px rgba(44,111,187,0.4); background:#3a7fcf; }
        .e6-wa { position:fixed; bottom:24px; right:24px; z-index:9999; width:52px; height:52px; border-radius:50%; background:#25D366; color:#fff; border:none; font-size:24px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 20px rgba(37,211,102,0.3); transition:all .3s; text-decoration:none; }
        .e6-wa:hover { transform:scale(1.1); box-shadow:0 8px 30px rgba(37,211,102,0.4); }

        .e6-cart-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:99997; display:none; }
        .e6-cart-drawer { position:fixed; top:0; right:0; width:var(--cart-w); height:100vh; background:var(--eb); border-left:1px solid var(--ebo); z-index:99998; display:none; flex-direction:column; animation:slideIn .3s ease; }
        .e6-cart-hdr { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid var(--ebo); flex-shrink:0; }
        .e6-cart-hdr h3 { font-size:18px; font-weight:600; color:var(--et); }
        .e6-cart-hdr span { font-size:12px; color:var(--et); opacity:0.35; }
        .e6-cart-close { background:none; border:none; color:var(--et); opacity:0.3; font-size:22px; cursor:pointer; }
        .e6-cart-close:hover { opacity:1; }
        .e6-cart-body { flex:1; overflow-y:auto; padding:16px 24px; }
        .e6-cart-empty { text-align:center; padding:60px 20px; color:var(--et); opacity:0.3; }
        .e6-cart-empty i { font-size:40px; margin-bottom:12px; opacity:0.3; }
        .e6-cart-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid var(--ebo); }
        .e6-cart-item-img { width:64px; height:64px; border-radius:8px; overflow:hidden; flex-shrink:0; background:rgba(255,255,255,0.04); }
        .e6-cart-item-img img { width:100%; height:100%; object-fit:cover; }
        .e6-cart-item-info { flex:1; min-width:0; }
        .e6-cart-item-info h4 { font-size:13px; font-weight:600; color:var(--et); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .e6-cart-item-info .p { font-size:14px; font-weight:700; color:var(--es); }
        .e6-cart-qty { display:flex; align-items:center; gap:8px; margin-top:6px; }
        .e6-cart-qty button { width:26px; height:26px; border-radius:6px; border:1px solid var(--ebo); background:rgba(255,255,255,0.04); color:var(--et); cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; transition:all .2s; }
        .e6-cart-qty button:hover { border-color:var(--es); background:rgba(44,111,187,0.1); }
        .e6-cart-qty span { font-size:13px; font-weight:600; color:var(--et); min-width:20px; text-align:center; }
        .e6-cart-item-del { background:none; border:none; color:rgba(239,68,68,0.4); cursor:pointer; font-size:14px; padding:4px; align-self:flex-start; transition:color .2s; }
        .e6-cart-item-del:hover { color:#ef4444; }
        .e6-cart-foot { border-top:1px solid var(--ebo); padding:20px 24px; flex-shrink:0; }
        .e6-cart-total { display:flex; justify-content:space-between; margin-bottom:16px; }
        .e6-cart-total span { font-size:11px; color:var(--et); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; }
        .e6-cart-total strong { font-size:22px; font-weight:700; color:var(--et); }
        .e6-cart-checkout { width:100%; padding:14px; background:var(--es); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; transition:all .3s; }
        .e6-cart-checkout:hover { background:#3a7fcf; transform:translateY(-2px); box-shadow:0 8px 24px rgba(44,111,187,0.3); }
        .e6-cart-checkout:disabled { opacity:.4; cursor:not-allowed; transform:none; box-shadow:none; }

        .e6-card { animation:fU .4s ease both; }
        .e6-card:nth-child(1) { animation-delay:0.03s; }
        .e6-card:nth-child(2) { animation-delay:0.06s; }
        .e6-card:nth-child(3) { animation-delay:0.09s; }
        .e6-card:nth-child(4) { animation-delay:0.12s; }
        .e6-card:nth-child(5) { animation-delay:0.15s; }
        .e6-card:nth-child(6) { animation-delay:0.18s; }
        @media(max-width:1024px){ .e6-grid{grid-template-columns:repeat(2,1fr)} .e6-banner{grid-template-columns:1fr} .e6-search{width:140px} .e6-search:focus{width:180px} }
        @media(max-width:768px){
            .e6-hdr{padding:12px 20px}
            .e6-hdr-l h2{font-size:15px}
            .e6-hero{padding:36px 20px 24px}
            .e6-hero h1{font-size:28px}
            .e6-ctn{padding:0 20px 40px}
            .e6-grid{grid-template-columns:1fr}
            .e6-card-img-w{height:200px}
            .e6-search{width:120px;font-size:11px}
            .e6-search:focus{width:140px}
            .e6-hdr-r{gap:8px}
            .e6-cart-btn{padding:7px 10px;font-size:12px}
            :root{--cart-w:100vw}
            .e6-banner{grid-template-columns:1fr}
        }
    </style>
<?php elseif ($tid === 4): ?>
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
        @media(max-width:768px){
            .t4-hdr{padding:14px 20px}
            .t4-hero{padding:40px 20px 0}
            .t4-hero h1{font-size:30px}
            .t4-ctn{padding:0 16px 40px}
            .t4-grid{grid-template-columns:1fr;gap:20px}
            .t4-card-img{height:180px}
        }
    </style>
<?php else: ?>
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
            opacity:0.15; flex-shrink:0;
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
        @media(max-width:768px){
            .g-ctn{padding:0 16px 40px} .g-hero{padding:40px 16px 0}
            .g-title{font-size:30px} .g-grid{grid-template-columns:1fr;gap:20px}
            .g-hdr{padding:14px 20px} .g-card-img{height:190px}
        }
    </style>
<?php endif; ?>
</head>
<body>

<?php if ($tid === 6):
    $tipos = [];
    foreach ($productos as $pr) {
        $ats = json_decode($pr['atributos'] ?? '{}', true);
        $t = $ats['tipo'] ?? 'General';
        if (!in_array($t, $tipos)) $tipos[] = $t;
    }
    sort($tipos);
?>
    <div class="e6-hdr">
        <div class="e6-hdr-l">
            <?php if (!empty($emprendimiento['logo_personalizado'])): ?>
            <img src="<?= BASE_URL ?>/<?= $emprendimiento['logo_personalizado'] ?>" class="e6-logo" alt="Logo">
            <?php endif; ?>
            <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        </div>
        <div class="e6-hdr-r">
            <input type="text" class="e6-search" id="e6Search" placeholder="Buscar producto..." oninput="filtrarProductos()">
            <?php if (!$es_propietario): ?>
            <button class="e6-cart-btn" onclick="abrirCarrito()">
                <i class="fas fa-shopping-cart"></i> <span id="e6CartBadge" class="e6-cart-badge">0</span>
            </button>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back">&larr;</a>
        </div>
    </div>
    <div class="e6-hero"<?php if (!empty($emprendimiento['banner_personalizado'])): ?> style="background:linear-gradient(rgba(0,0,0,0.55),rgba(0,0,0,0.55)),url(<?= BASE_URL ?>/<?= $emprendimiento['banner_personalizado'] ?>) center/cover no-repeat"<?php endif; ?>>
        <div class="e6-badge">✦ ElectroHogar</div>
        <h1><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h1>
        <p><?= htmlspecialchars($emprendimiento['descripcion']) ?></p>
    </div>
    <div class="e6-ctn">
        <div class="e6-banner">
            <div class="e6-banner-item"><i class="fas fa-truck"></i><h4>Envío rápido</h4><p>Entrega en 24-72 hrs</p></div>
            <div class="e6-banner-item"><i class="fas fa-shield-alt"></i><h4>Garantía incluida</h4><p>Todos nuestros productos tienen garantía</p></div>
            <div class="e6-banner-item"><i class="fas fa-credit-card"></i><h4>Pago seguro</h4><p>QR, transferencia o efectivo</p></div>
        </div>
        <div class="e6-bar">
            <div class="e6-cats" id="e6Cats">
                <span class="e6-cat active" data-cat="all">Todos</span>
                <?php foreach ($tipos as $tipo): ?>
                <span class="e6-cat" data-cat="<?= htmlspecialchars($tipo) ?>"><?= htmlspecialchars($tipo) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="e6-sort">
                <label>Ordenar</label>
                <select id="e6Sort" onchange="filtrarProductos()">
                    <option value="default">Por defecto</option>
                    <option value="price-asc">Menor precio</option>
                    <option value="price-desc">Mayor precio</option>
                    <option value="name">A-Z</option>
                </select>
            </div>
        </div>
        <?php if (count($productos) > 0): ?>
        <div class="e6-grid" id="e6Grid">
            <?php foreach ($productos as $producto):
                $atributos = json_decode($producto['atributos'] ?? '{}', true);
                $tipo = $atributos['tipo'] ?? 'General';
                $marca = $atributos['marca'] ?? '';
            ?>
            <div class="e6-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>" data-cat="<?= htmlspecialchars($tipo) ?>">
                <div class="e6-card-img-w">
                    <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="e6-card-img" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                    <?php if ($marca): ?>
                    <span class="e6-card-brand-tag"><?= htmlspecialchars($marca) ?></span>
                    <?php endif; ?>
                    <span class="e6-card-stock-tag <?= $producto['stock'] > 5 ? 'ok' : 'low' ?>">
                        <i class="fas fa-<?= $producto['stock'] > 5 ? 'check-circle' : 'exclamation-circle' ?>"></i> <?= $producto['stock'] ?> ud.
                    </span>
                </div>
                <div class="e6-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php if ($atributos): ?>
                    <div class="e6-specs">
                        <?php foreach ($atributos as $key => $val):
                            if (in_array($key, ['marca','tipo'])) continue; ?>
                            <span class="e6-spec"><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="e6-card-bot">
                        <div class="e6-price"><small>Bs.</small> <?= number_format($producto['precio_base'], 2) ?></div>
                        <?php if ($es_propietario): ?>
                        <a href="<?= BASE_URL ?>/productos?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>&edit=<?= $producto['id_producto'] ?>" class="e6-btn" style="text-decoration:none"><i class="fas fa-pen"></i> Editar</a>
                        <?php elseif ($producto['stock'] > 0): ?>
                        <button class="e6-btn" onclick="agregarAlCarrito(this)"><i class="fas fa-plus"></i> Añadir</button>
                        <?php else: ?>
                        <button class="e6-btn e6-btn-out" disabled><i class="fas fa-times"></i> Agotado</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="e6-empty" id="e6Empty" style="display:none"><i class="fas fa-search"></i><p>No se encontraron productos</p></div>
        <?php else: ?>
        <div class="e6-empty"><i class="fas fa-box-open"></i><p>No hay productos disponibles en esta tienda aún.</p></div>
        <?php endif; ?>
    </div>
    <div class="e6-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Todos los derechos reservados.</p>
    </div>
    <a href="https://wa.me/59171234567?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20productos" target="_blank" class="e6-wa" title="Contactar por WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <div class="e6-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit"><i class="fas fa-pen"></i> Editar</a>
    <?php endif; ?>

    <?php if (!$es_propietario): ?>
    <div class="e6-cart-overlay" id="cartOverlay" onclick="cerrarCarrito()"></div>
    <div class="e6-cart-drawer" id="cartDrawer">
        <div class="e6-cart-hdr">
            <div><h3>Carrito</h3><span id="cartCountLabel">0 producto(s)</span></div>
            <button class="e6-cart-close" onclick="cerrarCarrito()">&times;</button>
        </div>
        <div class="e6-cart-body" id="cartBody">
            <div class="e6-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>
        </div>
        <div class="e6-cart-foot" id="cartFoot" style="display:none">
            <div class="e6-cart-total">
                <span>Total</span>
                <strong id="cartTotal">Bs. 0.00</strong>
            </div>
            <button class="e6-cart-checkout" id="cartCheckoutBtn" onclick="checkoutCarrito()">Ir a pagar</button>
        </div>
    </div>
    <?php endif; ?>

<?php elseif ($tid === 4): ?>
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
    <div class="t4-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></p>
    </div>
    <div class="t4-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>

<?php else: ?>
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
    <div class="g-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></p>
    </div>
    <div class="g-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
    <?php if ($es_propietario): ?>
    <a href="<?= BASE_URL ?>/plantillas?id_emprendimiento=<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-edit">✎ Editar negocio</a>
    <?php endif; ?>
<?php endif; ?>

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

/* ===== CARRITO ===== */
let carrito = JSON.parse(localStorage.getItem('jacha_cart_' + TIENDA_ID) || '[]');

function guardarCarrito() {
    localStorage.setItem('jacha_cart_' + TIENDA_ID, JSON.stringify(carrito));
    actualizarCarritoUI();
}

function actualizarCarritoUI() {
    const badge = document.getElementById('e6CartBadge');
    const count = carrito.reduce((s, i) => s + i.cantidad, 0);
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }
    const label = document.getElementById('cartCountLabel');
    if (label) label.textContent = count + ' producto(s)';
    renderCarrito();
}

function renderCarrito() {
    const body = document.getElementById('cartBody');
    const foot = document.getElementById('cartFoot');
    if (!body) return;
    if (carrito.length === 0) {
        body.innerHTML = '<div class="e6-cart-empty"><i class="fas fa-shopping-bag"></i><p>Tu carrito está vacío</p></div>';
        if (foot) foot.style.display = 'none';
        return;
    }
    if (foot) foot.style.display = 'block';
    let html = '';
    let total = 0;
    carrito.forEach((item, idx) => {
        total += item.precio * item.cantidad;
        html += '<div class="e6-cart-item">' +
            '<div class="e6-cart-item-img"><img src="' + BASE + '/' + (item.img || 'assets/images/placeholder_producto.jpg') + '" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"></div>' +
            '<div class="e6-cart-item-info"><h4>' + item.nombre + '</h4><div class="p">Bs. ' + parseFloat(item.precio).toFixed(2) + '</div>' +
            '<div class="e6-cart-qty">' +
            '<button onclick="cambiarCantidad(' + idx + ',-1)">-</button>' +
            '<span>' + item.cantidad + '</span>' +
            '<button onclick="cambiarCantidad(' + idx + ',1)">+</button>' +
            '</div></div>' +
            '<button class="e6-cart-item-del" onclick="eliminarDelCarrito(' + idx + ')"><i class="fas fa-trash-alt"></i></button>' +
            '</div>';
    });
    body.innerHTML = html;
    document.getElementById('cartTotal').textContent = 'Bs. ' + total.toFixed(2);
}

function agregarAlCarrito(btn) {
    if (ES_PROPIETARIO) { mostrarNotificacion('Eres el dueño de esta tienda', 'error'); return; }
    const card = btn.closest('[data-id]');
    if (!card) return;
    const id = parseInt(card.dataset.id);
    const nombre = card.dataset.nombre;
    const precio = parseFloat(card.dataset.precio);
    const stock = parseInt(card.dataset.stock || '0');
    const imgEl = card.querySelector('.e6-card-img');
    const img = imgEl ? imgEl.getAttribute('src')?.replace(BASE + '/', '') || '' : '';

    const existe = carrito.findIndex(i => i.id === id);
    if (existe >= 0) {
        const nuevaCant = carrito[existe].cantidad + 1;
        if (nuevaCant > stock) {
            mostrarNotificacion('Stock máximo: ' + stock + ' unidades', 'error');
            return;
        }
        carrito[existe].cantidad = nuevaCant;
    } else {
        if (stock < 1) {
            mostrarNotificacion('Producto agotado', 'error');
            return;
        }
        carrito.push({ id, nombre, precio, cantidad: 1, stock, img });
    }
    guardarCarrito();
    mostrarNotificacion('✓ ' + nombre + ' añadido al carrito', 'success');
}

function cambiarCantidad(idx, delta) {
    if (idx < 0 || idx >= carrito.length) return;
    const item = carrito[idx];
    const nueva = item.cantidad + delta;
    if (nueva < 1) {
        carrito.splice(idx, 1);
    } else if (nueva > item.stock) {
        mostrarNotificacion('Stock máximo: ' + item.stock, 'error');
        return;
    } else {
        item.cantidad = nueva;
    }
    guardarCarrito();
}

function eliminarDelCarrito(idx) {
    carrito.splice(idx, 1);
    guardarCarrito();
}

function abrirCarrito() {
    document.getElementById('cartDrawer').style.display = 'flex';
    document.getElementById('cartOverlay').style.display = 'block';
    renderCarrito();
}

function cerrarCarrito() {
    document.getElementById('cartDrawer').style.display = 'none';
    document.getElementById('cartOverlay').style.display = 'none';
}

function checkoutCarrito() {
    if (carrito.length === 0) return;
    const btn = document.getElementById('cartCheckoutBtn');
    btn.disabled = true;
    btn.textContent = 'Procesando...';

    const data = new URLSearchParams();
    data.set('items', JSON.stringify(carrito.map(i => ({ id: i.id, cantidad: i.cantidad }))));
    data.set('total', carrito.reduce((s, i) => s + i.precio * i.cantidad, 0));

    fetch(BASE + '/pedido/comprar-rapido', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: data.toString()
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            mostrarNotificacion('✓ Pedido creado: ' + (res.codigo || '#OK'), 'success');
            carrito = [];
            guardarCarrito();
            cerrarCarrito();
        } else {
            mostrarNotificacion('✗ ' + (res.error || 'Error'), 'error');
            btn.disabled = false;
            btn.textContent = 'Ir a pagar';
        }
    })
    .catch(() => {
        mostrarNotificacion('✗ Error de conexión', 'error');
        btn.disabled = false;
        btn.textContent = 'Ir a pagar';
    });
}

/* ===== FILTROS ===== */
function filtrarProductos() {
    const q = (document.getElementById('e6Search').value || '').toLowerCase();
    const cat = document.querySelector('#e6Cats .active')?.dataset?.cat || 'all';
    const sort = document.getElementById('e6Sort').value;
    const cards = document.querySelectorAll('#e6Grid .e6-card');
    let visible = 0;

    const items = [];
    cards.forEach(c => {
        const nombre = (c.dataset.nombre || '').toLowerCase();
        const cCat = c.dataset.cat || 'General';
        const match = (cat === 'all' || cCat === cat) && (q === '' || nombre.includes(q));
        c.style.display = match ? '' : 'none';
        if (match) { visible++; items.push(c); }
    });

    document.getElementById('e6Empty').style.display = visible === 0 ? 'block' : 'none';

    if (sort !== 'default') {
        const parent = document.getElementById('e6Grid');
        const sorted = [...items].sort((a, b) => {
            const pa = parseFloat(a.dataset.precio);
            const pb = parseFloat(b.dataset.precio);
            if (sort === 'price-asc') return pa - pb;
            if (sort === 'price-desc') return pb - pa;
            if (sort === 'name') return (a.dataset.nombre || '').localeCompare(b.dataset.nombre || '');
            return 0;
        });
        sorted.forEach(c => parent.appendChild(c));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    actualizarCarritoUI();

    document.querySelectorAll('#e6Cats .e6-cat').forEach(el => {
        el.addEventListener('click', function() {
            document.querySelectorAll('#e6Cats .e6-cat').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            filtrarProductos();
        });
    });
});

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
