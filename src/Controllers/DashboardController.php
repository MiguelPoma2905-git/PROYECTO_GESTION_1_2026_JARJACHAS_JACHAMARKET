<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\PlantillaRepository;
use App\Repositories\PedidoRepository;

class DashboardController extends Controller
{
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;
    private PlantillaRepository $plantillaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
        $this->plantillaRepo = new PlantillaRepository();
    }

    public function dashboard(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];
        $db = $this->getDB();

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);

        if (!isset($_SESSION['rol_activo']) || !in_array($_SESSION['rol_activo'], $rolesNombres)) {
            $_SESSION['rol_activo'] = $rolesNombres[0] ?? 'Cliente';
        }
        $rolActivo = $_SESSION['rol_activo'];

        if (isset($_GET['cambiar_rol']) && in_array($_GET['cambiar_rol'], $rolesNombres)) {
            $_SESSION['rol_activo'] = $_GET['cambiar_rol'];
            $rolActivo = $_GET['cambiar_rol'];
            $this->redirect(BASE_URL . '/dashboard');
        }

        $misNegocios = [];
        if (in_array('Emprendedor', $rolesNombres)) {
            $misNegocios = $this->emprendimientoRepo->findByPropietario($usuario['id']);
        }

        $otrosNegocios = [];
        if (in_array('Cliente', $rolesNombres)) {
            $otrosNegocios = $this->emprendimientoRepo->findAprobadosExcept($usuario['id']);
        }

        $stats = [
            'total_negocios' => $this->emprendimientoRepo->countAll(),
            'total_usuarios' => $this->emprendimientoRepo->countAllUsuarios(),
            'total_productos' => 0
        ];
        $stmt = $db->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'Publicado'");
        $stats['total_productos'] = (int)$stmt->fetch()['total'];

        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));

        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id']);
        $success = isset($_GET['success']) ? 1 : 0;
        $esAdmin = in_array('Administrador', $rolesNombres);

        $this->view('dashboard/principal', [
            'usuario' => $usuario,
            'avatar_usuario' => $avatarUsuario,
            'roles_usuario' => $rolesUsuario,
            'roles_nombres' => $rolesNombres,
            'rol_activo' => $rolActivo,
            'mis_negocios' => $misNegocios,
            'otros_negocios' => $otrosNegocios,
            'stats' => $stats,
            'inicial' => $inicial,
            'success' => $success,
            'es_admin' => $esAdmin
        ]);
    }

    public function estadisticasCliente(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];
        $pedidoRepo = new PedidoRepository();
        $usuarioRepo = new UsuarioRepository();

        $rolesNombres = $usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Cliente', $rolesNombres)) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $statsCliente = $pedidoRepo->getStatsCliente($usuario['id']);
        $pedidos = $pedidoRepo->getPedidosByCliente($usuario['id']);
        $avatarUsuario = $usuarioRepo->getAvatar($usuario['id']);
        $rolesUsuario = $usuarioRepo->getRoles($usuario['id']);

        $_SESSION['rol_activo'] = 'Cliente';
        $rolActivo = 'Cliente';

        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));
        $esAdmin = in_array('Administrador', $rolesNombres);

        $this->view('dashboard/cliente-estadisticas', [
            'usuario' => $usuario,
            'avatar_usuario' => $avatarUsuario,
            'roles_usuario' => $rolesUsuario,
            'roles_nombres' => $rolesNombres,
            'rol_activo' => $rolActivo,
            'stats' => $statsCliente,
            'pedidos' => $pedidos,
            'inicial' => $inicial,
            'es_admin' => $esAdmin
        ]);
    }

    public function showCrearNegocio(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $_SESSION['perfil_error'] = 'Solo los emprendedores pueden crear negocios.';
            $this->redirect(BASE_URL . '/perfil');
        }

        $plantillaId = $_GET['plantilla'] ?? 0;
        if (!$plantillaId) {
            $this->redirect(BASE_URL . '/plantillas-disponibles');
        }

        $plantilla = $this->plantillaRepo->findById((int)$plantillaId);
        if (!$plantilla) {
            $this->redirect(BASE_URL . '/plantillas-disponibles');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreComercial = trim($_POST['nombre_comercial'] ?? '');
            $nit = trim($_POST['nit'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if (empty($nombreComercial)) {
                $error = 'El nombre comercial es obligatorio';
            } else {
                $portadaBlob = null;
                $portadaMime = null;
                if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $portadaBlob = file_get_contents($_FILES['portada']['tmp_name']);
                        $mimeMap = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
                        $portadaMime = $mimeMap[$ext] ?? 'image/jpeg';
                    }
                }
                try {
                    $idEmprendimiento = $this->emprendimientoRepo->insert([
                        'nombre_comercial' => $nombreComercial,
                        'nit' => $nit,
                        'descripcion' => $descripcion,
                        'direccion' => $direccion,
                        'ciudad' => $ciudad,
                        'telefono' => $telefono,
                        'id_plantilla' => $plantillaId,
                        'color_primario' => $plantilla['color_primario'],
                        'color_secundario' => $plantilla['color_secundario'],
                        'color_texto' => $plantilla['color_texto'] ?? '#1A1A2E',
                    ], $usuario['id']);

                    if ($portadaBlob) {
                        $this->emprendimientoRepo->updatePersonalizacion($idEmprendimiento, [
                            'portada_blob' => $portadaBlob,
                            'portada_mime' => $portadaMime
                        ]);
                    }

                    $this->redirect(BASE_URL . '/dashboard?success=1');
                } catch (\Exception $e) {
                    $error = 'Error al crear el negocio: ' . $e->getMessage();
                }
            }
        }

        $this->view('dashboard/crear-negocio', [
            'plantilla' => $plantilla,
            'error' => $error
        ]);
    }

    public function showPlantillas(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $_SESSION['perfil_error'] = 'Solo los emprendedores pueden personalizar tiendas.';
            $this->redirect(BASE_URL . '/perfil');
        }

        $idEmprendimiento = $_GET['id_emprendimiento'] ?? 0;

        if (!$idEmprendimiento) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $emprendimiento = $this->emprendimientoRepo->findByIdAndPropietario((int)$idEmprendimiento, $usuario['id']);
        if (!$emprendimiento) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $personalizacion = $this->emprendimientoRepo->getPersonalizacion((int)$idEmprendimiento);

        if (!$personalizacion) {
            $this->emprendimientoRepo->createDefaultPersonalizacion((int)$idEmprendimiento);
            $this->redirect(BASE_URL . '/plantillas?id_emprendimiento=' . $idEmprendimiento);
        }

        $plantillas = $this->plantillaRepo->findAllActive();

        // AJAX preview request
        if (isset($_POST['preview_ajax'])) {
            $previewId = (int)($_POST['id_plantilla'] ?? $personalizacion['id_plantilla']);
            $previewFile = match($previewId) {
                6 => 'electrodomesticos.php',
                4 => 'tecnologico.php',
                7 => 'modaviva.php',
                8 => 'sabores.php',
                9 => 'artesano.php',
                10 => 'glowup.php',
                11 => 'fullfit.php',
                12 => 'hogardulce.php',
                default => 'default.php',
            };
            $plantillaData = $this->plantillaRepo->findById($previewId);
            if ($plantillaData) {
                $personalizacion['id_plantilla'] = $previewId;
                $personalizacion['color_primario'] = $plantillaData['color_primario'] ?? '#1A3A5C';
                $personalizacion['color_secundario'] = $plantillaData['color_secundario'] ?? '#2C6FBB';
                $personalizacion['color_fondo'] = $plantillaData['color_fondo'] ?? '#FDFBF7';
                $personalizacion['color_texto'] = $plantillaData['color_texto'] ?? '#1A1A2E';
            }
            header('Content-Type: text/html; charset=utf-8');
            include BASE_PATH . 'src/Views/dashboard/previews/' . $previewFile;
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_plantilla' => $_POST['id_plantilla'] ?? $personalizacion['id_plantilla'],
                'color_primario' => $_POST['color_primario'] ?? null,
                'color_secundario' => $_POST['color_secundario'] ?? null,
                'color_fondo' => $_POST['color_fondo'] ?? null,
                'color_texto' => $_POST['color_texto'] ?? null,
                'modo_oscuro' => isset($_POST['modo_oscuro']) ? 1 : 0,
                'tipografia' => $_POST['tipografia'] ?? 'Inter',
                'faqs' => $_POST['faqs'] ?? null
            ];

            // Handle logo upload
            if (isset($_FILES['logo_personalizado']) && $_FILES['logo_personalizado']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['logo_personalizado']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $data['logo_blob'] = file_get_contents($_FILES['logo_personalizado']['tmp_name']);
                    $mimeMap = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
                    $data['logo_mime'] = $mimeMap[$ext] ?? 'image/jpeg';
                }
            }

            // Handle banner upload
            if (isset($_FILES['banner_personalizado']) && $_FILES['banner_personalizado']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['banner_personalizado']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $data['banner_blob'] = file_get_contents($_FILES['banner_personalizado']['tmp_name']);
                    $mimeMap = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
                    $data['banner_mime'] = $mimeMap[$ext] ?? 'image/jpeg';
                }
            }

            // Handle logo removal
            if (isset($_POST['eliminar_logo']) && $_POST['eliminar_logo'] === '1') {
                $data['eliminar_logo'] = true;
            }

            // Handle banner removal
            if (isset($_POST['eliminar_banner']) && $_POST['eliminar_banner'] === '1') {
                $data['eliminar_banner'] = true;
            }

            $this->emprendimientoRepo->updatePersonalizacion((int)$idEmprendimiento, $data);
            $this->redirect(BASE_URL . '/plantillas?id_emprendimiento=' . $idEmprendimiento . '&success=1');
        }

        $this->view('dashboard/plantillas', [
            'emprendimiento' => $emprendimiento,
            'personalizacion' => $personalizacion,
            'plantillas' => $plantillas
        ]);
    }

    public function repartidoresAdmin(): void
    {
        $this->requireAuth();
        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $idEmprendimiento = (int)($_GET['id_emprendimiento'] ?? 0);
        $negocios = $this->emprendimientoRepo->findByPropietario($usuario['id']);
        $negocioSeleccionado = null;
        $repartidores = [];

        if ($idEmprendimiento > 0) {
            foreach ($negocios as $n) {
                if ($n['id_emprendimiento'] === $idEmprendimiento) {
                    $negocioSeleccionado = $n;
                    break;
                }
            }
            if ($negocioSeleccionado) {
                $repartidores = $this->emprendimientoRepo->listarRepartidores($idEmprendimiento);
            }
        }

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));

        $this->view('dashboard/repartidores-admin', [
            'usuario' => $usuario,
            'avatar_usuario' => $avatarUsuario,
            'inicial' => $inicial,
            'negocios' => $negocios,
            'id_emprendimiento' => $idEmprendimiento,
            'negocio_seleccionado' => $negocioSeleccionado,
            'repartidores' => $repartidores,
            'success' => $_GET['success'] ?? '',
            'error' => $_GET['error'] ?? ''
        ]);
    }

    public function repartidoresVincular(): void
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $usuario = $_SESSION['usuario'];
        $idEmprendimiento = (int)($_POST['id_emprendimiento'] ?? 0);
        $email = trim($_POST['email'] ?? '');

        $emprendimiento = $this->emprendimientoRepo->findByIdAndPropietario($idEmprendimiento, $usuario['id']);
        if (!$emprendimiento) {
            $this->redirect(BASE_URL . '/repartidores-admin?error=Negocio no válido');
        }

        if (empty($email)) {
            $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&error=Debes ingresar un correo electrónico');
        }

        $repartidorUser = $this->usuarioRepo->findByEmail($email);
        if (!$repartidorUser) {
            $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&error=No se encontró ningún usuario con ese correo electrónico o no se encuentra activo');
        }

        $repartidorRoles = $this->usuarioRepo->getRolesNombres($repartidorUser['id_usuario']);
        if (!in_array('Repartidor', $repartidorRoles)) {
            $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&error=El usuario con ese correo electrónico no tiene asignado el rol de Repartidor');
        }

        try {
            $this->emprendimientoRepo->agregarRepartidor($idEmprendimiento, $repartidorUser['id_usuario']);
            $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&success=Repartidor vinculado correctamente');
        } catch (\Exception $e) {
            $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&error=El repartidor ya está vinculado a este negocio');
        }
    }

    public function repartidoresDesvincular(): void
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $usuario = $_SESSION['usuario'];
        $idEmprendimiento = (int)($_POST['id_emprendimiento'] ?? 0);
        $idRepartidor = (int)($_POST['id_repartidor'] ?? 0);

        $emprendimiento = $this->emprendimientoRepo->findByIdAndPropietario($idEmprendimiento, $usuario['id']);
        if (!$emprendimiento) {
            $this->redirect(BASE_URL . '/repartidores-admin?error=Negocio no válido');
        }

        $this->emprendimientoRepo->quitarRepartidor($idEmprendimiento, $idRepartidor);
        $this->redirect(BASE_URL . '/repartidores-admin?id_emprendimiento=' . $idEmprendimiento . '&success=Repartidor quitado del negocio');
    }

    public function repartidorSolicitudes(): void
    {
        $this->requireAuth();
        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Repartidor', $rolesNombres)) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $idRepartidor = (int)$usuario['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validate_csrf_token($_POST['csrf_token'] ?? null)) {
                $this->redirect(BASE_URL . '/repartidor-solicitudes?error=Sesión inválida');
            }

            $idEmprendimiento = (int)($_POST['id_emprendimiento'] ?? 0);
            $accion = $_POST['accion'] ?? '';

            if ($idEmprendimiento <= 0 || !in_array($accion, ['aceptar', 'rechazar'])) {
                $this->redirect(BASE_URL . '/repartidor-solicitudes?error=Acción no válida');
            }

            $nuevoEstado = $accion === 'aceptar' ? 'Aceptado' : 'Rechazado';
            $this->emprendimientoRepo->actualizarEstadoRepartidor($idEmprendimiento, $idRepartidor, $nuevoEstado);

            $msg = $nuevoEstado === 'Aceptado' ? 'Solicitud aceptada correctamente' : 'Solicitud rechazada';
            $this->redirect(BASE_URL . '/repartidor-solicitudes?success=' . urlencode($msg));
        }

        $solicitudes = $this->emprendimientoRepo->listarSolicitudesRepartidor($idRepartidor);
        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));

        $this->view('dashboard/repartidor-solicitudes', [
            'usuario' => $usuario,
            'avatar_usuario' => $avatarUsuario,
            'inicial' => $inicial,
            'solicitudes' => $solicitudes,
            'success' => $_GET['success'] ?? '',
            'error' => $_GET['error'] ?? ''
        ]);
    }
}
