<?php
namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller
{
    private function requireAdmin(): void
    {
        $this->requireAuth();
        $roles = $_SESSION['usuario']['roles_todos'] ?? '';
        if (strpos($roles, 'Administrador') === false) {
            $db = $this->getDB();
            $stmt = $db->prepare("SELECT 1 FROM usuario_roles ur JOIN roles r ON ur.id_rol = r.id_rol WHERE ur.id_usuario = ? AND r.nombre_rol = 'Administrador'");
            $stmt->execute([$_SESSION['usuario']['id']]);
            if (!$stmt->fetchColumn()) {
                $this->redirect(BASE_URL . '/dashboard');
            }
            $_SESSION['usuario']['roles_todos'] = $roles ? $roles . ',Administrador' : 'Administrador';
        }
    }

    public function panel(): void
    {
        $this->requireAdmin();
        $this->redirect(BASE_URL . '/dashboard');
    }

    public function eliminarUsuario(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/admin');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect(BASE_URL . '/admin');
        }

        $db = $this->getDB();
        $stmt = $db->prepare("SELECT email FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $email = $stmt->fetchColumn();

        if ($email === 'mikypramos2905@gmail.com') {
            $_SESSION['admin_error'] = 'No puedes eliminar al super administrador';
            $this->redirect(BASE_URL . '/admin');
        }

        $db->prepare("DELETE FROM usuarios WHERE id_usuario = ?")->execute([$id]);
        $_SESSION['admin_msg'] = 'Usuario eliminado correctamente';
        $this->redirect(BASE_URL . '/admin');
    }

    public function editarUsuario(): void
    {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) $this->redirect(BASE_URL . '/admin');

        $db = $this->getDB();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if (!$user) {
            $_SESSION['admin_error'] = 'Usuario no encontrado';
            $this->redirect(BASE_URL . '/admin');
        }

        $roles = $db->query("SELECT * FROM roles")->fetchAll();
        $userRoles = $db->prepare("SELECT id_rol FROM usuario_roles WHERE id_usuario = ?");
        $userRoles->execute([$id]);
        $userRoleIds = array_column($userRoles->fetchAll(), 'id_rol');

        $error = $_SESSION['admin_error'] ?? '';
        $success = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_error'], $_SESSION['admin_msg']);

        $this->view('admin/editar-usuario', [
            'user' => $user,
            'roles' => $roles,
            'user_role_ids' => $userRoleIds,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function editarUsuarioGuardar(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect(BASE_URL . '/admin');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) $this->redirect(BASE_URL . '/admin');

        $db = $this->getDB();

        $nombres = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $estado = $_POST['estado'] ?? 'Activo';
        $password = $_POST['password'] ?? '';

        if (empty($nombres) || empty($apellidos) || empty($email)) {
            $_SESSION['admin_error'] = 'Nombres, apellidos y email son obligatorios';
            $this->redirect(BASE_URL . '/admin/editar-usuario?id=' . $id);
        }

        $sql = "UPDATE usuarios SET nombres=?, apellidos=?, email=?, telefono=?, bio=?, ubicacion=?, estado=?";
        $params = [$nombres, $apellidos, $email, $telefono ?: null, $bio ?: null, $ubicacion ?: null, $estado];

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $_SESSION['admin_error'] = 'La contraseña debe tener al menos 6 caracteres';
                $this->redirect(BASE_URL . '/admin/editar-usuario?id=' . $id);
            }
            $sql .= ", password_hash=?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id_usuario=?";
        $params[] = $id;
        $db->prepare($sql)->execute($params);

        if ($email !== 'mikypramos2905@gmail.com') {
            $selectedRoles = $_POST['roles'] ?? [];
            $db->prepare("DELETE FROM usuario_roles WHERE id_usuario = ?")->execute([$id]);
            $insertStmt = $db->prepare("INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (?, ?)");
            foreach ($selectedRoles as $rolId) {
                $insertStmt->execute([$id, (int)$rolId]);
            }
        }

        $_SESSION['admin_msg'] = 'Usuario actualizado correctamente';
        $this->redirect(BASE_URL . '/admin');
    }

    public function eliminarNegocio(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/admin');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect(BASE_URL . '/admin');
        }

        $db = $this->getDB();
        $db->prepare("DELETE FROM emprendimientos WHERE id_emprendimiento = ?")->execute([$id]);
        $_SESSION['admin_msg'] = 'Negocio eliminado correctamente';
        $this->redirect(BASE_URL . '/admin');
    }

    public function ventas(): void
    {
        $this->requireAdmin();
        $db = $this->getDB();

        $negocioFilter = (int)($_GET['id_emprendimiento'] ?? 0);
        $plantillaFilter = (int)($_GET['id_plantilla'] ?? 0);

        $negocios = $db->query("
            SELECT e.*, p.nombre as plantilla_nombre, p.id_plantilla
            FROM emprendimientos e
            JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            ORDER BY e.id_emprendimiento DESC
        ")->fetchAll();

        $sql = "
            SELECT p.id_pedido, p.codigo_seguimiento, p.subtotal, p.costo_envio, p.total,
                   p.metodo_pago, p.estado_pago, p.estado_logistico, p.fecha_creacion,
                   u.nombres as cliente_nombre, u.apellidos as cliente_apellidos, u.email as cliente_email,
                   e.id_emprendimiento, e.nombre_comercial,
                   pl.nombre as plantilla_nombre, pl.id_plantilla,
                   COUNT(dp.id_detalle) as total_items
            FROM pedidos p
            JOIN usuarios u ON p.id_cliente = u.id_usuario
            JOIN sucursales s ON p.id_sucursal_origen = s.id_sucursal
            JOIN emprendimientos e ON s.id_emprendimiento = e.id_emprendimiento
            JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            JOIN plantillas pl ON pe.id_plantilla = pl.id_plantilla
            LEFT JOIN detalles_pedido dp ON p.id_pedido = dp.id_pedido
            WHERE 1=1
        ";
        $params = [];

        if ($negocioFilter) {
            $sql .= " AND e.id_emprendimiento = ?";
            $params[] = $negocioFilter;
        }
        if ($plantillaFilter) {
            $sql .= " AND pl.id_plantilla = ?";
            $params[] = $plantillaFilter;
        }

        $sql .= " GROUP BY p.id_pedido ORDER BY p.fecha_creacion DESC LIMIT 100";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $pedidos = $stmt->fetchAll();

        $resumen = $db->query("
            SELECT COUNT(*) as total_pedidos, COALESCE(SUM(total),0) as total_ventas
            FROM pedidos
        ")->fetch();

        $this->view('admin/ventas', [
            'pedidos' => $pedidos,
            'negocios' => $negocios,
            'negocio_filter' => $negocioFilter,
            'plantilla_filter' => $plantillaFilter,
            'resumen' => $resumen
        ]);
    }

    public function seedDemo(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/admin');
        }

        $db = $this->getDB();
        $sql = file_get_contents(__DIR__ . '/../../sql/top_3.sql');

        if (!$sql) {
            $_SESSION['admin_error'] = 'No se pudo leer el archivo SQL';
            $this->redirect(BASE_URL . '/admin');
        }

        $statements = explode(';', $sql);
        $count = 0;
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && stripos($statement, 'SELECT') !== 0 && stripos($statement, 'CREATE DATABASE') === false && stripos($statement, 'USE ') === false && stripos($statement, 'DROP TABLE') === false) {
                try {
                    $db->exec($statement);
                    $count++;
                } catch (\PDOException $e) {
                    error_log("Seed Demo: " . $e->getMessage());
                }
            }
        }

        $_SESSION['admin_msg'] = 'Datos base insertados correctamente';
        $this->redirect(BASE_URL . '/admin');
    }

    public function resetDb(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/admin');
        }
        if (!isset($_POST['confirmar']) || $_POST['confirmar'] !== 'RESET') {
            $_SESSION['admin_error'] = 'Debes escribir RESET para confirmar';
            $this->redirect(BASE_URL . '/admin');
        }

        $db = $this->getDB();
        $db->exec("SET FOREIGN_KEY_CHECKS = 0");

        $tables = $db->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            $db->exec("DROP TABLE IF EXISTS `$table`");
        }

        $db->exec("SET FOREIGN_KEY_CHECKS = 1");

        $sql = file_get_contents(__DIR__ . '/../../sql/top_3.sql');
        if ($sql) {
            $statements = explode(';', $sql);
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    try {
                        $db->exec($statement);
                    } catch (\PDOException $e) {
                        error_log("Admin Reset DB: " . $e->getMessage());
                    }
                }
            }
        }

        $_SESSION['admin_msg'] = 'Base de datos reiniciada correctamente';
        $this->redirect(BASE_URL . '/admin');
    }
}
