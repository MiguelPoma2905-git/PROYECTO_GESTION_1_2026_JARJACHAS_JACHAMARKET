-- ============================================
-- 3. Crear emprendimientos para cada vendedor
-- ============================================
USE db_jacha;

-- Emprendimiento 1: Tienda de tecnología (para Carlos)
INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado)
SELECT 
    id_usuario,
    'TecnoStore Bolivia',
    '1020304050',
    'Venta de laptops, computadoras y accesorios tecnológicos. Envíos a todo Bolivia.',
    'Aprobado'
FROM usuarios 
WHERE email = 'carlos.mendoza@test.com';

-- Emprendimiento 2: Tienda de artesanías (para Laura)
INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado)
SELECT 
    id_usuario,
    'Artesanías Los Andes',
    '2030405060',
    'Artesanía boliviana hecha a mano. Productos de alpaca, cerámica y textiles.',
    'Aprobado'
FROM usuarios 
WHERE email = 'laura.fernandez@test.com';


--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0004 segundos.)
-- -- ============================================ -- 3. Crear emprendimientos para cada vendedor -- ============================================ USE db_jacha;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 7 (La consulta tardó 0,0011 segundos.)
-- -- Emprendimiento 1: Tienda de tecnología (para Carlos) INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado) SELECT id_usuario, 'TecnoStore Bolivia', '1020304050', 'Venta de laptops, computadoras y accesorios tecnológicos. Envíos a todo Bolivia.', 'Aprobado' FROM usuarios WHERE email = 'carlos.mendoza@test.com';
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 8 (La consulta tardó 0,0010 segundos.)
-- -- Emprendimiento 2: Tienda de artesanías (para Laura) INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado) SELECT id_usuario, 'Artesanías Los Andes', '2030405060', 'Artesanía boliviana hecha a mano. Productos de alpaca, cerámica y textiles.', 'Aprobado' FROM usuarios WHERE email = 'laura.fernandez@test.com';
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
-- Abrir nueva ventana de phpMyAdmin