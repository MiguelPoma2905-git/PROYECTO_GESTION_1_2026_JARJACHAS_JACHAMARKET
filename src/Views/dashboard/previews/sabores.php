<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#E67E22' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#B3581C' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FFF8F0' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#2C1810' ?>;
            --preview-glow: rgba(230,126,34,0.08);
            --preview-glow2: rgba(179,88,28,0.05);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Merriweather' ?>', serif;
            background: <?= $personalizacion['color_fondo'] ?? '#FFF8F0' ?>">
    <div class="pv-hdr" style="background:linear-gradient(135deg,var(--preview-primary),#D35400);">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">🍴</div>
                <?php endif; ?>
            </div>
            <h3 style="color:#fff"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search" style="border-color:rgba(255,255,255,0.2);background:rgba(255,255,255,0.1)"></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge" style="color:var(--preview-primary);border-color:var(--preview-primary)40;">✦ Sabores</div>
        <h2 style="font-family:'Merriweather',serif;font-size:23px;font-weight:700;color:var(--preview-secondary);margin:0 0 4px;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'El sabor que enamora') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Receta</h4><p>Secreta</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Fresco</h4><p>Diario</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon" style="background:var(--preview-primary)"></div><h4>Domicilio</h4><p>Gratis</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active" style="background:var(--preview-primary);border-color:var(--preview-primary);color:#fff;">Todos</span>
            <span class="pv-cat">Platos</span>
            <span class="pv-cat">Bebidas</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">CHEF</span>
                <span class="pv-card-stock">8 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Combo Especial</h4>
                <div class="pv-specs">
                    <span class="pv-spec">1 entrada</span>
                    <span class="pv-spec">2 platos</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 89</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card" style="background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);border-color:rgba(0,0,0,0.04);">
            <div class="pv-card-img" style="background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));opacity:0.12;height:70px;">
                <span class="pv-card-tag">POSTRE</span>
                <span class="pv-card-stock">12 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4 style="color:var(--preview-text)">Postre Artesanal</h4>
                <div class="pv-specs">
                    <span class="pv-spec">Chocolate</span>
                    <span class="pv-spec">Nuez</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price" style="color:var(--preview-primary)"><small>Bs.</small> 39</div>
                    <div class="pv-addbtn" style="background:var(--preview-primary)">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-foot" style="color:var(--preview-text);border-color:rgba(0,0,0,0.06);">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
