<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#7B2D8E' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#C9A84C' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FCF8FF' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#1E1029' ?>;
            --preview-glow: rgba(123,45,142,0.07);
            --preview-glow2: rgba(201,168,76,0.06);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Cormorant Garamond' ?>', serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FCF8FF' ?>">
    <div class="pv-hdr" style="background:linear-gradient(135deg,var(--preview-primary),#5B1F6E)  !important;">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">✨</div>
                <?php endif; ?>
            </div>
            <h3 style="color:var(--preview-secondary);font-family:var(--preview-font);font-weight:600;letter-spacing:1px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:var(--preview-secondary)40;background:rgba(255,255,255,0.08)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-secondary);border-color:var(--preview-secondary)40;">✦ GlowUp</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:25px;font-weight:600;color:var(--preview-primary);margin:0 0 4px;letter-spacing:0.3px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Brilla con estilo') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Glow</h4><p>Efecto</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Premium</h4><p>Calidad</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Regalo</h4><p>Ideal</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:#fff;">Todos</span>
            <span class="pv-cat">Labios</span>
            <span class="pv-cat">Rostro</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(201,168,76,0.12);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag" style="color:var(--preview-secondary);border-color:var(--preview-secondary)30;">MAC</span>
                <span class="pv-card-stock">20 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Gloss Labial</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Mate</span>
                    <span class="pv-spec">Duradero</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 129</div>
                    <div class="pv-addbtn" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));border:none;">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(201,168,76,0.12);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag" style="color:var(--preview-secondary);border-color:var(--preview-secondary)30;">LOREAL</span>
                <span class="pv-card-stock">14 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Crema Facial</h4>
                <div class="pv-specs">
                    <span class="pv-spec">SPF 50</span>
                    <span class="pv-spec">Hidrata</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 199</div>
                    <div class="pv-addbtn" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));border:none;">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
