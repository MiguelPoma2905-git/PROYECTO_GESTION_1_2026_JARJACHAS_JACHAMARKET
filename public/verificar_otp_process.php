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
    
    // Procesar avatar
    $avatar_final = $temp['avatar'] ?? 'assets/avatars/default/avatar_1.png';
    
    // Si es una imagen temporal, moverla a la carpeta permanente
    if (strpos($avatar_final, 'uploads/temp_avatars/') === 0) {
        $temp_path = __DIR__ . '/../' . $avatar_final;
        $extension = pathinfo($temp_path, PATHINFO_EXTENSION);
        
        // Obtener ID del usuario (primero insertamos, luego actualizamos)
        $id_temp = null;
        
        // Insertar usuario sin avatar aún
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
        
        // Ahora procesar el avatar
        $destino_dir = __DIR__ . '/uploads/avatars/';
        if (!file_exists($destino_dir)) {
            mkdir($destino_dir, 0777, true);
        }
        
        $nombre_final = 'avatar_' . $id_usuario . '_' . time() . '.' . $extension;
        $destino = $destino_dir . $nombre_final;
        $avatar_final_db = 'uploads/avatars/' . $nombre_final;
        
        if (file_exists($temp_path)) {
            // Redimensionar imagen a 300x300 usando GD
            $img_info = getimagesize($temp_path);
            $src = null;
            
            switch ($img_info['mime']) {
                case 'image/jpeg':
                    $src = imagecreatefromjpeg($temp_path);
                    break;
                case 'image/png':
                    $src = imagecreatefrompng($temp_path);
                    break;
                case 'image/gif':
                    $src = imagecreatefromgif($temp_path);
                    break;
                case 'image/webp':
                    $src = imagecreatefromwebp($temp_path);
                    break;
                default:
                    $src = imagecreatefromjpeg($temp_path);
            }
            
            if ($src) {
                $new_width = 300;
                $new_height = 300;
                $dst = imagecreatetruecolor($new_width, $new_height);
                
                // Mantener transparencia para PNG
                if ($img_info['mime'] === 'image/png') {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefill($dst, 0, 0, $transparent);
                }
                
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $img_info[0], $img_info[1]);
                
                // Guardar imagen redimensionada
                if ($img_info['mime'] === 'image/png') {
                    imagepng($dst, $destino, 8);
                } elseif ($img_info['mime'] === 'image/webp') {
                    imagewebp($dst, $destino, 85);
                } else {
                    imagejpeg($dst, $destino, 85);
                }
                
                imagedestroy($src);
                imagedestroy($dst);
                
                // Eliminar archivo temporal
                unlink($temp_path);
                
                // Actualizar la base de datos con la ruta del avatar
                $stmt = $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?");
                $stmt->execute([$avatar_final_db, $id_usuario]);
                
                $avatar_final = $avatar_final_db;
            } else {
                // No se pudo procesar la imagen, usar avatar por defecto
                $stmt = $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?");
                $stmt->execute(['assets/avatars/default/avatar_1.png', $id_usuario]);
                $avatar_final = 'assets/avatars/default/avatar_1.png';
            }
        } else {
            // El archivo temporal no existe, usar avatar por defecto
            $stmt = $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?");
            $stmt->execute(['assets/avatars/default/avatar_1.png', $id_usuario]);
            $avatar_final = 'assets/avatars/default/avatar_1.png';
        }
    } else {
        // Es un avatar predeterminado o ya procesado
        $stmt = $db->prepare("
            INSERT INTO usuarios (nombres, apellidos, email, telefono, password_hash, avatar, estado)
            VALUES (?, ?, ?, ?, ?, ?, 'Activo')
        ");
        
        $stmt->execute([
            $temp['nombres'],
            $temp['apellidos'],
            $temp['email'],
            $temp['telefono'] ?? null,
            $temp['password_hash'],
            $avatar_final
        ]);
        
        $id_usuario = $db->lastInsertId();
    }
    
    // Insertar roles seleccionados
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
    
    // Redirigir al selector o dashboard principal
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