<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PedidoRepository;

class PedidoController extends Controller
{
    private PedidoRepository $pedidoRepo;

    public function __construct()
    {
        parent::__construct();
        $this->pedidoRepo = new PedidoRepository();
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
}
