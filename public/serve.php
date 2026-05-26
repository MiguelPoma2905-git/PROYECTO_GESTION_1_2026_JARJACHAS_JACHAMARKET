<?php
require_once __DIR__ . '/../config/database.php';

$type = $_GET['t'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!$type || !$id) {
    http_response_code(400);
    header('Content-Type: image/svg+xml');
    exit('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#eee" width="200" height="200"/><text fill="#aaa" x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="sans-serif" font-size="14">Invalid request</text></svg>');
}

try {
    $db = getDB();
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: image/svg+xml');
    exit('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#eee" width="200" height="200"/><text fill="#aaa" x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="sans-serif" font-size="14">DB error</text></svg>');
}

$blob = null;
$mime = null;

switch ($type) {
    case 'avatar':
        $stmt = $db->prepare("SELECT avatar_blob, avatar_mime FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $blob = $row['avatar_blob'];
            $mime = $row['avatar_mime'];
        }
        break;

    case 'logo':
        $stmt = $db->prepare("SELECT logo_blob, logo_mime FROM personalizacion_emprendimiento WHERE id_emprendimiento = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $blob = $row['logo_blob'];
            $mime = $row['logo_mime'];
        }
        break;

    case 'banner':
        $stmt = $db->prepare("SELECT banner_blob, banner_mime FROM personalizacion_emprendimiento WHERE id_emprendimiento = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $blob = $row['banner_blob'];
            $mime = $row['banner_mime'];
        }
        break;

    case 'portada':
        $stmt = $db->prepare("SELECT portada_blob, portada_mime FROM personalizacion_emprendimiento WHERE id_emprendimiento = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $blob = $row['portada_blob'];
            $mime = $row['portada_mime'];
        }
        break;

    case 'producto':
        $stmt = $db->prepare("SELECT imagen_blob, imagen_mime FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $blob = $row['imagen_blob'];
            $mime = $row['imagen_mime'];
        }
        break;

    default:
        http_response_code(400);
        header('Content-Type: image/svg+xml');
        exit('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#eee" width="200" height="200"/><text fill="#aaa" x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="sans-serif" font-size="14">Unknown type</text></svg>');
}

if (!$blob) {
    http_response_code(404);
    header('Content-Type: image/svg+xml');
    exit('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#eee" width="200" height="200"/><text fill="#aaa" x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="sans-serif" font-size="14">Not found</text></svg>');
}

$mime = $mime ?: 'image/png';

header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($blob));
header('Cache-Control: public, max-age=86400');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

echo $blob;
