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

// Obtener usuario con sus roles
$stmt = $db->prepare("
    SELECT u.*, GROUP_CONCAT(DISTINCT r.nombre_rol) as roles_todos
    FROM usuarios u
    LEFT JOIN usuario_roles ur ON u.id_usuario = ur.id_usuario
    LEFT JOIN roles r ON ur.id_rol = r.id_rol
    WHERE u.email = ? AND u.estado = 'Activo'
    GROUP BY u.id_usuario
");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
    header('Location: login.php?error=Credenciales incorrectas');
    exit;
}

// Generar OTP
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
    'roles' => $usuario['roles_todos'] ?? '',
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