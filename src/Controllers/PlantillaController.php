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

        if ($isLoggedIn) {
            $usuarioRepo = new UsuarioRepository();
            $usuarioId = $usuario['id'] ?? $usuario['id_usuario'] ?? 0;
            if ($usuarioId) {
                $usuarioDb = $usuarioRepo->findById($usuarioId);
                if (!$usuarioDb) {
                    session_destroy();
                    $isLoggedIn = false;
                    $usuario = null;
                } else {
                    $usuarioDb['id'] = $usuarioDb['id_usuario'];
                    $usuarioDb['nombre'] = trim(($usuarioDb['nombres'] ?? '') . ' ' . ($usuarioDb['apellidos'] ?? ''));
                    $_SESSION['usuario'] = $usuarioDb;
                    $usuario = $usuarioDb;
                }
            }
        }

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

        if ($isLoggedIn) {
            $usuarioRepo = new UsuarioRepository();
            $usuarioId = $usuario['id'] ?? $usuario['id_usuario'] ?? 0;
            if ($usuarioId) {
                $usuarioDb = $usuarioRepo->findById($usuarioId);
                if (!$usuarioDb) {
                    session_destroy();
                    $isLoggedIn = false;
                    $usuario = null;
                } else {
                    $usuarioDb['id'] = $usuarioDb['id_usuario'];
                    $usuarioDb['nombre'] = trim(($usuarioDb['nombres'] ?? '') . ' ' . ($usuarioDb['apellidos'] ?? ''));
                    $_SESSION['usuario'] = $usuarioDb;
                }
            }
        }

        $rolActivo = $isLoggedIn ? ($_SESSION['rol_activo'] ?? '') : '';
        $isVendedor = $isLoggedIn && $rolActivo === 'Emprendedor';

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
            'is_vendedor' => $isVendedor,
            'rol_activo' => $rolActivo
        ]);
    }
}
