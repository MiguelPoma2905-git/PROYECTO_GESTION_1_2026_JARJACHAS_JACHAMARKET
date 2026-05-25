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
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
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
        .register-container { position:relative;z-index:10;width:100%;max-width:640px;margin:32px auto;background:var(--auth-bg);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);border-radius:8px;border:1px solid var(--border);padding:52px 48px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);animation:fadeInUp 0.6s var(--ease) both }
        .form-row { display:grid;grid-template-columns:1fr 1fr;gap:20px }
        .form-group { margin-bottom:22px }
        .form-group label { display:block;margin-bottom:8px;font-size:13px;font-weight:500;color:var(--text-muted);font-family:'DM Sans',system-ui,sans-serif }
        .form-group input { width:100%;padding:15px 18px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:6px;font-size:14px;color:var(--text);font-family:'DM Sans',system-ui,sans-serif;transition:all 0.3s }
        .form-group input:focus { outline:none;border-color:var(--border-hi) }
        .form-group input::placeholder { color:var(--text-dim) }
        .password-requirements { margin-top:8px;font-size:12px;font-family:'DM Sans',system-ui,sans-serif }
        .requirement { color:var(--text-dim);margin-bottom:4px;display:flex;align-items:center;gap:8px }
        .requirement.valid { color:#4caf50 }
        .requirement .check { display:inline-block;width:16px;text-align:center }
        .btn-auth:disabled { opacity:0.4;cursor:not-allowed;transform:none }
        .pwd-strength-bar { height:4px;background:var(--border);border-radius:2px;margin-top:10px;overflow:hidden;transition:opacity .3s;opacity:0 }
        .pwd-strength-bar.show { opacity:1 }
        .pwd-strength-fill { height:100%;border-radius:2px;width:0;transition:width .3s,background .3s }
        .pwd-status { font-size:12px;margin-top:8px;line-height:1.6;min-height:0;transition:min-height .3s;font-family:'DM Sans',system-ui,sans-serif }
        .pwd-status .done { color:#4caf50;display:block }
        .pwd-status .missing { color:#e74c3c;display:block }
        .pwd-status .hint { color:var(--text-dim);font-size:11px;display:block }
        .pwd-match-status { font-size:12px;margin-top:8px;font-family:'DM Sans',system-ui,sans-serif }
        .pwd-match-status.ok { color:#4caf50 }
        .pwd-match-status.err { color:#e74c3c }
        .carousel-slide-1 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_login_variante_clara.jpg'); }
        .carousel-slide-2 { background-image: url('<?= BASE_URL ?>/assets/images/auth/fondo_variante_oscura.jpg'); }
        .carousel-slide-3 { background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-4 { background: linear-gradient(135deg, #111111 0%, #1a1a1a 30%, #2a2a2a 60%, #333333 100%); }
        .carousel-slide-5 { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #444444 100%); }
        @media (max-width:700px) { .register-container { max-width:100%;margin:24px 16px;padding:36px 28px } .form-row { grid-template-columns:1fr;gap:0 } }
        @media (max-width:600px) {
            body { background:var(--bg) !important; }
            #bgCarousel,.bg-carousel-overlay,.bg-carousel-gradient-overlay,.carousel-particles,.light,.watermark { display:none !important; }
            .register-container { margin:0;min-height:100vh;border-radius:0;background:var(--bg);backdrop-filter:none;-webkit-backdrop-filter:none;border:none;box-shadow:none;padding:32px 20px }
            .auth-theme-btn { top:12px;right:12px;width:36px;height:36px;font-size:14px }
        }
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
            <h1 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:36px;font-weight:500;margin-bottom:8px;color:var(--text)">Crear cuenta</h1>
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
                    <input type="password" name="password" required id="password" placeholder="Crea una contraseña segura" autocomplete="new-password">
                    <div class="pwd-strength-bar" id="pwdStrengthBar"><div class="pwd-strength-fill" id="pwdStrengthFill"></div></div>
                    <div class="pwd-status" id="pwdStatus"></div>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" required id="confirm_password" placeholder="Repite tu contraseña" autocomplete="new-password">
                    <div class="pwd-match-status" id="pwdMatchStatus"></div>
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
        const strengthBar = document.getElementById('pwdStrengthBar');
        const strengthFill = document.getElementById('pwdStrengthFill');
        const pwdStatus = document.getElementById('pwdStatus');
        const pwdMatchStatus = document.getElementById('pwdMatchStatus');

        const rules = [
            { id:'length', label:'8 caracteres', test:v=>v.length>=8 },
            { id:'upper',  label:'Una may&uacute;scula', test:v=>/[A-Z]/.test(v) },
            { id:'lower',  label:'Una min&uacute;scula', test:v=>/[a-z]/.test(v) },
            { id:'number', label:'Un n&uacute;mero', test:v=>/[0-9]/.test(v) },
            { id:'special',label:'Un car&aacute;cter especial', test:v=>/[!@#$%^&*()_\-+=<>?{}[\]~]/.test(v) }
        ];

        const ruleLabels = {
            length:'M&iacute;nimo 8 caracteres',
            upper:'Al menos una may&uacute;scula',
            lower:'Al menos una min&uacute;scula',
            number:'Al menos un n&uacute;mero',
            special:'Al menos un car&aacute;cter especial (!@#$%^&*)'
        };

        let reqState = {};

        function validatePassword() {
            const val = password.value;
            let done = [], missing = [];
            rules.forEach(r => {
                const ok = r.test(val);
                reqState[r.id] = ok;
                if (ok) done.push(r.label); else missing.push(ruleLabels[r.id]);
            });

            const total = rules.length;
            const score = done.length;
            const pct = (score / total) * 100;

            if (val.length === 0) {
                strengthBar.classList.remove('show');
                pwdStatus.innerHTML = '';
            } else {
                strengthBar.classList.add('show');
                strengthFill.style.width = pct + '%';
                let color;
                if (pct <= 33) color = '#e74c3c';
                else if (pct <= 66) color = '#f39c12';
                else color = '#4caf50';
                strengthFill.style.background = color;

                let html = '';
                if (done.length > 0) {
                    html += '<span class="done">Completado: ' + done.join(', ') + '</span>';
                }
                if (missing.length > 0) {
                    html += '<span class="missing">Falta: ' + missing.join(', ') + '</span>';
                }
                if (missing.length > 0 && done.length === 0) {
                    html = '<span class="hint">La contrase&ntilde;a debe tener: ' + missing.join(', ') + '</span>';
                }
                pwdStatus.innerHTML = html;
            }

            reqState.match = false;
            validateMatch();
            updateSubmitButton();
        }

        function validateMatch() {
            const val = password.value;
            const conf = confirmPassword.value;
            if (conf.length === 0) {
                pwdMatchStatus.innerHTML = '';
                pwdMatchStatus.className = 'pwd-match-status';
                reqState.match = false;
            } else if (val === conf) {
                pwdMatchStatus.innerHTML = 'Las contrase&ntilde;as coinciden';
                pwdMatchStatus.className = 'pwd-match-status ok';
                reqState.match = true;
            } else {
                pwdMatchStatus.innerHTML = 'Las contrase&ntilde;as no coinciden';
                pwdMatchStatus.className = 'pwd-match-status err';
                reqState.match = false;
            }
            updateSubmitButton();
        }

        function updateSubmitButton() {
            const allValid = rules.every(r => reqState[r.id]) && reqState.match;
            submitBtn.disabled = !allValid;
        }

        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validateMatch);
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            const allValid = rules.every(r => reqState[r.id]) && reqState.match;
            if (!allValid) { e.preventDefault(); alert('Cumple todos los requisitos de la contrase&ntilde;a antes de continuar.'); }
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