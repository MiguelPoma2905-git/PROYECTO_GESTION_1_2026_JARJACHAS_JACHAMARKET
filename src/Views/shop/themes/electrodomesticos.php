<?php if ($themePart === 'css'): ?>
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
    .e6-wishlist-count { background:rgba(255,255,255,0.06); border:1px solid var(--ebo); border-radius:8px; padding:8px 14px; color:var(--et); opacity:0.7; cursor:pointer; transition:all .2s; font-size:13px; display:flex; align-items:center; gap:6px; }
    .e6-wishlist-count:hover { opacity:1; border-color:var(--es); background:rgba(44,111,187,0.1); }
    .e6-wishlist-count .badge { background:#ef4444; color:#fff; font-size:9px; font-weight:700; min-width:16px; height:16px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
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
    .e6-card-stock-tag { position:absolute; top:48px; left:12px; padding:4px 10px; border-radius:4px; font-size:9px; font-weight:600; }
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
    .e6-faq { position:relative; z-index:1; max-width:800px; margin:0 auto 40px; padding:0 40px; }
    .e6-faq h2 { font-size:22px; font-weight:700; color:var(--et); margin-bottom:8px; text-align:center; }
    .e6-faq > p { font-size:12px; color:var(--et); opacity:0.4; text-align:center; margin-bottom:28px; }
    .e6-faq-item { background:var(--esu); border:1px solid var(--ebo); border-radius:12px; margin-bottom:8px; overflow:hidden; transition:all .3s; }
    .e6-faq-q { width:100%; background:none; border:none; padding:16px 20px; font-size:13px; font-weight:600; color:var(--et); text-align:left; cursor:pointer; display:flex; align-items:center; justify-content:space-between; gap:12px; transition:all .2s; font-family:inherit; }
    .e6-faq-q:hover { background:rgba(255,255,255,0.02); }
    .e6-faq-q .arrow { font-size:12px; opacity:0.3; transition:transform .3s; flex-shrink:0; }
    .e6-faq-item.open .e6-faq-q .arrow { transform:rotate(180deg); opacity:0.6; }
    .e6-faq-a { max-height:0; overflow:hidden; transition:max-height .4s cubic-bezier(.4,0,.2,1), padding .3s; padding:0 20px; color:var(--et); opacity:0.6; font-size:12px; line-height:1.7; }
    .e6-faq-item.open .e6-faq-a { max-height:300px; padding:0 20px 16px; }

    .e6-foot { position:relative; z-index:1; text-align:center; padding:32px; border-top:1px solid var(--ebo); color:var(--et); opacity:0.2; font-size:11px; }
    .e6-wm { position:fixed; bottom:16px; right:20px; display:flex; align-items:center; gap:8px; opacity:0.2; pointer-events:none; z-index:9999; background:rgba(0,0,0,0.3); padding:6px 14px 6px 10px; border-radius:20px; backdrop-filter:blur(4px); }
    .e6-wm img { height:14px; width:auto; opacity:0.5; }
    .btn-edit { position:fixed; bottom:24px; left:24px; z-index:10000; background:var(--es); color:#fff; border:none; border-radius:8px; padding:10px 20px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 4px 20px rgba(44,111,187,0.3); transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .btn-edit:hover { transform:translateY(-3px); box-shadow:0 8px 32px rgba(44,111,187,0.4); background:#3a7fcf; }
    .e6-wa { position:fixed; bottom:24px; right:24px; z-index:9999; width:52px; height:52px; border-radius:50%; background:#25D366; color:#fff; border:none; font-size:24px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 20px rgba(37,211,102,0.3); transition:all .3s; text-decoration:none; }
    .e6-wa:hover { transform:scale(1.1); box-shadow:0 8px 30px rgba(37,211,102,0.4); }

    /* ===== COMPARACIÓN ===== */
    .e6-compare-btn { position:absolute; bottom:12px; right:12px; background:rgba(255,255,255,0.06); border:1px solid var(--ebo); border-radius:6px; padding:4px 10px; font-size:9px; font-weight:600; color:var(--et); opacity:0.4; cursor:pointer; transition:all .2s; z-index:2; }
    .e6-compare-btn:hover { opacity:1; border-color:var(--es); background:rgba(44,111,187,0.1); }
    .e6-compare-btn.active { opacity:1; background:var(--es); color:#fff; border-color:var(--es); }
    .e6-compare-bar { position:fixed; bottom:0; left:0; right:0; z-index:9998; background:rgba(15,26,46,0.97); backdrop-filter:blur(16px); border-top:1px solid var(--ebo); padding:12px 32px; display:none; align-items:center; justify-content:space-between; transform:translateY(100%); transition:transform .3s ease; }
    .e6-compare-bar.show { display:flex; transform:translateY(0); }
    .e6-compare-bar-info { display:flex; align-items:center; gap:12px; }
    .e6-compare-bar-info strong { font-size:13px; color:var(--et); }
    .e6-compare-bar-info span { font-size:11px; color:var(--et); opacity:0.4; }
    .e6-compare-bar .e6-btn { padding:8px 18px; font-size:11px; }
    .e6-compare-bar .e6-btn:disabled { opacity:0.4; cursor:not-allowed; transform:none; }

    .e6-compare-modal { position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.7); backdrop-filter:blur(8px); display:none; align-items:center; justify-content:center; padding:32px; }
    .e6-compare-modal.open { display:flex; }
    .e6-compare-modal-box { background:var(--eb); border:1px solid var(--ebo); border-radius:20px; max-width:1100px; width:100%; max-height:85vh; overflow-y:auto; position:relative; animation:fU .3s ease; }
    .e6-compare-modal-close { position:absolute; top:16px; right:20px; background:none; border:none; color:var(--et); opacity:0.3; font-size:22px; cursor:pointer; }
    .e6-compare-modal-close:hover { opacity:1; }
    .e6-compare-modal-hdr { padding:24px 32px 16px; border-bottom:1px solid var(--ebo); }
    .e6-compare-modal-hdr h3 { font-size:18px; font-weight:600; color:var(--et); margin:0; }
    .e6-compare-table { width:100%; border-collapse:collapse; }
    .e6-compare-table td { padding:14px 20px; text-align:center; border-bottom:1px solid var(--ebo); font-size:12px; color:var(--et); }
    .e6-compare-table td:first-child { text-align:left; font-weight:600; opacity:0.5; width:140px; font-size:11px; text-transform:uppercase; letter-spacing:.5px; }
    .e6-compare-table .cmp-img { width:100%; max-width:180px; height:140px; object-fit:cover; border-radius:8px; background:rgba(255,255,255,0.04); margin:0 auto; display:block; }
    .e6-compare-table .cmp-name { font-size:14px; font-weight:600; color:var(--et); }
    .e6-compare-table .cmp-price { font-size:18px; font-weight:700; color:var(--es); }
    .e6-compare-table .cmp-stock { font-size:11px; }
    .e6-compare-table .cmp-stock.ok { color:#10b981; }
    .e6-compare-table .cmp-stock.low { color:#ef4444; }
    .e6-compare-table tr:last-child td { border-bottom:none; }

    /* ===== LIGHTBOX GALERÍA ===== */
    .e6-lbox { position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.92); backdrop-filter:blur(12px); display:none; align-items:center; justify-content:center; }
    .e6-lbox.open { display:flex; }
    .e6-lbox-img { max-width:80vw; max-height:80vh; border-radius:12px; object-fit:contain; box-shadow:0 20px 80px rgba(0,0,0,0.5); }
    .e6-lbox-close { position:absolute; top:24px; right:32px; background:none; border:none; color:rgba(255,255,255,0.4); font-size:32px; cursor:pointer; transition:all .2s; }
    .e6-lbox-close:hover { color:#fff; }
    .e6-lbox-prev, .e6-lbox-next { position:absolute; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.06); border:none; color:rgba(255,255,255,0.4); font-size:28px; width:48px; height:48px; border-radius:50%; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
    .e6-lbox-prev:hover, .e6-lbox-next:hover { background:rgba(255,255,255,0.12); color:#fff; }
    .e6-lbox-prev { left:24px; }
    .e6-lbox-next { right:24px; }
    .e6-lbox-thumbs { position:absolute; bottom:24px; left:50%; transform:translateX(-50%); display:flex; gap:8px; }
    .e6-lbox-thumb { width:48px; height:48px; border-radius:6px; object-fit:cover; cursor:pointer; opacity:0.4; border:2px solid transparent; transition:all .2s; }
    .e6-lbox-thumb:hover, .e6-lbox-thumb.active { opacity:1; border-color:var(--es); }
    .e6-card-img { cursor:pointer; }

    /* ===== WISHLIST ===== */
    .e6-wishlist-btn { position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; color:rgba(255,255,255,0.5); font-size:14px; transition:all .2s; z-index:2; border:2px solid transparent; }
    .e6-wishlist-btn:hover { color:#fff; background:rgba(0,0,0,0.6); }
    .e6-wishlist-btn.active { color:#ef4444; background:rgba(239,68,68,0.25); border-color:rgba(239,68,68,0.3); }

    /* ===== VALORACIONES ===== */
    .e6-stars { display:flex; gap:2px; margin:4px 0 8px; }
    .e6-star { font-size:11px; color:rgba(255,255,255,0.1); }
    .e6-star.filled { color:#f59e0b; }
    .e6-rating-count { font-size:10px; color:var(--et); opacity:0.3; margin-left:4px; }

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
    /* ===== FILTROS AVANZADOS ===== */
    .e6-filter-toggle { display:flex; align-items:center; gap:8px; margin-bottom:16px; cursor:pointer; user-select:none; }
    .e6-filter-toggle span { font-size:11px; font-weight:600; color:var(--et); opacity:0.5; text-transform:uppercase; letter-spacing:.5px; transition:all .2s; }
    .e6-filter-toggle i { font-size:14px; color:var(--es); opacity:0.7; transition:transform .3s; }
    .e6-filter-toggle:hover span { opacity:0.8; }
    .e6-filter-toggle.open i { transform:rotate(180deg); }
    .e6-filter-panel { display:none; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px; padding:20px; background:var(--esu); border:1px solid var(--ebo); border-radius:12px; }
    .e6-filter-panel.open { display:grid; }
    .e6-filter-group { }
    .e6-filter-group label { display:block; font-size:9px; font-weight:600; color:var(--et); opacity:0.4; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }
    .e6-filter-group input[type="number"] { width:100%; background:rgba(255,255,255,0.04); border:1px solid var(--ebo); border-radius:6px; padding:6px 10px; color:var(--et); font-size:11px; }
    .e6-filter-group input[type="number"]:focus { outline:none; border-color:var(--es); }
    .e6-filter-group .range-row { display:flex; gap:6px; align-items:center; }
    .e6-filter-group .range-row span { font-size:10px; color:var(--et); opacity:0.3; }
    .e6-filter-options { display:flex; flex-wrap:wrap; gap:6px; }
    .e6-filter-chip { padding:4px 12px; border-radius:5px; font-size:10px; font-weight:500; cursor:pointer; border:1px solid var(--ebo); background:transparent; color:var(--et); opacity:0.5; transition:all .2s; }
    .e6-filter-chip:hover { border-color:var(--es); opacity:1; }
    .e6-filter-chip.active { background:var(--es); color:#fff; border-color:var(--es); opacity:1; }
    .e6-filter-clear { font-size:10px; color:var(--es); cursor:pointer; opacity:0.6; text-decoration:underline; margin-top:4px; display:inline-block; }
    .e6-filter-clear:hover { opacity:1; }
    .e6-filter-count { font-size:10px; color:var(--et); opacity:0.3; margin-left:auto; }

    .e6-contact { position:relative; z-index:1; max-width:1200px; margin:0 auto; padding:20px 40px 0; }
    .e6-contact-inner { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; padding:16px 24px; background:var(--esu); border:1px solid var(--ebo); border-radius:12px; font-size:12px; color:var(--et); opacity:0.7; }
    .e6-contact-inner span { display:flex; align-items:center; gap:6px; }
    @media(max-width:768px){ .e6-contact-inner { flex-direction:column; align-items:center; gap:10px; } }
    @media(max-width:1024px){ .e6-grid{grid-template-columns:repeat(2,1fr)} .e6-banner{grid-template-columns:1fr} .e6-search{width:140px} .e6-search:focus{width:180px} .e6-filter-panel{grid-template-columns:repeat(2,1fr)} }
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
        .e6-filter-panel{grid-template-columns:1fr}
        .e6-faq{padding:0 20px}
        .e6-faq h2{font-size:18px}
        .e6-faq-q{font-size:12px;padding:14px 16px}
    }
</style>
<?php elseif ($themePart === 'html'): ?>
<?php
    $tipos = [];
    $marcas = [];
    $eficiencias = [];
    $garantias = [];
    foreach ($productos as $pr) {
        $ats = json_decode($pr['atributos'] ?? '{}', true);
        $t = $ats['tipo'] ?? 'General';
        if (!in_array($t, $tipos)) $tipos[] = $t;
        $m = $ats['marca'] ?? '';
        if ($m && !in_array($m, $marcas)) $marcas[] = $m;
        $e = $ats['eficiencia'] ?? '';
        if ($e && !in_array($e, $eficiencias)) $eficiencias[] = $e;
        $g = $ats['garantia_meses'] ?? '';
        if ($g && !in_array($g, $garantias)) $garantias[] = $g;
    }
    sort($tipos);
    sort($marcas);
    sort($eficiencias);
    sort($garantias);
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
            <span class="e6-wishlist-count" onclick="abrirWishlist()" title="Lista de deseos">
                ♡ <span class="badge" id="e6WishlistBadge">0</span>
            </span>
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
        <div class="e6-filter-toggle" id="e6FilterToggle" onclick="toggleFiltros()">
            <i class="fas fa-sliders-h"></i> <span>Filtros avanzados</span>
            <span class="e6-filter-count" id="e6FilterCount"></span>
        </div>
        <div class="e6-filter-panel" id="e6FilterPanel">
            <div class="e6-filter-group">
                <label>Precio (Bs.)</label>
                <div class="range-row">
                    <input type="number" id="e6FilterMin" placeholder="Mín" min="0" oninput="filtrarProductos()">
                    <span>—</span>
                    <input type="number" id="e6FilterMax" placeholder="Máx" min="0" oninput="filtrarProductos()">
                </div>
            </div>
            <?php if (count($marcas) > 0): ?>
            <div class="e6-filter-group">
                <label>Marca</label>
                <div class="e6-filter-options" id="e6FilterMarca">
                    <?php foreach ($marcas as $m): ?>
                    <span class="e6-filter-chip" data-val="<?= htmlspecialchars($m) ?>" onclick="toggleFilterChip(this, 'marca')"><?= htmlspecialchars($m) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (count($eficiencias) > 0): ?>
            <div class="e6-filter-group">
                <label>Eficiencia</label>
                <div class="e6-filter-options" id="e6FilterEficiencia">
                    <?php foreach ($eficiencias as $e): ?>
                    <span class="e6-filter-chip" data-val="<?= htmlspecialchars($e) ?>" onclick="toggleFilterChip(this, 'eficiencia')"><?= htmlspecialchars($e) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (count($garantias) > 0): ?>
            <div class="e6-filter-group">
                <label>Garantía</label>
                <div class="e6-filter-options" id="e6FilterGarantia">
                    <?php foreach ($garantias as $g): ?>
                    <span class="e6-filter-chip" data-val="<?= htmlspecialchars($g) ?>" onclick="toggleFilterChip(this, 'garantia')"><?= htmlspecialchars($g) ?> meses</span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
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
            <?php
                $imgsAdicionales = [];
                if (!empty($atributos['imagenes_adicionales'])) {
                    $parsed = $atributos['imagenes_adicionales'];
                    if (is_string($parsed)) $parsed = json_decode($parsed, true);
                    if (is_array($parsed)) $imgsAdicionales = $parsed;
                }
            ?>
            <div class="e6-card" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>" data-precio="<?= $producto['precio_base'] ?>" data-stock="<?= $producto['stock'] ?>" data-cat="<?= htmlspecialchars($tipo) ?>" data-marca="<?= htmlspecialchars($atributos['marca'] ?? '') ?>" data-eficiencia="<?= htmlspecialchars($atributos['eficiencia'] ?? '') ?>" data-garantia="<?= htmlspecialchars($atributos['garantia_meses'] ?? '') ?>" data-imagenes="<?= htmlspecialchars(json_encode($imgsAdicionales, JSON_UNESCAPED_SLASHES)) ?>">
                <div class="e6-card-img-w">
                    <img src="<?= BASE_URL ?>/<?= ($producto['imagen_url'] ?? '') ?: 'assets/images/placeholder_producto.jpg' ?>" class="e6-card-img" onclick="abrirLightbox(this)" onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder_producto.jpg'">
                    <?php if ($marca): ?>
                    <span class="e6-card-brand-tag"><?= htmlspecialchars($marca) ?></span>
                    <?php endif; ?>
                    <span class="e6-card-stock-tag <?= $producto['stock'] > 5 ? 'ok' : 'low' ?>">
                        <i class="fas fa-<?= $producto['stock'] > 5 ? 'check-circle' : 'exclamation-circle' ?>"></i> <?= $producto['stock'] ?> ud.
                    </span>
                    <?php if (!$es_propietario): ?>
                    <button class="e6-wishlist-btn" onclick="toggleWishlist(this)" data-id="<?= $producto['id_producto'] ?>">♡</button>
                    <button class="e6-compare-btn" onclick="toggleComparar(this)" data-id="<?= $producto['id_producto'] ?>"><i class="fas fa-balance-scale"></i> Comparar</button>
                    <?php endif; ?>
                </div>
                <div class="e6-card-body">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <?php
                        $valoracion = floatval($atributos['valoracion'] ?? 0);
                        $totalVotos = intval($atributos['total_votos'] ?? 0);
                    ?>
                    <?php if ($valoracion > 0): ?>
                    <div class="e6-stars">
                        <?php for ($i = 1; $i <= 5; $i++):
                            $cls = $i <= $valoracion ? 'filled' : '';
                        ?>
                        <span class="e6-star <?= $cls ?>">★</span>
                        <?php endfor; ?>
                        <span class="e6-rating-count">(<?= $totalVotos ?>)</span>
                    </div>
                    <?php endif; ?>
                    <?php if ($atributos): ?>
                    <div class="e6-specs">
                        <?php foreach ($atributos as $key => $val):
                            if (in_array($key, ['marca','tipo','valoracion','total_votos'])) continue; ?>
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
    <?php
        $faqs = [];
        if (!empty($emprendimiento['faqs'])) {
            $parsed = $emprendimiento['faqs'];
            if (is_string($parsed)) $parsed = json_decode($parsed, true);
            if (is_array($parsed)) $faqs = $parsed;
        }
        if (empty($faqs)):
            $faqs = [
                ['p' => '¿Cuánto tiempo tarda el envío?', 'r' => 'Realizamos envíos en un plazo de 24 a 72 horas hábiles, dependiendo de tu ubicación.'],
                ['p' => '¿Ofrecen garantía en los productos?', 'r' => 'Sí, todos nuestros productos incluyen garantía oficial del fabricante. La duración varía según el producto.'],
                ['p' => '¿Qué métodos de pago aceptan?', 'r' => 'Aceptamos pagos por transferencia bancaria, pago con QR y efectivo contra entrega.'],
                ['p' => '¿Puedo cambiar o devolver un producto?', 'r' => 'Sí, aceptamos cambios y devoluciones dentro de los primeros 7 días posteriores a la compra, siempre que el producto esté en su empaque original.'],
            ];
        endif;
    ?>
    <?php if (!empty($faqs)): ?>
    <div class="e6-faq" id="e6Faq">
        <h2>❓ Preguntas Frecuentes</h2>
        <p>Todo lo que necesitas saber antes de comprar</p>
        <?php foreach ($faqs as $faq): ?>
        <div class="e6-faq-item">
            <button class="e6-faq-q" onclick="toggleFAQ(this)">
                <?= htmlspecialchars($faq['p'] ?? '') ?>
                <span class="arrow">▼</span>
            </button>
            <div class="e6-faq-a"><?= nl2br(htmlspecialchars($faq['r'] ?? '')) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($emprendimiento['telefono']) || !empty($sucursal)): ?>
    <div class="e6-contact">
        <div class="e6-contact-inner">
            <?php if (!empty($emprendimiento['telefono'])): ?>
            <span><i class="fas fa-phone" style="color:var(--es)"></i> <?= htmlspecialchars($emprendimiento['telefono']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['direccion'])): ?>
            <span><i class="fas fa-map-pin" style="color:var(--es)"></i> <?= htmlspecialchars($sucursal['direccion']) ?></span>
            <?php endif; ?>
            <?php if (!empty($sucursal['ciudad'])): ?>
            <span><i class="fas fa-city" style="color:var(--es)"></i> <?= htmlspecialchars($sucursal['ciudad']) ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="e6-foot">
        <p>&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?>. Todos los derechos reservados.</p>
    </div>
    <a href="https://wa.me/591<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $emprendimiento['telefono'] ?? '71234567')) ?>?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20productos" target="_blank" class="e6-wa" title="Contactar por WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <div class="e6-wm"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>

    <div class="e6-lbox" id="e6Lbox" onclick="if(event.target===this)cerrarLightbox()">
        <button class="e6-lbox-close" onclick="cerrarLightbox()">&times;</button>
        <button class="e6-lbox-prev" onclick="navLightbox(-1)">‹</button>
        <button class="e6-lbox-next" onclick="navLightbox(1)">›</button>
        <img class="e6-lbox-img" id="e6LboxImg" src="" alt="">
        <div class="e6-lbox-thumbs" id="e6LboxThumbs"></div>
    </div>

    <?php if (!$es_propietario): ?>
    <div class="e6-compare-bar" id="e6CompareBar">
        <div class="e6-compare-bar-info">
            <strong>Comparar productos</strong>
            <span id="e6CompareCount">0 seleccionados</span>
        </div>
        <div>
            <button class="e6-btn" id="e6CompareBtn" onclick="abrirComparacion()" disabled><i class="fas fa-balance-scale"></i> Comparar</button>
        </div>
    </div>

    <div class="e6-compare-modal" id="e6CompareModal">
        <div class="e6-compare-modal-box">
            <button class="e6-compare-modal-close" onclick="cerrarComparacion()">&times;</button>
            <div class="e6-compare-modal-hdr"><h3>Comparación de productos</h3></div>
            <div id="e6CompareContent"></div>
        </div>
    </div>
    <?php endif; ?>
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

    <script>
    /* ===== CARRITO ELECTRODOMÉSTICOS ===== */
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

    /* ===== FILTROS AVANZADOS ===== */
    let filtrosActivos = { marca: [], eficiencia: [], garantia: [] };

    function toggleFiltros() {
        const panel = document.getElementById('e6FilterPanel');
        const toggle = document.getElementById('e6FilterToggle');
        panel.classList.toggle('open');
        toggle.classList.toggle('open');
    }

    function toggleFilterChip(el, tipo) {
        el.classList.toggle('active');
        const val = el.dataset.val;
        const arr = filtrosActivos[tipo];
        if (el.classList.contains('active')) {
            if (!arr.includes(val)) arr.push(val);
        } else {
            const idx = arr.indexOf(val);
            if (idx >= 0) arr.splice(idx, 1);
        }
        filtrarProductos();
    }

    function filtrarProductos() {
        const q = (document.getElementById('e6Search').value || '').toLowerCase();
        const cat = document.querySelector('#e6Cats .active')?.dataset?.cat || 'all';
        const sort = document.getElementById('e6Sort').value;
        const precioMin = parseFloat(document.getElementById('e6FilterMin').value) || 0;
        const precioMax = parseFloat(document.getElementById('e6FilterMax').value) || Infinity;

        const cards = document.querySelectorAll('#e6Grid .e6-card');
        let visible = 0;
        const items = [];

        cards.forEach(c => {
            const nombre = (c.dataset.nombre || '').toLowerCase();
            const cCat = c.dataset.cat || 'General';
            const precio = parseFloat(c.dataset.precio) || 0;
            const marca = c.dataset.marca || '';
            const eficiencia = c.dataset.eficiencia || '';
            const garantia = c.dataset.garantia || '';

            const matchCat = cat === 'all' || cCat === cat;
            const matchQ = q === '' || nombre.includes(q);
            const matchPrice = precio >= precioMin && precio <= precioMax;
            const matchMarca = filtrosActivos.marca.length === 0 || filtrosActivos.marca.includes(marca);
            const matchEficiencia = filtrosActivos.eficiencia.length === 0 || filtrosActivos.eficiencia.includes(eficiencia);
            const matchGarantia = filtrosActivos.garantia.length === 0 || filtrosActivos.garantia.includes(garantia);

            const match = matchCat && matchQ && matchPrice && matchMarca && matchEficiencia && matchGarantia;
            c.style.display = match ? '' : 'none';
            if (match) { visible++; items.push(c); }
        });

        document.getElementById('e6Empty').style.display = visible === 0 ? 'block' : 'none';
        const totalFilters = (filtrosActivos.marca.length + filtrosActivos.eficiencia.length + filtrosActivos.garantia.length) + (precioMin > 0 || precioMax < Infinity ? 1 : 0);
        const countEl = document.getElementById('e6FilterCount');
        countEl.textContent = totalFilters > 0 ? visible + ' resultado(s)' : '';

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

    /* ===== WISHLIST ===== */
    let wishlist = JSON.parse(localStorage.getItem('jacha_wish_' + TIENDA_ID) || '[]');

    function toggleWishlist(btn) {
        const id = parseInt(btn.dataset.id);
        const idx = wishlist.indexOf(id);
        if (idx >= 0) {
            wishlist.splice(idx, 1);
            btn.classList.remove('active');
            btn.textContent = '♡';
        } else {
            wishlist.push(id);
            btn.classList.add('active');
            btn.textContent = '♥';
        }
        localStorage.setItem('jacha_wish_' + TIENDA_ID, JSON.stringify(wishlist));
        actualizarWishlistUI();
    }

    function actualizarWishlistUI() {
        const badge = document.getElementById('e6WishlistBadge');
        if (badge) {
            badge.textContent = wishlist.length;
        }
        document.querySelectorAll('.e6-wishlist-btn').forEach(btn => {
            const id = parseInt(btn.dataset.id);
            if (wishlist.includes(id)) {
                btn.classList.add('active');
                btn.textContent = '♥';
            } else {
                btn.classList.remove('active');
                btn.textContent = '♡';
            }
        });
    }

    function abrirWishlist() {
        if (wishlist.length === 0) {
            mostrarNotificacion('Tu lista de deseos está vacía', 'error');
            return;
        }
        let msg = '♥ Lista de deseos (' + wishlist.length + '):\n';
        wishlist.forEach(id => {
            const card = document.querySelector('.e6-card[data-id="' + id + '"]');
            if (card) msg += '• ' + card.dataset.nombre + '\n';
        });
        mostrarNotificacion(msg.replace(/\n/g, ' | '), 'success');
    }

    /* ===== FAQ ===== */
    function toggleFAQ(btn) {
        btn.parentElement.classList.toggle('open');
    }

    /* ===== COMPARACIÓN ===== */
    let compararLista = [];

    function toggleComparar(btn) {
        const id = parseInt(btn.dataset.id);
        const idx = compararLista.indexOf(id);
        if (idx >= 0) {
            compararLista.splice(idx, 1);
            btn.classList.remove('active');
        } else {
            if (compararLista.length >= 4) {
                mostrarNotificacion('Máximo 4 productos para comparar', 'error');
                return;
            }
            compararLista.push(id);
            btn.classList.add('active');
        }
        actualizarBarComparar();
    }

    function actualizarBarComparar() {
        const bar = document.getElementById('e6CompareBar');
        const count = document.getElementById('e6CompareCount');
        const btn = document.getElementById('e6CompareBtn');
        if (!bar) return;
        if (compararLista.length > 0) {
            bar.classList.add('show');
            count.textContent = compararLista.length + ' seleccionado(s)';
            btn.disabled = compararLista.length < 2;
        } else {
            bar.classList.remove('show');
        }
    }

    function abrirComparacion() {
        if (compararLista.length < 2) return;
        const datos = [];
        compararLista.forEach(id => {
            const card = document.querySelector('.e6-card[data-id="' + id + '"]');
            if (card) {
                const img = card.querySelector('.e6-card-img')?.src || '';
                datos.push({
                    id: id,
                    nombre: card.dataset.nombre,
                    precio: card.dataset.precio,
                    stock: card.dataset.stock,
                    img: img,
                    marca: card.dataset.marca || '-',
                    tipo: card.dataset.cat || 'General',
                    eficiencia: card.dataset.eficiencia || '-',
                    garantia: card.dataset.garantia || '-',
                });
            }
        });

        const specs = ['marca', 'tipo', 'eficiencia', 'garantia'];
        const specLabels = { marca: 'Marca', tipo: 'Tipo', eficiencia: 'Eficiencia', garantia: 'Garantía (meses)' };

        function escHtml(s) { return (s+'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

        let html = '<table class="e6-compare-table">';
        html += '<tr><td>Producto</td>';
        datos.forEach(d => {
            html += '<td><img src="' + d.img + '" class="cmp-img" onerror="this.src=\'' + BASE + '/assets/images/placeholder_producto.jpg\'"><div class="cmp-name">' + escHtml(d.nombre) + '</div></td>';
        });
        html += '</tr>';
        html += '<tr><td>Precio</td>';
        datos.forEach(d => {
            html += '<td><div class="cmp-price">Bs. ' + parseFloat(d.precio).toFixed(2) + '</div></td>';
        });
        html += '</tr>';
        html += '<tr><td>Stock</td>';
        datos.forEach(d => {
            const cls = parseInt(d.stock) > 5 ? 'ok' : 'low';
            html += '<td><span class="cmp-stock ' + cls + '">' + d.stock + ' ud.</span></td>';
        });
        html += '</tr>';
        specs.forEach(s => {
            html += '<tr><td>' + specLabels[s] + '</td>';
            datos.forEach(d => {
                html += '<td>' + d[s] + '</td>';
            });
            html += '</tr>';
        });
        html += '</table>';

        document.getElementById('e6CompareContent').innerHTML = html;
        document.getElementById('e6CompareModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function cerrarComparacion() {
        document.getElementById('e6CompareModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('e6-compare-modal')) cerrarComparacion();
    });

    /* ===== LIGHTBOX GALERÍA ===== */
    let lboxImgs = [];
    let lboxIdx = 0;

    function abrirLightbox(imgEl) {
        const card = imgEl.closest('.e6-card');
        if (!card) return;
        const principal = imgEl.src;
        let adicionales = [];
        try {
            const raw = card.dataset.imagenes;
            if (raw) adicionales = JSON.parse(raw);
        } catch(e) {}
        const todas = [principal, ...adicionales.filter(u => u && u !== principal)];
        lboxImgs = [...new Set(todas)];
        lboxIdx = 0;
        mostrarLboxImg();
        document.getElementById('e6Lbox').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function cerrarLightbox() {
        document.getElementById('e6Lbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    function mostrarLboxImg() {
        const img = document.getElementById('e6LboxImg');
        img.src = lboxImgs[lboxIdx];
        const single = lboxImgs.length <= 1;
        document.querySelector('#e6Lbox .e6-lbox-prev').style.display = single ? 'none' : '';
        document.querySelector('#e6Lbox .e6-lbox-next').style.display = single ? 'none' : '';
        const thumbs = document.getElementById('e6LboxThumbs');
        thumbs.innerHTML = '';
        lboxImgs.forEach((url, i) => {
            const t = document.createElement('img');
            t.className = 'e6-lbox-thumb' + (i === lboxIdx ? ' active' : '');
            t.src = url;
            t.onerror = function() { this.style.display = 'none'; };
            t.onclick = function() { lboxIdx = i; mostrarLboxImg(); };
            thumbs.appendChild(t);
        });
    }

    function navLightbox(dir) {
        if (lboxImgs.length <= 1) return;
        lboxIdx = (lboxIdx + dir + lboxImgs.length) % lboxImgs.length;
        mostrarLboxImg();
    }

    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('e6Lbox').classList.contains('open')) return;
        if (e.key === 'Escape') cerrarLightbox();
        if (e.key === 'ArrowLeft') navLightbox(-1);
        if (e.key === 'ArrowRight') navLightbox(1);
    });

    document.addEventListener('DOMContentLoaded', function() {
        actualizarCarritoUI();
        actualizarWishlistUI();

        document.querySelectorAll('#e6Cats .e6-cat').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('#e6Cats .e6-cat').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                filtrarProductos();
            });
        });
    });
    </script>
<?php endif; ?>
