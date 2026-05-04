-- ============================================
-- 1. Crear 2 usuarios con rol Emprendedor
-- ============================================
USE db_jacha;

-- Insertar primer vendedor
INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado)
VALUES (
    'Carlos', 
    'Mendoza', 
    'carlos.mendoza@test.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi',  -- contraseña: "password"
    '71234567',
    'Activo'
);

-- Insertar segundo vendedor
INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado)
VALUES (
    'Laura', 
    'Fernandez', 
    'laura.fernandez@test.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi',  -- contraseña: "password"
    '79876543',
    'Activo'
);

--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0005 segundos.)
-- -- ============================================ -- 1. Crear 2 usuarios con rol Emprendedor -- ============================================ USE db_jacha;
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 11 (La consulta tardó 0,0010 segundos.)
-- -- Insertar primer vendedor INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado) VALUES ( 'Carlos', 'Mendoza', 'carlos.mendoza@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', -- contraseña: "password" '71234567', 'Activo' );
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
--  1 fila insertada.
-- La Id de la fila insertada es: 12 (La consulta tardó 0,0009 segundos.)
-- -- Insertar segundo vendedor INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado) VALUES ( 'Laura', 'Fernandez', 'laura.fernandez@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', -- contraseña: "password" '79876543', 'Activo' );
-- [ Editar en línea ] [ Editar ] [ Crear código PHP ]
-- Abrir nueva ventana de phpMyAdmin