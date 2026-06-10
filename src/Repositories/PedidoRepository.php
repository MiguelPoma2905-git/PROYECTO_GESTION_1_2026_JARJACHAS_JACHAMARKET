<?php
namespace App\Repositories;

class PedidoRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function crearPedido(array $datos): array
    {
        $this->conn->beginTransaction();
        try {
            $codigo = 'JACHA-' . strtoupper(substr(uniqid(), -8));

            $fecha = $datos['fecha_creacion'] ?? date('Y-m-d');

            $stmt = $this->conn->prepare("
                INSERT INTO pedidos (id_cliente, id_sucursal_origen, codigo_seguimiento, 
                                    subtotal, costo_envio, total, metodo_pago, direccion_entrega, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $datos['id_cliente'], $datos['id_sucursal'], $codigo,
                $datos['subtotal'], $datos['costo_envio'], $datos['total'],
                $datos['metodo_pago'], $datos['direccion'], $fecha
            ]);

            $id_pedido = (int)$this->conn->lastInsertId();

            foreach ($datos['items'] as $item) {
                $stmt = $this->conn->prepare("
                    INSERT INTO detalles_pedido (id_pedido, id_variante, cantidad, precio_unitario, subtotal)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $id_pedido, $item['id_variante'], $item['cantidad'],
                    $item['precio'], $item['cantidad'] * $item['precio']
                ]);
            }

            $stmt = $this->conn->prepare("INSERT INTO envios_logistica (id_pedido) VALUES (?)");
            $stmt->execute([$id_pedido]);

            $this->conn->commit();
            return ['success' => true, 'id_pedido' => $id_pedido, 'codigo' => $codigo];
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getPedidosByCliente(int $idCliente, int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));
        $stmt = $this->conn->prepare("
            SELECT p.*, e.nombre_comercial,
                   (SELECT COUNT(*) FROM detalles_pedido WHERE id_pedido = p.id_pedido) as total_items
            FROM pedidos p
            JOIN sucursales s ON p.id_sucursal_origen = s.id_sucursal
            JOIN emprendimientos e ON s.id_emprendimiento = e.id_emprendimiento
            WHERE p.id_cliente = ?
            ORDER BY p.fecha_creacion DESC
            LIMIT $limit
        ");
        $stmt->execute([$idCliente]);
        return $stmt->fetchAll();
    }

    public function getDetallesByPedido(int $idPedido): array
    {
        $stmt = $this->conn->prepare("
            SELECT dp.*,
                   COALESCE(vp.id_producto, dp.id_variante) as id_producto,
                   COALESCE(p.nombre, 'Producto') as producto_nombre,
                   COALESCE(p.precio_base, dp.precio_unitario) as precio_base
            FROM detalles_pedido dp
            LEFT JOIN variantes_producto vp ON dp.id_variante = vp.id_variante
            LEFT JOIN productos p ON p.id_producto = COALESCE(vp.id_producto, dp.id_variante)
            WHERE dp.id_pedido = ?
            ORDER BY dp.id_detalle ASC
        ");
        $stmt->execute([$idPedido]);
        return $stmt->fetchAll();
    }

    public function getPedidosPendientesRepartidor(): array
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, e.nombre_comercial, 
                   u.nombres as cliente_nombre, u.apellidos as cliente_apellidos,
                   u.telefono as cliente_telefono,
                   el.id_envio, el.distancia_km
            FROM pedidos p
            JOIN envios_logistica el ON p.id_pedido = el.id_pedido
            JOIN emprendimientos e ON e.id_emprendimiento = 
                (SELECT id_emprendimiento FROM sucursales WHERE id_sucursal = p.id_sucursal_origen)
            JOIN usuarios u ON p.id_cliente = u.id_usuario
            WHERE p.estado_logistico = 'Preparando' 
               OR (p.estado_logistico = 'En_Ruta' AND el.id_repartidor IS NULL)
            ORDER BY p.fecha_creacion ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function asignarRepartidor(int $idPedido, int $idRepartidor): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE envios_logistica 
            SET id_repartidor = ?, fecha_despacho = NOW()
            WHERE id_pedido = ?
        ");
        if ($stmt->execute([$idRepartidor, $idPedido])) {
            $stmt = $this->conn->prepare("
                UPDATE pedidos SET estado_logistico = 'En_Ruta' WHERE id_pedido = ?
            ");
            return $stmt->execute([$idPedido]);
        }
        return false;
    }

    public function getPedidosByRepartidor(int $idRepartidor): array
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, e.nombre_comercial,
                   u.nombres as cliente_nombre, u.apellidos as cliente_apellidos,
                   u.telefono as cliente_telefono,
                   el.id_envio, el.distancia_km, el.fecha_despacho
            FROM pedidos p
            JOIN envios_logistica el ON p.id_pedido = el.id_pedido
            JOIN emprendimientos e ON e.id_emprendimiento =
                (SELECT id_emprendimiento FROM sucursales WHERE id_sucursal = p.id_sucursal_origen)
            JOIN usuarios u ON p.id_cliente = u.id_usuario
            WHERE el.id_repartidor = ? AND p.estado_logistico IN ('En_Ruta', 'Preparando')
            ORDER BY el.fecha_despacho DESC
        ");
        $stmt->execute([$idRepartidor]);
        return $stmt->fetchAll();
    }

    public function getHistorialRepartidor(int $idRepartidor): array
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, e.nombre_comercial,
                   u.nombres as cliente_nombre, u.apellidos as cliente_apellidos,
                   el.fecha_entrega
            FROM pedidos p
            JOIN envios_logistica el ON p.id_pedido = el.id_pedido
            JOIN emprendimientos e ON e.id_emprendimiento =
                (SELECT id_emprendimiento FROM sucursales WHERE id_sucursal = p.id_sucursal_origen)
            JOIN usuarios u ON p.id_cliente = u.id_usuario
            WHERE el.id_repartidor = ? AND p.estado_logistico = 'Entregado'
            ORDER BY el.fecha_entrega DESC
            LIMIT 50
        ");
        $stmt->execute([$idRepartidor]);
        return $stmt->fetchAll();
    }

    public function getStatsRepartidor(int $idRepartidor): array
    {
        $hoy = date('Y-m-d');
        $stmt = $this->conn->prepare("
            SELECT
                COUNT(CASE WHEN p.estado_logistico = 'Entregado' AND DATE(el.fecha_entrega) = ? THEN 1 END) as entregas_hoy,
                COUNT(CASE WHEN p.estado_logistico = 'Entregado' THEN 1 END) as entregas_totales,
                COALESCE(SUM(CASE WHEN p.estado_logistico = 'Entregado' AND DATE(el.fecha_entrega) = ? THEN p.costo_envio ELSE 0 END), 0) as ganancias_hoy,
                COALESCE(SUM(CASE WHEN p.estado_logistico = 'Entregado' THEN p.costo_envio ELSE 0 END), 0) as ganancias_totales,
                COUNT(CASE WHEN p.estado_logistico IN ('En_Ruta', 'Preparando') THEN 1 END) as activos
            FROM envios_logistica el
            JOIN pedidos p ON p.id_pedido = el.id_pedido
            WHERE el.id_repartidor = ?
        ");
        $stmt->execute([$hoy, $hoy, $idRepartidor]);
        return $stmt->fetch();
    }

    public function getStatsCliente(int $idCliente): array
    {
        $stmt = $this->conn->prepare("
            SELECT
                COUNT(*) as total_pedidos,
                COALESCE(SUM(total), 0) as total_gastado,
                COALESCE(AVG(total), 0) as promedio_gasto,
                COUNT(CASE WHEN estado_logistico = 'Entregado' THEN 1 END) as entregados,
                COUNT(CASE WHEN estado_logistico = 'Cancelado' THEN 1 END) as cancelados,
                COUNT(CASE WHEN estado_logistico IN ('Recibido', 'Preparando', 'En_Ruta') THEN 1 END) as en_proceso
            FROM pedidos
            WHERE id_cliente = ?
        ");
        $stmt->execute([$idCliente]);
        return $stmt->fetch();
    }

    public function marcarEntregado(int $idPedido, int $idRepartidor): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE envios_logistica 
            SET fecha_entrega = NOW()
            WHERE id_pedido = ? AND id_repartidor = ?
        ");
        if ($stmt->execute([$idPedido, $idRepartidor])) {
            $stmt = $this->conn->prepare("
                UPDATE pedidos SET estado_logistico = 'Entregado', estado_pago = 'Completado'
                WHERE id_pedido = ?
            ");
            return $stmt->execute([$idPedido]);
        }
        return false;
    }
}
