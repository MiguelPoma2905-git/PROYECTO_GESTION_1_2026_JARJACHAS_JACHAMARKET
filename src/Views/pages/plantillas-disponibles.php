<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Plantillas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',system-ui,sans-serif; background:var(--bg,#0d0d0d); color:var(--text,#f0f0f0); min-height:100vh; }
        .container { max-width:1500px; margin:0 auto; padding:40px 28px; }
        .header { display:flex; align-items:center; justify-content:space-between; margin-bottom:48px; }
        .header .logo-img { height:28px; width:auto; opacity:0.7; }
        .header .back-btn { color:var(--text-muted,#888); text-decoration:none; font-size:13px; display:flex; align-items:center; gap:6px; transition:color .2s; font-family:'Cormorant Garamond',Georgia,serif; font-size:15px; }
        .header .back-btn:hover { color:var(--text,#f0f0f0); }
        .page-title { text-align:center; margin-bottom:8px; }
        .page-title h1 { font-family:'Cormorant Garamond',Georgia,serif; font-size:44px; font-weight:500; color:var(--text,#f0f0f0); margin-bottom:10px; letter-spacing:-0.5px; }
        .page-title p { font-size:14px; color:var(--text-muted,#888); max-width:520px; margin:0 auto 48px; line-height:1.7; font-family:'DM Sans',system-ui,sans-serif; }
        .plantillas-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:32px; }
        .plantilla-card { background:var(--card-bg,#141414); border:1px solid var(--border,rgba(255,255,255,0.05)); border-radius:8px; overflow:hidden; transition:all .4s cubic-bezier(.4,0,.2,1); display:flex; flex-direction:column; position:relative; }
        .plantilla-card::before { content:'';position:absolute;inset:-1px;border-radius:8px;background:linear-gradient(135deg,rgba(255,255,255,0.04),transparent 50%,rgba(255,255,255,0.02));pointer-events:none;z-index:-1;opacity:0;transition:opacity .5s; }
        .plantilla-card:hover::before { opacity:1; }
        .plantilla-card:hover { transform:translateY(-6px); border-color:rgba(255,255,255,0.08); box-shadow:0 20px 60px rgba(0,0,0,0.3); }
        .plantilla-img-wrap { position:relative; height:260px; overflow:hidden; flex-shrink:0; display:block; text-decoration:none; }
        .plantilla-img-wrap::after { content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.5) 0%,transparent 50%);pointer-events:none;z-index:1; }
        .plantilla-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .6s; display:block; }
        .plantilla-card:hover .plantilla-img-wrap img { transform:scale(1.06); }
        .plantilla-img-wrap .badge { position:absolute; bottom:16px; left:16px; background:rgba(0,0,0,0.55); backdrop-filter:blur(8px); padding:4px 14px; border-radius:4px; font-size:11px; font-weight:500; letter-spacing:0.5px; color:#fff; z-index:2; font-family:'Cormorant Garamond',Georgia,serif; }
        .plantilla-img-wrap .featured-tag { position:absolute; top:16px; right:16px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--text-muted,#aaa); font-size:9px; font-weight:500; padding:3px 10px; border-radius:4px; letter-spacing:1px; text-transform:uppercase; z-index:2; }
        .plantilla-body { padding:24px 28px 28px; flex:1; display:flex; flex-direction:column; }
        .plantilla-body h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:22px; font-weight:500; color:var(--text,#f0f0f0); margin-bottom:6px; }
        .plantilla-body .desc { font-size:13px; color:var(--text-muted,#888); line-height:1.65; margin-bottom:20px; flex:1; }
        .plantilla-colors { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
        .color-swatch { display:flex; align-items:center; gap:6px; padding:4px 10px; background:var(--surface2,#1a1a1a); border:1px solid var(--border,rgba(255,255,255,0.04)); border-radius:4px; }
        .color-swatch .swatch-dot { width:14px; height:14px; border-radius:3px; flex-shrink:0; }
        .color-swatch .swatch-label { font-size:9px; color:var(--text-dim,#666); letter-spacing:0.3px; text-transform:uppercase; }
        .plantilla-actions { display:flex; gap:12px; }
        .btn-detail { flex:1; padding:12px; border:1px solid var(--border,rgba(255,255,255,0.06)); background:transparent; color:var(--text,#f0f0f0); border-radius:6px; font-size:13px; font-weight:500; cursor:pointer; transition:all .3s; text-align:center; text-decoration:none; }
        .btn-detail:hover { background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.12); }
        .btn-elegir { flex:1; padding:12px; background:var(--text,#e8e8e8); color:var(--bg,#121212); border:none; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer; transition:all .3s; text-align:center; text-decoration:none; }
        .btn-elegir:hover { opacity:0.85; transform:translateY(-1px); }
        [data-theme="dark"] .plantilla-card:hover { border-color:rgba(255,255,255,0.08); box-shadow:0 20px 60px rgba(0,0,0,0.3); }
        [data-theme="dark"] .btn-detail:hover { background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.12); }
        [data-theme="light"] .plantilla-card:hover { border-color:rgba(0,0,0,0.12); box-shadow:0 20px 60px rgba(0,0,0,0.06); }
        [data-theme="light"] .btn-detail:hover { background:rgba(0,0,0,0.03); border-color:rgba(0,0,0,0.15); }
        [data-theme="light"] .plantilla-card::before { background:linear-gradient(135deg,rgba(0,0,0,0.03),transparent 50%,rgba(0,0,0,0.02)); }
        [data-theme="light"] .modal-overlay { background:rgba(255,255,255,0.6); backdrop-filter:blur(8px); }
        [data-theme="light"] .modal-box { box-shadow:0 32px 80px rgba(0,0,0,0.08); }
        [data-theme="light"] .btn-elegir { box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .error-message { text-align:center; padding:60px 40px; background:var(--card-bg,#141414); border:1px solid var(--border,rgba(255,255,255,0.05)); border-radius:8px; max-width:520px; margin:0 auto; }
        .error-message h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:22px; margin-bottom:8px; font-weight:500; color:var(--text,#f0f0f0); }
        .error-message p { font-size:13px; color:var(--text-muted,#888); margin-bottom:24px; }
        .btn-error { background:var(--text,#f0f0f0); color:var(--bg,#0d0d0d); padding:12px 28px; border-radius:6px; text-decoration:none; display:inline-block; font-size:13px; font-weight:500; transition:all .3s; }
        .btn-error:hover { transform:translateY(-1px); opacity:0.9; }
        .watermark { position:fixed; bottom:12px; right:16px; opacity:0.25; pointer-events:none; z-index:9999; }
        .watermark img { height:16px; width:auto; }
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(8px); z-index:1000; display:none; align-items:center; justify-content:center; animation:fadeIn .3s ease; }
        .modal-overlay.active { display:flex; }
        .modal-box { background:var(--card-bg,#141414); border:1px solid var(--border,rgba(255,255,255,0.06)); border-radius:8px; padding:40px; max-width:420px; width:90%; text-align:center; box-shadow:0 32px 80px rgba(0,0,0,0.4); animation:modalIn .3s ease; position:relative; }
        .modal-box h3 { font-family:'Cormorant Garamond',Georgia,serif; font-size:24px; font-weight:500; color:var(--text,#f0f0f0); margin-bottom:12px; }
        .modal-box p { font-size:13px; color:var(--text-muted,#888); margin-bottom:28px; line-height:1.6; }
        .modal-actions { display:flex; gap:12px; justify-content:center; }
        .modal-btn { padding:12px 28px; border-radius:6px; font-size:13px; font-weight:500; text-decoration:none; transition:all .2s; }
        .modal-btn-primary { background:var(--text,#f0f0f0); color:var(--bg,#0d0d0d); }
        .modal-btn-primary:hover { transform:translateY(-1px); opacity:0.9; }
        .modal-btn-secondary { background:transparent; border:1px solid var(--border,rgba(255,255,255,0.1)); color:var(--text,#f0f0f0); }
        .modal-btn-secondary:hover { border-color:rgba(255,255,255,0.2); }
        .modal-btn-close { position:absolute; top:16px; right:16px; background:none; border:none; color:var(--text-muted,#888); font-size:24px; cursor:pointer; transition:color .2s; }
        .modal-btn-close:hover { color:var(--text,#f0f0f0); }
        @keyframes fadeIn { from{opacity:0} to{opacity:1} }
        @keyframes modalIn { from{opacity:0;transform:scale(0.95) translateY(20px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @media (max-width:1200px) { .container { padding:32px 24px; } .plantillas-grid { gap:24px; } }
        @media (max-width:1024px) { .plantillas-grid { grid-template-columns:repeat(2,1fr); } }
        @media (max-width:768px) { .plantillas-grid { grid-template-columns:1fr; gap:20px; } .container { padding:24px 16px; } .page-title h1 { font-size:34px; } .plantilla-img-wrap { height:200px; } .color-swatch .swatch-label { display:none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:48px;">
            <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img" style="height:28px;width:auto;opacity:0.7;"></a>
            <div style="display:flex;align-items:center;gap:16px;">
                <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="background:none;border:none;color:var(--text-muted);font-size:22px;cursor:pointer;transition:color .2s;line-height:1;padding:0;">&#9790;</button>
                <a href="<?= BASE_URL ?>/" class="back-btn" style="color:var(--text-muted);text-decoration:none;font-size:15px;display:flex;align-items:center;gap:6px;transition:color .2s;font-family:'Cormorant Garamond',Georgia,serif;">&larr; Volver al inicio</a>
            </div>
        </div>

        <div class="page-title">
            <h1>Elige la plantilla de tu negocio</h1>
            <p>Cada plantilla est&aacute; dise&ntilde;ada para un tipo de negocio. Selecciona la que mejor represente tu marca.</p>
        </div>

        <?php if (!$mostrar_selector): ?>
            <div class="error-message">
                <h3>No puedes seleccionar una plantilla</h3>
                <p><?= $mensaje_error ?></p>
                <?php if (!$is_logged_in): ?>
                    <a href="<?= BASE_URL ?>/login" class="btn-error">Iniciar sesi&oacute;n</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/perfil" class="btn-error">Ir a mi perfil</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="plantillas-grid">
                <?php foreach ($plantillas as $plantilla): 
                    $img = BASE_URL . '/assets/images/plantillas/plantilla_' . $plantilla['id_plantilla'] . '.jpg';
                    $esNueva = in_array($plantilla['id_plantilla'], [7,8,9,10,11,12]);
                ?>
                <div class="plantilla-card">
                    <a href="<?= BASE_URL ?>/plantilla/<?= $plantilla['id_plantilla'] ?>" class="plantilla-img-wrap">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($plantilla['nombre']) ?>" loading="lazy" onerror="this.style.display='none'">
                        <div class="badge"><?= htmlspecialchars($plantilla['nombre']) ?></div>
                        <?php if ($esNueva): ?>
                        <div class="featured-tag">Nueva</div>
                        <?php endif; ?>
                    </a>
                    <div class="plantilla-body">
                        <h3><?= htmlspecialchars($plantilla['nombre']) ?></h3>
                        <p class="desc"><?= htmlspecialchars($plantilla['descripcion']) ?></p>
                        <div class="plantilla-colors">
                            <div class="color-swatch"><div class="swatch-dot" style="background:<?= $plantilla['color_primario'] ?>"></div><span class="swatch-label">Primario</span></div>
                            <div class="color-swatch"><div class="swatch-dot" style="background:<?= $plantilla['color_secundario'] ?>"></div><span class="swatch-label">Secundario</span></div>
                            <div class="color-swatch"><div class="swatch-dot" style="background:<?= $plantilla['color_fondo'] ?? '#FDFBF7' ?>"></div><span class="swatch-label">Fondo</span></div>
                        </div>
                        <div class="plantilla-actions">
                            <a href="<?= BASE_URL ?>/plantilla/<?= $plantilla['id_plantilla'] ?>" class="btn-detail">Detalles</a>
                            <button class="btn-elegir" onclick="elegirPlantilla(<?= $plantilla['id_plantilla'] ?>, '<?= htmlspecialchars($plantilla['nombre'], ENT_QUOTES) ?>')">Usar</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal-overlay" id="authModal">
        <div class="modal-box">
            <button class="modal-btn-close" onclick="cerrarModal()">&times;</button>
            <h3>Inicia sesi&oacute;n para continuar</h3>
            <p>Necesitas tener una cuenta de emprendedor para usar esta plantilla. Inicia sesi&oacute;n o crea una cuenta nueva.</p>
            <div class="modal-actions">
                <a href="<?= BASE_URL ?>/login" class="modal-btn modal-btn-primary">Iniciar sesi&oacute;n</a>
                <a href="<?= BASE_URL ?>/registro?rol=Emprendedor" class="modal-btn modal-btn-secondary">Registrarse</a>
            </div>
        </div>
    </div>

    <script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
    var toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.innerHTML = theme === 'dark' ? '\u2600' : '\u263E';
        toggle.addEventListener('click', function() {
            var t = document.documentElement.getAttribute('data-theme');
            var n = t === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', n);
            localStorage.setItem('jacha_theme', n);
            toggle.innerHTML = n === 'dark' ? '\u2600' : '\u263E';
        });
    }
})();
</script>
<script>
        function elegirPlantilla(id, nombre) {
            <?php if ($is_logged_in && $is_vendedor): ?>
                if (confirm('Usar la plantilla "' + nombre + '" para tu nuevo negocio?')) {
                    window.location.href = '<?= BASE_URL ?>/crear-negocio?plantilla=' + id;
                }
            <?php elseif ($is_logged_in && !$is_vendedor): ?>
                alert('Necesitas ser emprendedor para crear un negocio. Cambia tu rol a Vendedor desde el panel.');
            <?php else: ?>
                document.getElementById('authModal').classList.add('active');
            <?php endif; ?>
        }
        function cerrarModal() {
            document.getElementById('authModal').classList.remove('active');
        }
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
    <div class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
</body>
</html>