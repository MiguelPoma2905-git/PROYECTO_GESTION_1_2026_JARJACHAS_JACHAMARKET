-- ============================================
-- TAREA 3: Índice y medición de rendimiento
-- ============================================
USE db_jacha;

-- ============================================
-- PARTE A: MEDICIÓN SIN ÍNDICE (ANTES)
-- ============================================

-- Habilitar temporizador
SET @start = NOW(6);

-- Consulta de prueba (buscar productos por emprendimiento)
SELECT * FROM productos WHERE id_emprendimiento = 1 AND precio_base > 500;

-- Calcular tiempo transcurrido
SET @end = NOW(6);
SELECT TIMEDIFF(@end, @start) AS tiempo_sin_indice;

-- ============================================
-- PARTE B: CREAR ÍNDICE
-- ============================================

-- Crear índice en la columna más usada para búsquedas
CREATE INDEX idx_productos_emprendimiento_precio ON productos(id_emprendimiento, precio_base);

-- Mostrar los índices creados en la tabla productos
SHOW INDEX FROM productos;

-- ============================================
-- PARTE C: MEDICIÓN CON ÍNDICE (DESPUÉS)
-- ============================================

SET @start = NOW(6);

-- Misma consulta de prueba
SELECT * FROM productos WHERE id_emprendimiento = 1 AND precio_base > 500;

-- Calcular tiempo transcurrido
SET @end = NOW(6);
SELECT TIMEDIFF(@end, @start) AS tiempo_con_indice;

-- ============================================
-- CONCLUSIÓN: Comparar los tiempos
-- ============================================
SELECT 'El índice mejora la velocidad de búsqueda' AS resultado;