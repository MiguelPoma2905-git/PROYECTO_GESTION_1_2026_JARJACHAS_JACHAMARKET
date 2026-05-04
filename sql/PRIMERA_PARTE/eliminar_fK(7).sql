-- Ver el nombre exacto de la constraint
SELECT CONSTRAINT_NAME 
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'usuarios' AND COLUMN_NAME = 'id_rol';

-- Eliminar la foreign key (usa el nombre que veas)
ALTER TABLE usuarios DROP FOREIGN KEY usuarios_ibfk_1;

-- Eliminar la columna id_rol si aún existe
ALTER TABLE usuarios DROP COLUMN IF EXISTS id_rol;