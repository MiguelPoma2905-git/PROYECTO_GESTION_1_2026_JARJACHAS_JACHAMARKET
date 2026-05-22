<?php
if (isset($_SESSION['usuario'])) { header('Location: ' . BASE_URL . '/'); exit; }
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Crear cuenta - Jacha Marketplace</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=5">
    <style>
        .auth-theme-btn {
            position:fixed; top:20px; right:20px; z-index:100;
            width:40px; height:40px; border-radius:50%;
            background:var(--card-bg); border:1px solid var(--border);
            color:var(--text-muted); font-size:16px; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; backdrop-filter:blur(8px);
        }
        .auth-theme-btn:hover { border-color:var(--border-hi); color:var(--text); }
        body { min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:0 }
        .register-container { position:relative;z-index:10;width:100%;max-width:500px;margin:32px auto;background:var(--auth-bg);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);border-radius:32px;border:1px solid var(--border);padding:48px 40px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);animation:fadeInUp 0.6s var(--ease) both }
        .form-row { display:grid;grid-template-columns:1fr 1fr;gap:16px }
        .form-group { margin-bottom:20px }
        .form-group label { display:block;margin-bottom:8px;font-size:13px;font-weight:500;color:var(--text-muted) }
        .form-group input { width:100%;padding:14px 16px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:14px;font-size:14px;color:var(--text);transition:all 0.3s }
        .form-group input:focus { outline:none;border-color:var(--border-hi);box-shadow:0 0 0 3px var(--accent-glow) }
        .form-group input::placeholder { color:var(--text-dim) }
        .password-requirements { margin-top:8px;font-size:12px }
        .requirement { color:var(--text-dim);margin-bottom:4px;display:flex;align-items:center;gap:8px }
        .requirement.valid { color:#4caf50 }
        .requirement .check { display:inline-block;width:16px;text-align:center }
        .btn-auth:disabled { opacity:0.4;cursor:not-allowed;transform:none }
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
        @media (max-width:560px) { .form-row { grid-template-columns:1fr;gap:0 } .register-container { padding:32px 24px } }
    </style>
</head>
<body>
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

    <button class="auth-theme-btn" id="themeToggle" title="Cambiar tema">&#9790;</button>
    <div class="light light-tl"></div>
    <div class="light light-br"></div>
    <div class="register-container">
        <div class="logo-auth">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" class="logo-img-lg">
        </div>
        <div class="text-center mb-xl">
            <h1 class="heading-gradient" style="font-size:32px;font-weight:600;margin-bottom:8px">Crear cuenta</h1>
            <p style="font-size:14px;color:var(--text-muted)">Completa tus datos para comenzar</p>
        </div>
        <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="<?= BASE_URL ?>/registro" id="registroForm">
            <div class="form-row">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" required placeholder="Tu nombre" id="nombres">
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" required placeholder="Tu apellido" id="apellidos">
                </div>
            </div>
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" required placeholder="tu@email.com" id="email">
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" name="telefono" placeholder="Ej: 71234567" id="telefono">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required id="password" placeholder="Crea una contraseña segura">
                    <div class="password-requirements" id="passwordRequirements">
                        <div class="requirement" id="req-length"><span class="check"></span> Al menos 8 caracteres</div>
                        <div class="requirement" id="req-upper"><span class="check"></span> Al menos una letra may&uacute;scula</div>
                        <div class="requirement" id="req-lower"><span class="check"></span> Al menos una letra min&uacute;scula</div>
                        <div class="requirement" id="req-number"><span class="check"></span> Al menos un n&uacute;mero</div>
                        <div class="requirement" id="req-special"><span class="check"></span> Al menos un car&aacute;cter especial (!@#$%^&*)</div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" required id="confirm_password" placeholder="Repite tu contraseña">
                    <div class="password-requirements">
                        <div class="requirement" id="req-match"><span class="check"></span> Las contraseñas coinciden</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-auth" id="submitBtn">Continuar</button>
        </form>
        <div class="auth-link">
            <p>¿Ya tienes cuenta? <a href="<?= BASE_URL ?>/login">Iniciar sesión</a></p>
        </div>
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
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');
        const requirements = { length: false, upper: false, lower: false, number: false, special: false, match: false };
        function validatePassword() {
            const value = password.value;
            requirements.length = value.length >= 8;
            requirements.upper = /[A-Z]/.test(value);
            requirements.lower = /[a-z]/.test(value);
            requirements.number = /[0-9]/.test(value);
            requirements.special = /[!@#$%^&*()_\-+=<>?{}[\]~]/.test(value);
            updateRequirementUI('length', requirements.length);
            updateRequirementUI('upper', requirements.upper);
            updateRequirementUI('lower', requirements.lower);
            updateRequirementUI('number', requirements.number);
            updateRequirementUI('special', requirements.special);
            validateMatch();
            updateSubmitButton();
        }
        function validateMatch() { const match = password.value === confirmPassword.value && password.value.length > 0; requirements.match = match; updateRequirementUI('match', match); updateSubmitButton(); }
        function updateRequirementUI(reqId, isValid) {
            const element = document.getElementById(`req-${reqId}`);
            if (element) { if (isValid) { element.classList.add('valid'); element.querySelector('.check').innerHTML = '✓'; } else { element.classList.remove('valid'); element.querySelector('.check').innerHTML = ''; } }
        }
        function updateSubmitButton() { const allValid = requirements.length && requirements.upper && requirements.lower && requirements.number && requirements.special && requirements.match; submitBtn.disabled = !allValid; }
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validateMatch);
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            if (!(requirements.length && requirements.upper && requirements.lower && requirements.number && requirements.special && requirements.match)) { e.preventDefault(); alert('Por favor, cumple con todos los requisitos de la contraseña'); }
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