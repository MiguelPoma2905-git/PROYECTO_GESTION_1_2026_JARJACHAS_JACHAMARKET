<?php
namespace App\Repositories;

class KardexRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function insert(int $idInventario, string $tipo, int $cantidad, int $idUsuarioResponsable, ?string $observacion = null): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO movimientos_kardex (id_inventario, tipo, cantidad, id_usuario_responsable, observacion)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$idInventario, $tipo, $cantidad, $idUsuarioResponsable, $observacion]);
        return (int)$this->conn->lastInsertId();
    }

    public function findByEmprendimiento(int $idEmprendimiento, ?string $tipo = null, ?string $fechaDesde = null, ?string $fechaHasta = null, ?int $idSucursal = null, int $limit = 100): array
    {
        $sql = "
            SELECT mk.id_movimiento, mk.tipo, mk.cantidad, mk.fecha, mk.observacion,
                   mk.id_usuario_responsable,
                   u.nombres as responsable_nombre, u.apellidos as responsable_apellidos,
                   i.id_inventario, i.id_variante, i.id_sucursal, i.cantidad_actual,
                   s.nombre_sucursal,
                   vp.sku, vp.atributo_1, vp.valor_1, vp.atributo_2, vp.valor_2,
                   p.id_producto, p.nombre as producto_nombre
            FROM movimientos_kardex mk
            JOIN inventario i ON mk.id_inventario = i.id_inventario
            JOIN sucursales s ON i.id_sucursal = s.id_sucursal
            JOIN variantes_producto vp ON i.id_variante = vp.id_variante
            JOIN productos p ON vp.id_producto = p.id_producto
            JOIN usuarios u ON mk.id_usuario_responsable = u.id_usuario
            WHERE p.id_emprendimiento = ?
        ";
        $params = [$idEmprendimiento];

        if ($tipo) {
            $sql .= " AND mk.tipo = ?";
            $params[] = $tipo;
        }
        if ($fechaDesde) {
            $sql .= " AND mk.fecha >= ?";
            $params[] = $fechaDesde . ' 00:00:00';
        }
        if ($fechaHasta) {
            $sql .= " AND mk.fecha <= ?";
            $params[] = $fechaHasta . ' 23:59:59';
        }
        if ($idSucursal) {
            $sql .= " AND i.id_sucursal = ?";
            $params[] = $idSucursal;
        }

        $sql .= " ORDER BY mk.fecha DESC LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findByVariante(int $idVariante, int $limit = 50): array
    {
        $stmt = $this->conn->prepare("
            SELECT mk.*, u.nombres as responsable_nombre, u.apellidos as responsable_apellidos,
                   s.nombre_sucursal
            FROM movimientos_kardex mk
            JOIN inventario i ON mk.id_inventario = i.id_inventario
            JOIN sucursales s ON i.id_sucursal = s.id_sucursal
            JOIN usuarios u ON mk.id_usuario_responsable = u.id_usuario
            WHERE i.id_variante = ?
            ORDER BY mk.fecha DESC
            LIMIT ?
        ");
        $stmt->execute([$idVariante, $limit]);
        return $stmt->fetchAll();
    }
}
