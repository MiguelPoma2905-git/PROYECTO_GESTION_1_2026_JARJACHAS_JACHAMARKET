<?php
require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Crear cuenta - Jacha Marketplace</title>
    
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
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
            background-image: url('assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.12;
            pointer-events: none;
        }
        .light-1 { position: fixed; top: -20%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(250,113,54,0.2) 0%, transparent 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 0; }
        .light-2 { position: fixed; bottom: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(26,65,71,0.15) 0%, transparent 70%); border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .register-container {
            position: relative; z-index: 1; width: 100%; max-width: 500px; margin: 40px 24px;
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
        .form-header { text-align: center; margin-bottom: 32px; }
        .form-header h1 { font-size: 32px; font-weight: 600; margin-bottom: 8px; background: linear-gradient(135deg, #ffffff, #ccc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .form-header p { font-size: 14px; color: #888; }
        .error-message { background: rgba(250,113,54,0.12); border-left: 3px solid #fa7136; padding: 14px; margin-bottom: 24px; font-size: 13px; color:rgba(255,255,255,0.15); border-radius: 10px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #aaa; }
        .form-group input { width: 100%; padding: 14px 16px; background: #141414; border: 1px solid #2a2a2a; border-radius: 14px; font-size: 14px; color: #fff; transition: all 0.3s; }
        .form-group input:focus { outline: none; border-color: #797979; box-shadow: 0 0 0 3px rgba(250,113,54,0.15); }
        .form-group input::placeholder { color: #555; }
        .password-requirements { margin-top: 8px; font-size: 12px; }
        .requirement { color: #666; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .requirement.valid { color: #4caf50; }
        .requirement .check { display: inline-block; width: 16px; text-align: center; }
        .requirement.valid .check { color: #4caf50; }
        .btn-register { width: 100%; padding: 14px; background: #fff; border: none; border-radius: 14px; font-size: 15px; font-weight: 600; color: #0a0a0a; cursor: pointer; transition: all 0.3s; margin-top: 8px; }
        .btn-register:hover { background: #e8e8e8; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,255,255,0.15); }
        .btn-register:disabled { background: #555; cursor: not-allowed; transform: none; }
        .login-link { text-align: center; margin-top: 28px; padding-top: 24px; border-top: 1px solid #2a2a2a; }
        .login-link p { font-size: 13px; color: #888; }
        .login-link a { color: #fa7136; text-decoration: none; font-weight: 500; }
        @media (max-width: 560px) { .form-row { grid-template-columns: 1fr; gap: 0; } .register-container { padding: 32px 24px; } .logo-img { height: 40px; } .logo-text { font-size: 24px; } .logo-text span { font-size: 18px; } }
    </style>
</head>
<body>
    <div class="light-1"></div>
    <div class="light-2"></div>

    <div class="register-container">
        <div class="logo-wrapper">
            <img src="assets/images/logo_jacha_sinfondo.png" alt="Jacha" class="logo-img">
            <div class="logo-text">JACHA<span>market</span></div>
        </div>
        
        <div class="form-header">
            <h1>Crear cuenta</h1>
            <p>Completa tus datos para comenzar</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="registro_process.php" id="registroForm">
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
                        <div class="requirement" id="req-length"><span class="check">○</span> Al menos 8 caracteres</div>
                        <div class="requirement" id="req-upper"><span class="check">○</span> Al menos una letra mayúscula</div>
                        <div class="requirement" id="req-lower"><span class="check">○</span> Al menos una letra minúscula</div>
                        <div class="requirement" id="req-number"><span class="check">○</span> Al menos un número</div>
                        <div class="requirement" id="req-special"><span class="check">○</span> Al menos un carácter especial (!@#$%^&*)</div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" required id="confirm_password" placeholder="Repite tu contraseña">
                    <div class="password-requirements">
                        <div class="requirement" id="req-match"><span class="check">○</span> Las contraseñas coinciden</div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn-register" id="submitBtn">
                Continuar
            </button>
        </form>
        
        <div class="login-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
        </div>
    </div>

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
        
        function validateMatch() {
            const match = password.value === confirmPassword.value && password.value.length > 0;
            requirements.match = match;
            updateRequirementUI('match', match);
        }
        
        function updateRequirementUI(reqId, isValid) {
            const element = document.getElementById(`req-${reqId}`);
            if (element) {
                if (isValid) {
                    element.classList.add('valid');
                    element.querySelector('.check').innerHTML = '✓';
                } else {
                    element.classList.remove('valid');
                    element.querySelector('.check').innerHTML = '○';
                }
            }
        }
        
        function updateSubmitButton() {
            const allValid = requirements.length && requirements.upper && requirements.lower && 
                           requirements.number && requirements.special && requirements.match;
            submitBtn.disabled = !allValid;
        }
        
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validateMatch);
        
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            const allValid = requirements.length && requirements.upper && requirements.lower && 
                           requirements.number && requirements.special && requirements.match;
            if (!allValid) {
                e.preventDefault();
                alert('Por favor, cumple con todos los requisitos de la contraseña');
            }
        });
    </script>
</body>
</html>