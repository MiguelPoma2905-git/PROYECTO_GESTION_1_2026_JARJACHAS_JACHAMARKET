<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/OTP.php';
require_once __DIR__ . '/../config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$nombres = trim($_POST['nombres'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$password = $_POST['password'] ?? '';
$rol_nombre = $_POST['rol'] ?? 'Cliente';

// ==============================================
// VALIDACIONES DE SEGURIDAD
// ==============================================

// 1. Validar que no haya campos vacíos
if (empty($nombres) || empty($apellidos) || empty($email) || empty($password)) {
    header('Location: registro.php?error=Todos los campos son obligatorios');
    exit;
}

// 2. Validar email con expresión regular estricta
if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
    header('Location: registro.php?error=Formato de correo inválido');
    exit;
}

// 3. Validar que el email no tenga caracteres extraños
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=Correo electrónico inválido');
    exit;
}

// 4. Validar longitud de contraseña (mínimo 6 caracteres)
if (strlen($password) < 6) {
    header('Location: registro.php?error=La contraseña debe tener al menos 6 caracteres');
    exit;
}

// 5. Validar que la contraseña no sea solo números o solo letras (opcional - mejora seguridad)
if (preg_match('/^[0-9]+$/', $password) || preg_match('/^[a-zA-Z]+$/', $password)) {
    // Esto es solo advertencia, no bloqueamos
    error_log("Advertencia: Contraseña débil para email: $email");
}

// 6. Validar nombres y apellidos (solo letras, espacios y tildes)
if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombres)) {
    header('Location: registro.php?error=Los nombres solo pueden contener letras');
    exit;
}

if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $apellidos)) {
    header('Location: registro.php?error=Los apellidos solo pueden contener letras');
    exit;
}

// 7. Validar teléfono (opcional, solo números)
if (!empty($telefono) && !preg_match('/^[0-9]{7,15}$/', $telefono)) {
    header('Location: registro.php?error=El teléfono solo debe contener números (7-15 dígitos)');
    exit;
}

$db = getDB();

// Verificar si el email ya existe
$stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header('Location: registro.php?error=El email ya está registrado');
    exit;
}

// Obtener ID del rol
$stmt = $db->prepare("SELECT id_rol FROM roles WHERE nombre_rol = ?");
$stmt->execute([$rol_nombre]);
$rol = $stmt->fetch();

if (!$rol) {
    header('Location: registro.php?error=Rol no válido');
    exit;
}

// Generar OTP
$otp = new OTP();
$result = $otp->generarCodigo($email);

if (!$result['success']) {
    header('Location: registro.php?error=' . urlencode($result['error']));
    exit;
}

// Guardar temporalmente en sesión
$_SESSION['registro_temp'] = [
    'nombres' => $nombres,
    'apellidos' => $apellidos,
    'email' => $email,
    'telefono' => $telefono,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'id_rol' => $rol['id_rol'],
    'codigo_otp' => $result['codigo']
];

// Enviar correo
$mailer = new Mailer();
$enviado = $mailer->enviarCodigoOTP($email, $result['codigo'], $nombres);

if (!$enviado) {
    // Si falla el envío, eliminamos el registro temporal
    unset($_SESSION['registro_temp']);
    header('Location: registro.php?error=Error al enviar el código de verificación. Revisa tu correo o intenta más tarde.');
    exit;
}

// Redirigir a verificación OTP
header('Location: verificar_otp.php');
exit;
?>