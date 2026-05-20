<?php
namespace App\Repositories;

class ProductoRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findByEmprendimiento(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id_emprendimiento = ? ORDER BY id_producto DESC");
        $stmt->execute([$idEmprendimiento]);
        return $stmt->fetchAll();
    }

    public function findPublishedByEmprendimiento(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id_emprendimiento = ? AND estado = 'Publicado' ORDER BY id_producto DESC");
        $stmt->execute([$idEmprendimiento]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByIdAndEmprendimiento(int $id, int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id_producto = ? AND id_emprendimiento = ?");
        $stmt->execute([$id, $idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function insert(array $data, int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, atributos, estado, stock, imagen_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $idEmprendimiento, $data['nombre'], $data['precio_base'],
            $data['descripcion'] ?? null, $data['atributos'] ?? null,
            $data['estado'] ?? 'Borrador', $data['stock'] ?? 0, $data['imagen_url'] ?? ''
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function update(int $id, int $idEmprendimiento, array $data): void
    {
        $sql = "UPDATE productos SET nombre = ?, precio_base = ?, descripcion_larga = ?, atributos = ?, estado = ?, stock = ?";
        $params = [$data['nombre'], $data['precio_base'], $data['descripcion'] ?? null, $data['atributos'] ?? null, $data['estado'] ?? 'Borrador', $data['stock'] ?? 0];

        if (!empty($data['imagen_url'])) {
            $sql .= ", imagen_url = ?";
            $params[] = $data['imagen_url'];
        }

        $sql .= " WHERE id_producto = ? AND id_emprendimiento = ?";
        $params[] = $id;
        $params[] = $idEmprendimiento;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    public function delete(int $id, int $idEmprendimiento): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM productos WHERE id_producto = ? AND id_emprendimiento = ?");
        return $stmt->execute([$id, $idEmprendimiento]);
    }

    // For db_demo.php queries
    public function countAll(): int
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'Publicado'");
        return (int)$stmt->fetch()['total'];
    }

    public function queryAllWithPagination(string $sqlBase, array $params, int $limit, int $offset): array
    {
        $countParams = $params;
        $stmtCount = $this->conn->prepare("SELECT COUNT(*) FROM ($sqlBase) as sub");
        $stmtCount->execute($countParams);
        $total = (int)$stmtCount->fetchColumn();

        $sql = $sqlBase . " LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        return ['data' => $rows, 'total' => $total];
    }
}
