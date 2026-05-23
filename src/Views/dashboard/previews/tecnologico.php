<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#1A73E8' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#0D47A1' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#F0F4FF' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#1A1A2E' ?>;
            --preview-glow: rgba(26,115,232,0.08);
            --preview-glow2: rgba(13,71,161,0.06);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Inter' ?>', sans-serif;
            background: <?= $personalizacion['color_fondo'] ?? '#F0F4FF' ?>">
    <div class="pv-hdr" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary))">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">💻</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)30;">✦ TecnoStore</div>
        <h2 style="background:linear-gradient(135deg,var(--preview-text),var(--preview-primary));-webkit-background-clip:text;background-clip:text;color:transparent;font-size:22px;font-weight:700;margin:0 0 4px;letter-spacing:-0.3px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Tecnología de punta para ti') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Envío rápido</h4><p>24-72 hrs</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Soporte</h4><p>Técnico</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-secondary)"></div><h4>Pago seguro</h4><p>QR y más</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-secondary);border-color:var(--preview-secondary);color:#fff;">Todos</span>
            <span class="pv-cat">Laptops</span>
            <span class="pv-cat">Audio</span>
            <span class="pv-cat">Acces.</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">DELL</span>
                <span class="pv-card-stock">5 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Laptop Pro</h4>
                <div class="pv-specs">
                    <span class="pv-spec">16GB RAM</span>
                    <span class="pv-spec">512GB</span>
                    <span class="pv-spec">i7</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 6,999</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:#fff;border-color:rgba(0,0,0,0.06);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">SONY</span>
                <span class="pv-card-stock">15 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Auriculares</h4>
                <div class="pv-specs">
                    <span class="pv-spec">BT 5.0</span>
                    <span class="pv-spec">ANC</span>
                    <span class="pv-spec">20h</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 899</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
