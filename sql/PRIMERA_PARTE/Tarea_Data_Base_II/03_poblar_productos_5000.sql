-- ============================================
-- TAREA 2: Poblar 5000 productos (distribuidos entre los 2 emprendimientos)
-- ============================================
USE db_jacha;

-- PRIMERO: Asegúrate de tener los IDs correctos
-- REEMPLAZA 1 y 2 con los IDs que obtuviste en el paso anterior

-- Poblar 2500 productos para TecnoStore Bolivia (id_emprendimiento = 1)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock, imagen_url)
WITH RECURSIVE numeros AS (
    SELECT 1 AS n
    UNION ALL
    SELECT n + 1 FROM numeros WHERE n < 2500
)
SELECT 
    1 AS id_emprendimiento,  -- REEMPLAZAR por ID real de TecnoStore
    CONCAT('Producto Tecnológico ', n) AS nombre,
    ROUND(50 + RAND() * 2000, 2) AS precio_base,
    CONCAT('Descripción del producto tecnológico número ', n, '. Calidad garantizada.') AS descripcion_larga,
    'Publicado' AS estado,
    FLOOR(10 + RAND() * 100) AS stock,
    NULL AS imagen_url
FROM numeros;

-- Poblar 2500 productos para Artesanías Los Andes (id_emprendimiento = 2)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock, imagen_url)
WITH RECURSIVE numeros AS (
    SELECT 1 AS n
    UNION ALL
    SELECT n + 1 FROM numeros WHERE n < 2500
)
SELECT 
    2 AS id_emprendimiento,  -- REEMPLAZAR por ID real de Artesanías
    CONCAT('Producto Artesanal ', n) AS nombre,
    ROUND(10 + RAND() * 500, 2) AS precio_base,
    CONCAT('Hermosa artesanía boliviana número ', n, '. Hecho a mano con materiales naturales.') AS descripcion_larga,
    'Publicado' AS estado,
    FLOOR(5 + RAND() * 50) AS stock,
    NULL AS imagen_url
FROM numeros;

-- Verificar que se insertaron los 5000 productos
SELECT COUNT(*) as total_productos FROM productos;
SELECT id_emprendimiento, COUNT(*) as cantidad FROM productos GROUP BY id_emprendimiento;