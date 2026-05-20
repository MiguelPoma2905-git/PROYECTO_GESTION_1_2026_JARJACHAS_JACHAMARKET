<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\PlantillaRepository;

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
            'success' => $success
        ]);
    }

    public function showCrearNegocio(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $this->redirect(BASE_URL . '/perfil?error=No tienes el rol de emprendedor');
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

            if (empty($nombreComercial)) {
                $error = 'El nombre comercial es obligatorio';
            } else {
                try {
                    $this->emprendimientoRepo->insert([
                        'nombre_comercial' => $nombreComercial,
                        'nit' => $nit,
                        'descripcion' => $descripcion,
                        'id_plantilla' => $plantillaId,
                        'color_primario' => $plantilla['color_primario'],
                        'color_secundario' => $plantilla['color_secundario']
                    ], $usuario['id']);

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
            $this->redirect(BASE_URL . '/dashboard?error=No tienes permisos');
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_plantilla' => $_POST['id_plantilla'] ?? $personalizacion['id_plantilla'],
                'color_primario' => $_POST['color_primario'] ?? null,
                'color_secundario' => $_POST['color_secundario'] ?? null,
                'color_fondo' => $_POST['color_fondo'] ?? null,
                'modo_oscuro' => isset($_POST['modo_oscuro']) ? 1 : 0
            ];
            $this->emprendimientoRepo->updatePersonalizacion((int)$idEmprendimiento, $data);
            $this->redirect(BASE_URL . '/plantillas?id_emprendimiento=' . $idEmprendimiento . '&success=1');
        }

        $this->view('dashboard/plantillas', [
            'emprendimiento' => $emprendimiento,
            'personalizacion' => $personalizacion,
            'plantillas' => $plantillas
        ]);
    }
}
