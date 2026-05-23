<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\ProductoRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;

class ProductoController extends Controller
{
    private ProductoRepository $productoRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;

    public function __construct()
    {
        parent::__construct();
        $this->productoRepo = new ProductoRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    public function showTienda(array $params = []): void
    {
        $idEmprendimiento = (int)($params['id'] ?? $_GET['id'] ?? 0);
        if (!$idEmprendimiento) {
            $this->redirect(BASE_URL . '/');
        }

        $emprendimiento = $this->emprendimientoRepo->findById($idEmprendimiento);
        $esPropietario = false;

        if (!$emprendimiento && isset($_SESSION['usuario'])) {
            $emprendimiento = $this->emprendimientoRepo->findByIdAndPropietario($idEmprendimiento, $_SESSION['usuario']['id']);
            if ($emprendimiento) {
                $esPropietario = true;
            }
        }

        if (!$emprendimiento) {
            $this->redirect(BASE_URL . '/');
        }

        if (isset($_SESSION['usuario']) && (int)$emprendimiento['id_propietario'] === (int)$_SESSION['usuario']['id']) {
            $esPropietario = true;
        }

        $productos = $this->productoRepo->findPublishedByEmprendimiento($idEmprendimiento);
        $sucursal = $this->emprendimientoRepo->findSucursalByEmprendimiento($idEmprendimiento);

        $this->view('shop/tienda', [
            'emprendimiento' => $emprendimiento,
            'productos' => $productos,
            'es_propietario' => $esPropietario,
            'sucursal' => $sucursal
        ]);
    }

    public function index(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];

        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id']);
        if (!in_array('Emprendedor', $rolesNombres)) {
            $this->redirect(BASE_URL . '/dashboard?error=No tienes permisos de vendedor');
        }

        $negocios = $this->emprendimientoRepo->findByPropietario($usuario['id']);

        $idEmprendimiento = (int)($_GET['id_emprendimiento'] ?? 0);
        $negocioSeleccionado = null;
        $productos = [];

        if ($idEmprendimiento) {
            foreach ($negocios as $n) {
                if ($n['id_emprendimiento'] == $idEmprendimiento) {
                    $negocioSeleccionado = $n;
                    break;
                }
            }

            if ($negocioSeleccionado) {
                $productos = $this->productoRepo->findByEmprendimiento($idEmprendimiento);
            }
        }

        $mensaje = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $negocioSeleccionado) {
            $idProducto = (int)($_POST['id_producto'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $precioBase = (float)($_POST['precio_base'] ?? 0);
            $descripcion = trim($_POST['descripcion'] ?? '');
            $estado = $_POST['estado'] ?? 'Borrador';
            $stock = (int)($_POST['stock'] ?? 0);

            $atributos = [];
            $attrNames = $_POST['attr_nombre'] ?? [];
            $attrValues = $_POST['attr_valor'] ?? [];
            foreach ($attrNames as $i => $name) {
                $name = is_string($name) ? trim($name) : '';
                $value = isset($attrValues[$i]) && is_string($attrValues[$i]) ? trim($attrValues[$i]) : '';
                if ($name !== '' && $value !== '') {
                    $atributos[$name] = $value;
                }
            }
            $atributosJson = !empty($atributos) ? json_encode($atributos, JSON_UNESCAPED_UNICODE) : null;

            $imagenUrl = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . 'public/uploads/productos/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = 'prod_' . uniqid() . '.' . $extension;
                $ruta = $uploadDir . $nombreArchivo;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                    $imagenUrl = 'uploads/productos/' . $nombreArchivo;
                }
            }

            if (empty($nombre)) {
                $error = 'El nombre del producto es obligatorio';
            } elseif ($precioBase <= 0) {
                $error = 'El precio debe ser mayor a 0';
            } else {
                if ($idProducto > 0) {
                    $this->productoRepo->update($idProducto, $idEmprendimiento, [
                        'nombre' => $nombre,
                        'precio_base' => $precioBase,
                        'descripcion' => $descripcion,
                        'atributos' => $atributosJson,
                        'estado' => $estado,
                        'stock' => $stock,
                        'imagen_url' => $imagenUrl
                    ]);
                } else {
                    $this->productoRepo->insert([
                        'nombre' => $nombre,
                        'precio_base' => $precioBase,
                        'descripcion' => $descripcion,
                        'atributos' => $atributosJson,
                        'estado' => $estado,
                        'stock' => $stock,
                        'imagen_url' => $imagenUrl
                    ], $idEmprendimiento);
                }
                $this->redirect(BASE_URL . '/productos?id_emprendimiento=' . $idEmprendimiento . '&success=1');
            }
        }

        $productoEditar = null;
        if (isset($_GET['edit']) && is_numeric($_GET['edit']) && $negocioSeleccionado) {
            $productoEditar = $this->productoRepo->findByIdAndEmprendimiento((int)$_GET['edit'], $idEmprendimiento);
            if ($productoEditar && $productoEditar['atributos']) {
                $productoEditar['atributos_arr'] = json_decode($productoEditar['atributos'], true);
            }
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && $negocioSeleccionado) {
            $this->productoRepo->delete((int)$_GET['id'], $idEmprendimiento);
            $this->redirect(BASE_URL . '/productos?id_emprendimiento=' . $idEmprendimiento . '&deleted=1');
        }

        $this->view('dashboard/productos-admin', [
            'usuario' => $usuario,
            'negocios' => $negocios,
            'id_emprendimiento' => $idEmprendimiento,
            'negocio_seleccionado' => $negocioSeleccionado,
            'productos' => $productos,
            'producto_editar' => $productoEditar,
            'mensaje' => $mensaje,
            'error' => $error
        ]);
    }
}
