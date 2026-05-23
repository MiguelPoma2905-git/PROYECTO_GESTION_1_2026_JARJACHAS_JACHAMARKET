<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#D44A6A' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#9A2A4E' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FFF5F7' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#2D1B22' ?>;
            --preview-glow: rgba(212,74,106,0.06);
            --preview-glow2: rgba(154,42,78,0.04);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Playfair Display' ?>', serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FFF5F7' ?>">
    <div class="pv-hdr" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">👗</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff;font-family:var(--preview-font);font-weight:500;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)40;">✦ ModaViva</div>
        <h2 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:600;color:var(--preview-secondary);margin:0 0 4px;font-style:italic;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Tendencias que inspiran') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);border-radius:50%;"></div><h4>Envío</h4><p>Express</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);border-radius:50%;"></div><h4>Calidad</h4><p>Premium</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary);border-radius:50%;"></div><h4>Estilo</h4><p>Único</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:#fff;">Todos</span>
            <span class="pv-cat">Mujer</span>
            <span class="pv-cat">Hombre</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);border-radius:12px;">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">ZARA</span>
                <span class="pv-card-stock">15 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Vestido Floral</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Algodón</span>
                    <span class="pv-spec">M-L</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 349</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);border-radius:12px;">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">TOMMY</span>
                <span class="pv-card-stock">10 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Blazer Elegante</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Slim</span>
                    <span class="pv-spec">Lino</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 599</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
