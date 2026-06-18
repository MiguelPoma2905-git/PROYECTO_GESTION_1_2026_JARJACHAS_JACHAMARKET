<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\NotificacionRepository;

class NotificacionController extends Controller
{
    private NotificacionRepository $repo;

    public function __construct()
    {
        $this->repo = new NotificacionRepository();
    }

    public function obtener(): void
    {
        $usuario = $this->requireAuth();
        $notifs = $this->repo->getByUser((int)$usuario['id']);
        $result = array_map(function ($n) {
            $url = null;
            if ($n['tipo_referencia'] === 'emprendimiento' && $n['id_referencia']) {
                $url = BASE_URL . '/tienda/' . $n['id_referencia'];
            }
            return [
                'id' => $n['id_notificacion'],
                'tipo' => $n['tipo'],
                'titulo' => $n['titulo'],
                'mensaje' => $n['mensaje'],
                'leida' => (bool)$n['leida'],
                'ref_nombre' => $n['ref_nombre'],
                'url' => $url,
                'fecha' => $n['fecha_creacion'],
            ];
        }, $notifs);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $result, 'no_leidas' => $this->repo->countUnread((int)$usuario['id'])]);
    }

    public function contar(): void
    {
        $usuario = $this->requireAuth();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'count' => $this->repo->countUnread((int)$usuario['id'])]);
    }

    public function marcarLeida(): void
    {
        $usuario = $this->requireAuth();
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->repo->markAsRead($id);
        } else {
            $this->repo->markAllAsRead((int)$usuario['id']);
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }
}
