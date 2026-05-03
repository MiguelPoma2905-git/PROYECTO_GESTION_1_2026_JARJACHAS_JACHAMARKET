<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Models/OTP.php';
require_once __DIR__ . '/../config/mail.php';

if (!isset($_SESSION['registro_temp'])) {
    header('Location: registro.php');
    exit;
}

$temp = $_SESSION['registro_temp'];

if (empty($temp['roles_seleccionados'])) {
    header('Location: elegir_roles.php');
    exit;
}

$email = $temp['email'];
$nombre = $temp['nombres'];

// Generar OTP
$otp = new OTP();
$result = $otp->generarCodigo($email);

if (!$result['success']) {
    header('Location: elegir_roles.php?error=' . urlencode($result['error']));
    exit;
}

// Guardar código OTP en sesión
$_SESSION['registro_temp']['codigo_otp'] = $result['codigo'];

// Enviar correo
$mailer = new Mailer();
$enviado = $mailer->enviarCodigoOTP($email, $result['codigo'], $nombre);

if (!$enviado) {
    unset($_SESSION['registro_temp']['codigo_otp']);
    header('Location: elegir_roles.php?error=Error al enviar el código de verificación');
    exit;
}

// Redirigir a verificación
header('Location: verificar_otp.php');
exit;
?>