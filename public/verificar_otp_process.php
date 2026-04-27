<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/OTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: verificar_otp.php');
    exit;
}

if (!isset($_SESSION['registro_temp'])) {
    header('Location: registro.php');
    exit;
}

$codigo = $_POST['codigo'] ?? '';
$temp = $_SESSION['registro_temp'];

$otp = new OTP();
$result = $otp->verificarCodigo($temp['email'], $codigo);

if (!$result['success']) {
    header('Location: verificar_otp.php?error=' . urlencode($result['error']));
    exit;
}

$db = getDB();

$stmt = $db->prepare("
    INSERT INTO usuarios (nombres, apellidos, email, telefono, password_hash, id_rol, estado)
    VALUES (?, ?, ?, ?, ?, ?, 'Activo')
");

if ($stmt->execute([
    $temp['nombres'],
    $temp['apellidos'],
    $temp['email'],
    $temp['telefono'] ?? null,
    $temp['password_hash'],
    $temp['id_rol']
])) {
    $id_usuario = $db->lastInsertId();
    
    $_SESSION['usuario'] = [
        'id' => $id_usuario,
        'nombre' => $temp['nombres'] . ' ' . $temp['apellidos'],
        'email' => $temp['email'],
        'rol' => ''
    ];
    
    $stmt = $db->prepare("SELECT nombre_rol FROM roles WHERE id_rol = ?");
    $stmt->execute([$temp['id_rol']]);
    $rol = $stmt->fetch();
    $_SESSION['usuario']['rol'] = $rol['nombre_rol'];
    
    unset($_SESSION['registro_temp']);
    
    // ==============================================
    // REDIRECCIÓN SEGÚN EL ROL REGISTRADO
    // ==============================================
    if ($rol['nombre_rol'] === 'Emprendedor') {
        header('Location: dashboard_vendedor.php');
    } elseif ($rol['nombre_rol'] === 'Repartidor') {
        header('Location: dashboard_repartidor.php');
    } elseif ($rol['nombre_rol'] === 'Administrador') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: index.php');
    }
    exit;
} else {
    header('Location: registro.php?error=Error al crear usuario');
    exit;
}
?>