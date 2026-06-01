<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#111827' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#2563EB' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#F5F7FB' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#111827' ?>;
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Inter' ?>', sans-serif;
            background: radial-gradient(circle at top left, color-mix(in srgb,var(--preview-secondary) 14%, transparent), transparent 38%), var(--preview-bg); padding:12px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
        <div style="display:flex;align-items:center;gap:8px;min-width:0;">
            <div class="pv-logo" id="previewLogoWrap" style="width:34px;height:34px;border-radius:12px;background:#fff;overflow:hidden;box-shadow:0 8px 22px rgba(0,0,0,.10);">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg" style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                <div id="previewLogoPlaceholder" style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--preview-secondary);font-weight:800;">J</div>
                <?php endif; ?>
            </div>
            <h3 style="color:var(--preview-text);font-size:13px;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <div style="width:44px;height:18px;border-radius:99px;background:var(--preview-secondary);opacity:.85;"></div>
    </div>

    <div style="background:linear-gradient(135deg,var(--preview-primary),color-mix(in srgb,var(--preview-primary) 72%,#000));border-radius:22px;padding:22px;color:#fff;position:relative;overflow:hidden;margin-bottom:14px;">
        <div style="position:absolute;right:-34px;bottom:-44px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.12);"></div>
        <div style="font-size:9px;text-transform:uppercase;letter-spacing:2px;opacity:.65;font-weight:800;margin-bottom:8px;">Nueva tienda</div>
        <h2 style="font-size:27px;line-height:.95;letter-spacing:-1.3px;margin:0;max-width:230px;color:#fff;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p style="margin:10px 0 0;font-size:11px;line-height:1.55;opacity:.68;max-width:250px;"><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Productos destacados') ?></p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
        <div style="background:rgba(255,255,255,.82);border:1px solid rgba(17,24,39,.08);border-radius:16px;padding:12px;">
            <strong style="display:block;font-size:24px;color:var(--preview-secondary);">24</strong>
            <span style="font-size:10px;color:var(--preview-text);opacity:.55;">productos</span>
        </div>
        <div style="background:rgba(255,255,255,.82);border:1px solid rgba(17,24,39,.08);border-radius:16px;padding:12px;">
            <strong style="display:block;font-size:24px;color:var(--preview-secondary);">4.8</strong>
            <span style="font-size:10px;color:var(--preview-text);opacity:.55;">valoracion</span>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <?php foreach ([['Producto Pro','199'], ['Nuevo Item','89']] as $item): ?>
        <div style="background:rgba(255,255,255,.82);border:1px solid rgba(17,24,39,.08);border-radius:20px;overflow:hidden;box-shadow:0 16px 38px rgba(15,23,42,.06);">
            <div style="height:76px;background:linear-gradient(135deg,var(--preview-secondary),var(--preview-primary));position:relative;"><span style="position:absolute;top:8px;left:8px;background:#fff;border-radius:99px;padding:4px 7px;font-size:8px;font-weight:800;color:var(--preview-primary);">12 disp.</span></div>
            <div style="padding:10px;">
                <h4 style="margin:0 0 8px;color:var(--preview-text);font-size:12px;line-height:1.15;"><?= $item[0] ?></h4>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;"><strong style="color:var(--preview-primary);font-size:15px;">Bs. <?= $item[1] ?></strong><span style="background:var(--preview-secondary);color:#fff;border-radius:10px;padding:6px 8px;font-size:9px;font-weight:800;">Comprar</span></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
