<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UsuarioRepository;
use App\Repositories\EmprendimientoRepository;

class PerfilController extends Controller
{
    private UsuarioRepository $usuarioRepo;
    private EmprendimientoRepository $emprendimientoRepo;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioRepo = new UsuarioRepository();
        $this->emprendimientoRepo = new EmprendimientoRepository();
    }

    public function index(): void
    {
        $this->requireAuth();
        $usuario = $this->usuarioRepo->findById($_SESSION['usuario']['id']);
        if (!$usuario) {
            $this->redirect(BASE_URL . '/logout');
        }
        $db = $this->getDB();

        $avatar = $this->usuarioRepo->getAvatar($usuario['id_usuario']);
        $rolesNombres = $this->usuarioRepo->getRolesNombres($usuario['id_usuario']);
        $rolesUsuario = $this->usuarioRepo->getRoles($usuario['id_usuario']);
        $inicial = strtoupper(substr($usuario['nombres'], 0, 1));

        $misNegocios = [];
        if (in_array('Emprendedor', $rolesNombres)) {
            $misNegocios = $this->emprendimientoRepo->findByPropietario($usuario['id_usuario']);
        }

        $error = $_SESSION['perfil_error'] ?? '';
        $success = $_SESSION['perfil_msg'] ?? '';
        unset($_SESSION['perfil_error'], $_SESSION['perfil_msg']);

        $this->view('perfil/index', [
            'usuario' => $usuario,
            'avatar' => $avatar,
            'roles_nombres' => $rolesNombres,
            'roles_usuario' => $rolesUsuario,
            'inicial' => $inicial,
            'mis_negocios' => $misNegocios,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function actualizar(): void
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/perfil');
        }

        $id = $_SESSION['usuario']['id'];
        $db = $this->getDB();

        $nombres = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($nombres) || empty($apellidos)) {
            $_SESSION['perfil_error'] = 'Nombres y apellidos son obligatorios';
            $this->redirect(BASE_URL . '/perfil');
        }

        if (!empty($telefono) && !preg_match('/^[0-9]{7,15}$/', $telefono)) {
            $_SESSION['perfil_error'] = 'Teléfono inválido (solo números, 7-15 dígitos)';
            $this->redirect(BASE_URL . '/perfil');
        }

        $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, telefono = ?, bio = ?, ubicacion = ?";
        $params = [$nombres, $apellidos, $telefono ?: null, $bio ?: null, $ubicacion ?: null];

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $_SESSION['perfil_error'] = 'La contraseña debe tener al menos 6 caracteres';
                $this->redirect(BASE_URL . '/perfil');
            }
            $sql .= ", password_hash = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id_usuario = ?";
        $params[] = $id;

        $db->prepare($sql)->execute($params);

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $uploadDir = BASE_PATH . 'public/assets/avatars/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $name = 'avatar_' . $id . '_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $name)) {
                    $avatarPath = 'assets/avatars/' . $name;
                    $db->prepare("UPDATE usuarios SET avatar = ? WHERE id_usuario = ?")->execute([$avatarPath, $id]);
                }
            }
        }

        $_SESSION['perfil_msg'] = 'Datos actualizados correctamente';

        $stmt = $db->prepare("SELECT id_usuario, CONCAT(nombres, ' ', apellidos) as nombre, email FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $updated = $stmt->fetch();
        $_SESSION['usuario'] = [
            'id' => $updated['id_usuario'],
            'nombre' => $updated['nombre'],
            'email' => $updated['email'],
            'roles_todos' => $_SESSION['usuario']['roles_todos'] ?? ''
        ];

        $this->redirect(BASE_URL . '/perfil');
    }

    public function quitarRepartidor(): void
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/perfil');
        }

        $id = $_SESSION['usuario']['id'];
        $db = $this->getDB();
        $rolId = $this->usuarioRepo->getRolIdByName('Repartidor');

        if ($rolId) {
            $db->prepare("DELETE FROM usuario_roles WHERE id_usuario = ? AND id_rol = ?")
                ->execute([$id, $rolId]);
            $_SESSION['perfil_msg'] = 'Rol Repartidor eliminado correctamente';
        }

        $this->redirect(BASE_URL . '/perfil');
    }

    public function eliminarNegocio(): void
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/perfil');
        }

        $idUsuario = $_SESSION['usuario']['id'];
        $idNegocio = (int)($_POST['id_negocio'] ?? 0);

        if ($idNegocio <= 0) {
            $this->redirect(BASE_URL . '/perfil');
        }

        $negocio = $this->emprendimientoRepo->findByIdAndPropietario($idNegocio, $idUsuario);
        if (!$negocio) {
            $_SESSION['perfil_error'] = 'Negocio no encontrado o no te pertenece';
            $this->redirect(BASE_URL . '/perfil');
        }

        $db = $this->getDB();
        $db->prepare("DELETE FROM emprendimientos WHERE id_emprendimiento = ? AND id_propietario = ?")
            ->execute([$idNegocio, $idUsuario]);

        $_SESSION['perfil_msg'] = 'Negocio eliminado correctamente';
        $this->redirect(BASE_URL . '/perfil');
    }
}
