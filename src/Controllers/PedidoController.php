<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PedidoRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\UsuarioRepository;

class PedidoController extends Controller
{
    private PedidoRepository $pedidoRepo;
    private ProductoRepository $productoRepo;
    private EmprendimientoRepository $emprendimientoRepo;
    private UsuarioRepository $usuarioRepo;

    public function __construct()
    {
        parent::__construct();
        $this->pedidoRepo = new PedidoRepository();
        $this->productoRepo = new ProductoRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    public function crear(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/');
        }

        $result = $this->pedidoRepo->crearPedido($_POST);

        if ($result['success']) {
            $this->json($result);
        } else {
            $this->json($result, 400);
        }
    }

    public function comprarRapido(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'error' => 'Método no permitido'], 405);
            return;
        }

        $productoId = (int)($_POST['producto_id'] ?? 0);
        $cantidad = max(1, (int)($_POST['cantidad'] ?? 1));
        $direccion = trim($_POST['direccion'] ?? '');
        $metodoPago = $_POST['metodo_pago'] ?? 'QR';
        $usuarioId = (int)$_SESSION['usuario']['id'];

        if (!$productoId) {
            $this->json(['success' => false, 'error' => 'Producto no especificado'], 400);
            return;
        }

        $producto = $this->productoRepo->findById($productoId);
        if (!$producto || $producto['estado'] !== 'Publicado') {
            $this->json(['success' => false, 'error' => 'Producto no disponible'], 400);
            return;
        }

        if (empty($direccion)) {
            $usuario = $this->usuarioRepo->findById($usuarioId);
            $direccion = ($usuario['ubicacion'] ?? '') ?: 'Dirección no especificada';
        }

        $emprendimiento = $this->emprendimientoRepo->findById($producto['id_emprendimiento']);
        if (!$emprendimiento) {
            $this->json(['success' => false, 'error' => 'Emprendimiento no encontrado'], 400);
            return;
        }

        $db = $this->getDB();
        $stmt = $db->prepare("SELECT id_sucursal FROM sucursales WHERE id_emprendimiento = ? LIMIT 1");
        $stmt->execute([$producto['id_emprendimiento']]);
        $sucursal = $stmt->fetch();

        if (!$sucursal) {
            $this->json(['success' => false, 'error' => 'Este negocio no tiene sucursales configuradas'], 400);
            return;
        }

        $subtotal = $producto['precio_base'] * $cantidad;
        $costoEnvio = 15.00;
        $total = $subtotal + $costoEnvio;

        $result = $this->pedidoRepo->crearPedido([
            'id_cliente' => $usuarioId,
            'id_sucursal' => $sucursal['id_sucursal'],
            'subtotal' => $subtotal,
            'costo_envio' => $costoEnvio,
            'total' => $total,
            'metodo_pago' => $metodoPago,
            'direccion' => $direccion,
            'items' => [
                [
                    'id_variante' => $productoId,
                    'cantidad' => $cantidad,
                    'precio' => $producto['precio_base']
                ]
            ]
        ]);

        $this->json($result, $result['success'] ? 200 : 400);
    }
}
