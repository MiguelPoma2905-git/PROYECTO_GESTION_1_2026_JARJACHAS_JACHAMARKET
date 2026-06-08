-- Agregar columnas para recuperación de contraseña
ALTER TABLE usuarios ADD COLUMN reset_token VARCHAR(64) DEFAULT NULL;
ALTER TABLE usuarios ADD COLUMN reset_token_expiry DATETIME DEFAULT NULL;
