<div class="preview-device" id="previewDevice"
     style="--preview-primary: <?= $personalizacion['color_primario'] ?? '#231F20' ?>;
            --preview-secondary: <?= $personalizacion['color_secundario'] ?? '#B08D57' ?>;
            --preview-bg: <?= $personalizacion['color_fondo'] ?? '#FBF8F1' ?>;
            --preview-text: <?= $personalizacion['color_texto'] ?? '#241E18' ?>;
            --preview-font: '<?= $personalizacion['tipografia'] ?? 'Cormorant Garamond' ?>', serif;
            background: linear-gradient(180deg,var(--preview-bg),#fff); padding:14px; color:var(--preview-text);">
    <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(36,30,24,.12);padding-bottom:12px;margin-bottom:18px;">
        <div style="display:flex;align-items:center;gap:10px;min-width:0;">
            <div class="pv-logo" id="previewLogoWrap" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--preview-secondary);padding:3px;background:#fff;overflow:hidden;">
                <?php if (!empty($personalizacion['logo_personalizado'])): ?>
                <img src="<?= BASE_URL ?>/<?= $personalizacion['logo_personalizado'] ?>" alt="Logo" id="previewLogoImg" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                <?php else: ?>
                <div id="previewLogoPlaceholder" style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--preview-secondary);font-weight:700;">J</div>
                <?php endif; ?>
            </div>
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:500;color:var(--preview-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h3>
        </div>
        <span style="font-size:8px;letter-spacing:1.8px;text-transform:uppercase;color:var(--preview-secondary);font-weight:800;">Volver</span>
    </div>

    <div style="text-align:center;padding:16px 8px 20px;">
        <div style="width:54px;height:1px;background:var(--preview-secondary);margin:0 auto 14px;"></div>
        <div style="color:var(--preview-secondary);font-size:9px;letter-spacing:2.8px;text-transform:uppercase;font-weight:800;margin-bottom:8px;">Coleccion</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:38px;line-height:.95;font-weight:400;color:var(--preview-primary);margin:0;"><?= htmlspecialchars($emprendimiento['nombre_comercial']) ?></h2>
        <p style="max-width:250px;margin:12px auto 0;font-size:11px;line-height:1.65;color:var(--preview-text);opacity:.58;"><?= htmlspecialchars($emprendimiento['descripcion'] ?? 'Productos elegidos con cuidado') ?></p>
    </div>

    <div style="height:94px;background:linear-gradient(135deg,var(--preview-primary),var(--preview-secondary));position:relative;margin-bottom:14px;">
        <div style="position:absolute;inset:10px;border:1px solid rgba(255,255,255,.46);"></div>
    </div>

    <div style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
        <span style="background:rgba(255,255,255,.86);border:1px solid rgba(36,30,24,.12);border-radius:99px;padding:6px 10px;font-size:9px;opacity:.72;">24 productos</span>
        <span style="background:rgba(255,255,255,.86);border:1px solid rgba(36,30,24,.12);border-radius:99px;padding:6px 10px;font-size:9px;opacity:.72;">Disponible</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <?php foreach ([['Linea Premium','249'], ['Edicion Clasica','149']] as $item): ?>
        <div style="background:rgba(255,255,255,.88);border:1px solid rgba(36,30,24,.12);position:relative;">
            <div style="height:96px;background:color-mix(in srgb,var(--preview-secondary) 18%,#fff);position:relative;"><span style="position:absolute;top:8px;right:8px;background:rgba(255,255,255,.86);border:1px solid rgba(36,30,24,.12);padding:4px 6px;font-size:7px;letter-spacing:1px;color:var(--preview-secondary);font-weight:800;">DISP.</span></div>
            <div style="padding:10px;">
                <h4 style="font-family:'Cormorant Garamond',serif;font-size:17px;line-height:1;margin:0 0 10px;color:var(--preview-primary);font-weight:500;"><?= $item[0] ?></h4>
                <div style="border-top:1px solid rgba(36,30,24,.12);padding-top:8px;display:flex;align-items:center;justify-content:space-between;gap:8px;"><strong style="font-size:14px;color:var(--preview-primary);">Bs. <?= $item[1] ?></strong><span style="border:1px solid var(--preview-secondary);padding:5px 7px;font-size:8px;letter-spacing:1px;text-transform:uppercase;color:var(--preview-primary);font-weight:800;">Comprar</span></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>