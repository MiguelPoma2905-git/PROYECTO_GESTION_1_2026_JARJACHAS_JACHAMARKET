<?php
namespace App\Repositories;

class ProductoRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    private function rowsWithImgUrl(array $rows): array
    {
        foreach ($rows as &$row) {
            $id = $row['id_producto'] ?? 0;
            $row['imagen_url'] = !empty($row['imagen_blob']) ? 'serve.php?t=producto&id=' . $id : '';
            unset($row['imagen_blob'], $row['imagen_mime']);
        }
        return $rows;
    }

    public function findByEmprendimiento(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("
            SELECT id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, atributos,
                   imagen_blob, imagen_mime,
                   precio_base, precio_costo, stock, estado, creado_en, actualizado_en
            FROM productos WHERE id_emprendimiento = ? ORDER BY id_producto DESC
        ");
        $stmt->execute([$idEmprendimiento]);
        return $this->rowsWithImgUrl($stmt->fetchAll());
    }

    public function findPublishedByEmprendimiento(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("
            SELECT id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, atributos,
                   imagen_blob, imagen_mime,
                   precio_base, precio_costo, stock, estado, creado_en, actualizado_en
            FROM productos WHERE id_emprendimiento = ? AND estado = 'Publicado' ORDER BY id_producto DESC
        ");
        $stmt->execute([$idEmprendimiento]);
        return $this->rowsWithImgUrl($stmt->fetchAll());
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, atributos,
                   imagen_blob, imagen_mime,
                   precio_base, precio_costo, stock, estado, creado_en, actualizado_en
            FROM productos WHERE id_producto = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ? $this->rowsWithImgUrl([$result])[0] : null;
    }

    public function findByIdAndEmprendimiento(int $id, int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, atributos,
                   imagen_blob, imagen_mime,
                   precio_base, precio_costo, stock, estado, creado_en, actualizado_en
            FROM productos WHERE id_producto = ? AND id_emprendimiento = ?
        ");
        $stmt->execute([$id, $idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ? $this->rowsWithImgUrl([$result])[0] : null;
    }

    public function insert(array $data, int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO productos (id_emprendimiento, nombre, precio_base, precio_costo, descripcion_larga, atributos, estado, stock, imagen_blob, imagen_mime, id_categoria)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $idEmprendimiento, $data['nombre'], $data['precio_base'],
            $data['precio_costo'] ?? null,
            $data['descripcion'] ?? null, $data['atributos'] ?? null,
            $data['estado'] ?? 'Borrador', $data['stock'] ?? 0,
            $data['imagen_blob'] ?? null, $data['imagen_mime'] ?? null,
            $data['id_categoria'] ?? null
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function update(int $id, int $idEmprendimiento, array $data): void
    {
        $sql = "UPDATE productos SET nombre = ?, precio_base = ?, precio_costo = ?, descripcion_larga = ?, atributos = ?, estado = ?, stock = ?, id_categoria = ?";
        $params = [$data['nombre'], $data['precio_base'], $data['precio_costo'] ?? null, $data['descripcion'] ?? null, $data['atributos'] ?? null, $data['estado'] ?? 'Borrador', $data['stock'] ?? 0, $data['id_categoria'] ?? null];

        if (!empty($data['imagen_blob'])) {
            $sql .= ", imagen_blob = ?";
            $params[] = $data['imagen_blob'];
            $sql .= ", imagen_mime = ?";
            $params[] = $data['imagen_mime'] ?? 'image/jpeg';
        }

        if (!empty($data['eliminar_imagen'])) {
            $sql .= ", imagen_blob = NULL, imagen_mime = NULL";
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

        return ['data' => $this->rowsWithImgUrl($rows), 'total' => $total];
    }
}
