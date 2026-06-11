<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\ProductoRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\VarianteRepository;
use App\Repositories\InventarioRepository;
use App\Repositories\CategoriaRepository;

class ProductoController extends Controller
{
    private ProductoRepository $productoRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;
    private VarianteRepository $varianteRepo;
    private InventarioRepository $inventarioRepo;
    private CategoriaRepository $categoriaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->productoRepo = new ProductoRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
        $this->varianteRepo = new VarianteRepository();
        $this->inventarioRepo = new InventarioRepository();
        $this->categoriaRepo = new CategoriaRepository();
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

        $idCategoria = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? (int)$_GET['categoria'] : null;
        $allProductos = $this->productoRepo->findPublishedByEmprendimiento($idEmprendimiento);

        if ($idCategoria) {
            $productos = array_filter($allProductos, fn($p) => (int)($p['id_categoria'] ?? 0) === $idCategoria);
        } else {
            $productos = $allProductos;
        }

        $sucursal = $this->emprendimientoRepo->findSucursalByEmprendimiento($idEmprendimiento);
        $categorias = $this->categoriaRepo->getTree();

        $this->view('shop/tienda', [
            'emprendimiento' => $emprendimiento,
            'productos' => $productos,
            'categorias' => $categorias,
            'categoria_seleccionada' => $idCategoria,
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
            $precioCosto = $_POST['precio_costo'] !== '' ? (float)($_POST['precio_costo'] ?? 0) : null;
            $descripcion = trim($_POST['descripcion'] ?? '');
            $estado = $_POST['estado'] ?? 'Borrador';
            $stock = (int)($_POST['stock'] ?? 0);

            $idCategoria = $_POST['id_categoria'] !== '' ? (int)$_POST['id_categoria'] : null;

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

            $maxFileSize = 500 * 1024;
            $imagenBlob = null;
            $imagenMime = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                if ($_FILES['imagen']['size'] > $maxFileSize) {
                    $error = 'La imagen supera el tamaño máximo de 500 KB';
                } else {
                    $imagenBlob = file_get_contents($_FILES['imagen']['tmp_name']);
                    $imagenMime = mime_content_type($_FILES['imagen']['tmp_name']) ?: 'image/jpeg';
                }
            }

            $eliminarImagen = !empty($_POST['eliminar_imagen']);

            if ($error) {
                // skip
            } elseif (empty($nombre)) {
                $error = 'El nombre del producto es obligatorio';
            } elseif ($precioBase <= 0) {
                $error = 'El precio debe ser mayor a 0';
            } else {
                if ($idProducto > 0) {
                    $this->productoRepo->update($idProducto, $idEmprendimiento, [
                        'nombre' => $nombre,
                        'precio_base' => $precioBase,
                        'precio_costo' => $precioCosto,
                        'descripcion' => $descripcion,
                        'atributos' => $atributosJson,
                        'estado' => $estado,
                        'stock' => $stock,
                        'id_categoria' => $idCategoria,
                        'imagen_blob' => $imagenBlob,
                        'imagen_mime' => $imagenMime,
                        'eliminar_imagen' => $eliminarImagen
                    ]);
                } else {
                    $idProducto = $this->productoRepo->insert([
                        'nombre' => $nombre,
                        'precio_base' => $precioBase,
                        'precio_costo' => $precioCosto,
                        'descripcion' => $descripcion,
                        'atributos' => $atributosJson,
                        'estado' => $estado,
                        'stock' => $stock,
                        'id_categoria' => $idCategoria,
                        'imagen_blob' => $imagenBlob,
                        'imagen_mime' => $imagenMime
                    ], $idEmprendimiento);
                }

                // Process variantes
                $skuList = $_POST['variante_sku'] ?? [];
                $attr1List = $_POST['variante_atributo_1'] ?? [];
                $val1List = $_POST['variante_valor_1'] ?? [];
                $attr2List = $_POST['variante_atributo_2'] ?? [];
                $val2List = $_POST['variante_valor_2'] ?? [];
                $precioAdicionalList = $_POST['variante_precio'] ?? [];

                if (!empty($skuList) && is_array($skuList)) {
                    $this->varianteRepo->deleteByProducto($idProducto);
                    foreach ($skuList as $i => $sku) {
                        $sku = trim($sku);
                        if ($sku === '') continue;
                        if ($this->varianteRepo->skuExists($sku)) {
                            $error = "El SKU '$sku' ya existe en otro producto";
                            break;
                        }
                        $vid = $this->varianteRepo->insert([
                            'id_producto' => $idProducto,
                            'sku' => $sku,
                            'atributo_1' => trim($attr1List[$i] ?? ''),
                            'valor_1' => trim($val1List[$i] ?? ''),
                            'atributo_2' => trim($attr2List[$i] ?? ''),
                            'valor_2' => trim($val2List[$i] ?? ''),
                            'precio_adicional' => (float)($precioAdicionalList[$i] ?? 0),
                        ]);
                        if (!$error) {
                            $this->inventarioRepo->autoCreateForNuevaVariante($vid, $idProducto);
                        }
                    }
                }

                if (!$error) {
                    $this->redirect(BASE_URL . '/productos?id_emprendimiento=' . $idEmprendimiento . '&success=1');
                }
            }
        }

        $productoEditar = null;
        $variantesEdit = [];
        if (isset($_GET['edit']) && is_numeric($_GET['edit']) && $negocioSeleccionado) {
            $productoEditar = $this->productoRepo->findByIdAndEmprendimiento((int)$_GET['edit'], $idEmprendimiento);
            if ($productoEditar && $productoEditar['atributos']) {
                $productoEditar['atributos_arr'] = json_decode($productoEditar['atributos'], true);
            }
            $variantesEdit = $this->varianteRepo->findByProducto((int)$_GET['edit']);
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && $negocioSeleccionado) {
            $this->productoRepo->delete((int)$_GET['id'], $idEmprendimiento);
            $this->redirect(BASE_URL . '/productos?id_emprendimiento=' . $idEmprendimiento . '&deleted=1');
        }

        $categorias = $this->categoriaRepo->getTree();
        $selectedCatId = $productoEditar['id_categoria'] ?? null;

        $this->view('dashboard/productos-admin', [
            'usuario' => $usuario,
            'negocios' => $negocios,
            'id_emprendimiento' => $idEmprendimiento,
            'negocio_seleccionado' => $negocioSeleccionado,
            'productos' => $productos,
            'producto_editar' => $productoEditar,
            'variantes' => $variantesEdit,
            'categorias' => $categorias,
            'selected_categoria' => $selectedCatId,
            'mensaje' => $mensaje,
            'error' => $error
        ]);
    }
}
