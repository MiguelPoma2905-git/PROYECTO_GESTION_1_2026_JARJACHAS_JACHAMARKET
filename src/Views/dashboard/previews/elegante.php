<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#2C3E50' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#C0392B' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FDFBF7' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#1A1A2E' ?>;
            --preview-glow: rgba(44,62,80,0.06);
            --preview-glow2: rgba(192,57,43,0.04);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Inter' ?>', sans-serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FDFBF7' ?>">
    <div class="pv-hdr" style="background:linear-gradient(135deg,var(--preview-primary),color-mix(in srgb,var(--preview-primary) 70%,#000));">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">🏪</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)40;">✦ Tienda</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:500;color:var(--preview-secondary);margin:0 0 4px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Productos de calidad') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Envío</h4><p>Rápido</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Calidad</h4><p>Garantizada</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Pago</h4><p>Seguro</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:#fff;">Todos</span>
            <span class="pv-cat">Nuevos</span>
            <span class="pv-cat">Ofertas</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">MARCA</span>
                <span class="pv-card-stock">10 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Producto Premium</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Calidad</span>
                    <span class="pv-spec">Original</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 199</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">MARCA</span>
                <span class="pv-card-stock">20 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Producto Clásico</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Económico</span>
                    <span class="pv-spec">Confiado</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 99</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
