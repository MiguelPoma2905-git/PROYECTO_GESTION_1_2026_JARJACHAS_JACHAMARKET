<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Elige tus roles y avatar - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: #0a0a0a;
            color: #ebebeb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
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
            opacity: 0.12;
            pointer-events: none;
        }
        .light-1 { position: fixed; top: -20%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(250,113,54,0.2) 0%, transparent 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 0; }
        .light-2 { position: fixed; bottom: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(26,65,71,0.15) 0%, transparent 70%); border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .roles-container {
            position: relative; z-index: 1; width: 100%; max-width: 1200px; margin: 40px 24px;
            background: rgba(8,8,8,0.65); backdrop-filter: blur(15px); border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.1); padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            animation: fadeInUp 0.6s ease-out both;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .logo-wrapper { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 32px; }
        .logo-img { height: 48px; width: auto; filter: brightness(0) invert(1); }
        .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 500; color: #ffffff; }
        .logo-text span { font-weight: 300; color: #888; font-size: 22px; }
        .form-header { text-align: center; margin-bottom: 40px; }
        .form-header h1 { font-size: 32px; font-weight: 600; margin-bottom: 12px; background: linear-gradient(135deg, #ffffff, #ccc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .form-header p { font-size: 14px; color: #888; max-width: 400px; margin: 0 auto; }
        
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .roles-section h3, .avatar-section h3 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #fff;
        }
        .roles-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .rol-card {
            background: #141414; border: 1px solid #2a2a2a; border-radius: 20px; padding: 20px;
            text-align: left; cursor: pointer; transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .rol-card:hover { transform: translateX(4px); border-color: #fa7136; background: rgba(250,113,54,0.05); }
        .rol-card.selected { border-color: #fa7136; background: rgba(250,113,54,0.1); box-shadow: 0 0 20px rgba(250,113,54,0.1); }
        .rol-image { width: 60px; height: 60px; }
        .rol-img { width: 100%; height: 100%; object-fit: contain; filter: brightness(0) invert(1); }
        .rol-info h4 { font-size: 18px; font-weight: 600; margin-bottom: 4px; color: #fff; }
        .rol-info p { font-size: 12px; color: #888; }
        
        .avatar-section {
            text-align: center;
        }
        .avatar-preview {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 20px 0;
        }
        .avatar-option {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        .avatar-option img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar-option:hover { transform: scale(1.05); }
        .avatar-option.selected { border-color: #fa7136; box-shadow: 0 0 0 2px rgba(250,113,54,0.3); }
        
        .upload-btn {
            background: #1a1a1a; border: 1px solid #333; color: #fff; padding: 10px 20px;
            border-radius: 30px; cursor: pointer; font-size: 13px; margin-top: 16px;
            transition: all 0.2s;
        }
        .upload-btn:hover { background: #333; border-color: #555; }
        
        .error-message { background: rgba(250,113,54,0.12); border-left: 3px solid #fa7136; padding: 14px; margin-bottom: 24px; font-size: 13px; color: #fa7136; border-radius: 10px; text-align: center; }
        .btn-continuar { width: 100%; padding: 15px; background: #fff; border: none; border-radius: 14px; font-size: 15px; font-weight: 600; color: #0a0a0a; cursor: pointer; transition: all 0.3s; }
        .btn-continuar:hover { background: #e8e8e8; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,255,255,0.15); }
        .btn-continuar:disabled { background: #444; color: #888; cursor: not-allowed; transform: none; }
        
        @media (max-width: 850px) {
            .two-columns { grid-template-columns: 1fr; gap: 30px; }
            .roles-container { padding: 32px 24px; }
            .avatar-grid { grid-template-columns: repeat(4, 1fr); }
        }
        @media (max-width: 480px) {
            .form-header h1 { font-size: 28px; }
            .logo-img { height: 40px; }
            .logo-text { font-size: 24px; }
            .logo-text span { font-size: 18px; }
            .avatar-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>
    <div class="light-1"></div>
    <div class="light-2"></div>

    <div class="roles-container">
        <div class="logo-wrapper">
            <img src="<?= BASE_URL ?>/assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
            <div class="logo-text">JACHA<span>market</span></div>
        </div>
        
        <div class="form-header">
            <h1>Personaliza tu cuenta</h1>
            <p>Selecciona tus roles y elige un avatar</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" id="registroRolesForm" action="<?= BASE_URL ?>/choose-roles">
            <div class="two-columns">
                <div class="roles-section">
                    <h3>¿Qué quieres hacer en Jacha?</h3>
                    <div class="roles-grid">
                        <div class="rol-card" data-rol="Cliente">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/rol_1.png" alt="Cliente" class="rol-img"></div>
                            <div class="rol-info">
                                <h4>Cliente</h4>
                                <p>Explora productos, compra y sigue tus tiendas favoritas</p>
                            </div>
                        </div>
                        <div class="rol-card" data-rol="Emprendedor">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/rol_2.png" alt="Emprendedor" class="rol-img"></div>
                            <div class="rol-info">
                                <h4>Emprendedor</h4>
                                <p>Crea tu tienda online, vende y gestiona tu negocio</p>
                            </div>
                        </div>
                        <div class="rol-card" data-rol="Repartidor">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/rol_3.png" alt="Repartidor" class="rol-img"></div>
                            <div class="rol-info">
                                <h4>Repartidor</h4>
                                <p>Gestiona entregas y gana por cada pedido</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="roles" id="rolesInput" value="">
                </div>
                
                <div class="avatar-section">
                    <h3>Tu avatar</h3>
                    <div class="avatar-preview" id="avatarPreview">
                        <img src="<?= BASE_URL ?>/assets/avatars/default/avatar_1.png" alt="Avatar">
                    </div>
                    
                    <div class="avatar-grid" id="avatarGrid">
                        <?php foreach ($avatares_default as $index => $avatar): ?>
                        <div class="avatar-option" data-avatar="<?= $avatar ?>" data-index="<?= $index ?>">
                            <img src="<?= BASE_URL ?>/<?= $avatar ?>" alt="Avatar <?= $index + 1 ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="button" class="upload-btn" id="uploadAvatarBtn">📁 Subir mi propia foto</button>
                    <input type="file" id="fileInput" accept="image/*" style="display: none;">
                    <input type="hidden" name="avatar" id="avatarInput" value="assets/avatars/default/avatar_1.png">
                </div>
            </div>
            
            <button type="submit" class="btn-continuar" id="submitBtn" disabled>Continuar</button>
        </form>
    </div>

    <script>
        const cards = document.querySelectorAll('.rol-card');
        const rolesInput = document.getElementById('rolesInput');
        const submitBtn = document.getElementById('submitBtn');
        let selectedRoles = [];

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const rol = card.getAttribute('data-rol');
                
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    selectedRoles = selectedRoles.filter(r => r !== rol);
                } else {
                    card.classList.add('selected');
                    selectedRoles.push(rol);
                }
                
                rolesInput.value = selectedRoles.join(',');
                submitBtn.disabled = selectedRoles.length === 0;
            });
        });
        
        const avatarOptions = document.querySelectorAll('.avatar-option');
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview').querySelector('img');
        
        avatarOptions.forEach(option => {
            option.addEventListener('click', () => {
                avatarOptions.forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                const avatarUrl = option.getAttribute('data-avatar');
                avatarInput.value = avatarUrl;
                avatarPreview.src = '<?= BASE_URL ?>/' + avatarUrl;
            });
        });
        
        if (avatarOptions.length > 0) {
            avatarOptions[0].classList.add('selected');
        }
        
        const uploadBtn = document.getElementById('uploadAvatarBtn');
        const fileInput = document.getElementById('fileInput');
        
        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });
        
        fileInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    avatarPreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
                
                const formData = new FormData();
                formData.append('temp_avatar', file);
                
                const originalText = uploadBtn.innerText;
                uploadBtn.innerText = 'Subiendo...';
                uploadBtn.disabled = true;
                
                try {
                    const response = await fetch('<?= BASE_URL ?>/guardar-temp-avatar', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        avatarInput.value = result.temp_url;
                        avatarOptions.forEach(opt => opt.classList.remove('selected'));
                        console.log('Avatar temporal guardado:', result.temp_url);
                    } else {
                        alert('Error al subir la imagen: ' + result.error);
                        const selectedAvatar = document.querySelector('.avatar-option.selected');
                        if (selectedAvatar) {
                            avatarPreview.src = selectedAvatar.querySelector('img').src;
                        } else if (avatarOptions.length > 0) {
                            avatarPreview.src = avatarOptions[0].querySelector('img').src;
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error de conexión al subir la imagen');
                } finally {
                    uploadBtn.innerText = originalText;
                    uploadBtn.disabled = false;
                    fileInput.value = '';
                }
            }
        });
    </script>
</body>
</html>
