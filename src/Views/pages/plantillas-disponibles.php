<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Plantillas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',system-ui,sans-serif; background:var(--bg,#0d0d0d); color:var(--text,#f0f0f0); min-height:100vh; }
        .container { max-width:1300px; margin:0 auto; padding:40px 32px; }
        .header { display:flex; align-items:center; justify-content:space-between; margin-bottom:48px; }
        .header .logo-img { height:28px; width:auto; opacity:0.7; }
        .header .back-btn { color:var(--text-muted,#888); text-decoration:none; font-size:13px; display:flex; align-items:center; gap:6px; transition:color .2s; }
        .header .back-btn:hover { color:var(--text,#f0f0f0); }
        .page-title { text-align:center; margin-bottom:8px; }
        .page-title h1 { font-size:36px; font-weight:600; color:var(--text,#f0f0f0); margin-bottom:8px; letter-spacing:-.5px; }
        .page-title p { font-size:14px; color:var(--text-muted,#888); max-width:500px; margin:0 auto 48px; line-height:1.6; }
        .plantillas-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:28px; }
        .plantilla-card { background:var(--card-bg,#141414); border:1px solid var(--border,rgba(255,255,255,0.06)); border-radius:20px; overflow:hidden; transition:all .35s cubic-bezier(.4,0,.2,1); display:flex; flex-direction:column; }
        .plantilla-card:hover { transform:translateY(-6px); border-color:rgba(108,140,255,0.15); box-shadow:0 16px 48px rgba(0,0,0,0.3); }
        .plantilla-img-wrap { position:relative; height:200px; overflow:hidden; flex-shrink:0; }
        .plantilla-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .5s; display:block; }
        .plantilla-card:hover .plantilla-img-wrap img { transform:scale(1.05); }
        .plantilla-img-wrap .overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.5) 0%,transparent 50%); pointer-events:none; }
        .plantilla-img-wrap .badge { position:absolute; top:16px; left:16px; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); padding:4px 12px; border-radius:6px; font-size:10px; font-weight:600; letter-spacing:.8px; text-transform:uppercase; color:#fff; }
        .plantilla-img-wrap .featured-tag { position:absolute; top:16px; right:16px; background:rgba(108,140,255,0.15); border:1px solid rgba(108,140,255,0.2); color:#6c8cff; font-size:9px; font-weight:600; padding:4px 10px; border-radius:6px; letter-spacing:.5px; }
        .plantilla-body { padding:20px 24px 24px; flex:1; display:flex; flex-direction:column; }
        .plantilla-body h3 { font-size:18px; font-weight:600; color:var(--text,#f0f0f0); margin-bottom:4px; }
        .plantilla-body .desc { font-size:12px; color:var(--text-muted,#888); line-height:1.6; margin-bottom:16px; flex:1; }
        .plantilla-colors { display:flex; gap:6px; margin-bottom:16px; }
        .plantilla-colors .dot { width:24px; height:24px; border-radius:6px; border:1px solid rgba(255,255,255,0.06); }
        .plantilla-actions { display:flex; gap:10px; }
        .btn-detail { flex:1; padding:11px; border:1px solid var(--border,rgba(255,255,255,0.06)); background:rgba(255,255,255,0.03); color:var(--text,#f0f0f0); border-radius:10px; font-size:12px; font-weight:500; cursor:pointer; transition:all .25s; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-detail:hover { background:rgba(255,255,255,0.06); }
        .btn-elegir { flex:1; padding:11px; background:linear-gradient(135deg,#6c8cff,#5a7ae8); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; transition:all .25s; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-elegir:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(108,140,255,0.2); }
        .error-message { text-align:center; padding:60px 40px; background:var(--card-bg,#141414); border:1px solid var(--border,rgba(255,255,255,0.06)); border-radius:20px; max-width:500px; margin:0 auto; }
        .error-message h3 { font-size:20px; margin-bottom:8px; color:var(--text,#f0f0f0); }
        .error-message p { font-size:13px; color:var(--text-muted,#888); margin-bottom:20px; }
        .btn-error { background:var(--text,#f0f0f0); color:var(--bg,#0d0d0d); padding:12px 28px; border-radius:10px; text-decoration:none; display:inline-block; font-size:13px; font-weight:600; transition:all .3s; }
        .btn-error:hover { transform:translateY(-2px); }
        .watermark { position:fixed; bottom:12px; right:16px; opacity:0.25; pointer-events:none; z-index:9999; display:flex; align-items:center; gap:6px; }
        .watermark img { height:16px; width:auto; }
        @media (max-width:1024px) { .plantillas-grid { grid-template-columns:repeat(2,1fr); } }
        @media (max-width:768px) { .plantillas-grid { grid-template-columns:1fr; } .container { padding:24px 20px; } .page-title h1 { font-size:26px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img"></a>
            <a href="<?= BASE_URL ?>/dashboard" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al panel</a>
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
                    <a href="<?= BASE_URL ?>/plantilla/<?= $plantilla['id_plantilla'] ?>" class="plantilla-img-wrap" style="display:block;text-decoration:none">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($plantilla['nombre']) ?>" loading="lazy" onerror="this.style.display='none'">
                        <div class="overlay"></div>
                        <div class="badge"><?= htmlspecialchars($plantilla['nombre']) ?></div>
                        <?php if ($esNueva): ?>
                        <div class="featured-tag">NUEVA</div>
                        <?php endif; ?>
                    </a>
                    <div class="plantilla-body">
                        <h3><?= htmlspecialchars($plantilla['nombre']) ?></h3>
                        <p class="desc"><?= htmlspecialchars($plantilla['descripcion']) ?></p>
                        <div class="plantilla-colors">
                            <div class="dot" style="background:<?= $plantilla['color_primario'] ?>"></div>
                            <div class="dot" style="background:<?= $plantilla['color_secundario'] ?>"></div>
                            <div class="dot" style="background:<?= $plantilla['color_fondo'] ?? '#FDFBF7' ?>"></div>
                            <div class="dot" style="background:<?= $plantilla['color_texto'] ?? '#2D2D2D' ?>"></div>
                        </div>
                        <div class="plantilla-actions">
                            <a href="<?= BASE_URL ?>/plantilla/<?= $plantilla['id_plantilla'] ?>" class="btn-detail"><i class="fas fa-info-circle"></i> Detalles</a>
                            <button class="btn-elegir" onclick="elegirPlantilla(<?= $plantilla['id_plantilla'] ?>, '<?= htmlspecialchars($plantilla['nombre'], ENT_QUOTES) ?>')"><i class="fas fa-rocket"></i> Usar</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function elegirPlantilla(id, nombre) {
            if (confirm('Usar la plantilla "' + nombre + '" para tu nuevo negocio?')) {
                window.location.href = '<?= BASE_URL ?>/crear-negocio?plantilla=' + id;
            }
        }
    </script>
    <div class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>
</body>
</html>