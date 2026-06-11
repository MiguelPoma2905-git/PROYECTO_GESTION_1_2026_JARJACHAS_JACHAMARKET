<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\SucursalRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;

class SucursalesController extends Controller
{
    private SucursalRepository $sucursalRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;

    public function __construct()
    {
        parent::__construct();
        $this->sucursalRepo = new SucursalRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    public function index(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];
        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $misNegocios = $this->emprendimientoRepo->findByPropietario($usuario['id']);
        $idEmprendimiento = (int)($_GET['id_emprendimiento'] ?? 0);

        $negocioSeleccionado = null;
        foreach ($misNegocios as $n) {
            if ($n['id_emprendimiento'] === $idEmprendimiento) {
                $negocioSeleccionado = $n;
                break;
            }
        }

        if (!$negocioSeleccionado && count($misNegocios) > 0) {
            $negocioSeleccionado = $misNegocios[0];
            $idEmprendimiento = $negocioSeleccionado['id_emprendimiento'];
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'crear' || $accion === 'editar') {
                $nombre = trim($_POST['nombre_sucursal'] ?? '');
                $direccion = trim($_POST['direccion'] ?? '');
                $ciudad = trim($_POST['ciudad'] ?? '');
                $latitud = trim($_POST['latitud'] ?? '');
                $longitud = trim($_POST['longitud'] ?? '');

                if (empty($nombre)) {
                    $error = 'El nombre de la sucursal es obligatorio';
                } elseif ($this->sucursalRepo->existsInEmprendimiento($nombre, $idEmprendimiento, $accion === 'editar' ? (int)($_POST['id_sucursal'] ?? 0) : null)) {
                    $error = 'Ya existe una sucursal con ese nombre en este negocio';
                } else {
                    $data = [
                        'nombre_sucursal' => $nombre,
                        'direccion' => $direccion,
                        'ciudad' => $ciudad,
                        'latitud' => $latitud,
                        'longitud' => $longitud,
                    ];
                    if ($accion === 'crear') {
                        $this->sucursalRepo->insert($data, $idEmprendimiento);
                        $success = 'Sucursal creada correctamente';
                    } else {
                        $idSucursal = (int)($_POST['id_sucursal'] ?? 0);
                        $this->sucursalRepo->update($idSucursal, $idEmprendimiento, $data);
                        $success = 'Sucursal actualizada correctamente';
                    }
                }
            } elseif ($accion === 'eliminar') {
                $idSucursal = (int)($_POST['id_sucursal'] ?? 0);
                $ok = $this->sucursalRepo->delete($idSucursal, $idEmprendimiento);
                $success = $ok ? 'Sucursal eliminada correctamente' : '';
                $error = $ok ? '' : 'No se pudo eliminar la sucursal';
            }
        }

        $sucursales = $this->sucursalRepo->findAllByEmprendimiento($idEmprendimiento);
        $editSucursal = null;
        if (isset($_GET['edit'])) {
            $editSucursal = $this->sucursalRepo->findByIdAndEmprendimiento((int)$_GET['edit'], $idEmprendimiento);
        }

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));
        $esAdmin = in_array('Administrador', $rolesNombres);
        $rolActivo = $_SESSION['rol_activo'] ?? $rolesNombres[0] ?? 'Cliente';

        $this->view('dashboard/sucursales', [
            'usuario' => $usuario,
            'avatar_usuario' => $avatarUsuario,
            'roles_usuario' => $rolesUsuario,
            'roles_nombres' => $rolesNombres,
            'rol_activo' => $rolActivo,
            'inicial' => $inicial,
            'es_admin' => $esAdmin,
            'mis_negocios' => $misNegocios,
            'negocio_seleccionado' => $negocioSeleccionado,
            'id_emprendimiento' => $idEmprendimiento,
            'sucursales' => $sucursales,
            'edit_sucursal' => $editSucursal,
            'success' => $success,
            'error' => $error,
        ]);
    }
}
