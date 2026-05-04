<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/OTP.php';

// Mostrar errores para depuración (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
$db->beginTransaction();

try {
    // Verificar que el email no exista ya
    $stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->execute([$temp['email']]);
    if ($stmt->fetch()) {
        throw new Exception("El email ya está registrado");
    }
    
    // Insertar usuario (SIN id_rol)
    $stmt = $db->prepare("
        INSERT INTO usuarios (nombres, apellidos, email, telefono, password_hash, estado)
        VALUES (?, ?, ?, ?, ?, 'Activo')
    ");
    
    $stmt->execute([
        $temp['nombres'],
        $temp['apellidos'],
        $temp['email'],
        $temp['telefono'] ?? null,
        $temp['password_hash']
    ]);
    
    $id_usuario = $db->lastInsertId();
    
    // Insertar roles seleccionados en usuario_roles
    $roles_nombres = explode(',', $temp['roles_seleccionados']);
    foreach ($roles_nombres as $rol_nombre) {
        $stmt = $db->prepare("SELECT id_rol FROM roles WHERE nombre_rol = ?");
        $stmt->execute([trim($rol_nombre)]);
        $rol = $stmt->fetch();
        if ($rol) {
            $stmt = $db->prepare("INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (?, ?)");
            $stmt->execute([$id_usuario, $rol['id_rol']]);
        }
    }
    
    // Procesar avatar si existe
    $avatar_final = $temp['avatar'] ?? 'assets/avatars/default/avatar_1.png';
    
    if (strpos($avatar_final, 'uploads/temp_avatars/') === 0) {
        $temp_path = __DIR__ . '/../' . $avatar_final;
        $extension = pathinfo($temp_path, PATHINFO_EXTENSION);
        $destino_dir = __DIR__ . '/uploads/avatars/';
        
        if (!file_exists($destino_dir)) {
            mkdir($destino_dir, 0777, true);
        }
        
        $nombre_final = 'avatar_' . $id_usuario . '_' . time() . '.' . $extension;
        $destino = $destino_dir . $nombre_final;
        $avatar_final_db = 'uploads/avatars/' . $nombre_final;
        
        if (file_exists($temp_path)) {
            rename($temp_path, $destino);
            $avatar_final = $avatar_final_db;
            
            $stmt = $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?");
            $stmt->execute([$avatar_final, $id_usuario]);
        }
    } else {
        $stmt = $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?");
        $stmt->execute([$avatar_final, $id_usuario]);
    }
    
    $db->commit();
    
    // Iniciar sesión
    $_SESSION['usuario'] = [
        'id' => $id_usuario,
        'nombre' => $temp['nombres'] . ' ' . $temp['apellidos'],
        'email' => $temp['email']
    ];
    
    // Obtener roles del usuario recién creado
    $stmt = $db->prepare("
        SELECT COUNT(*) as total, GROUP_CONCAT(r.nombre_rol) as roles
        FROM usuario_roles ur
        JOIN roles r ON ur.id_rol = r.id_rol
        WHERE ur.id_usuario = ?
    ");
    $stmt->execute([$id_usuario]);
    $roles_info = $stmt->fetch();
    $total_roles = $roles_info['total'];
    $roles_array = explode(',', $roles_info['roles']);
    
    unset($_SESSION['registro_temp']);
    
    // Redirigir según cantidad de roles
    if ($total_roles > 1) {
        header('Location: selector_rol.php');
    } else {
        $_SESSION['rol_activo'] = trim($roles_array[0]);
        header('Location: dashboard_principal.php');
    }
    exit;
    
} catch (Exception $e) {
    $db->rollBack();
    error_log("Error al crear usuario: " . $e->getMessage());
    header('Location: registro.php?error=Error al crear usuario. Intenta nuevamente.');
    exit;
}
?>