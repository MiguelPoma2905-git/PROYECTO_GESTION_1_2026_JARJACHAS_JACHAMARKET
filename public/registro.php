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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .register-container {
            display: flex;
            min-height: 100vh;
            animation: fadeIn 0.6s ease-out;
        }
        
        .hero-section {
            flex: 1;
            position: relative;
            background-image: url('assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 65, 71, 0.85), rgba(250, 113, 54, 0.75));
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hero-logo {
            margin-bottom: 80px;
        }
        
        .hero-logo img {
            width: 100%;
            max-width: 320px;
            height: auto;
            display: block;
        }
        
        .hero-quote {
            position: relative;
            z-index: 1;
            margin-top: auto;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }
        
        .hero-quote h2 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        
        .hero-quote p {
            font-size: 14px;
            opacity: 0.8;
            line-height: 1.6;
        }
        
        .hero-footer {
            position: relative;
            z-index: 1;
            font-size: 12px;
            opacity: 0.6;
            margin-top: auto;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .form-section {
            width: 520px;
            background: #1a1a1a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 56px;
            box-shadow: -4px 0 20px rgba(0,0,0,0.05);
            animation: fadeInUp 0.6s ease-out 0.1s both;
        }
        
        .mobile-logo {
            display: none;
            margin-bottom: 40px;
        }
        
        .mobile-logo img {
            width: 100%;
            max-width: 200px;
            height: auto;
        }
        
        .form-header {
            margin-bottom: 32px;
        }
        
        .form-header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .form-header p {
            color: #a0a0a0;
            font-size: 14px;
        }
        
        .error-message {
            background: rgba(250,113,54,0.1);
            border-left: 3px solid #fa7136;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #fa7136;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #a0a0a0;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            background: #252525;
            border: 1px solid #333333;
            border-radius: 4px;
            font-size: 14px;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #fa7136;
            box-shadow: 0 0 0 2px rgba(250,113,54,0.1);
        }
        
        .password-requirements {
            margin-top: 8px;
            font-size: 12px;
        }
        
        .requirement {
            color: #666666;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        
        .requirement.valid {
            color: #4caf50;
        }
        
        .requirement .check {
            display: inline-block;
            width: 16px;
            text-align: center;
        }
        
        .requirement.valid .check {
            color: #4caf50;
        }
        
        .rol-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 8px;
        }
        
        .rol-option {
            padding: 12px;
            border: 1px solid #333333;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #252525;
        }
        
        .rol-option.selected {
            border-color: #fa7136;
            background: rgba(250,113,54,0.1);
        }
        
        .rol-option input {
            display: none;
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: #fa7136;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }
        
        .btn-register:hover {
            background: #e05a2a;
            transform: translateY(-1px);
        }
        
        .btn-register:disabled {
            background: #555555;
            cursor: not-allowed;
            transform: none;
        }
        
        .login-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #2a2a2a;
        }
        
        .login-link p {
            font-size: 13px;
            color: #a0a0a0;
        }
        
        .login-link a {
            color: #fa7136;
            text-decoration: none;
            font-weight: 500;
        }
        
        @media (max-width: 900px) {
            .hero-section {
                display: none;
            }
            
            .form-section {
                width: 100%;
                min-height: 100vh;
                justify-content: center;
                padding: 80px 32px 40px;
                box-shadow: none;
            }
            
            .mobile-logo {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                right: 20px;
                z-index: 20;
            }
            
            .mobile-logo img {
                max-width: 160px;
            }
            
            .form-wrapper {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }
            
            .form-section {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .form-header {
                text-align: center;
            }
        }
        
        @media (max-width: 560px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .form-section {
                padding: 70px 24px 32px;
            }
            
            .mobile-logo img {
                max-width: 140px;
            }
            
            .form-header h1 {
                font-size: 26px;
            }
            
            .rol-option {
                padding: 10px;
                font-size: 13px;
            }
        }
        
        @media (min-width: 901px) {
            .mobile-logo {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-logo">
                    <img src="assets/images/logo_2.png" alt="Jacha Logo">
                </div>
            </div>
            <div class="hero-quote">
                <h2>Únete a la comunidad</h2>
                <p>Crea tu cuenta y comienza a vender o comprar productos bolivianos de calidad.</p>
            </div>
            <div class="hero-footer">
                <p>© 2026 Jacha Marketplace</p>
            </div>
        </div>
        
        <div class="form-section">
            <div class="mobile-logo">
                <img src="assets/images/logo_2.png" alt="Jacha Logo">
            </div>
            
            <div class="form-wrapper">
                <div class="form-header">
                    <h1>Crear cuenta</h1>
                    <p>Completa tus datos para registrarte</p>
                </div>
                
                <?php if ($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
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
                                <div class="requirement" id="req-length">
                                    <span class="check">○</span> Al menos 8 caracteres
                                </div>
                                <div class="requirement" id="req-upper">
                                    <span class="check">○</span> Al menos una letra mayúscula
                                </div>
                                <div class="requirement" id="req-lower">
                                    <span class="check">○</span> Al menos una letra minúscula
                                </div>
                                <div class="requirement" id="req-number">
                                    <span class="check">○</span> Al menos un número
                                </div>
                                <div class="requirement" id="req-special">
                                    <span class="check">○</span> Al menos un carácter especial (!@#$%^&*)
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="confirm_password" required id="confirm_password" placeholder="Repite tu contraseña">
                            <div class="password-requirements" id="confirmRequirements">
                                <div class="requirement" id="req-match">
                                    <span class="check">○</span> Las contraseñas coinciden
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de cuenta</label>
                        <div class="rol-selector">
                            <div class="rol-option selected" data-rol="Cliente">
                                Comprador
                                <input type="radio" name="rol" value="Cliente" checked hidden>
                            </div>
                            <div class="rol-option" data-rol="Emprendedor">
                                Vendedor
                                <input type="radio" name="rol" value="Emprendedor" hidden>
                            </div>
                            <div class="rol-option" data-rol="Repartidor">
                                Repartidor
                                <input type="radio" name="rol" value="Repartidor" hidden>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-register" id="submitBtn">
                        Registrarse
                    </button>
                </form>
                
                <div class="login-link">
                    <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');
        
        const requirements = {
            length: false,
            upper: false,
            lower: false,
            number: false,
            special: false,
            match: false
        };
        
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
        
        document.querySelectorAll('.rol-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.rol-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                const radio = opt.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            });
        });
        
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