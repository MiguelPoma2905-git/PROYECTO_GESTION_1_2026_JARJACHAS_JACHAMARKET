-- ============================================
-- Obtener los IDs de los emprendimientos creados
-- ============================================
USE db_jacha;

-- Ver los emprendimientos con sus IDs
SELECT 
    e.id_emprendimiento,
    e.nombre_comercial,
    u.nombres,
    u.apellidos,
    u.email
FROM emprendimientos e
JOIN usuarios u ON e.id_propietario = u.id_usuario
WHERE u.email IN ('carlos.mendoza@test.com', 'laura.fernandez@test.com');

-- ANOTA LOS IDs QUE APAREZCAN
-- Ejemplo: TecnoStore Bolivia → id_emprendimiento = 1
--          Artesanías Los Andes → id_emprendimiento = 2