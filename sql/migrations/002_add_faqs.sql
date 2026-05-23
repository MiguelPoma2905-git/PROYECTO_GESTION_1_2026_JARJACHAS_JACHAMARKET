SET @dbname = DATABASE();
SET @tablename = "personalizacion_emprendimiento";
SET @columnname = "faqs";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = @tablename
    AND TABLE_SCHEMA = @dbname
    AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 1",
  "ALTER TABLE personalizacion_emprendimiento ADD COLUMN faqs TEXT AFTER tipografia;"
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
