<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Personalizar Mi Tienda - Jacha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        * { box-sizing: border-box; }
        :root { --editor-bg: #0f0f13; --editor-card: #1a1a24; --editor-border: #2a2a3a; --editor-text: #e0e0e8; --editor-muted: #8888a0; }
        body { background: var(--editor-bg); color: var(--editor-text); font-family: 'Inter', sans-serif; margin: 0; }
        .editor-wrap { max-width: 1440px; margin: 0 auto; padding: 32px 40px; }
        .editor-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; }
        .editor-top h1 { font-size: 26px; font-weight: 600; margin: 0; }
        .editor-top .subtitle { font-size: 13px; color: var(--editor-muted); margin: 4px 0 0; }
        .editor-top-actions { display: flex; gap: 12px; align-items: center; }
        .btn-back { background: var(--editor-card); border: 1px solid var(--editor-border); border-radius: 10px; padding: 10px 18px; color: var(--editor-text); text-decoration: none; font-size: 13px; font-weight: 500; transition: all .2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-back:hover { border-color: rgba(255,255,255,0.2); }
        .editor-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 32px; align-items: start; }
        @media (max-width: 1024px) { .editor-grid { grid-template-columns: 1fr; } .editor-wrap { padding: 24px 20px; } }

        /* Preview - Electrodomésticos style */
        .preview-panel { position: sticky; top: 32px; }
        .preview-frame { background: #111; border-radius: 24px; padding: 20px; border: 1px solid #222; overflow: hidden; }
        .preview-device { border-radius: 16px; overflow: hidden; box-shadow: 0 4px 40px rgba(0,0,0,0.3); transition: all .3s; font-family: var(--preview-font, 'Inter'), sans-serif; position: relative; }
        .preview-device::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 20%, var(--preview-glow, rgba(44,111,187,0.08)) 0%, transparent 50%), radial-gradient(ellipse at 80% 80%, var(--preview-glow2, rgba(26,58,92,0.12)) 0%, transparent 50%); pointer-events: none; z-index: 0; }
        .pv-hdr { display: flex; align-items: center; gap: 12px; padding: 10px 20px; background: rgba(15,26,46,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06); position: sticky; top: 0; z-index: 10; }
        .pv-hdr-l { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
        .pv-logo { width: 28px; height: 28px; border-radius: 6px; overflow: hidden; flex-shrink: 0; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; }
        .pv-logo img { width: 100%; height: 100%; object-fit: contain; }
        .pv-logo-ph { width: 28px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.1); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 14px; color: rgba(255,255,255,0.3); }
        .pv-hdr-l h3 { font-size: 13px; font-weight: 700; color: var(--preview-text, #E8EDF5); margin: 0; }
        .pv-hdr-r { display: flex; align-items: center; gap: 8px; }
        .pv-search { width: 100px; height: 26px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.06); }
        .pv-cart { width: 26px; height: 26px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; position: relative; }
        .pv-cart-dot { position: absolute; top: -3px; right: -3px; width: 10px; height: 10px; border-radius: 50%; background: #ef4444; border: 2px solid var(--preview-bg, #0F1A2E); }
        .pv-hero { text-align: center; padding: 24px 20px 16px; position: relative; z-index: 1; }
        .pv-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 8px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--preview-secondary, #2C6FBB); background: rgba(44,111,187,0.1); padding: 3px 10px; border-radius: 3px; margin-bottom: 10px; border: 1px solid rgba(44,111,187,0.2); }
        .pv-hero h2 { font-size: 22px; font-weight: 700; color: var(--preview-text, #E8EDF5); margin: 0 0 4px; letter-spacing: -0.3px; }
        .pv-hero p { font-size: 10px; color: var(--preview-text, #E8EDF5); opacity: 0.5; margin: 0 auto 16px; max-width: 300px; line-height: 1.5; }
        .pv-banners { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; padding: 0 20px 12px; position: relative; z-index: 1; }
        .pv-banner-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; padding: 10px 8px; text-align: center; }
        .pv-banner-icon { width: 18px; height: 18px; border-radius: 50%; background: var(--preview-secondary, #2C6FBB); margin: 0 auto 4px; opacity: 0.8; }
        .pv-banner-item h4 { font-size: 9px; font-weight: 600; color: var(--preview-text, #E8EDF5); opacity: 0.7; margin: 0 0 2px; }
        .pv-banner-item p { font-size: 8px; color: var(--preview-text, #E8EDF5); opacity: 0.25; margin: 0; }
        .pv-bar { display: flex; align-items: center; justify-content: space-between; padding: 0 20px 12px; position: relative; z-index: 1; }
        .pv-cats { display: flex; gap: 4px; }
        .pv-cat { padding: 3px 10px; border-radius: 4px; font-size: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); color: var(--preview-text, rgba(255,255,255,0.4)); opacity: 0.7; }
        .pv-cat.active { background: var(--preview-secondary, #2C6FBB); color: #fff; border-color: var(--preview-secondary, #2C6FBB); opacity: 1; }
        .pv-sort { width: 60px; height: 20px; border-radius: 4px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); }
        .pv-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 0 20px 16px; position: relative; z-index: 1; }
        .pv-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; overflow: hidden; }
        .pv-card-img { height: 70px; background: linear-gradient(135deg, rgba(26,58,92,0.5), rgba(15,26,46,0.8)); position: relative; }
        .pv-card-tag { position: absolute; top: 5px; left: 5px; background: rgba(0,0,0,0.5); padding: 2px 6px; border-radius: 3px; font-size: 6px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: #fff; }
        .pv-card-stock { position: absolute; top: 5px; right: 5px; padding: 2px 6px; border-radius: 3px; font-size: 6px; font-weight: 600; background: rgba(16,185,129,0.15); color: #10b981; }
        .pv-card-body { padding: 8px 10px 10px; }
        .pv-card-body h4 { font-size: 10px; font-weight: 600; color: var(--preview-text, #E8EDF5); margin: 0 0 4px; }
        .pv-specs { display: flex; gap: 4px; margin-bottom: 6px; flex-wrap: wrap; }
        .pv-spec { font-size: 7px; color: var(--preview-text, rgba(255,255,255,0.3)); opacity: 0.6; background: rgba(255,255,255,0.03); padding: 1px 5px; border-radius: 3px; }
        .pv-card-bot { display: flex; align-items: center; justify-content: space-between; padding-top: 6px; border-top: 1px solid rgba(255,255,255,0.06); }
        .pv-price { font-size: 13px; font-weight: 700; color: var(--preview-text, #E8EDF5); }
        .pv-price small { font-size: 8px; font-weight: 400; color: var(--preview-text, rgba(255,255,255,0.3)); opacity: 0.5; }
        .pv-addbtn { padding: 4px 10px; background: var(--preview-secondary, #2C6FBB); color: #fff; border: none; border-radius: 4px; font-size: 8px; font-weight: 600; cursor: default; }
        .pv-foot { text-align: center; padding: 12px; position: relative; z-index: 1; font-size: 8px; color: var(--preview-text, rgba(255,255,255,0.15)); opacity: 0.3; border-top: 1px solid rgba(255,255,255,0.06); }
        .pv-faq { padding: 12px 20px; position: relative; z-index: 1; }
        .pv-faq-hdr { font-size: 10px; font-weight: 600; color: var(--preview-text, #E8EDF5); text-align: center; margin-bottom: 8px; opacity: 0.7; }
        .pv-faq-items { display: flex; flex-direction: column; gap: 4px; }
        .pv-faq-item { display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 6px; padding: 6px 10px; font-size: 7px; color: var(--preview-text, rgba(255,255,255,0.3)); opacity: 0.6; }
        .pv-faq-arrow { font-size: 5px; opacity: 0.3; }

        /* Controls */
        .controls-panel { background: var(--editor-card); border-radius: 24px; padding: 28px; border: 1px solid var(--editor-border); }
        .controls-section { margin-bottom: 28px; }
        .controls-section:last-child { margin-bottom: 0; }
        .controls-section-title { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--editor-muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .controls-section-title::after { content: ''; flex: 1; height: 1px; background: var(--editor-border); }

        .plantilla-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 4px; }
        .plantilla-card { background: rgba(255,255,255,0.03); border: 1px solid var(--editor-border); border-radius: 12px; padding: 14px; text-align: center; cursor: pointer; transition: all .2s; }
        .plantilla-card:hover { background: rgba(255,255,255,0.06); transform: translateY(-2px); }
        .plantilla-card.selected { border-color: #fff; background: rgba(255,255,255,0.08); box-shadow: 0 0 0 1px rgba(255,255,255,0.15); }
        .plantilla-card h4 { font-size: 13px; font-weight: 500; margin: 0 0 8px; color: #d0d0e0; }
        .plantilla-card .color-dots { display: flex; gap: 5px; justify-content: center; }
        .plantilla-card .color-dot { width: 18px; height: 18px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.08); }

        /* Font selector grid */
        .font-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 8px; max-height: 280px; overflow-y: auto; padding-right: 4px; }
        .font-grid::-webkit-scrollbar { width: 4px; }
        .font-grid::-webkit-scrollbar-thumb { background: var(--editor-border); border-radius: 2px; }
        .font-card { background: rgba(255,255,255,0.02); border: 1px solid var(--editor-border); border-radius: 10px; padding: 12px 10px; text-align: center; cursor: pointer; transition: all .2s; }
        .font-card:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15); }
        .font-card.selected { border-color: #fff; background: rgba(255,255,255,0.07); box-shadow: 0 0 0 1px rgba(255,255,255,0.12); }
        .font-card .font-preview-text { font-size: 18px; margin: 0 0 6px; line-height: 1.2; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .font-card .font-category { font-size: 9px; color: var(--editor-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }

        .upload-area { border: 2px dashed var(--editor-border); border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all .2s; position: relative; }
        .upload-area:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.02); }
        .upload-area.has-image { border-style: solid; border-color: rgba(255,255,255,0.08); }
        .upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
        .upload-preview { max-width: 100%; max-height: 100px; border-radius: 8px; display: block; margin: 0 auto 8px; }
        .upload-placeholder { color: var(--editor-muted); font-size: 12px; }
        .upload-placeholder i { font-size: 20px; display: block; margin-bottom: 6px; opacity: 0.4; }
        .upload-remove { position: absolute; top: 8px; right: 8px; background: rgba(239,68,68,0.8); color: #fff; border: none; border-radius: 6px; padding: 4px 10px; font-size: 10px; font-weight: 600; cursor: pointer; display: none; z-index: 2; }
        .upload-area.has-image .upload-remove { display: block; }

        .color-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .color-group label { display: block; font-size: 10px; color: var(--editor-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .color-group input[type="color"] { width: 100%; height: 40px; border: 1px solid var(--editor-border); border-radius: 8px; background: rgba(255,255,255,0.03); cursor: pointer; padding: 3px; }

        .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; }
        .toggle-row span { font-size: 13px; }
        .toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; inset: 0; background: rgba(255,255,255,0.08); border-radius: 12px; transition: .2s; }
        .toggle-slider::before { content: ''; position: absolute; height: 18px; width: 18px; left: 3px; bottom: 3px; background: #fff; border-radius: 50%; transition: .2s; }
        .toggle input:checked + .toggle-slider { background: var(--preview-secondary, #555); }
        .toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

        .btn-save-wrap { margin-top: 24px; }
        .btn-save { width: 100%; padding: 14px; background: #fff; color: #0a0a0a; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all .2s; }
        .btn-save:hover { background: #e0e0e0; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,255,255,0.1); }
        .btn-view { width: 100%; margin-top: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: transparent; color: var(--editor-text); border: 1px solid var(--editor-border); border-radius: 12px; padding: 12px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s; }
        .btn-view:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.03); }

        .success-banner { background: rgba(255,255,255,0.05); border-left: 3px solid #4caf50; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 13px; color: #4caf50; display: flex; align-items: center; gap: 10px; }
        .watermark { position: fixed; bottom: 12px; right: 16px; opacity: 0.15; pointer-events: none; z-index: 9999; }
        .watermark img { height: 16px; width: auto; }

        /* FAQ Editor */
        .section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .section-header span { font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--editor-muted); }
        .btn-faq-add { background:rgba(255,255,255,0.06); border:1px solid var(--editor-border); color:var(--editor-text); border-radius:8px; padding:6px 14px; font-size:11px; font-weight:600; cursor:pointer; transition:all .2s; }
        .btn-faq-add:hover { background:rgba(255,255,255,0.1); }
        .faq-empty { font-size:12px; color:var(--editor-muted); padding:10px; text-align:center; }
        .faq-item { background:rgba(255,255,255,0.02); border:1px solid var(--editor-border); border-radius:10px; padding:14px; margin-bottom:10px; position:relative; }
        .faq-item input[type="text"] { width:100%; background:rgba(255,255,255,0.04); border:1px solid var(--editor-border); border-radius:6px; padding:8px 10px; color:var(--editor-text); font-size:12px; margin-bottom:8px; }
        .faq-item input[type="text"]:focus { outline:none; border-color:rgba(255,255,255,0.2); }
        .faq-item textarea { width:100%; background:rgba(255,255,255,0.04); border:1px solid var(--editor-border); border-radius:6px; padding:8px 10px; color:var(--editor-text); font-size:11px; resize:vertical; min-height:50px; font-family:inherit; }
        .faq-item textarea:focus { outline:none; border-color:rgba(255,255,255,0.2); }
        .faq-item .faq-del { position:absolute; top:10px; right:10px; background:none; border:none; color:var(--editor-muted); font-size:16px; cursor:pointer; opacity:0.4; transition:all .2s; }
        .faq-item .faq-del:hover { opacity:1; color:#ef4444; }
        .faq-item label { display:block; font-size:9px; color:var(--editor-muted); text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
    </style>
</head>
<body>
<div class="editor-wrap">
    <?php if (isset($_GET['success'])): ?>
    <div class="success-banner">✓ Cambios guardados correctamente</div>
    <?php endif; ?>

    <div class="editor-top">
        <div>
            <h1>Personaliza tu tienda</h1>
            <p class="subtitle">Dale tu estilo a <strong><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></strong></p>
        </div>
        <div class="editor-top-actions">
            <a href="<?= BASE_URL ?>/tienda/<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-back" target="_blank">↗ Ver tienda</a>
            <a href="<?= BASE_URL ?>/dashboard" class="btn-back">← Panel</a>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data" class="editor-grid" id="editorForm">
        <input type="hidden" name="id_plantilla" id="id_plantilla" value="<?= $personalizacion['id_plantilla'] ?>">
        <input type="hidden" name="eliminar_logo" id="eliminar_logo" value="0">
        <input type="hidden" name="eliminar_banner" id="eliminar_banner" value="0">

        <!-- ===== PREVIEW (dinámico según plantilla) ===== -->
        <div class="preview-panel">
            <div class="preview-frame">
                <?php
                $previewId = (int)($personalizacion['id_plantilla'] ?? 0);
                $previewFile = match($previewId) {
                    1 => 'moderno.php',
                    2 => 'elegante.php',
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
                include "previews/{$previewFile}";
                ?>
            </div>
        </div>

        <!-- ===== CONTROLS ===== -->
        <div class="controls-panel">

            <!-- Estilo base -->
            <div class="controls-section">
                <div class="controls-section-title">Estilo base</div>
                <div class="plantilla-grid" id="plantillaGrid">
                    <?php foreach ($plantillas as $plantilla): ?>
                    <div class="plantilla-card <?= $personalizacion['id_plantilla'] == $plantilla['id_plantilla'] ? 'selected' : '' ?>"
                         data-id="<?= $plantilla['id_plantilla'] ?>"
                         data-primary="<?= $plantilla['color_primario'] ?>"
                         data-secondary="<?= $plantilla['color_secundario'] ?>"
                         data-bg="<?= $plantilla['color_fondo'] ?? '#ffffff' ?>"
                         data-text="<?= $plantilla['color_texto'] ?? '#1A1A2E' ?>">
                        <h4><?= htmlspecialchars($plantilla['nombre']) ?></h4>
                        <div class="color-dots">
                            <span class="color-dot" style="background:<?= $plantilla['color_primario'] ?>"></span>
                            <span class="color-dot" style="background:<?= $plantilla['color_secundario'] ?>"></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Logo -->
            <div class="controls-section">
                <div class="controls-section-title">Logo</div>
                <div class="upload-area <?= !empty($personalizacion['logo_personalizado']) ? 'has-image' : '' ?>" id="logoUploadArea">
                    <input type="file" name="logo_personalizado" accept="image/png,image/jpeg,image/webp" id="logoInput">
                    <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                    <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" class="upload-preview" id="logoPreview">
                    <?php else: ?>
                    <div class="upload-placeholder" id="logoPlaceholder">
                        <i>🖼</i> Subir logo (PNG, JPG)
                    </div>
                    <?php endif; ?>
                    <button type="button" class="upload-remove" id="logoRemoveBtn">✕ Eliminar</button>
                </div>
            </div>

            <!-- Banner -->
            <div class="controls-section">
                <div class="controls-section-title">Banner / Portada</div>
                <div class="upload-area <?= !empty($personalizacion['banner_personalizado']) ? 'has-image' : '' ?>" id="bannerUploadArea">
                    <input type="file" name="banner_personalizado" accept="image/png,image/jpeg,image/webp" id="bannerInput">
                    <?php if (!empty($personalizacion['banner_personalizado'])): ?>
                    <img src="<?= BASE_URL ?>/<?= $personalizacion['banner_personalizado'] ?>" class="upload-preview" id="bannerPreview">
                    <?php else: ?>
                    <div class="upload-placeholder" id="bannerPlaceholder">
                        <i>🖼</i> Subir banner (PNG, JPG)
                    </div>
                    <?php endif; ?>
                    <button type="button" class="upload-remove" id="bannerRemoveBtn">✕ Eliminar</button>
                </div>
            </div>

            <!-- Tipografia -->
            <div class="controls-section">
                <div class="controls-section-title">Tipografía</div>
                <input type="hidden" name="tipografia" id="tipografiaInput" value="<?= $personalizacion['tipografia'] ?? 'Inter' ?>">
                <div class="font-grid" id="fontGrid">
                    <?php
                    $fonts = [
                        ['name' => 'Inter', 'cat' => 'Sans'],
                        ['name' => 'Poppins', 'cat' => 'Sans'],
                        ['name' => 'Roboto', 'cat' => 'Sans'],
                        ['name' => 'Open Sans', 'cat' => 'Sans'],
                        ['name' => 'Montserrat', 'cat' => 'Sans'],
                        ['name' => 'Lato', 'cat' => 'Sans'],
                        ['name' => 'Raleway', 'cat' => 'Sans'],
                        ['name' => 'Nunito', 'cat' => 'Sans'],
                        ['name' => 'DM Sans', 'cat' => 'Sans'],
                        ['name' => 'Jost', 'cat' => 'Sans'],
                        ['name' => 'Manrope', 'cat' => 'Sans'],
                        ['name' => 'Outfit', 'cat' => 'Sans'],
                        ['name' => 'Playfair Display', 'cat' => 'Serif'],
                        ['name' => 'Cormorant Garamond', 'cat' => 'Serif'],
                        ['name' => 'Lora', 'cat' => 'Serif'],
                        ['name' => 'Merriweather', 'cat' => 'Serif'],
                        ['name' => 'PT Serif', 'cat' => 'Serif'],
                        ['name' => 'Crimson Text', 'cat' => 'Serif'],
                        ['name' => 'Oswald', 'cat' => 'Display'],
                        ['name' => 'Bebas Neue', 'cat' => 'Display'],
                        ['name' => 'Anton', 'cat' => 'Display'],
                        ['name' => 'Orbitron', 'cat' => 'Display'],
                        ['name' => 'Pacifico', 'cat' => 'Mano'],
                        ['name' => 'Caveat', 'cat' => 'Mano'],
                        ['name' => 'Dancing Script', 'cat' => 'Mano'],
                        ['name' => 'JetBrains Mono', 'cat' => 'Mono'],
                        ['name' => 'Space Mono', 'cat' => 'Mono'],
                    ];
                    $selectedFont = $personalizacion['tipografia'] ?? 'Inter';
                    foreach ($fonts as $f):
                        $isSelected = $f['name'] === $selectedFont;
                    ?>
                    <div class="font-card <?= $isSelected ? 'selected' : '' ?>" data-font="<?= htmlspecialchars($f['name']) ?>">
                        <div class="font-preview-text" style="font-family:'<?= htmlspecialchars($f['name']) ?>',sans-serif"><?= htmlspecialchars($f['name']) ?></div>
                        <div class="font-category"><?= $f['cat'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Colores -->
            <div class="controls-section">
                <div class="controls-section-title">Colores</div>
                <div class="color-grid">
                    <div class="color-group">
                        <label>Principal</label>
                        <input type="color" name="color_primario" id="color_primario" value="<?= $personalizacion['color_primario'] ?? '#1a1a2e' ?>">
                    </div>
                    <div class="color-group">
                        <label>Secundario</label>
                        <input type="color" name="color_secundario" id="color_secundario" value="<?= $personalizacion['color_secundario'] ?? '#555555' ?>">
                    </div>
                    <div class="color-group">
                        <label>Fondo</label>
                        <input type="color" name="color_fondo" id="color_fondo" value="<?= $personalizacion['color_fondo'] ?? '#ffffff' ?>">
                    </div>
                    <div class="color-group">
                        <label>Texto</label>
                        <input type="color" name="color_texto" id="color_texto" value="<?= $personalizacion['color_texto'] ?? '#1a1a2e' ?>">
                    </div>
                </div>
            </div>

            <!-- Modo oscuro -->
            <div class="controls-section">
                <div class="toggle-row">
                    <span>Modo oscuro en tienda</span>
                    <label class="toggle">
                        <input type="checkbox" name="modo_oscuro" id="modoOscuroInput" value="1" <?= !empty($personalizacion['modo_oscuro']) ? 'checked' : '' ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- FAQ -->
            <div class="controls-section" id="faqSection">
                <div class="section-header">
                    <span>❓ Preguntas Frecuentes (FAQ)</span>
                    <button type="button" class="btn-faq-add" onclick="agregarFAQ()">+ Agregar</button>
                </div>
                <div id="faqList">
                    <?php
                    $faqs = [];
                    if (!empty($personalizacion['faqs'])) {
                        $parsed = $personalizacion['faqs'];
                        if (is_string($parsed)) $parsed = json_decode($parsed, true);
                        if (is_array($parsed)) $faqs = $parsed;
                    }
                    if (empty($faqs)):
                    ?>
                    <div class="faq-empty">Aún no hay preguntas. Haz clic en "Agregar" para crear la primera.</div>
                    <?php endif; ?>
                </div>
                <textarea name="faqs" id="faqsInput" style="display:none"><?= htmlspecialchars(is_string($personalizacion['faqs'] ?? '') ? $personalizacion['faqs'] : json_encode($faqs, JSON_UNESCAPED_UNICODE)) ?></textarea>
            </div>

            <!-- Guardar -->
            <div class="btn-save-wrap">
                <button type="submit" class="btn-save">Guardar todos los cambios</button>
                <a href="<?= BASE_URL ?>/tienda/<?= $emprendimiento['id_emprendimiento'] ?>" class="btn-view" target="_blank">↗ Ver tienda en vivo</a>
            </div>
        </div>
    </form>
</div>

<div class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></div>

<script>
(function() {
    let preview = document.getElementById('previewDevice');

    function actualizarPreview() {
        preview = document.getElementById('previewDevice');
        if (!preview) return;

        const primary = document.getElementById('color_primario').value;
        const secondary = document.getElementById('color_secundario').value;
        const bg = document.getElementById('color_fondo').value;
        const text = document.getElementById('color_texto').value;
        const fontName = document.getElementById('tipografiaInput').value;

        const fontValue = "'" + fontName + "', sans-serif";
        preview.style.setProperty('--preview-primary', primary);
        preview.style.setProperty('--preview-secondary', secondary);
        preview.style.setProperty('--preview-text', text);
        preview.style.setProperty('--preview-font', fontValue);
        preview.style.background = bg;
        preview.style.fontFamily = fontValue;

        preview.style.setProperty('--preview-glow', primary + '15');
        preview.style.setProperty('--preview-glow2', primary + '30');

        const hdr = preview.querySelector('.pv-hdr');
        if (hdr) hdr.style.background = 'linear-gradient(135deg,' + primary + ',color-mix(in srgb,' + primary + ' 70%,#000))';

        const badges = preview.querySelectorAll('.pv-badge');
        badges.forEach(b => { b.style.color = secondary; b.style.borderColor = secondary + '40'; });

        const cats = preview.querySelectorAll('.pv-cat.active');
        cats.forEach(c => { c.style.background = secondary; c.style.borderColor = secondary; c.style.color = '#fff'; });

        const addBtns = preview.querySelectorAll('.pv-addbtn');
        addBtns.forEach(b => { b.style.background = secondary; });

        const icons = preview.querySelectorAll('.pv-banner-icon');
        icons.forEach(i => { i.style.background = secondary; });

        const allEls = preview.querySelectorAll('.pv-hero h2, .pv-hero p, .pv-card-body h4, .pv-price, .pv-banner-item h4, .pv-banner-item p');
        allEls.forEach(el => el.style.fontFamily = fontValue);
    }

    // Plantilla selection with preview reload
    document.querySelectorAll('.plantilla-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.plantilla-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('id_plantilla').value = this.dataset.id;
            document.getElementById('color_primario').value = this.dataset.primary;
            document.getElementById('color_secundario').value = this.dataset.secondary;
            if (this.dataset.bg) document.getElementById('color_fondo').value = this.dataset.bg;
            if (this.dataset.text) document.getElementById('color_texto').value = this.dataset.text;
            cargarPreview(this.dataset.id);
        });
    });

    function cargarPreview(plantillaId) {
        const frame = document.querySelector('.preview-frame');
        const formData = new FormData();
        formData.set('preview_ajax', '1');
        formData.set('id_plantilla', plantillaId);
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newPreview = doc.querySelector('.preview-device');
            if (newPreview) {
                const oldPreview = document.getElementById('previewDevice');
                if (oldPreview) oldPreview.replaceWith(newPreview);
                actualizarPreview();
            }
        })
        .catch(() => {});
    }

    // Font selection
    var fuentesCargadas = {};
    function cargarFuente(nombre) {
        if (fuentesCargadas[nombre]) return;
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://fonts.googleapis.com/css2?family=' + encodeURIComponent(nombre) + ':wght@300;400;500;600;700&display=swap';
        document.head.appendChild(link);
        fuentesCargadas[nombre] = true;
    }

    document.querySelectorAll('.font-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.font-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            var fontName = this.dataset.font;
            document.getElementById('tipografiaInput').value = fontName;
            cargarFuente(fontName);
            actualizarPreview();
        });
    });

    // Cargar fuente inicial si no es Inter
    var fontInicial = document.getElementById('tipografiaInput').value;
    if (fontInicial && fontInicial !== 'Inter') { cargarFuente(fontInicial); }

    // Color / dark mode changes
    document.getElementById('color_primario').addEventListener('input', actualizarPreview);
    document.getElementById('color_secundario').addEventListener('input', actualizarPreview);
    document.getElementById('color_fondo').addEventListener('input', actualizarPreview);
    document.getElementById('color_texto').addEventListener('input', actualizarPreview);
    document.getElementById('modoOscuroInput').addEventListener('change', actualizarPreview);

    // Logo upload preview
    document.getElementById('logoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            let img = document.getElementById('logoPreview');
            let placeholder = document.getElementById('logoPlaceholder');
            if (!img) {
                img = document.createElement('img');
                img.className = 'upload-preview';
                img.id = 'logoPreview';
                const area = document.getElementById('logoUploadArea');
                if (placeholder) placeholder.remove();
                area.insertBefore(img, area.querySelector('.upload-remove'));
            }
            img.src = ev.target.result;
            img.style.display = 'block';
            document.getElementById('logoUploadArea').classList.add('has-image');
            document.getElementById('eliminar_logo').value = '0';

            const wrap = document.getElementById('previewLogoWrap');
            const ph = document.getElementById('previewLogoPlaceholder');
            if (ph) ph.remove();
            let pImg = document.getElementById('previewLogoImg');
            if (!pImg) {
                pImg = document.createElement('img');
                pImg.id = 'previewLogoImg';
                pImg.style.cssText = 'width:100%;height:100%;object-fit:contain';
                wrap.appendChild(pImg);
            }
            pImg.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Logo remove
    document.getElementById('logoRemoveBtn').addEventListener('click', function() {
        document.getElementById('eliminar_logo').value = '1';
        document.getElementById('logoInput').value = '';
        const img = document.getElementById('logoPreview');
        if (img) img.remove();
        const area = document.getElementById('logoUploadArea');
        area.classList.remove('has-image');
        let placeholder = document.getElementById('logoPlaceholder');
        if (!placeholder) {
            placeholder = document.createElement('div');
            placeholder.className = 'upload-placeholder';
            placeholder.id = 'logoPlaceholder';
            placeholder.innerHTML = '<i>🖼</i> Subir logo (PNG, JPG)';
            area.insertBefore(placeholder, area.querySelector('.upload-remove'));
        }
        const wrap = document.getElementById('previewLogoWrap');
        const pImg = document.getElementById('previewLogoImg');
        if (pImg) pImg.remove();
        let ph = document.getElementById('previewLogoPlaceholder');
        if (!ph) {
            ph = document.createElement('div');
            ph.className = 'preview-logo-placeholder';
            ph.id = 'previewLogoPlaceholder';
            ph.textContent = '🏪';
            wrap.appendChild(ph);
        }
    });

    // Banner upload preview
    document.getElementById('bannerInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            let img = document.getElementById('bannerPreview');
            let placeholder = document.getElementById('bannerPlaceholder');
            if (!img) {
                img = document.createElement('img');
                img.className = 'upload-preview';
                img.id = 'bannerPreview';
                const area = document.getElementById('bannerUploadArea');
                if (placeholder) placeholder.remove();
                area.insertBefore(img, area.querySelector('.upload-remove'));
            }
            img.src = ev.target.result;
            img.style.display = 'block';
            document.getElementById('bannerUploadArea').classList.add('has-image');
            document.getElementById('eliminar_banner').value = '0';
        };
        reader.readAsDataURL(file);
    });

    // Banner remove
    document.getElementById('bannerRemoveBtn').addEventListener('click', function() {
        document.getElementById('eliminar_banner').value = '1';
        document.getElementById('bannerInput').value = '';
        const img = document.getElementById('bannerPreview');
        if (img) img.remove();
        const area = document.getElementById('bannerUploadArea');
        area.classList.remove('has-image');
        let placeholder = document.getElementById('bannerPlaceholder');
        if (!placeholder) {
            placeholder = document.createElement('div');
            placeholder.className = 'upload-placeholder';
            placeholder.id = 'bannerPlaceholder';
            placeholder.innerHTML = '<i>🖼</i> Subir banner (PNG, JPG)';
            area.insertBefore(placeholder, area.querySelector('.upload-remove'));
        }
    });

    // Init
    actualizarPreview();
})();

// ===== FAQ management =====
let faqCount = 0;

function renderFAQs() {
    const container = document.getElementById('faqList');
    const input = document.getElementById('faqsInput');
    let faqs = [];
    try { faqs = JSON.parse(input.value || '[]'); } catch(e) {}
    container.innerHTML = '';
    if (faqs.length === 0) {
        container.innerHTML = '<div class="faq-empty">Aún no hay preguntas. Haz clic en "Agregar" para crear la primera.</div>';
        return;
    }
    faqs.forEach((faq, idx) => {
        const div = document.createElement('div');
        div.className = 'faq-item';
        div.innerHTML = `
            <button type="button" class="faq-del" onclick="eliminarFAQ(${idx})">&times;</button>
            <label>Pregunta</label>
            <input type="text" class="faq-p" value="${escapeHTML(faq.p || '')}" placeholder="Ej: ¿Hacen envíos?" oninput="syncFAQs()">
            <label>Respuesta</label>
            <textarea class="faq-r" placeholder="Ej: Sí, hacemos envíos a toda la ciudad." oninput="syncFAQs()">${escapeHTML(faq.r || '')}</textarea>
        `;
        container.appendChild(div);
    });
    syncFAQs();
}

function agregarFAQ() {
    const input = document.getElementById('faqsInput');
    let faqs = [];
    try { faqs = JSON.parse(input.value || '[]'); } catch(e) {}
    faqs.push({ p: '', r: '' });
    input.value = JSON.stringify(faqs);
    renderFAQs();
}

function eliminarFAQ(idx) {
    const input = document.getElementById('faqsInput');
    let faqs = [];
    try { faqs = JSON.parse(input.value || '[]'); } catch(e) {}
    faqs.splice(idx, 1);
    input.value = JSON.stringify(faqs);
    renderFAQs();
}

function syncFAQs() {
    const items = document.querySelectorAll('.faq-item');
    const faqs = [];
    items.forEach(item => {
        const p = item.querySelector('.faq-p').value.trim();
        const r = item.querySelector('.faq-r').value.trim();
        if (p || r) faqs.push({ p, r });
    });
    document.getElementById('faqsInput').value = JSON.stringify(faqs);
}

function escapeHTML(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Initialize FAQ editor on load
document.addEventListener('DOMContentLoaded', renderFAQs);
</script>
</body>
</html>
