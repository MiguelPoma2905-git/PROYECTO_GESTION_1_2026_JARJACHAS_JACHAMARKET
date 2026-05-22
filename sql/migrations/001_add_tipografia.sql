-- Migration: Add tipografia column to personalizacion_emprendimiento
-- This is safe to run multiple times (uses IF NOT EXISTS pattern via INFORMATION_SCHEMA)

SET @dbname = DATABASE();
SET @tablename = "personalizacion_emprendimiento";
SET @columnname = "tipografia";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = @tablename
    AND TABLE_SCHEMA = @dbname
    AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD COLUMN ", @columnname, " VARCHAR(100) DEFAULT 'Inter' AFTER color_texto;")
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
