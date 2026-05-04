-- Agregar columna atributos JSON a productos si no existe
ALTER TABLE productos ADD COLUMN IF NOT EXISTS atributos JSON NULL AFTER descripcion_larga;

--  MySQL ha devuelto un conjunto de valores vacío (es decir: cero columnas). (La consulta tardó 0,0009 segundos.)
-- ALTER TABLE productos ADD COLUMN IF NOT EXISTS atributos JSON NULL AFTER descripcion_larga;