<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#2ECC71' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#1A1A2E' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#F4FCF7' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#0D1B14' ?>;
            --preview-glow: rgba(46,204,113,0.08);
            --preview-glow2: rgba(26,26,46,0.04);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Inter' ?>', sans-serif;
            background: <?= $personalizacion['color_fondo'] ?? '#F4FCF7' ?>">
    <div class="pv-hdr" style="background:var(--preview-secondary);border-bottom:3px solid var(--preview-primary);">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">💪</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:var(--preview-primary)40;background:rgba(255,255,255,0.08)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)40;background:rgba(46,204,113,0.06);">✦ FullFit</div>
        <h2 style="font-size:24px;font-weight:800;color:var(--preview-secondary);margin:0 0 4px;text-transform:uppercase;letter-spacing:-0.5px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Tu mejor versión') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);"></div><h4>Energía</h4><p>Total</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);"></div><h4>Rendimiento</h4><p>Máximo</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);"></div><h4>Nutrición</h4><p>Inteligente</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:var(--preview-secondary);">Todos</span>
            <span class="pv-cat">Suplementos</span>
            <span class="pv-cat">Ropa</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);border-left:3px solid var(--preview-primary);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">WHEY</span>
                <span class="pv-card-stock">25 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Proteína Whey</h4>
                <div class="pv-specs">
                    <span class="pv-spec">2kg</span>
                    <span class="pv-spec">Vainilla</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 299</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary);color:var(--preview-secondary);font-weight:700;">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);border-left:3px solid var(--preview-primary);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">NIKE</span>
                <span class="pv-card-stock">18 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Leggings Deportivos</h4>
                <div class="pv-specs">
                    <span class="pv-spec">M-L</span>
                    <span class="pv-spec">Compresión</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 199</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary);color:var(--preview-secondary);font-weight:700;">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
