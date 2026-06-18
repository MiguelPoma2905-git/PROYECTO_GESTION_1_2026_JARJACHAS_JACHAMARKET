<?php
namespace App\Repositories;

class NotificacionRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function getByUser(int $userId, int $limit = 20): array
    {
        $stmt = $this->conn->prepare("
            SELECT n.*, e.nombre_comercial as ref_nombre
            FROM notificaciones n
            LEFT JOIN emprendimientos e ON n.tipo_referencia = 'emprendimiento' AND n.id_referencia = e.id_emprendimiento
            WHERE n.id_usuario = ?
            ORDER BY n.fecha_creacion DESC
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    public function countUnread(int $userId): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario = ? AND leida = 0");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function create(int $userId, string $tipo, string $titulo, string $mensaje, ?int $idReferencia = null, ?string $tipoReferencia = null): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO notificaciones (id_usuario, tipo, titulo, mensaje, id_referencia, tipo_referencia)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $tipo, $titulo, $mensaje, $idReferencia, $tipoReferencia]);
        return (int)$this->conn->lastInsertId();
    }

    public function markAsRead(int $id): void
    {
        $stmt = $this->conn->prepare("UPDATE notificaciones SET leida = 1 WHERE id_notificacion = ?");
        $stmt->execute([$id]);
    }

    public function markAllAsRead(int $userId): void
    {
        $stmt = $this->conn->prepare("UPDATE notificaciones SET leida = 1 WHERE id_usuario = ? AND leida = 0");
        $stmt->execute([$userId]);
    }

    public function notifyAllClientes(string $tipo, string $titulo, string $mensaje, ?int $idRef = null, ?string $tipoRef = null): void
    {
        $stmt = $this->conn->prepare("
            SELECT DISTINCT ur.id_usuario FROM usuario_roles ur
            JOIN roles r ON ur.id_rol = r.id_rol
            WHERE r.nombre_rol = 'Cliente'
        ");
        $stmt->execute();
        $clientes = $stmt->fetchAll();
        foreach ($clientes as $c) {
            $this->create((int)$c['id_usuario'], $tipo, $titulo, $mensaje, $idRef, $tipoRef);
        }
    }
}
