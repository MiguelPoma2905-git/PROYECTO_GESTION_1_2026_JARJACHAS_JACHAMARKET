<?php
require_once __DIR__ . '/../config/config.php';

// Crear directorio temporal si no existe
$temp_dir = __DIR__ . '/uploads/temp_avatars/';
if (!file_exists($temp_dir)) {
    mkdir($temp_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['temp_avatar'])) {
    $file = $_FILES['temp_avatar'];
    
    // Validar que sea una imagen
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode(['success' => false, 'error' => 'Tipo de archivo no válido. Solo imágenes JPG, PNG, GIF, WEBP.']);
        exit;
    }
    
    // Limitar tamaño (5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode(['success' => false, 'error' => 'La imagen es demasiado grande. Máximo 5MB.']);
        exit;
    }
    
    // Generar nombre único
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $session_id = session_id();
    if (empty($session_id)) {
        session_start();
        $session_id = session_id();
    }
    $nombre_archivo = 'temp_' . $session_id . '_' . time() . '.' . $extension;
    $ruta_temporal = $temp_dir . $nombre_archivo;
    $ruta_db = 'uploads/temp_avatars/' . $nombre_archivo;
    
    if (move_uploaded_file($file['tmp_name'], $ruta_temporal)) {
        echo json_encode([
            'success' => true, 
            'temp_url' => $ruta_db,
            'temp_path' => $ruta_temporal
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al guardar el archivo en el servidor']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'No se recibió archivo']);
?>