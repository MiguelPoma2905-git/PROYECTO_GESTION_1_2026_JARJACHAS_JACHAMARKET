<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Seleccionar rol - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: #080808;
            color: #ebebeb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at 30% 40%, rgba(250,113,54,0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .selector-container {
            width: 100%;
            max-width: 500px;
            margin: 24px;
            background: rgba(16,16,16,0.7);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.08);
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        .logo-img {
            height: 40px;
            width: auto;
            filter: brightness(0) invert(1);
        }
        .logo-text {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 24px;
            font-weight: 500;
            color: #ffffff;
        }
        .logo-text span { font-weight: 300; color: #888; font-size: 18px; }
        h2 { font-size: 28px; margin-bottom: 12px; }
        .subtitle { color: #888; font-size: 14px; margin-bottom: 32px; }
        .roles-grid { display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }
        .rol-option {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .rol-option:hover { border-color: #fa7136; background: rgba(250,113,54,0.05); transform: translateX(4px); }
        .rol-option.selected { border-color: #fa7136; background: rgba(250,113,54,0.08); }
        .rol-icon { font-size: 32px; }
        .rol-info h4 { font-size: 18px; margin-bottom: 4px; }
        .rol-info p { font-size: 12px; color: #777; }
        input[type="radio"] { display: none; }
        .btn-continuar {
            width: 100%;
            padding: 14px;
            background: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            color: #080808;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-continuar:hover { background: #e0e0e0; transform: translateY(-2px); }
        .error { color: #fa7136; font-size: 13px; margin-top: 16px; }
        @media (max-width: 480px) {
            .selector-container { padding: 32px 24px; }
            .rol-option { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="selector-container">
        <div class="logo-wrapper">
            <img src="<?= BASE_URL ?>/assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
            <div class="logo-text">JACHA<span>market</span></div>
        </div>
        <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?></h2>
        <p class="subtitle">Tienes acceso a múltiples perfiles. Selecciona con qué rol deseas ingresar hoy.</p>
        
        <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" id="rolForm" action="<?= BASE_URL ?>/selector-rol">
            <div class="roles-grid">
                <?php foreach ($roles_disponibles as $rol): ?>
                <label class="rol-option">
                    <input type="radio" name="rol" value="<?= $rol['nombre_rol'] ?>">
                    <div class="rol-icon">
                        <?php if ($rol['nombre_rol'] === 'Emprendedor'): ?>🏪
                        <?php elseif ($rol['nombre_rol'] === 'Cliente'): ?>🛍️
                        <?php elseif ($rol['nombre_rol'] === 'Repartidor'): ?>🚚
                        <?php else: ?>⚙️
                        <?php endif; ?>
                    </div>
                    <div class="rol-info">
                        <h4><?= $rol['nombre_rol'] ?></h4>
                        <p>
                            <?php if ($rol['nombre_rol'] === 'Emprendedor'): ?>Gestiona tu tienda, productos y ventas
                            <?php elseif ($rol['nombre_rol'] === 'Cliente'): ?>Explora y compra productos bolivianos
                            <?php elseif ($rol['nombre_rol'] === 'Repartidor'): ?>Gestiona entregas y pedidos
                            <?php else: ?>Panel de administración
                            <?php endif; ?>
                        </p>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn-continuar">Continuar</button>
        </form>
    </div>
    <script>
        document.querySelectorAll('.rol-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.rol-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                option.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>
