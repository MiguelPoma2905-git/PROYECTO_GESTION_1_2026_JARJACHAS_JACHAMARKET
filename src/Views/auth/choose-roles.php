<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Elige tus roles y avatar - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        body { min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:0 }
        .auth-theme-btn {
            position:fixed; top:20px; right:20px; z-index:100;
            width:40px; height:40px; border-radius:50%;
            background:var(--card-bg); border:1px solid var(--border);
            color:var(--text-muted); font-size:16px; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; backdrop-filter:blur(8px);
        }
        .auth-theme-btn:hover { border-color:var(--border-hi); color:var(--text); }
        .roles-container { position:relative;z-index:10;width:100%;max-width:960px;margin:32px auto;background:var(--auth-bg);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);border-radius:24px;border:1px solid var(--border);padding:36px 32px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);animation:fadeInUp 0.6s var(--ease) both }
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
        .two-columns { display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-bottom:32px;align-items:start }
        .roles-section h3, .avatar-section h3 { font-size:15px;font-weight:600;margin-bottom:16px;color:var(--text);text-transform:uppercase;letter-spacing:.5px }
        .roles-grid { display:flex;flex-direction:column;gap:12px }
        .rol-card { background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:14px 16px;text-align:left;cursor:pointer;transition:all 0.3s var(--ease);display:flex;align-items:center;gap:14px }
        .rol-card:hover { transform:translateX(4px);border-color:var(--border-hi);background:var(--hover-surface) }
        .rol-card.selected { border-color:var(--text);background:var(--surface3);box-shadow:0 0 20px var(--accent-shadow) }
        .rol-image { width:48px;height:48px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--surface2);border:1px solid var(--border);transition:border-color .2s }
        .rol-image img { width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.95);transition:filter .2s }
        .rol-card:hover .rol-image { border-color:var(--border-hi) }
        .rol-card:hover .rol-image img { filter:brightness(1.05) }
        .rol-card.selected .rol-image { border-color:var(--text);box-shadow:0 0 12px var(--accent-shadow) }
        .rol-card.selected .rol-image img { filter:brightness(1.1) }
        [data-theme="dark"] .rol-image { background:#fff;border-color:rgba(255,255,255,0.15); }
        [data-theme="dark"] .rol-image img { filter:brightness(0.95) contrast(1.05); }
        [data-theme="dark"] .rol-card:hover .rol-image img { filter:brightness(1.05) contrast(1.05); }
        [data-theme="dark"] .rol-card.selected .rol-image img { filter:brightness(1.1) contrast(1.05); }
        [data-theme="dark"] .rol-card.selected .rol-image { border-color:#fff;box-shadow:0 0 12px rgba(255,255,255,0.15); }
        .rol-info h4 { font-size:15px;font-weight:600;color:var(--text);margin-bottom:2px }
        .rol-info p { font-size:12px;color:var(--text-muted);line-height:1.4;margin:0 }
        .avatar-preview { width:100px;height:100px;border-radius:50%;overflow:hidden;margin:0 auto 16px;border:2px solid var(--border);background:var(--surface2) }
        .avatar-preview img { width:100%;height:100%;object-fit:cover;display:block }
        .avatar-grid { display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:16px }
        .avatar-option { width:100%;aspect-ratio:1;border-radius:12px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:all .2s;background:var(--surface2) }
        .avatar-option:hover { border-color:var(--border-hi) }
        .avatar-option.selected { border-color:var(--border-hi);box-shadow:0 0 0 2px var(--accent-glow) }
        .avatar-option img { width:100%;height:100%;object-fit:cover;display:block }
        .upload-btn { width:100%;padding:10px;border:1px dashed var(--border);border-radius:10px;background:transparent;color:var(--text-muted);font-size:13px;cursor:pointer;transition:all .2s;text-align:center }
        .upload-btn:hover { border-color:var(--border-hi);color:var(--text) }
        .btn-continuar { width:100%;padding:14px;background:var(--text);color:var(--card-bg);border:none;border-radius:12px;font-size:15px;font-weight:600;cursor:pointer;transition:all .3s }
        .btn-continuar:hover:not(:disabled) { transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.3) }
        .btn-continuar:disabled { opacity:.35;cursor:not-allowed }
        .heading-gradient { font-size:28px !important;font-weight:600 !important;margin-bottom:8px !important }
        .error-msg { background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:12px 16px;font-size:13px;color:#ef4444;margin-bottom:20px;text-align:center }
        @media (max-width:850px) {
            .two-columns { grid-template-columns:1fr;gap:24px }
            .roles-container { padding:28px 20px;margin:24px 12px }
            .avatar-grid { grid-template-columns:repeat(5,1fr) }
        }
        @media (max-width:480px) {
            .avatar-grid { grid-template-columns:repeat(4,1fr) }
            .roles-container { padding:20px 16px }
            .rol-card { padding:12px 14px }
            .rol-image { width:40px;height:40px }
        }
    </style>
</head>
<body>
    <button class="auth-theme-btn" id="themeToggle" title="Cambiar tema">&#9790;</button>
    <div class="bg-carousel" id="bgCarousel">
        <div class="carousel-slide carousel-slide-1 active"></div>
        <div class="carousel-slide carousel-slide-2"></div>
        <div class="carousel-slide carousel-slide-3"></div>
        <div class="carousel-slide carousel-slide-4"></div>
        <div class="carousel-slide carousel-slide-5"></div>
    </div>
    <div class="bg-carousel-overlay"></div>
    <div class="bg-carousel-gradient-overlay"></div>
    <div class="carousel-particles" id="particles"></div>
    <div class="light light-tl"></div>
    <div class="light light-br"></div>

    <div class="roles-container">
        <div class="logo-auth">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img-lg">
        </div>
        
        <div class="text-center mb-xl">
            <h1 class="heading-gradient">Personaliza tu cuenta</h1>
            <p style="font-size:14px;color:var(--text-muted);max-width:400px;margin:0 auto">Selecciona tus roles y elige un avatar</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" id="registroRolesForm" action="<?= BASE_URL ?>/elegir-roles">
            <div class="two-columns">
                <div class="roles-section">
                    <h3>¿Qué quieres hacer en Jacha?</h3>
                    <div class="roles-grid">
                        <div class="rol-card" data-rol="Cliente">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/roles/cliente_compra.jpg" alt="Cliente" class="rol-img"></div>
                            <div class="rol-info">
                                <h4>Cliente</h4>
                                <p>Explora productos, compra y sigue tus tiendas favoritas</p>
                            </div>
                        </div>
                        <div class="rol-card" data-rol="Emprendedor">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/roles/emprendedor_venta.jpg" alt="Emprendedor" class="rol-img"></div>
                            <div class="rol-info">
                                <h4>Emprendedor</h4>
                                <p>Crea tu tienda online, vende y gestiona tu negocio</p>
                            </div>
                        </div>
                        <div class="rol-card" data-rol="Repartidor">
                            <div class="rol-image"><img src="<?= BASE_URL ?>/assets/images/roles/repartidor_entrega.jpg" alt="Repartidor" class="rol-img"></div>
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
                        <img src="<?= BASE_URL ?>/assets/avatars/default/avatar_1.jpg" alt="Avatar">
                    </div>
                    
                    <div class="avatar-grid" id="avatarGrid">
                        <?php foreach ($avatares_default as $index => $avatar): ?>
                        <div class="avatar-option" data-avatar="<?= $avatar ?>" data-index="<?= $index ?>">
                            <img src="<?= BASE_URL ?>/<?= $avatar ?>" alt="Avatar <?= $index + 1 ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="button" class="upload-btn" id="uploadAvatarBtn">✎ Subir foto</button>
                    <input type="file" id="fileInput" accept="image/*" style="display: none;">
                    <input type="hidden" name="avatar" id="avatarInput" value="assets/avatars/default/avatar_1.jpg">
                </div>
            </div>
            
            <button type="submit" class="btn-continuar" id="submitBtn" disabled>Continuar</button>
        </form>
    </div>

    <script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
    var toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.innerHTML = theme === 'dark' ? '\u2600' : '\u263E';
        toggle.addEventListener('click', function() {
            var current = document.documentElement.getAttribute('data-theme');
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('jacha_theme', next);
            toggle.innerHTML = next === 'dark' ? '\u2600' : '\u263E';
        });
    }
})();
</script>
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
    <script>
    (function() {
        var slides = document.querySelectorAll('#bgCarousel .carousel-slide');
        var current = 0;
        var total = slides.length;
        var interval = 7000;

        function createParticles() {
            var container = document.getElementById('particles');
            for (var i = 0; i < 15; i++) {
                var p = document.createElement('div');
                p.className = 'carousel-particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.width = (2 + Math.random() * 4) + 'px';
                p.style.height = p.style.width;
                p.style.animationDuration = (10 + Math.random() * 20) + 's';
                p.style.animationDelay = (Math.random() * 20) + 's';
                p.style.opacity = 0.1 + Math.random() * 0.3;
                container.appendChild(p);
            }
        }

        function nextSlide() {
            slides[current].classList.remove('active');
            slides[current].classList.add('prev');
            current = (current + 1) % total;
            slides[current].classList.add('active');
            setTimeout(function() {
                slides.forEach(function(s) { s.classList.remove('prev'); });
            }, 1500);
        }

        createParticles();
        setInterval(nextSlide, interval);
    })();
    </script>
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>
</body>
</html>
