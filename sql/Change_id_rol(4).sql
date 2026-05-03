-- 1. Primero, eliminar la foreign key constraint
ALTER TABLE usuarios DROP FOREIGN KEY usuarios_ibfk_1;

-- 2. Luego, eliminar la columna id_rol
ALTER TABLE usuarios DROP COLUMN id_rol;

-- 3. Verificar que la estructura quedó bien
DESCRIBE usuarios;