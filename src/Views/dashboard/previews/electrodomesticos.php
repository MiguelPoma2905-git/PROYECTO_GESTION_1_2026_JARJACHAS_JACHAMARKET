<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#1A3A5C' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#2C6FBB' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#0F1A2E' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#E8EDF5' ?>;
            --preview-glow: rgba(44,111,187,0.08);
            --preview-glow2: rgba(26,58,92,0.12);
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Inter' ?>', sans-serif;
            background: <?= $personalizacion['color_fondo'] ?? '#0F1A2E' ?>">
    <div class="pv-hdr" style="background:<?= $personalizacion['color_fondo'] ?? '#0F1A2E' ?>e6">
        <div class="pv-hdr-l">
            <div class="pv-logo" id="previewLogoWrap">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg">
                <?php else: ?>
                <div class="pv-logo-ph" id="previewLogoPlaceholder">🏪</div>
                <?php endif; ?>
            </div>
            <h3><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div class="pv-hdr-r">
            <div class="pv-search"></div>
            <div class="pv-cart"><span class="pv-cart-dot"></span></div>
        </div>
    </div>
    <div class="pv-hero">
        <div class="pv-badge">✦ ElectroHogar</div>
        <h2><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Productos de calidad para tu hogar') ?></p>
    </div>
    <div class="pv-banners">
        <div class="pv-banner-item"><div class="pv-banner-icon"></div><h4>Envío rápido</h4><p>24-72 hrs</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon"></div><h4>Garantía</h4><p>Incluida</p></div>
        <div class="pv-banner-item"><div class="pv-banner-icon"></div><h4>Pago seguro</h4><p>QR y más</p></div>
    </div>
    <div class="pv-bar">
        <div class="pv-cats">
            <span class="pv-cat active">Todos</span>
            <span class="pv-cat">Refri</span>
            <span class="pv-cat">Lavado</span>
            <span class="pv-cat">Cocina</span>
        </div>
        <div class="pv-sort"></div>
    </div>
    <div class="pv-grid">
        <div class="pv-card">
            <div class="pv-card-img">
                <span class="pv-card-tag">SAMSUNG</span>
                <span class="pv-card-stock">12 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4>Refrigerador</h4>
                <div class="pv-specs">
                    <span class="pv-spec">300W</span>
                    <span class="pv-spec">Inox</span>
                    <span class="pv-spec">A++</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price"><small>Bs.</small> 3,299</div>
                    <div class="pv-addbtn">Añadir</div>
                </div>
            </div>
        </div>
        <div class="pv-card">
            <div class="pv-card-img">
                <span class="pv-card-tag">LG</span>
                <span class="pv-card-stock">8 ud.</span>
            </div>
            <div class="pv-card-body">
                <h4>Lavadora</h4>
                <div class="pv-specs">
                    <span class="pv-spec">500W</span>
                    <span class="pv-spec">Blanco</span>
                    <span class="pv-spec">A+</span>
                </div>
                <div class="pv-card-bot">
                    <div class="pv-price"><small>Bs.</small> 2,499</div>
                    <div class="pv-addbtn">Añadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-faq">
        <div class="pv-faq-hdr">❓ Preguntas Frecuentes</div>
        <div class="pv-faq-items">
            <div class="pv-faq-item"><span>¿Cuánto tarda el envío?</span><span class="pv-faq-arrow">▼</span></div>
            <div class="pv-faq-item"><span>¿Ofrecen garantía?</span><span class="pv-faq-arrow">▼</span></div>
        </div>
    </div>
    <div class="pv-foot">&copy; 2026 <?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></div>
</div>
