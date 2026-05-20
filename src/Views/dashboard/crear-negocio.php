<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Crear negocio - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0a0a0a;
            color: #ebebeb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?= BASE_URL ?>/assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            pointer-events: none;
        }
        .container { max-width: 550px; width: 100%; margin: 40px 24px; }
        .card {
            background: rgba(18,18,18,0.9);
            backdrop-filter: blur(15px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.08);
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 28px; text-align: center; margin-bottom: 32px; color: #fff; }
        .logo span { color: #888; font-weight: 300; }
        h1 { font-family: Georgia, serif; font-size: 28px; font-weight: 400; margin-bottom: 8px; text-align: center; }
        .subtitle { text-align: center; color: #888; font-size: 14px; margin-bottom: 32px; }
        .plantilla-info { background: #1a1a1a; border-radius: 16px; padding: 16px; margin-bottom: 32px; display: flex; align-items: center; gap: 16px; }
        .plantilla-colors { display: flex; gap: 8px; }
        .plantilla-color { width: 40px; height: 40px; border-radius: 8px; }
        .plantilla-name { font-weight: 500; }
        .error { background: rgba(255,107,107,0.1); border-left: 3px solid #ff6b6b; padding: 14px; border-radius: 10px; margin-bottom: 24px; font-size: 13px; color: #ff6b6b; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; color: #aaa; margin-bottom: 8px; }
        input, textarea {
            width: 100%; padding: 14px 16px; background: #1a1a1a; border: 1px solid #2a2a2a;
            border-radius: 14px; font-size: 14px; color: #fff; transition: all 0.2s;
        }
        input:focus, textarea:focus { outline: none; border-color: #fff; }
        textarea { resize: vertical; min-height: 80px; }
        .btn-create { width: 100%; padding: 14px; background: #fff; border: none; border-radius: 14px; font-size: 15px; font-weight: 600; color: #0a0a0a; cursor: pointer; transition: all 0.2s; margin-top: 8px; }
        .btn-create:hover { background: #e0e0e0; transform: translateY(-2px); }
        .back-link { text-align: center; margin-top: 24px; }
        .back-link a { color: #888; text-decoration: none; font-size: 13px; }
        .back-link a:hover { color: #fff; }
        @media (max-width: 480px) { .card { padding: 32px 24px; } h1 { font-size: 24px; } .logo { font-size: 24px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">JACHA<span>market</span></div>
            <h1>Crear nuevo negocio</h1>
            <p class="subtitle">Completa los datos de tu emprendimiento</p>
            
            <div class="plantilla-info">
                <div class="plantilla-colors">
                    <div class="plantilla-color" style="background: <?= $plantilla['color_primario'] ?>;"></div>
                    <div class="plantilla-color" style="background: <?= $plantilla['color_secundario'] ?>;"></div>
                </div>
                <div>
                    <div class="plantilla-name">Plantilla: <?= htmlspecialchars($plantilla['nombre']) ?></div>
                    <small style="color: #888;">Podrás personalizar los colores después</small>
                </div>
            </div>
            
            <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?= BASE_URL ?>/crear-negocio?plantilla=<?= $_GET['plantilla'] ?? $plantilla['id_plantilla'] ?>">
                <div class="form-group">
                    <label>Nombre comercial *</label>
                    <input type="text" name="nombre_comercial" required placeholder="Ej: Tecnología Plus">
                </div>
                <div class="form-group">
                    <label>NIT (opcional)</label>
                    <input type="text" name="nit" placeholder="Ej: 1234567890">
                </div>
                <div class="form-group">
                    <label>Descripción del negocio</label>
                    <textarea name="descripcion" placeholder="Cuéntanos sobre tu emprendimiento..."></textarea>
                </div>
                <button type="submit" class="btn-create">Crear negocio</button>
            </form>
            <div class="back-link">
                <a href="<?= BASE_URL ?>/plantillas-disponibles">← Volver a plantillas</a>
            </div>
        </div>
    </div>
</body>
</html>
