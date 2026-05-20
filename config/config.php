<?php
session_start();

// Configuración de zona horaria
date_default_timezone_set('America/La_Paz');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// URLs base - Auto-detecta automáticamente para que funcione en cualquier carpeta
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? 'C:/xampp/htdocs');
$basePath = str_replace($docRoot, '', str_replace('\\', '/', dirname(__DIR__)));
$basePath = rtrim($basePath, '/');
define('BASE_URL', $protocol . '://' . $host . $basePath);
define('BASE_PATH', dirname(__DIR__) . '/');

// NUEVOS COLORES DEL SISTEMA
define('COLOR_PRIMARY', '#fa7136');    // Naranja intenso
define('COLOR_SECONDARY', '#1a4147');  // Verde azulado oscuro
define('COLOR_BACKGROUND', '#FDFBF7'); // Blanco hueso
define('COLOR_TEXT', '#2D2D2D');       // Negro
?>