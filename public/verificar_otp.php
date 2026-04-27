<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['registro_temp'])) {
    header('Location: registro.php');
    exit;
}

$error = $_GET['error'] ?? '';
$email = $_SESSION['registro_temp']['email'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - Jacha Marketplace</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .verification-container {
            max-width: 450px;
            width: 100%;
            margin: 20px;
        }
        
        .verification-card {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .verification-card h1 {
            font-size: 28px;
            margin-bottom: 16px;
        }
        
        .verification-card p {
            color: #a0a0a0;
            font-size: 14px;
            margin-bottom: 24px;
        }
        
        .email-display {
            background: #252525;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #fa7136;
            word-break: break-all;
        }
        
        .codigo-input {
            width: 100%;
            text-align: center;
            font-size: 32px;
            letter-spacing: 12px;
            padding: 16px;
            background: #252525;
            border: 1px solid #333333;
            border-radius: 8px;
            color: #ffffff;
            font-family: monospace;
            margin-bottom: 24px;
        }
        
        .codigo-input:focus {
            outline: none;
            border-color: #fa7136;
            box-shadow: 0 0 0 2px rgba(250,113,54,0.1);
        }
        
        .btn-verify {
            width: 100%;
            padding: 14px;
            background: #fa7136;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-verify:hover {
            background: #e05a2a;
            transform: translateY(-1px);
        }
        
        .resend-link {
            margin-top: 24px;
        }
        
        .resend-link a {
            color: #fa7136;
            text-decoration: none;
            font-size: 13px;
        }
        
        .timer {
            margin-top: 16px;
            font-size: 12px;
            color: #666666;
        }
        
        .error-message {
            background: rgba(250,113,54,0.1);
            border-left: 3px solid #fa7136;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #fa7136;
            text-align: left;
        }
        
        .success-message {
            background: rgba(26,65,71,0.2);
            border-left: 3px solid #1a4147;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #1a4147;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-card">
            <h1>🔐 Verifica tu correo</h1>
            <p>Hemos enviado un código de verificación a:</p>
            <div class="email-display">
                <?php echo htmlspecialchars($email); ?>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['resent']) && $_GET['resent'] == 1): ?>
            <div class="success-message">
                ✓ Se ha enviado un nuevo código a tu correo
            </div>
            <?php endif; ?>
            
            <form method="POST" action="verificar_otp_process.php">
                <input type="text" name="codigo" maxlength="6" class="codigo-input" 
                       pattern="[0-9]{6}" required placeholder="000000" autofocus>
                <button type="submit" class="btn-verify">
                    Verificar y Activar Cuenta
                </button>
            </form>
            
            <div class="resend-link">
                <a href="reenviar_otp.php">📧 ¿No recibiste el código? Reenviar</a>
            </div>
            
            <div class="timer" id="timer">
                El código expira en 10:00
            </div>
        </div>
    </div>
    
    <script>
        // Temporizador de 10 minutos
        let timeLeft = 600;
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerElement = document.getElementById('timer');
            
            if (timerElement) {
                if (timeLeft <= 0) {
                    timerElement.innerHTML = '⚠️ El código ha expirado. Solicita uno nuevo.';
                    timerElement.style.color = '#fa7136';
                } else {
                    timerElement.innerHTML = `El código expira en ${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }
            timeLeft--;
        }
        
        setInterval(updateTimer, 1000);
        
        // Enfoque automático en el campo
        document.querySelector('.codigo-input').focus();
    </script>
</body>
</html><?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['registro_temp'])) {
    header('Location: registro.php');
    exit;
}

$error = $_GET['error'] ?? '';
$email = $_SESSION['registro_temp']['email'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - Jacha Marketplace</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .verification-container {
            max-width: 450px;
            width: 100%;
            margin: 20px;
        }
        
        .verification-card {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .verification-card h1 {
            font-size: 28px;
            margin-bottom: 16px;
        }
        
        .verification-card p {
            color: #a0a0a0;
            font-size: 14px;
            margin-bottom: 24px;
        }
        
        .email-display {
            background: #252525;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #fa7136;
            word-break: break-all;
        }
        
        .codigo-input {
            width: 100%;
            text-align: center;
            font-size: 32px;
            letter-spacing: 12px;
            padding: 16px;
            background: #252525;
            border: 1px solid #333333;
            border-radius: 8px;
            color: #ffffff;
            font-family: monospace;
            margin-bottom: 24px;
        }
        
        .codigo-input:focus {
            outline: none;
            border-color: #fa7136;
            box-shadow: 0 0 0 2px rgba(250,113,54,0.1);
        }
        
        .btn-verify {
            width: 100%;
            padding: 14px;
            background: #fa7136;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-verify:hover {
            background: #e05a2a;
            transform: translateY(-1px);
        }
        
        .resend-link {
            margin-top: 24px;
        }
        
        .resend-link a {
            color: #fa7136;
            text-decoration: none;
            font-size: 13px;
        }
        
        .timer {
            margin-top: 16px;
            font-size: 12px;
            color: #666666;
        }
        
        .error-message {
            background: rgba(250,113,54,0.1);
            border-left: 3px solid #fa7136;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #fa7136;
            text-align: left;
        }
        
        .success-message {
            background: rgba(26,65,71,0.2);
            border-left: 3px solid #1a4147;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #1a4147;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-card">
            <h1>🔐 Verifica tu correo</h1>
            <p>Hemos enviado un código de verificación a:</p>
            <div class="email-display">
                <?php echo htmlspecialchars($email); ?>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['resent']) && $_GET['resent'] == 1): ?>
            <div class="success-message">
                ✓ Se ha enviado un nuevo código a tu correo
            </div>
            <?php endif; ?>
            
            <form method="POST" action="verificar_otp_process.php">
                <input type="text" name="codigo" maxlength="6" class="codigo-input" 
                       pattern="[0-9]{6}" required placeholder="000000" autofocus>
                <button type="submit" class="btn-verify">
                    Verificar y Activar Cuenta
                </button>
            </form>
            
            <div class="resend-link">
                <a href="reenviar_otp.php">📧 ¿No recibiste el código? Reenviar</a>
            </div>
            
            <div class="timer" id="timer">
                El código expira en 10:00
            </div>
        </div>
    </div>
    
    <script>
        // Temporizador de 10 minutos
        let timeLeft = 600;
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerElement = document.getElementById('timer');
            
            if (timerElement) {
                if (timeLeft <= 0) {
                    timerElement.innerHTML = '⚠️ El código ha expirado. Solicita uno nuevo.';
                    timerElement.style.color = '#fa7136';
                } else {
                    timerElement.innerHTML = `El código expira en ${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }
            timeLeft--;
        }
        
        setInterval(updateTimer, 1000);
        
        // Enfoque automático en el campo
        document.querySelector('.codigo-input').focus();
    </script>
</body>
</html>