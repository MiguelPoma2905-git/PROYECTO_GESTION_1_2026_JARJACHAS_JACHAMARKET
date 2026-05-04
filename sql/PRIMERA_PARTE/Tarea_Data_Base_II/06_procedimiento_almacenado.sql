-- ============================================
-- TAREA 5: Procedimiento almacenado
-- Reporte de ventas por emprendimiento
-- ============================================
USE db_jacha;

DELIMITER //

CREATE PROCEDURE sp_reporte_ventas_emprendimiento(
    IN p_id_emprendimiento INT,
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    -- Reporte de ventas para un emprendimiento específico
    SELECT 
        e.nombre_comercial AS nombre_negocio,
        COUNT(DISTINCT p.id_pedido) AS total_pedidos,
        COUNT(dp.id_detalle) AS unidades_vendidas,
        SUM(dp.subtotal) AS ingresos_totales,
        AVG(dp.subtotal) AS valor_promedio_por_producto,
        p_fecha_inicio AS fecha_desde,
        p_fecha_fin AS fecha_hasta
    FROM emprendimientos e
    JOIN sucursales s ON e.id_emprendimiento = s.id_emprendimiento
    JOIN pedidos p ON s.id_sucursal = p.id_sucursal_origen
    JOIN detalles_pedido dp ON p.id_pedido = dp.id_pedido
    WHERE e.id_emprendimiento = p_id_emprendimiento
        AND DATE(p.fecha_creacion) BETWEEN p_fecha_inicio AND p_fecha_fin
        AND p.estado_pago = 'Completado'
    GROUP BY e.id_emprendimiento;
    
    -- Productos más vendidos del emprendimiento
    SELECT 
        prod.nombre AS producto,
        SUM(dp.cantidad) AS cantidad_vendida,
        SUM(dp.subtotal) AS total_generado
    FROM emprendimientos e
    JOIN productos prod ON e.id_emprendimiento = prod.id_emprendimiento
    JOIN detalles_pedido dp ON prod.id_producto = dp.id_variante
    JOIN pedidos p ON dp.id_pedido = p.id_pedido
    WHERE e.id_emprendimiento = p_id_emprendimiento
        AND DATE(p.fecha_creacion) BETWEEN p_fecha_inicio AND p_fecha_fin
        AND p.estado_pago = 'Completado'
    GROUP BY prod.id_producto
    ORDER BY cantidad_vendida DESC
    LIMIT 10;
END //

DELIMITER ;

-- ============================================
-- EJECUTAR EL PROCEDIMIENTO
-- ============================================
-- Ejemplo: Reporte de TecnoStore Bolivia (id_emprendimiento = 1)
-- CALL sp_reporte_ventas_emprendimiento(1, '2025-01-01', '2025-12-31');