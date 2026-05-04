-- ============================================
-- 5. Verificar los usuarios creados
-- ============================================
USE db_jacha;

-- Ver los usuarios y sus roles
SELECT 
    u.id_usuario,
    u.nombres,
    u.apellidos,
    u.email,
    u.telefono,
    GROUP_CONCAT(r.nombre_rol) as roles
FROM usuarios u
LEFT JOIN usuario_roles ur ON u.id_usuario = ur.id_usuario
LEFT JOIN roles r ON ur.id_rol = r.id_rol
WHERE u.email IN ('carlos.mendoza@test.com', 'laura.fernandez@test.com')
GROUP BY u.id_usuario;

-- Ver los emprendimientos creados
SELECT 
    e.id_emprendimiento,
    e.nombre_comercial,
    e.descripcion,
    u.nombres as propietario,
    u.email,
    p.nombre as plantilla
FROM emprendimientos e
JOIN usuarios u ON e.id_propietario = u.id_usuario
LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
WHERE u.email IN ('carlos.mendoza@test.com', 'laura.fernandez@test.com');



--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0004 segundos.)
-- -- ============================================ -- 5. Verificar los usuarios creados -- ============================================ USE db_jacha;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  La selección actual no contiene una columna única. La edición de la grilla y los enlaces de copiado, eliminación y edición no están disponibles. Documentación
--  Mostrando filas 0 - 1 (total de 2, La consulta tardó 0,0027 segundos.)
-- -- Ver los usuarios y sus roles SELECT u.id_usuario, u.nombres, u.apellidos, u.email, u.telefono, GROUP_CONCAT(r.nombre_rol) as roles FROM usuarios u LEFT JOIN usuario_roles ur ON u.id_usuario = ur.id_usuario LEFT JOIN roles r ON ur.id_rol = r.id_rol WHERE u.email IN ('carlos.mendoza@test.com', 'laura.fernandez@test.com') GROUP BY u.id_usuario;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  Mostrar todo
-- |			
-- Número de filas: 
-- 25
-- id_usuario
-- nombres
-- apellidos
-- email
-- telefono
-- roles
-- 11
-- Carlos
-- Mendoza
-- carlos.mendoza@test.com
-- 71234567
-- Emprendedor
-- 12
-- Laura
-- Fernandez
-- laura.fernandez@test.com
-- 79876543
-- Emprendedor
--  Mostrar todo
-- |			
-- Número de filas: 
-- 25
-- Operaciones sobre los resultados de la consulta
    
-- Guardar esta consulta en favoritos Guardar esta consulta en favoritos
-- Etiqueta: 
--  Permitir que todo usuario pueda acceder a este favorito

--  La selección actual no contiene una columna única. La edición de la grilla y los enlaces de copiado, eliminación y edición no están disponibles. Documentación
--  Mostrando filas 0 - 1 (total de 2, La consulta tardó 0,0015 segundos.)
-- -- Ver los emprendimientos creados SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, u.nombres as propietario, u.email, p.nombre as plantilla FROM emprendimientos e JOIN usuarios u ON e.id_propietario = u.id_usuario LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla WHERE u.email IN ('carlos.mendoza@test.com', 'laura.fernandez@test.com');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  Mostrar todo
-- |			
-- Número de filas: 
-- 25
-- id_emprendimiento
-- nombre_comercial
-- descripcion
-- propietario
-- email
-- plantilla
-- 7
-- TecnoStore Bolivia
-- Venta de laptops, computadoras y accesorios tecnol...
-- Carlos
-- carlos.mendoza@test.com
-- Tecnológico
-- 8
-- Artesanías Los Andes
-- Artesanía boliviana hecha a mano. Productos de alp...
-- Laura
-- laura.fernandez@test.com
-- Moderno
--  Mostrar todo
-- |			
-- Número de filas: 
-- 25
-- Operaciones sobre los resultados de la consulta
    
-- Guardar esta consulta en favoritos Guardar esta consulta en favoritos
-- Etiqueta: 
--  Permitir que todo usuario pueda acceder a este favorito
