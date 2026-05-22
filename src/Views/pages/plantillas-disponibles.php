<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Plantillas - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        .container { max-width:1400px;margin:0 auto;padding:40px 32px }
        .header { display:flex;align-items:center;justify-content:space-between;margin-bottom:48px }
        .page-theme-btn { background:var(--card-bg);border:1px solid var(--border);border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;color:var(--text-muted);flex-shrink:0;transition:all 0.2s;margin-right:16px }
        .page-theme-btn:hover { border-color:var(--border-hi);color:var(--text);background:var(--hover-surface) }
        .plantillas-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:32px }
        .plantilla-card { background:var(--card-bg);border:1px solid var(--border);border-radius:24px;overflow:hidden;transition:all 0.3s var(--ease);cursor:pointer;position:relative }
        .plantilla-card:hover { transform:translateY(-6px);border-color:var(--border-hi);box-shadow:var(--shadow-lg) }
        .plantilla-card.tech-highlight { border:2px solid var(--accent);box-shadow:0 0 30px var(--accent-glow) }
        .plantilla-card.tech-highlight::before { content:'NUEVA';position:absolute;top:16px;right:16px;background:var(--white);color:var(--bg);font-size:10px;font-weight:600;padding:4px 12px;border-radius:20px;letter-spacing:1px;z-index:10 }
        .plantilla-preview { height:200px;display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--border);position:relative;overflow:hidden }
        .preview-mockup { width:100%;height:100%;padding:20px;display:flex;flex-direction:column;gap:12px }
        .preview-bar { height:8px;border-radius:4px;width:100% }
        .preview-body { display:flex;gap:12px;justify-content:center;padding:12px 0 }
        .preview-dot { width:36px;height:36px;border-radius:8px }
        .preview-footer { display:flex;flex-direction:column;gap:6px;align-items:center }
        .preview-line { height:6px;background:rgba(255,255,255,0.2);border-radius:3px }
        .color-preview { display:flex;gap:16px;margin-top:20px }
        .color-circle { width:40px;height:40px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.3) }
        .plantilla-info { padding:24px }
        .plantilla-info h3 { font-size:22px;font-weight:500;margin-bottom:8px;color:var(--text) }
        .plantilla-info p { font-size:13px;color:var(--text-muted);line-height:1.5;margin-bottom:20px }
        .tech-badge { display:inline-block;background:var(--glow);color:var(--text-muted);font-size:11px;padding:4px 12px;border-radius:20px;margin-bottom:12px }
        .btn-elegir { display:block;width:100%;padding:12px;background:var(--white);border:none;border-radius:12px;color:var(--bg);text-align:center;font-size:14px;font-weight:600;transition:all 0.3s var(--ease);cursor:pointer }
        .btn-elegir:hover { transform:translateY(-2px);box-shadow:0 6px 16px var(--accent-shadow) }
        .error-message { text-align:center;padding:60px 40px;background:var(--card-bg);border:1px solid var(--border);border-radius:24px;max-width:500px;margin:0 auto }
        .error-message h3 { font-size:24px;margin-bottom:16px;color:var(--text) }
        .error-message p { color:var(--text-muted);margin-bottom:24px }
        .btn-error { background:var(--white);color:var(--bg);padding:12px 28px;border-radius:30px;text-decoration:none;display:inline-block;transition:all 0.3s var(--ease) }
        .btn-error:hover { background:#e0e0e0;transform:translateY(-2px);box-shadow:0 6px 16px var(--accent-shadow) }
        @media (max-width:1024px) { .plantillas-grid { grid-template-columns:repeat(2,1fr) } }
        @media (max-width:768px) { .plantillas-grid { grid-template-columns:1fr } .container { padding:24px 20px } h1 { font-size:28px } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img"></a>
            <div style="display:flex;align-items:center">
                <button class="page-theme-btn" id="themeToggle" title="Cambiar tema">&#x2600;</button>
                <a href="<?= BASE_URL ?>/dashboard" class="back-btn">← Volver al panel</a>
            </div>
        </div>
        
        <h1 style="font-family:var(--font-serif);font-size:36px;font-weight:400;margin-bottom:16px;text-align:center;color:var(--text)">Elige la plantilla de tu negocio</h1>
        <p class="subtitle" style="text-align:center;color:var(--text-muted);margin-bottom:48px">Selecciona el dise&ntilde;o que mejor represente la esencia de tu emprendimiento</p>
        
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
                    $isTech = in_array($plantilla['nombre'], ['Tecnológico', 'Electrodomésticos']);
                ?>
                <div class="plantilla-card <?= $isTech ? 'tech-highlight' : '' ?>" data-id="<?= $plantilla['id_plantilla'] ?>" data-nombre="<?= htmlspecialchars($plantilla['nombre']) ?>">
                    <div class="plantilla-preview" style="background:linear-gradient(135deg,<?= $plantilla['color_primario'] ?: '#C0392B' ?>,<?= $plantilla['color_secundario'] ?: '#2C3E50' ?>)">
                        <div class="preview-mockup">
                            <div class="preview-bar" style="background:rgba(0,0,0,0.15)"></div>
                            <div class="preview-body">
                                <div class="preview-dot" style="background:<?= $plantilla['color_primario'] ?>"></div>
                                <div class="preview-dot" style="background:<?= $plantilla['color_secundario'] ?>"></div>
                                <div class="preview-dot" style="background:<?= $plantilla['color_fondo'] ?>;border:1px solid rgba(255,255,255,0.2)"></div>
                            </div>
                            <div class="preview-footer">
                                <div class="preview-line" style="width:50%"></div>
                                <div class="preview-line" style="width:30%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="plantilla-info">
                        <?php if ($isTech): ?>
                            <div class="tech-badge">ESPECIALIZADA</div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($plantilla['nombre']) ?></h3>
                        <p><?= htmlspecialchars($plantilla['descripcion']) ?></p>
                        <button class="btn-elegir" onclick="elegirPlantilla(<?= $plantilla['id_plantilla'] ?>, '<?= htmlspecialchars($plantilla['nombre'], ENT_QUOTES) ?>')">Usar esta plantilla</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function elegirPlantilla(id, nombre) {
            if (confirm(`¿Quieres crear un nuevo negocio con la plantilla "${nombre}"?`)) {
                window.location.href = '<?= BASE_URL ?>/crear-negocio?plantilla=' + id;
            }
        }
    </script>
    <script>
        (function() {
            var themeToggle = document.getElementById('themeToggle');
            var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            if (themeToggle) {
                themeToggle.innerHTML = currentTheme === 'dark' ? '\u2600' : '\u263E';
                themeToggle.addEventListener('click', function() {
                    var theme = document.documentElement.getAttribute('data-theme');
                    var newTheme = theme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('jacha_theme', newTheme);
                    themeToggle.innerHTML = newTheme === 'dark' ? '\u2600' : '\u263E';
                });
            }
        })();
    </script>
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
</body>
</html>
