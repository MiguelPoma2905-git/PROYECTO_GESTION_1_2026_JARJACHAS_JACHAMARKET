<?php
namespace App\Repositories;

class VarianteRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findByProducto(int $idProducto): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM variantes_producto WHERE id_producto = ? ORDER BY id_variante ASC");
        $stmt->execute([$idProducto]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM variantes_producto WHERE id_variante = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByIdAndEmprendimiento(int $id, int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT vp.* FROM variantes_producto vp
            JOIN productos p ON vp.id_producto = p.id_producto
            WHERE vp.id_variante = ? AND p.id_emprendimiento = ?
        ");
        $stmt->execute([$id, $idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function skuExists(string $sku, ?int $excluirId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM variantes_producto WHERE sku = ?";
        $params = [$sku];
        if ($excluirId) {
            $sql .= " AND id_variante != ?";
            $params[] = $excluirId;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function insert(array $data): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO variantes_producto (id_producto, sku, atributo_1, valor_1, atributo_2, valor_2, precio_adicional)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['id_producto'],
            $data['sku'],
            $data['atributo_1'] ?? null,
            $data['valor_1'] ?? null,
            $data['atributo_2'] ?? null,
            $data['valor_2'] ?? null,
            $data['precio_adicional'] ?? 0.00
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM variantes_producto WHERE id_variante = ?");
        return (bool)$stmt->execute([$id]);
    }

    public function deleteByProducto(int $idProducto): void
    {
        $this->conn->prepare("DELETE FROM variantes_producto WHERE id_producto = ?")->execute([$idProducto]);
    }

    public function getStockTotalByProducto(int $idProducto): int
    {
        $stmt = $this->conn->prepare("
            SELECT COALESCE(SUM(i.cantidad_actual), 0)
            FROM variantes_producto vp
            LEFT JOIN inventario i ON vp.id_variante = i.id_variante
            WHERE vp.id_producto = ?
        ");
        $stmt->execute([$idProducto]);
        return (int)$stmt->fetchColumn();
    }
}
