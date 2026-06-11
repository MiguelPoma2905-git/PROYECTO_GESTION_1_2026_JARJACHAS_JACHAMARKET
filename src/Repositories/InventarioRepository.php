<?php
namespace App\Repositories;

class InventarioRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findByEmprendimiento(int $idEmprendimiento, ?int $idSucursal = null): array
    {
        $sql = "
            SELECT i.id_inventario, i.id_variante, i.id_sucursal, i.cantidad_actual, i.alerta_minima,
                   s.nombre_sucursal, s.ciudad,
                   vp.sku, vp.atributo_1, vp.valor_1, vp.atributo_2, vp.valor_2, vp.precio_adicional,
                   p.id_producto, p.nombre as producto_nombre, p.precio_base, p.precio_costo,
                   (i.cantidad_actual * COALESCE(p.precio_costo, p.precio_base)) as valor_inventario,
                   CASE WHEN i.cantidad_actual <= i.alerta_minima THEN 1 ELSE 0 END as alerta
            FROM inventario i
            JOIN sucursales s ON i.id_sucursal = s.id_sucursal
            JOIN variantes_producto vp ON i.id_variante = vp.id_variante
            JOIN productos p ON vp.id_producto = p.id_producto
            WHERE p.id_emprendimiento = ?
        ";
        $params = [$idEmprendimiento];
        if ($idSucursal) {
            $sql .= " AND i.id_sucursal = ?";
            $params[] = $idSucursal;
        }
        $sql .= " ORDER BY p.nombre ASC, vp.sku ASC, s.nombre_sucursal ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findByVarianteAndSucursal(int $idVariante, int $idSucursal): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM inventario WHERE id_variante = ? AND id_sucursal = ?");
        $stmt->execute([$idVariante, $idSucursal]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM inventario WHERE id_inventario = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function createIfNotExists(int $idVariante, int $idSucursal, int $cantidadInicial = 0, int $alertaMinima = 5): int
    {
        $existing = $this->findByVarianteAndSucursal($idVariante, $idSucursal);
        if ($existing) {
            return (int)$existing['id_inventario'];
        }
        $stmt = $this->conn->prepare("
            INSERT INTO inventario (id_variante, id_sucursal, cantidad_actual, alerta_minima)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$idVariante, $idSucursal, $cantidadInicial, $alertaMinima]);
        return (int)$this->conn->lastInsertId();
    }

    public function ajustarStock(int $idInventario, int $nuevaCantidad): void
    {
        $stmt = $this->conn->prepare("UPDATE inventario SET cantidad_actual = ? WHERE id_inventario = ?");
        $stmt->execute([$nuevaCantidad, $idInventario]);
    }

    public function updateAlertaMinima(int $idInventario, int $alerta): void
    {
        $stmt = $this->conn->prepare("UPDATE inventario SET alerta_minima = ? WHERE id_inventario = ?");
        $stmt->execute([$alerta, $idInventario]);
    }

    public function countAlertasByEmprendimiento(int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM inventario i
            JOIN sucursales s ON i.id_sucursal = s.id_sucursal
            JOIN variantes_producto vp ON i.id_variante = vp.id_variante
            JOIN productos p ON vp.id_producto = p.id_producto
            WHERE p.id_emprendimiento = ? AND i.cantidad_actual <= i.alerta_minima AND i.cantidad_actual > 0
        ");
        $stmt->execute([$idEmprendimiento]);
        return (int)$stmt->fetchColumn();
    }

    public function countStockCeroByEmprendimiento(int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM inventario i
            JOIN sucursales s ON i.id_sucursal = s.id_sucursal
            JOIN variantes_producto vp ON i.id_variante = vp.id_variante
            JOIN productos p ON vp.id_producto = p.id_producto
            WHERE p.id_emprendimiento = ? AND i.cantidad_actual = 0
        ");
        $stmt->execute([$idEmprendimiento]);
        return (int)$stmt->fetchColumn();
    }

    public function getValorTotalByEmprendimiento(int $idEmprendimiento): float
    {
        $stmt = $this->conn->prepare("
            SELECT COALESCE(SUM(i.cantidad_actual * COALESCE(p.precio_costo, p.precio_base)), 0)
            FROM inventario i
            JOIN variantes_producto vp ON i.id_variante = vp.id_variante
            JOIN productos p ON vp.id_producto = p.id_producto
            WHERE p.id_emprendimiento = ?
        ");
        $stmt->execute([$idEmprendimiento]);
        return (float)$stmt->fetchColumn();
    }

    public function autoCreateForNuevaVariante(int $idVariante, int $idProducto): void
    {
        $stmt = $this->conn->prepare("SELECT id_emprendimiento FROM productos WHERE id_producto = ?");
        $stmt->execute([$idProducto]);
        $idEmprendimiento = (int)$stmt->fetchColumn();

        $stmt = $this->conn->prepare("SELECT id_sucursal FROM sucursales WHERE id_emprendimiento = ?");
        $stmt->execute([$idEmprendimiento]);
        $sucursales = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($sucursales as $idSucursal) {
            $this->createIfNotExists($idVariante, $idSucursal, 0, 5);
        }
    }
}
