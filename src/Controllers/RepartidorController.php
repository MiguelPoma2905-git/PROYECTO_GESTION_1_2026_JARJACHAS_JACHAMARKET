<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PedidoRepository;

class RepartidorController extends Controller
{
    private PedidoRepository $pedidoRepo;

    public function __construct()
    {
        parent::__construct();
        $this->pedidoRepo = new PedidoRepository();
    }

    public function dashboard(): void
    {
        $this->requireAuth();
        $usuario = $_SESSION['usuario'];
        $idRepartidor = (int)$usuario['id'];

        $pedidosPendientes = $this->pedidoRepo->getPedidosPendientesRepartidor();
        $misActivos = $this->pedidoRepo->getPedidosByRepartidor($idRepartidor);
        $historial = $this->pedidoRepo->getHistorialRepartidor($idRepartidor);
        $stats = $this->pedidoRepo->getStatsRepartidor($idRepartidor);

        $this->view('dashboard/repartidor', [
            'usuario' => $usuario,
            'pedidos_pendientes' => $pedidosPendientes,
            'mis_activos' => $misActivos,
            'historial' => $historial,
            'stats' => $stats,
        ]);
    }

    public function pedidosPendientes(): void
    {
        $this->requireAuth();
        $pedidos = $this->pedidoRepo->getPedidosPendientesRepartidor();
        $this->json($pedidos);
    }

    public function asignar(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/');
        }

        $idPedido = (int)($_POST['id_pedido'] ?? 0);
        $idRepartidor = (int)($_SESSION['usuario']['id']);

        if ($this->pedidoRepo->asignarRepartidor($idPedido, $idRepartidor)) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false, 'error' => 'Error al asignar repartidor'], 400);
        }
    }

    public function entregar(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/');
        }

        $idPedido = (int)($_POST['id_pedido'] ?? 0);
        $idRepartidor = (int)($_SESSION['usuario']['id']);

        if ($this->pedidoRepo->marcarEntregado($idPedido, $idRepartidor)) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false, 'error' => 'Error al marcar entregado'], 400);
        }
    }
}
