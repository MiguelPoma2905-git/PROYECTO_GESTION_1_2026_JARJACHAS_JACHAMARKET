<?php
// Front Controller - Single entry point

require_once __DIR__ . '/../vendor/autoload.php';

// Ensure global autoload for non-namespaced config classes
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/mail.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProductoController;
use App\Controllers\PlantillaController;
use App\Controllers\HomeController;
use App\Controllers\PedidoController;
use App\Controllers\RepartidorController;

$router = new Router();

// ===================== ROUTES =====================

// Home
$router->get('/', [HomeController::class, 'index']);

// Auth
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/registro', [AuthController::class, 'showRegisterForm']);
$router->post('/registro', [AuthController::class, 'register']);
$router->match(['GET', 'POST'], '/elegir-roles', [AuthController::class, 'showRoleSelection']);
$router->get('/verificar-otp', [AuthController::class, 'showVerificarOtp']);
$router->post('/verificar-otp', [AuthController::class, 'verifyOtp']);
$router->get('/verificar-otp-login', [AuthController::class, 'showVerificarOtpLogin']);
$router->post('/verificar-otp-login', [AuthController::class, 'verifyOtpLogin']);
$router->get('/enviar-otp', [AuthController::class, 'sendOtp']);
$router->get('/reenviar-otp', [AuthController::class, 'resendOtp']);
$router->get('/reenviar-otp-login', [AuthController::class, 'resendOtpLogin']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->match(['GET', 'POST'], '/selector-rol', [AuthController::class, 'showSelectorRol']);
$router->post('/guardar-temp-avatar', [AuthController::class, 'guardarTempAvatar']);

// Dashboard
$router->get('/dashboard', [DashboardController::class, 'dashboard']);
$router->match(['GET', 'POST'], '/crear-negocio', [DashboardController::class, 'showCrearNegocio']);
$router->match(['GET', 'POST'], '/plantillas', [DashboardController::class, 'showPlantillas']);

// Products
$router->get('/tienda/{id}', [ProductoController::class, 'showTienda']);
$router->match(['GET', 'POST'], '/productos', [ProductoController::class, 'index']);

// Plantillas disponibles
$router->get('/plantillas-disponibles', [PlantillaController::class, 'disponibles']);

// Pedidos (JSON endpoints)
$router->post('/pedido/crear', [PedidoController::class, 'crear']);

// Repartidor (JSON endpoints)
$router->get('/repartidor/pedidos-pendientes', [RepartidorController::class, 'pedidosPendientes']);
$router->post('/repartidor/asignar', [RepartidorController::class, 'asignar']);
$router->post('/repartidor/entregar', [RepartidorController::class, 'entregar']);

// DB Demo
$router->get('/db-demo', [HomeController::class, 'dbDemo']);

// ===================== BACKWARDS COMPATIBILITY (old .php URLs) =====================
$router->get('/login.php', [AuthController::class, 'showLoginForm']);
$router->post('/login_process.php', [AuthController::class, 'login']);
$router->get('/registro.php', [AuthController::class, 'showRegisterForm']);
$router->post('/registro_process.php', [AuthController::class, 'register']);
$router->match(['GET', 'POST'], '/elegir_roles.php', [AuthController::class, 'showRoleSelection']);
$router->get('/verificar_otp.php', [AuthController::class, 'showVerificarOtp']);
$router->post('/verificar_otp_process.php', [AuthController::class, 'verifyOtp']);
$router->get('/verificar_otp_login.php', [AuthController::class, 'showVerificarOtpLogin']);
$router->post('/verificar_otp_login_process.php', [AuthController::class, 'verifyOtpLogin']);
$router->get('/enviar_otp.php', [AuthController::class, 'sendOtp']);
$router->get('/reenviar_otp.php', [AuthController::class, 'resendOtp']);
$router->get('/reenviar_otp_login.php', [AuthController::class, 'resendOtpLogin']);
$router->get('/logout.php', [AuthController::class, 'logout']);
$router->match(['GET', 'POST'], '/selector_rol.php', [AuthController::class, 'showSelectorRol']);
$router->post('/guardar_temp_avatar.php', [AuthController::class, 'guardarTempAvatar']);
$router->get('/dashboard_principal.php', [DashboardController::class, 'dashboard']);
$router->match(['GET', 'POST'], '/crear_negocio.php', [DashboardController::class, 'showCrearNegocio']);
$router->match(['GET', 'POST'], '/plantillas.php', [DashboardController::class, 'showPlantillas']);
$router->get('/tienda.php', [ProductoController::class, 'showTienda']);
$router->match(['GET', 'POST'], '/productos_admin.php', [ProductoController::class, 'index']);
$router->get('/Plantillas_disponibles.php', [PlantillaController::class, 'disponibles']);
$router->get('/db_demo.php', [HomeController::class, 'dbDemo']);
$router->post('/crear_pedido.php', [PedidoController::class, 'crear']);
$router->get('/pedidos_pendientes.php', [RepartidorController::class, 'pedidosPendientes']);
$router->post('/asignar_repartidor.php', [RepartidorController::class, 'asignar']);
$router->post('/marcar_entregado.php', [RepartidorController::class, 'entregar']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string from URI for routing
$uri = strtok($uri, '?');

// Remove base path
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/' && $basePath !== '\\') {
    $uri = substr($uri, strlen($basePath));
}

$uri = '/' . ltrim($uri, '/');

$router->dispatch($method, $uri);
