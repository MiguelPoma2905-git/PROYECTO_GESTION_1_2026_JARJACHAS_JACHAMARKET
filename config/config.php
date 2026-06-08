<?php
session_start();

// Configuración de zona horaria
date_default_timezone_set('America/La_Paz');

// Configuración de errores
error_reporting(E_ALL);
if (isset($_SERVER['SERVER_ADDR']) && ($_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '::1')) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

// URLs base - Auto-detecta automáticamente para que funcione en cualquier carpeta
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? 'C:/xampp/htdocs');
$projectRoot = str_replace('\\', '/', dirname(__DIR__));

// Cuando se usa `php -S localhost:8000 -t public`, DOCUMENT_ROOT apunta a /public.
// En ese caso la app vive en la raíz del host y los assets deben salir de /assets/...
if (basename($docRoot) === 'public' && realpath(dirname($docRoot)) === realpath($projectRoot)) {
    $basePath = '';
} else {
    $basePath = str_replace($docRoot, '', $projectRoot);
    $basePath = rtrim($basePath, '/');
}
define('BASE_URL', $protocol . '://' . $host . $basePath);
define('BASE_PATH', dirname(__DIR__) . '/');

// CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function get_csrf_token(): string {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// COLORES NEUTROS DEL SISTEMA (escala de grises)
define('COLOR_PRIMARY', '#1a1a1a');    // Negro suave
define('COLOR_SECONDARY', '#555555');  // Gris medio
define('COLOR_BACKGROUND', '#ffffff'); // Blanco puro
define('COLOR_TEXT', '#2D2D2D');       // Casi negro
?>
