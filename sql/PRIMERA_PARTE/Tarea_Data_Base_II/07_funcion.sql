-- ============================================
-- TAREA 6: Función 
-- Calcular ganancia neta considerando costo e impuestos
-- ============================================
USE db_jacha;

DELIMITER //

CREATE FUNCTION fn_calcular_ganancia_neta(
    p_precio_venta DECIMAL(10,2),
    p_costo DECIMAL(10,2),
    p_impuesto_porcentaje DECIMAL(5,2)
)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE v_ganancia_bruta DECIMAL(10,2);
    DECLARE v_impuesto DECIMAL(10,2);
    DECLARE v_ganancia_neta DECIMAL(10,2);
    
    -- Calcular ganancia bruta
    SET v_ganancia_bruta = p_precio_venta - p_costo;
    
    -- Calcular impuesto sobre la ganancia
    SET v_impuesto = v_ganancia_bruta * (p_impuesto_porcentaje / 100);
    
    -- Calcular ganancia neta
    SET v_ganancia_neta = v_ganancia_bruta - v_impuesto;
    
    RETURN v_ganancia_neta;
END //

DELIMITER ;

-- ============================================
-- EJEMPLOS DE USO DE LA FUNCIÓN
-- ============================================

-- Ejemplo 1: Producto vendido a Bs. 500, costo Bs. 300, impuesto 13%
SELECT fn_calcular_ganancia_neta(500, 300, 13) AS ganancia_neta;

-- Ejemplo 2: Usar dentro de una consulta (simulada)
SELECT 
    nombre,
    precio_base,
    0 AS costo,  -- Aquí iría el costo real
    13 AS impuesto,
    fn_calcular_ganancia_neta(precio_base, 0, 13) AS ganancia_estimada
FROM productos
WHERE id_emprendimiento = 1
LIMIT 5;