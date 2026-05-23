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
$basePath = str_replace($docRoot, '', str_replace('\\', '/', dirname(__DIR__)));
$basePath = rtrim($basePath, '/');
define('BASE_URL', $protocol . '://' . $host . $basePath);
define('BASE_PATH', dirname(__DIR__) . '/');

// COLORES NEUTROS DEL SISTEMA (escala de grises)
define('COLOR_PRIMARY', '#1a1a1a');    // Negro suave
define('COLOR_SECONDARY', '#555555');  // Gris medio
define('COLOR_BACKGROUND', '#ffffff'); // Blanco puro
define('COLOR_TEXT', '#2D2D2D');       // Casi negro
?>