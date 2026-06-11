<?php
namespace App\Repositories;

class SucursalRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findAllByEmprendimiento(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("
            SELECT s.*, 
                   (SELECT COUNT(*) FROM inventario i 
                    JOIN variantes_producto vp ON i.id_variante = vp.id_variante
                    JOIN productos p ON vp.id_producto = p.id_producto
                    WHERE i.id_sucursal = s.id_sucursal AND p.id_emprendimiento = ?
                   ) as total_variantes
            FROM sucursales s
            WHERE s.id_emprendimiento = ?
            ORDER BY s.id_sucursal ASC
        ");
        $stmt->execute([$idEmprendimiento, $idEmprendimiento]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM sucursales WHERE id_sucursal = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByIdAndEmprendimiento(int $id, int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM sucursales WHERE id_sucursal = ? AND id_emprendimiento = ?");
        $stmt->execute([$id, $idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function existsInEmprendimiento(string $nombre, int $idEmprendimiento, ?int $excluirId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM sucursales WHERE nombre_sucursal = ? AND id_emprendimiento = ?";
        $params = [$nombre, $idEmprendimiento];
        if ($excluirId) {
            $sql .= " AND id_sucursal != ?";
            $params[] = $excluirId;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function insert(array $data, int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO sucursales (id_emprendimiento, nombre_sucursal, direccion, ciudad, latitud, longitud)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $idEmprendimiento,
            $data['nombre_sucursal'],
            $data['direccion'] ?? '',
            $data['ciudad'] ?? '',
            $data['latitud'] !== '' ? (float)$data['latitud'] : null,
            $data['longitud'] !== '' ? (float)$data['longitud'] : null
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function update(int $id, int $idEmprendimiento, array $data): void
    {
        $stmt = $this->conn->prepare("
            UPDATE sucursales SET nombre_sucursal = ?, direccion = ?, ciudad = ?, latitud = ?, longitud = ?
            WHERE id_sucursal = ? AND id_emprendimiento = ?
        ");
        $stmt->execute([
            $data['nombre_sucursal'],
            $data['direccion'] ?? '',
            $data['ciudad'] ?? '',
            $data['latitud'] !== '' ? (float)$data['latitud'] : null,
            $data['longitud'] !== '' ? (float)$data['longitud'] : null,
            $id,
            $idEmprendimiento
        ]);
    }

    public function delete(int $id, int $idEmprendimiento): bool
    {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare("DELETE FROM movimientos_kardex WHERE id_inventario IN (SELECT id_inventario FROM inventario WHERE id_sucursal = ?)");
            $stmt->execute([$id]);
            $stmt = $this->conn->prepare("DELETE FROM inventario WHERE id_sucursal = ?");
            $stmt->execute([$id]);
            $stmt = $this->conn->prepare("DELETE FROM sucursales WHERE id_sucursal = ? AND id_emprendimiento = ?");
            $stmt->execute([$id, $idEmprendimiento]);
            $this->conn->commit();
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function countByEmprendimiento(int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sucursales WHERE id_emprendimiento = ?");
        $stmt->execute([$idEmprendimiento]);
        return (int)$stmt->fetchColumn();
    }
}
