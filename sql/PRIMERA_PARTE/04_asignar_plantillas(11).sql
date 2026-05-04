-- ============================================
-- 4. Asignar plantilla Tecnológico y personalizar
-- ============================================
USE db_jacha;

-- Obtener IDs de los emprendimientos recién creados
SET @id_emprendimiento_tecnologia = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'TecnoStore Bolivia');
SET @id_emprendimiento_artesania = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'Artesanías Los Andes');

-- Plantilla Tecnológico (id_plantilla = 4)
INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo)
VALUES 
(@id_emprendimiento_tecnologia, 4, '#3498db', '#2c3e50', '#0a0a0a');

-- Plantilla Moderno (id_plantilla = 1) para artesanías
INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo)
VALUES 
(@id_emprendimiento_artesania, 1, '#e67e22', '#d35400', '#1a1a1a');


--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0006 segundos.)
-- -- ============================================ -- 4. Asignar plantilla Tecnológico y personalizar -- ============================================ USE db_jacha;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0008 segundos.)
-- -- Obtener IDs de los emprendimientos recién creados SET @id_emprendimiento_tecnologia = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'TecnoStore Bolivia');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0009 segundos.)
-- SET @id_emprendimiento_artesania = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'Artesanías Los Andes');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 5 (La consulta tardó 0,0012 segundos.)
-- -- Plantilla Tecnológico (id_plantilla = 4) INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo) VALUES (@id_emprendimiento_tecnologia, 4, '#3498db', '#2c3e50', '#0a0a0a');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 6 (La consulta tardó 0,0024 segundos.)
-- -- Plantilla Moderno (id_plantilla = 1) para artesanías INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo) VALUES (@id_emprendimiento_artesania, 1, '#e67e22', '#d35400', '#1a1a1a');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
-- Abrir nueva ventana de phpMyAdmin