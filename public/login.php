<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

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
    <title>Iniciar Sesión - Jacha Marketplace</title>
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
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
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
            max-width: 400px;
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
            margin-top: auto;
            position: relative;
            z-index: 1;
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
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .form-section {
            width: 480px;
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
            padding: 0 16px;
        }
        
        .mobile-logo img {
            width: 100%;
            max-width: 200px;
            height: auto;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #ffffff;
        }
        
        .form-header p {
            color: #a0a0a0;
            font-size: 14px;
        }
        
        .error-message {
            background: rgba(250,113,54,0.1);
            border-left: 3px solid #fa7136;
            padding: 14px 16px;
            margin-bottom: 28px;
            font-size: 13px;
            color: #fa7136;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #a0a0a0;
            letter-spacing: 0.3px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: #252525;
            border: 1px solid #333333;
            border-radius: 4px;
            font-size: 15px;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #fa7136;
            box-shadow: 0 0 0 2px rgba(250,113,54,0.1);
        }
        
        .form-group input::placeholder {
            color: #a0a0a0;
            opacity: 0.5;
        }
        
        .btn-login {
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
        
        .btn-login:hover {
            background: #e05a2a;
            transform: translateY(-1px);
        }
        
        .register-link {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #2a2a2a;
        }
        
        .register-link p {
            font-size: 13px;
            color: #a0a0a0;
        }
        
        .register-link a {
            color: #fa7136;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .register-link a:hover {
            text-decoration: underline;
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
                margin-bottom: 0;
                padding: 0;
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
        
        @media (max-width: 480px) {
            .form-section {
                padding: 70px 24px 32px;
            }
            
            .mobile-logo img {
                max-width: 140px;
            }
            
            .form-header h1 {
                font-size: 26px;
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
    <div class="login-container">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-logo">
                    <img src="assets/images/logo_2.png" alt="Jacha Logo">
                </div>
            </div>
            
            <div class="hero-quote">
                <h2>Potencia tu emprendimiento</h2>
                <p>La plataforma que conecta el talento boliviano con el mundo digital. Gestiona tu negocio, vende online y llega a más clientes.</p>
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
                    <h1>Iniciar sesión</h1>
                    <p>Ingresa tus credenciales para acceder a tu cuenta</p>
                </div>
                
                <?php if ($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="login_process.php">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" required placeholder="tu@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" required placeholder="Ingresa tu contraseña">
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Acceder
                    </button>
                </form>
                
                <div class="register-link">
                    <p>¿No tienes una cuenta? <a href="registro.php">Crear cuenta</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>