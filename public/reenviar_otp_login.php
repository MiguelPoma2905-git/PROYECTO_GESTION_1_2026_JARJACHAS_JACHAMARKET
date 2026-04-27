<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Models/OTP.php';
require_once __DIR__ . '/../config/mail.php';

if (!isset($_SESSION['login_temp'])) {
    header('Location: login.php');
    exit;
}

$temp = $_SESSION['login_temp'];
$email = $temp['email'];

$otp = new OTP();
$result = $otp->generarCodigo($email);

if (!$result['success']) {
    header('Location: verificar_otp_login.php?error=' . urlencode($result['error']));
    exit;
}

$_SESSION['login_temp']['codigo_otp'] = $result['codigo'];

$mailer = new Mailer();
$enviado = $mailer->enviarCodigoOTP($email, $result['codigo'], explode(' ', $temp['nombre'])[0]);

if (!$enviado) {
    header('Location: verificar_otp_login.php?error=Error al reenviar el código');
    exit;
}

header('Location: verificar_otp_login.php?resent=1');
exit;
?>