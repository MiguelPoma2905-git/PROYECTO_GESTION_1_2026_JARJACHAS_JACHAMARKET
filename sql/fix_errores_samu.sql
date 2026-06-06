-- Correcciones puntuales para la base ya importada.
-- Ejecutar una sola vez en phpMyAdmin sobre la base del proyecto.

ALTER TABLE usuarios
    ADD COLUMN IF NOT EXISTS avatar VARCHAR(255) NULL AFTER telefono;

UPDATE emprendimientos
SET nit = NULL
WHERE nit = '';
