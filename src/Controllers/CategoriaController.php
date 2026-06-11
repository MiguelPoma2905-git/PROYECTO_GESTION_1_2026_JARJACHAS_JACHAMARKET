<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CategoriaRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;

class CategoriaController extends Controller
{
    private CategoriaRepository $categoriaRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;

    public function __construct()
    {
        parent::__construct();
        $this->categoriaRepo = new CategoriaRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    public function index(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];
        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        $esAdmin = in_array('Administrador', $rolesNombres);
        $esEmprendedor = in_array('Emprendedor', $rolesNombres);

        if (!$esAdmin && !$esEmprendedor) {
            $this->redirect(BASE_URL . '/dashboard');
        }

        $idEmprendimiento = (int)($_GET['id_emprendimiento'] ?? 0);
        $misNegocios = $esEmprendedor ? $this->emprendimientoRepo->findByPropietario($usuario['id']) : [];
        $negocioSeleccionado = null;

        if ($esEmprendedor) {
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
        }

        $error = '';
        $success = '';

        // Delete
        if (isset($_GET['delete'])) {
            $idDelete = (int)$_GET['delete'];
            if ($this->categoriaRepo->hasProducts($idDelete)) {
                $error = 'No se puede eliminar: hay productos asignados a esta categoría';
            } elseif ($this->categoriaRepo->hasChildren($idDelete)) {
                $error = 'No se puede eliminar: tiene subcategorías. Elimina primero las hijas.';
            } else {
                $this->categoriaRepo->delete($idDelete);
                $success = 'Categoría eliminada correctamente';
                $this->redirect(BASE_URL . '/categorias' . ($idEmprendimiento ? '?id_emprendimiento=' . $idEmprendimiento : ''));
            }
        }

        // POST (create/edit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $idPadre = $_POST['id_padre'] !== '' ? (int)$_POST['id_padre'] : null;
            $editId = (int)($_POST['id_categoria'] ?? 0);

            if (empty($nombre)) {
                $error = 'El nombre es obligatorio';
            } elseif (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $nombre), '-'));
            }

            if (!$error && $this->categoriaRepo->slugExists($slug, $editId ?: null)) {
                $error = "El slug '$slug' ya existe";
            }

            if (!$error) {
                $data = ['nombre' => $nombre, 'slug' => $slug, 'id_padre' => $idPadre];
                if ($editId > 0) {
                    $this->categoriaRepo->update($editId, $data);
                    $success = 'Categoría actualizada correctamente';
                } else {
                    $this->categoriaRepo->insert($data);
                    $success = 'Categoría creada correctamente';
                }
            }
        }

        $tree = $this->categoriaRepo->getTree($idEmprendimiento ?: null);
        $editCategoria = null;
        if (isset($_GET['edit'])) {
            $editCategoria = $this->categoriaRepo->findById((int)$_GET['edit']);
        }

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));
        $rolActivo = $_SESSION['rol_activo'] ?? $rolesNombres[0] ?? 'Cliente';

        $treeHtml = $this->categoriaRepo->renderTreeHtml($tree);
        $selectedPadre = $editCategoria['id_padre'] ?? '';
        $optionsHtml = $this->categoriaRepo->renderTreeOptions($tree, 0, $selectedPadre ? (int)$selectedPadre : 0);

        $this->view('dashboard/categorias', [
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
            'tree' => $tree,
            'edit_categoria' => $editCategoria,
            'tree_html' => $treeHtml,
            'options_html' => $optionsHtml,
            'success' => $success,
            'error' => $error,
        ]);
    }
}
