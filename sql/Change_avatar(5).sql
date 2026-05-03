-- Agregar columna avatar a usuarios
ALTER TABLE usuarios ADD COLUMN avatar VARCHAR(255) NULL AFTER telefono;

-- Agregar columna bio (opcional)
ALTER TABLE usuarios ADD COLUMN bio TEXT NULL;

-- Agregar columna ubicacion
ALTER TABLE usuarios ADD COLUMN ubicacion VARCHAR(100) NULL;

-- SE MDOFIICOY SE AGREGO LOS AVATRES A LOS USUARIOS