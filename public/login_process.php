<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/OTP.php';
require_once __DIR__ . '/../config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: login.php?error=Correo y contraseña son requeridos');
    exit;
}

$db = getDB();

$stmt = $db->prepare("
    SELECT u.*, r.nombre_rol 
    FROM usuarios u 
    JOIN roles r ON u.id_rol = r.id_rol 
    WHERE u.email = ? AND u.estado = 'Activo'
");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
    header('Location: login.php?error=Credenciales incorrectas');
    exit;
}

// Generar OTP para este inicio de sesión
$otp = new OTP();
$result = $otp->generarCodigo($email);

if (!$result['success']) {
    header('Location: login.php?error=' . urlencode($result['error']));
    exit;
}

$_SESSION['login_temp'] = [
    'id' => $usuario['id_usuario'],
    'nombre' => $usuario['nombres'] . ' ' . $usuario['apellidos'],
    'email' => $usuario['email'],
    'rol' => $usuario['nombre_rol'],
    'codigo_otp' => $result['codigo']
];

$mailer = new Mailer();
$enviado = $mailer->enviarCodigoOTP($email, $result['codigo'], $usuario['nombres']);

if (!$enviado) {
    unset($_SESSION['login_temp']);
    header('Location: login.php?error=Error al enviar código de verificación');
    exit;
}

header('Location: verificar_otp_login.php');
exit;
?>