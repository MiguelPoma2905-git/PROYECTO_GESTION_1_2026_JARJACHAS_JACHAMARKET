-- ============================================================
-- LIMPIAR DATOS DE PRUEBA — Jacha Marketplace
-- Elimina TODOS los datos insertados por llenar_datos_prueba.sql
-- CONSERVA al administrador: mikypramos2905@gmail.com (id_usuario=2)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM envios_logistica;
DELETE FROM detalles_pedido;
DELETE FROM pedidos;
DELETE FROM movimientos_kardex;
DELETE FROM inventario;
DELETE FROM variantes_producto;
DELETE FROM productos;
DELETE FROM personalizacion_emprendimiento;
DELETE FROM sucursales;
DELETE FROM emprendimientos;
DELETE FROM logs_auditoria WHERE id_usuario != 2;
DELETE FROM otp_verificacion WHERE email != 'mikypramos2905@gmail.com';
DELETE FROM usuario_roles WHERE id_usuario != 2;
DELETE FROM usuarios WHERE id_usuario > 2;

SET FOREIGN_KEY_CHECKS = 1;

SELECT 'LIMPIADO: Todos los datos de prueba fueron eliminados. Admin conservado.' AS resultado;