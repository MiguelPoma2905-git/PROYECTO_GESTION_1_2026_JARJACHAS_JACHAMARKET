<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Models/OTP.php';
require_once __DIR__ . '/../config/mail.php';

if (!isset($_SESSION['registro_temp'])) {
    header('Location: registro.php');
    exit;
}

$temp = $_SESSION['registro_temp'];
$email = $temp['email'];

// Generar nuevo código
$otp = new OTP();
$result = $otp->generarCodigo($email);

if (!$result['success']) {
    header('Location: verificar_otp.php?error=' . urlencode($result['error']));
    exit;
}

// Actualizar el código en la sesión
$_SESSION['registro_temp']['codigo_otp'] = $result['codigo'];

// Enviar nuevo correo
$mailer = new Mailer();
$enviado = $mailer->enviarCodigoOTP($email, $result['codigo'], $temp['nombres']);

if (!$enviado) {
    header('Location: verificar_otp.php?error=Error al reenviar el código');
    exit;
}

header('Location: verificar_otp.php?resent=1');
exit;
?>