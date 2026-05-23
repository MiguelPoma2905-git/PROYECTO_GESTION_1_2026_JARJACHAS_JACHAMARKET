<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#8FA88B' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#C4B49C' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FAF8F5' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#2C2A28' ?>;
            --preview-glow: rgba(143,168,139,0.06);
            --preview-glow2: rgba(196,180,156,0.06);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Lora' ?>', serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FAF8F5' ?>">
    <div class="pv-hdr" style="background:var(--preview-primary);">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">🏠</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff;font-family:var(--preview-font);font-weight:400;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-secondary);border-color:var(--preview-secondary)40;">✦ HogarDulce</div>
        <h2 style="font-family:'Lora',serif;font-size:24px;font-weight:500;color:var(--preview-text);margin:0 0 4px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Haz de tu casa un hogar') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:6px;"></div><h4>Confort</h4><p>Garantizado</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:6px;"></div><h4>Natural</h4><p>Orgánico</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary);border-radius:6px;"></div><h4>Decoración</h4><p>Única</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:#fff;">Todos</span>
            <span class="pv-cat">Sala</span>
            <span class="pv-cat">Cocina</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:rgba(255,255,255,0.8);backdrop-filter:blur(8px);border-color:rgba(196,180,156,0.15);border-radius:10px;">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag" style="color:var(--preview-primary);border-color:var(--preview-primary)30;">HOGAR</span>
                <span class="pv-card-stock">10 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Cojín Texturizado</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Algodón</span>
                    <span class="pv-spec">45cm</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 129</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:rgba(255,255,255,0.8);backdrop-filter:blur(8px);border-color:rgba(196,180,156,0.15);border-radius:10px;">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag" style="color:var(--preview-primary);border-color:var(--preview-primary)30;">HOME</span>
                <span class="pv-card-stock">7 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Vela Aromática</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Vainilla</span>
                    <span class="pv-spec">60h</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 79</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
