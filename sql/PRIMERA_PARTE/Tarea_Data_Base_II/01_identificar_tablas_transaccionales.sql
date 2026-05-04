-- ============================================
-- TAREA 1: Identificar la tabla con mayor transaccionalidad
-- ============================================
USE db_jacha;

-- Ver cantidad de registros por tabla
SELECT 'productos' AS tabla, COUNT(*) AS registros FROM productos
UNION ALL
SELECT 'pedidos', COUNT(*) FROM pedidos
UNION ALL
SELECT 'detalles_pedido', COUNT(*) FROM detalles_pedido
UNION ALL
SELECT 'usuarios', COUNT(*) FROM usuarios
UNION ALL
SELECT 'emprendimientos', COUNT(*) FROM emprendimientos
ORDER BY registros DESC;

-- Conclusión: La tabla con mayor potencial de crecimiento es 'detalles_pedido'
-- porque por cada pedido se insertan múltiples productos.