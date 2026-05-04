-- ============================================
-- 2. Asignar rol Emprendedor a los nuevos usuarios
-- ============================================
USE db_jacha;

-- Obtener ID del rol Emprendedor
SET @id_rol_emprendedor = (SELECT id_rol FROM roles WHERE nombre_rol = 'Emprendedor');

-- Asignar rol al primer usuario
INSERT INTO usuario_roles (id_usuario, id_rol)
SELECT id_usuario, @id_rol_emprendedor
FROM usuarios 
WHERE email = 'carlos.mendoza@test.com';

-- Asignar rol al segundo usuario
INSERT INTO usuario_roles (id_usuario, id_rol)
SELECT id_usuario, @id_rol_emprendedor
FROM usuarios 
WHERE email = 'laura.fernandez@test.com';


--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0003 segundos.)
-- -- ============================================ -- 2. Asignar rol Emprendedor a los nuevos usuarios -- ============================================ USE db_jacha;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0014 segundos.)
-- -- Obtener ID del rol Emprendedor SET @id_rol_emprendedor = (SELECT id_rol FROM roles WHERE nombre_rol = 'Emprendedor');
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada. (La consulta tardó 0,0009 segundos.)
-- -- Asignar rol al primer usuario INSERT INTO usuario_roles (id_usuario, id_rol) SELECT id_usuario, @id_rol_emprendedor FROM usuarios WHERE email = 'carlos.mendoza@test.com';
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada. (La consulta tardó 0,0043 segundos.)
-- -- Asignar rol al segundo usuario INSERT INTO usuario_roles (id_usuario, id_rol) SELECT id_usuario, @id_rol_emprendedor FROM usuarios WHERE email = 'laura.fernandez@test.com';
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
-- Abrir nueva ventana de phpMyAdmin