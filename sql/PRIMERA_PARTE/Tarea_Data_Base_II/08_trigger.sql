-- ============================================
-- TAREA 7: Trigger
-- Actualizar stock automáticamente al vender
-- ============================================
USE db_jacha;

-- ============================================
-- PARTE A: Verificar/Añadir columna stock en productos
-- ============================================

-- Verificar si la columna stock existe
-- Si no existe, agregarla
ALTER TABLE productos ADD COLUMN IF NOT EXISTS stock INT DEFAULT 0;

-- ============================================
-- PARTE B: Crear el trigger
-- ============================================

DELIMITER //

CREATE TRIGGER trg_actualizar_stock_venta
AFTER INSERT ON detalles_pedido
FOR EACH ROW
BEGIN
    DECLARE v_stock_actual INT;
    
    -- Obtener stock actual del producto
    SELECT stock INTO v_stock_actual 
    FROM productos 
    WHERE id_producto = NEW.id_variante;
    
    -- Verificar que hay suficiente stock
    IF v_stock_actual >= NEW.cantidad THEN
        -- Actualizar stock
        UPDATE productos 
        SET stock = stock - NEW.cantidad,
            actualizado_en = NOW()
        WHERE id_producto = NEW.id_variante;
        
        -- Registrar en tabla de log (opcional)
        INSERT INTO logs_auditoria (id_usuario, tabla_afectada, accion, datos_nuevos)
        VALUES (
            (SELECT id_cliente FROM pedidos WHERE id_pedido = NEW.id_pedido),
            'productos',
            'UPDATE',
            JSON_OBJECT('producto', NEW.id_variante, 'cantidad_descontada', NEW.cantidad)
        );
    ELSE
        -- Si no hay stock suficiente, lanzar un error
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Stock insuficiente para completar la venta';
    END IF;
END //

DELIMITER ;

-- ============================================
-- PARTE C: Verificar el trigger
-- ============================================

SHOW TRIGGERS LIKE 'trg_actualizar_stock_venta';

-- ============================================
-- PARTE D: Probar el trigger (ejemplo)
-- ============================================

-- Primero, verificar stock de un producto
SELECT id_producto, nombre, stock FROM productos WHERE id_producto = 1;

-- Luego, al insertar un detalle de pedido, el stock se actualizará automáticamente
-- INSERT INTO detalles_pedido (id_pedido, id_variante, cantidad, precio_unitario, subtotal)
-- VALUES (1, 1, 2, 100, 200);
-- El trigger descontará 2 del stock del producto con id_producto = 1

-- NOTA: Para probar, necesitas tener un pedido existente