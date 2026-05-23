<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#A0522D' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#6B3A2A' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FBF6F0' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#2D1F14' ?>;
            --preview-glow: rgba(160,82,45,0.07);
            --preview-glow2: rgba(107,58,42,0.05);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'EB Garamond' ?>', serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FBF6F0' ?>">
    <div class="pv-hdr" style="background:var(--preview-primary);">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">🧶</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff;font-family:var(--preview-font);font-weight:400;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)40;">✦ Artesano</div>
        <h2 style="font-family:'EB Garamond',serif;font-size:26px;font-weight:500;color:var(--preview-secondary);margin:0 0 4px;letter-spacing:0.5px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Hecho a mano con amor') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:4px;"></div><h4>Hecho</h4><p>a mano</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:4px;"></div><h4>Natural</h4><p>100%</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:4px;"></div><h4>Único</h4><p>Pieza</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-secondary);border-color:var(--preview-secondary);color:#fff;">Todos</span>
            <span class="pv-cat">Textil</span>
            <span class="pv-cat">Cerámica</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);box-shadow:0 2px 8px rgba(160,82,45,0.06);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">ANDINO</span>
                <span class="pv-card-stock">6 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Tejido Andino</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Lana</span>
                    <span class="pv-spec">Natural</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 249</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);box-shadow:0 2px 8px rgba(160,82,45,0.06);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">ARTE</span>
                <span class="pv-card-stock">4 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Cerámica Pintada</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Barro</span>
                    <span class="pv-spec">Esmalte</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 179</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
