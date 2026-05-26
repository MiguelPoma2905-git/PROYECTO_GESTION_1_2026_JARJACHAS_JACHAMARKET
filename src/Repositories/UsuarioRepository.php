<?php
namespace App\Repositories;

class UsuarioRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT u.*, GROUP_CONCAT(DISTINCT r.nombre_rol) as roles_todos
            FROM usuarios u
            LEFT JOIN usuario_roles ur ON u.id_usuario = ur.id_usuario
            LEFT JOIN roles r ON ur.id_rol = r.id_rol
            WHERE u.email = ? AND u.estado = 'Activo'
            GROUP BY u.id_usuario
        ");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getAvatar(int $id): string
    {
        $stmt = $this->conn->prepare("SELECT avatar_blob FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $blob = $stmt->fetchColumn();
        return $blob ? 'serve.php?t=avatar&id=' . $id : 'assets/avatars/default/avatar_1.jpg';
    }

    public function getRoles(int $id): array
    {
        $stmt = $this->conn->prepare("
            SELECT r.nombre_rol 
            FROM usuario_roles ur 
            JOIN roles r ON ur.id_rol = r.id_rol 
            WHERE ur.id_usuario = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getRolesNombres(int $id): array
    {
        return array_column($this->getRoles($id), 'nombre_rol');
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetch();
    }

    public function insert(array $data): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (nombres, apellidos, email, telefono, password_hash, estado)
            VALUES (?, ?, ?, ?, ?, 'Activo')
        ");
        $stmt->execute([
            $data['nombres'], $data['apellidos'], $data['email'],
            $data['telefono'] ?? null, $data['password_hash']
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function updateAvatarBlob(int $id, string $blob, string $mime): void
    {
        $stmt = $this->conn->prepare("UPDATE usuarios SET avatar_blob = ?, avatar_mime = ? WHERE id_usuario = ?");
        $stmt->execute([$blob, $mime, $id]);
    }

    public function clearAvatarBlob(int $id): void
    {
        $stmt = $this->conn->prepare("UPDATE usuarios SET avatar_blob = NULL, avatar_mime = NULL WHERE id_usuario = ?");
        $stmt->execute([$id]);
    }

    public function insertUsuarioRol(int $idUsuario, int $idRol): void
    {
        $stmt = $this->conn->prepare("INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $idRol]);
    }

    public function getRolIdByName(string $nombre): ?int
    {
        $stmt = $this->conn->prepare("SELECT id_rol FROM roles WHERE nombre_rol = ?");
        $stmt->execute([$nombre]);
        $result = $stmt->fetch();
        return $result ? (int)$result['id_rol'] : null;
    }

    public function getUserRolesInfo(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total, GROUP_CONCAT(r.nombre_rol) as roles
            FROM usuario_roles ur
            JOIN roles r ON ur.id_rol = r.id_rol
            WHERE ur.id_usuario = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}
