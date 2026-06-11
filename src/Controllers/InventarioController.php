<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\InventarioRepository;
use App\Repositories\KardexRepository;
use App\Repositories\VarianteRepository;
use App\Repositories\SucursalRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;

class InventarioController extends Controller
{
    private InventarioRepository $inventarioRepo;
    private KardexRepository $kardexRepo;
    private VarianteRepository $varianteRepo;
    private SucursalRepository $sucursalRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;

    public function __construct()
    {
        parent::__construct();
        $this->inventarioRepo = new InventarioRepository();
        $this->kardexRepo = new KardexRepository();
        $this->varianteRepo = new VarianteRepository();
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
        $filtroSucursal = (int)($_GET['id_sucursal'] ?? 0);

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

        $sucursales = $negocioSeleccionado ? $this->sucursalRepo->findAllByEmprendimiento($idEmprendimiento) : [];
        $inventario = $negocioSeleccionado ? $this->inventarioRepo->findByEmprendimiento($idEmprendimiento, $filtroSucursal ?: null) : [];
        $totalAlertas = $negocioSeleccionado ? $this->inventarioRepo->countAlertasByEmprendimiento($idEmprendimiento) : 0;
        $totalStockCero = $negocioSeleccionado ? $this->inventarioRepo->countStockCeroByEmprendimiento($idEmprendimiento) : 0;
        $valorTotal = $negocioSeleccionado ? $this->inventarioRepo->getValorTotalByEmprendimiento($idEmprendimiento) : 0;

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'ajustar') {
                $idInventario = (int)($_POST['id_inventario'] ?? 0);
                $nuevaCantidad = (int)($_POST['cantidad'] ?? 0);
                $observacion = trim($_POST['observacion'] ?? 'Ajuste manual');

                if ($nuevaCantidad < 0) $nuevaCantidad = 0;

                $inv = $this->inventarioRepo->findById($idInventario);
                if ($inv) {
                    $diferencia = $nuevaCantidad - $inv['cantidad_actual'];
                    $this->inventarioRepo->ajustarStock($idInventario, $nuevaCantidad);

                    $tipo = $diferencia > 0 ? 'Ingreso_Compra' : 'Ajuste_Perdida';
                    $this->kardexRepo->insert($idInventario, $tipo, abs($diferencia), (int)$usuario['id'], $observacion);
                    $success = 'Stock actualizado correctamente';
                } else {
                    $error = 'Registro de inventario no encontrado';
                }
            } elseif ($accion === 'transferir') {
                $idVariante = (int)($_POST['id_variante'] ?? 0);
                $idOrigen = (int)($_POST['id_sucursal_origen'] ?? 0);
                $idDestino = (int)($_POST['id_sucursal_destino'] ?? 0);
                $cantidad = (int)($_POST['cantidad'] ?? 0);

                if ($idOrigen === $idDestino) {
                    $error = 'La sucursal de origen y destino deben ser diferentes';
                } elseif ($cantidad <= 0) {
                    $error = 'La cantidad debe ser mayor a 0';
                } else {
                    $origenInv = $this->inventarioRepo->findByVarianteAndSucursal($idVariante, $idOrigen);
                    if (!$origenInv || $origenInv['cantidad_actual'] < $cantidad) {
                        $error = 'Stock insuficiente en la sucursal de origen';
                    } else {
                        $destinoInv = $this->inventarioRepo->findByVarianteAndSucursal($idVariante, $idDestino);
                        if (!$destinoInv) {
                            $destinoId = $this->inventarioRepo->createIfNotExists($idVariante, $idDestino, 0, 5);
                        } else {
                            $destinoId = (int)$destinoInv['id_inventario'];
                        }

                        $this->inventarioRepo->ajustarStock((int)$origenInv['id_inventario'], $origenInv['cantidad_actual'] - $cantidad);
                        $this->inventarioRepo->ajustarStock($destinoId, ($destinoInv['cantidad_actual'] ?? 0) + $cantidad);

                        $obsOrigen = "Transferencia a sucursal ID $idDestino";
                        $obsDestino = "Transferencia desde sucursal ID $idOrigen";
                        $this->kardexRepo->insert((int)$origenInv['id_inventario'], 'Transferencia', $cantidad, (int)$usuario['id'], $obsOrigen);
                        $this->kardexRepo->insert($destinoId, 'Transferencia', $cantidad, (int)$usuario['id'], $obsDestino);
                        $success = 'Transferencia realizada correctamente';
                    }
                }
            } elseif ($accion === 'alerta') {
                $idInventario = (int)($_POST['id_inventario'] ?? 0);
                $alerta = (int)($_POST['alerta_minima'] ?? 5);
                $this->inventarioRepo->updateAlertaMinima($idInventario, $alerta);
                $success = 'Alerta mínima actualizada';
            }
        }

        $sucursalesList = $sucursales;

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));
        $esAdmin = in_array('Administrador', $rolesNombres);
        $rolActivo = $_SESSION['rol_activo'] ?? $rolesNombres[0] ?? 'Cliente';

        $this->view('dashboard/inventario', [
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
            'sucursales' => $sucursalesList,
            'sucursales_all' => $sucursalesList,
            'inventario' => $inventario,
            'filtro_sucursal' => $filtroSucursal,
            'total_alertas' => $totalAlertas,
            'total_stock_cero' => $totalStockCero,
            'valor_total' => $valorTotal,
            'success' => $success,
            'error' => $error,
        ]);
    }

    public function kardex(): void
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

        $filtroTipo = $_GET['tipo'] ?? '';
        $filtroDesde = $_GET['desde'] ?? '';
        $filtroHasta = $_GET['hasta'] ?? '';
        $filtroSucursal = (int)($_GET['id_sucursal'] ?? 0);

        $movimientos = $negocioSeleccionado
            ? $this->kardexRepo->findByEmprendimiento(
                $idEmprendimiento,
                $filtroTipo ?: null,
                $filtroDesde ?: null,
                $filtroHasta ?: null,
                $filtroSucursal ?: null,
                200
              )
            : [];

        $sucursales = $negocioSeleccionado ? $this->sucursalRepo->findAllByEmprendimiento($idEmprendimiento) : [];

        $avatarUsuario = $this->usuarioRepo->getAvatar($usuario['id']);
        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id']);
        $inicial = strtoupper(substr($usuario['nombre'], 0, 1));
        $esAdmin = in_array('Administrador', $rolesNombres);
        $rolActivo = $_SESSION['rol_activo'] ?? $rolesNombres[0] ?? 'Cliente';

        $tiposKardex = ['Ingreso_Compra', 'Salida_Venta', 'Ajuste_Perdida', 'Transferencia'];

        $this->view('dashboard/kardex', [
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
            'movimientos' => $movimientos,
            'filtro_tipo' => $filtroTipo,
            'filtro_desde' => $filtroDesde,
            'filtro_hasta' => $filtroHasta,
            'filtro_sucursal' => $filtroSucursal,
            'tipos_kardex' => $tiposKardex,
        ]);
    }
}
