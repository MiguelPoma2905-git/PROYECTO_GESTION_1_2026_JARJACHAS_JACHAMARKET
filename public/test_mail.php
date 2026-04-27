<?php
require_once __DIR__ . '/../config/mail.php';

echo "<h1>📧 Prueba de envío de correo SMTP (Gmail)</h1>";
echo "<hr>";

$mailer = new Mailer();

// Probar conexión SMTP
echo "<h2>1. Probando conexión SMTP...</h2>";
$test = $mailer->testConnection();

if ($test['success']) {
    echo "<p style='color:green; background:#e8f5e9; padding:10px; border-radius:5px;'>✅ " . $test['message'] . "</p>";
} else {
    echo "<p style='color:red; background:#ffebee; padding:10px; border-radius:5px;'>❌ Error: " . $test['message'] . "</p>";
    echo "<p><strong>Posibles soluciones:</strong></p>";
    echo "<ul>";
    echo "<li>Verifica tu correo y contraseña de aplicación en config/mail.php</li>";
    echo "<li>La contraseña debe ser la de 16 caracteres, NO tu contraseña normal</li>";
    echo "<li>Activa la verificación en 2 pasos en tu Gmail</li>";
    echo "<li>Espera unos minutos después de generar la contraseña de aplicación</li>";
    echo "</ul>";
    exit;
}

// Probar envío de correo
echo "<h2>2. Enviando correo de prueba...</h2>";

// CAMBIA ESTO por un correo real para recibir la prueba
$email_prueba = 'mikypramos2905@gmail.com';
$codigo = rand(100000, 999999);
$nombre = 'Usuario de Prueba';

echo "<p>Enviando a: <strong>" . $email_prueba . "</strong></p>";
echo "<p>Código generado: <strong style='color:#fa7136; font-size:24px;'>" . $codigo . "</strong></p>";

$resultado = $mailer->enviarCodigoOTP($email_prueba, $codigo, $nombre);

if ($resultado) {
    echo "<p style='color:green; background:#e8f5e9; padding:10px; border-radius:5px;'>✅ Correo enviado exitosamente!</p>";
    echo "<p>📬 Revisa tu bandeja de entrada o <strong>carpeta SPAM</strong></p>";
} else {
    echo "<p style='color:red; background:#ffebee; padding:10px; border-radius:5px;'>❌ Error al enviar correo</p>";
}
?>