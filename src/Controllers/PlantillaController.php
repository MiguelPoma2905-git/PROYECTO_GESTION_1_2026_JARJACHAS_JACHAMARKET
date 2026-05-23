<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PlantillaRepository;
use App\Repositories\UsuarioRepository;

class PlantillaController extends Controller
{
    private PlantillaRepository $plantillaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->plantillaRepo = new PlantillaRepository();
    }

    public function detalle(array $params = []): void
    {
        $id = (int)($params['id'] ?? 0);
        $plantilla = $this->plantillaRepo->findById($id);
        if (!$plantilla) {
            $this->redirect(BASE_URL . '/plantillas-disponibles');
        }

        $usuario = $_SESSION['usuario'] ?? null;
        $isLoggedIn = $usuario !== null;
        $isVendedor = $isLoggedIn && ($_SESSION['rol_activo'] ?? '') === 'Emprendedor';

        $this->view('pages/plantilla-detalle', [
            'plantilla' => $plantilla,
            'is_logged_in' => $isLoggedIn,
            'is_vendedor' => $isVendedor
        ]);
    }

    public function disponibles(): void
    {
        $usuario = $_SESSION['usuario'] ?? null;
        $isLoggedIn = $usuario !== null;
        $isVendedor = $isLoggedIn && ($_SESSION['rol_activo'] ?? '') === 'Emprendedor';

        $mensajeError = '';
        $mostrarSelector = true;

        if (!$isLoggedIn) {
            $mostrarSelector = false;
            $mensajeError = 'Debes iniciar sesión para elegir una plantilla.';
        } elseif (!$isVendedor) {
            $mostrarSelector = false;
            $mensajeError = 'Necesitas ser emprendedor para crear una tienda.';
        }

        $plantillas = $this->plantillaRepo->findAllActive();

        $this->view('pages/plantillas-disponibles', [
            'mostrar_selector' => $mostrarSelector,
            'mensaje_error' => $mensajeError,
            'plantillas' => $plantillas,
            'is_logged_in' => $isLoggedIn,
            'is_vendedor' => $isVendedor
        ]);
    }
}
