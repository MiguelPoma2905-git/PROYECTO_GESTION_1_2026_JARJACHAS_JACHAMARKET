<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$nombres = trim($_POST['nombres'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$password = $_POST['password'] ?? '';

// ==============================================
// VALIDACIONES DE SEGURIDAD
// ==============================================

if (empty($nombres) || empty($apellidos) || empty($email) || empty($password)) {
    header('Location: registro.php?error=Todos los campos son obligatorios');
    exit;
}

if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
    header('Location: registro.php?error=Formato de correo inválido');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=Correo electrónico inválido');
    exit;
}

if (strlen($password) < 6) {
    header('Location: registro.php?error=La contraseña debe tener al menos 6 caracteres');
    exit;
}

if (preg_match('/^[0-9]+$/', $password) || preg_match('/^[a-zA-Z]+$/', $password)) {
    error_log("Advertencia: Contraseña débil para email: $email");
}

if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombres)) {
    header('Location: registro.php?error=Los nombres solo pueden contener letras');
    exit;
}

if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $apellidos)) {
    header('Location: registro.php?error=Los apellidos solo pueden contener letras');
    exit;
}

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

// Guardar temporalmente en sesión (sin OTP aún)
$_SESSION['registro_temp'] = [
    'nombres' => $nombres,
    'apellidos' => $apellidos,
    'email' => $email,
    'telefono' => $telefono,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'roles_seleccionados' => []  // se llenará en elegir_roles.php
];

// Redirigir a elegir roles
header('Location: elegir_roles.php');
exit;
?>