<?php
// Front Controller - Single entry point

$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die('Error: Ejecuta "composer install" primero.');
}
require_once $autoloadPath;

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
use App\Controllers\AdminController;
use App\Controllers\PerfilController;

$router = new Router();

// ===================== ROUTES =====================

// Home
$router->get('/', [HomeController::class, 'index']);
$router->get('/explorar', [HomeController::class, 'explorar']);

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
$router->post('/guardar-temp-avatar', [AuthController::class, 'guardarTempAvatar']);

// Dashboard
$router->get('/dashboard', [DashboardController::class, 'dashboard']);
$router->get('/mis-estadisticas', [DashboardController::class, 'estadisticasCliente']);
$router->match(['GET', 'POST'], '/crear-negocio', [DashboardController::class, 'showCrearNegocio']);
$router->match(['GET', 'POST'], '/plantillas', [DashboardController::class, 'showPlantillas']);

// Products
$router->get('/tienda/{id}', [ProductoController::class, 'showTienda']);
$router->match(['GET', 'POST'], '/productos', [ProductoController::class, 'index']);

// Plantillas disponibles
$router->get('/plantillas-disponibles', [PlantillaController::class, 'disponibles']);
$router->get('/plantilla/{id}', [PlantillaController::class, 'detalle']);

// Pedidos (JSON endpoints)
$router->post('/pedido/crear', [PedidoController::class, 'crear']);
$router->post('/pedido/comprar-rapido', [PedidoController::class, 'comprarRapido']);

// Repartidor
$router->get('/dashboard-repartidor', [RepartidorController::class, 'dashboard']);
$router->get('/repartidor/pedidos-pendientes', [RepartidorController::class, 'pedidosPendientes']);
$router->post('/repartidor/asignar', [RepartidorController::class, 'asignar']);
$router->post('/repartidor/entregar', [RepartidorController::class, 'entregar']);

// Perfil
$router->get('/perfil', [PerfilController::class, 'index']);
$router->post('/perfil/actualizar', [PerfilController::class, 'actualizar']);
$router->post('/perfil/quitar-repartidor', [PerfilController::class, 'quitarRepartidor']);
$router->post('/perfil/eliminar-negocio', [PerfilController::class, 'eliminarNegocio']);

// Admin
$router->get('/admin', [AdminController::class, 'panel']);
$router->post('/admin/eliminar-usuario', [AdminController::class, 'eliminarUsuario']);
$router->post('/admin/eliminar-negocio', [AdminController::class, 'eliminarNegocio']);
$router->post('/admin/reiniciar-bd', [AdminController::class, 'resetDb']);
$router->get('/admin/editar-usuario', [AdminController::class, 'editarUsuario']);
$router->post('/admin/editar-usuario/guardar', [AdminController::class, 'editarUsuarioGuardar']);
$router->get('/admin/ventas', [AdminController::class, 'ventas']);
$router->post('/admin/seed-demo', [AdminController::class, 'seedDemo']);

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

// Remove base path (project root, not including /public)
$basePath = dirname(dirname($_SERVER['SCRIPT_NAME']));
if ($basePath !== '/' && $basePath !== '\\') {
    $uri = substr($uri, strlen($basePath));
}

$uri = '/' . ltrim($uri, '/');

$router->dispatch($method, $uri);
