<?php
session_start();

// Configuración de zona horaria
date_default_timezone_set('America/La_Paz');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// URLs base - Cambia 'Mercado_Jacha' por el nombre de TU carpeta
define('BASE_URL', 'http://localhost/Mercado_Jacha/');
define('BASE_PATH', dirname(__DIR__) . '/');

// NUEVOS COLORES DEL SISTEMA
define('COLOR_PRIMARY', '#fa7136');    // Naranja intenso
define('COLOR_SECONDARY', '#1a4147');  // Verde azulado oscuro
define('COLOR_BACKGROUND', '#FDFBF7'); // Blanco hueso
define('COLOR_TEXT', '#2D2D2D');       // Negro
?>