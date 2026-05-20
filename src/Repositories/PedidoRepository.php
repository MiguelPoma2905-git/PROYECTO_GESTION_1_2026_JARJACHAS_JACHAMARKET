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

            $stmt = $this->conn->prepare("
                INSERT INTO pedidos (id_cliente, id_sucursal_origen, codigo_seguimiento, 
                                    subtotal, costo_envio, total, metodo_pago, direccion_entrega)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $datos['id_cliente'], $datos['id_sucursal'], $codigo,
                $datos['subtotal'], $datos['costo_envio'], $datos['total'],
                $datos['metodo_pago'], $datos['direccion']
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
