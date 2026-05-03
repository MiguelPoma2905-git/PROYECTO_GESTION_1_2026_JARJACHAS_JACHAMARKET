<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/OTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['login_temp'])) {
    header('Location: login.php');
    exit;
}

$codigo = $_POST['codigo'] ?? '';
$temp = $_SESSION['login_temp'];

$otp = new OTP();
$result = $otp->verificarCodigo($temp['email'], $codigo);

if (!$result['success']) {
    header('Location: verificar_otp_login.php?error=' . urlencode($result['error']));
    exit;
}

// Iniciar sesión
$_SESSION['usuario'] = [
    'id' => $temp['id'],
    'nombre' => $temp['nombre'],
    'email' => $temp['email']
];

// Guardar roles disponibles
$roles_array = explode(',', $temp['roles']);
$total_roles = count($roles_array);

unset($_SESSION['login_temp']);

if ($total_roles > 1) {
    // Múltiples roles → selector de rol
    header('Location: selector_rol.php');
} else {
    // Un solo rol → asignar directamente
    $rol_unico = trim($roles_array[0]);
    $_SESSION['rol_activo'] = $rol_unico;
    header('Location: dashboard_principal.php');
}
exit;
?>