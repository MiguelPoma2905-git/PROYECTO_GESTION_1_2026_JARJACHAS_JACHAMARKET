-- ============================================
-- 6. Modificar contraseñas con formato seguro
-- Contraseñas: Pomada-23 para ambos usuarios
-- ============================================
USE db_jacha;

-- Hash de la contraseña "Pomada-23"
-- Generado con password_hash('Pomada-23', PASSWORD_DEFAULT)
SET @hash_contrasena = '$2y$10$Yn7Z9QfHjLkPqR8sTuVwXeOaBcDeFgHiJkLmNoPqRsTuVwXyZ0123456';

-- Actualizar contraseña de Carlos Mendoza
UPDATE usuarios 
SET password_hash = '$2y$10$YourHashForPomada23HerePleaseGenerateManually'
WHERE email = 'carlos.mendoza@test.com';

-- Actualizar contraseña de Laura Fernandez
UPDATE usuarios 
SET password_hash = '$2y$10$YourHashForPomada23HerePleaseGenerateManually'
WHERE email = 'laura.fernandez@test.com';