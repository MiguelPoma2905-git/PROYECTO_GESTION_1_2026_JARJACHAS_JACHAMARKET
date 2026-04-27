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

// Código verificado correctamente - iniciar sesión
$_SESSION['usuario'] = [
    'id' => $temp['id'],
    'nombre' => $temp['nombre'],
    'email' => $temp['email'],
    'rol' => $temp['rol']
];

unset($_SESSION['login_temp']);

// ==============================================
// REDIRECCIÓN SEGÚN EL ROL
// ==============================================
if ($temp['rol'] === 'Emprendedor') {
    // Vendedor → Dashboard del vendedor
    header('Location: dashboard_vendedor.php');
} elseif ($temp['rol'] === 'Repartidor') {
    // Repartidor → Dashboard del repartidor
    header('Location: dashboard_repartidor.php');
} elseif ($temp['rol'] === 'Administrador') {
    // Admin → Panel de administración
    header('Location: admin/dashboard.php');
} else {
    // Cliente normal → Index (marketplace)
    header('Location: index.php');
}
exit;
?>