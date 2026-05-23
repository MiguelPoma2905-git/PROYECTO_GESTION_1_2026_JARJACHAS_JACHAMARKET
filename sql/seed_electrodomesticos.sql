-- ============================================================
-- SEED: Electrodomésticos Demo - Datos de prueba
-- Ejecutar solo si la BD está limpia (solo admin existe)
-- ============================================================

USE db_jacha;

-- 1. Crear usuario emprendedor demo
INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado)
SELECT 'Carlos', 'Mendoza', 'carlos.demo@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', '71234567', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'carlos.demo@test.com');

SET @id_emprendedor = (SELECT id_usuario FROM usuarios WHERE email = 'carlos.demo@test.com');

-- 2. Asignar roles
INSERT IGNORE INTO usuario_roles (id_usuario, id_rol)
SELECT @id_emprendedor, id_rol FROM roles WHERE nombre_rol IN ('Emprendedor', 'Cliente');

-- 3. Crear negocio con plantilla Electrodomésticos (id=6)
INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado)
SELECT @id_emprendedor, 'ElectroHogar Bolivia', '1020304050', 'Venta de electrodomésticos y tecnología para el hogar con los mejores precios y calidad garantizada.', 'Aprobado'
WHERE NOT EXISTS (SELECT 1 FROM emprendimientos WHERE nit = '1020304050');

SET @id_negocio = (SELECT id_emprendimiento FROM emprendimientos WHERE nit = '1020304050');

-- 4. Personalización con plantilla Electrodomésticos
INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo, color_texto, tipografia)
SELECT @id_negocio, 6, '#1A3A5C', '#2C6FBB', '#0F1A2E', '#E8EDF5', 'Inter'
WHERE NOT EXISTS (SELECT 1 FROM personalizacion_emprendimiento WHERE id_emprendimiento = @id_negocio);

-- 5. Sucursal
INSERT INTO sucursales (id_emprendimiento, nombre_sucursal, direccion, ciudad)
SELECT @id_negocio, 'Tienda Central', 'Av. 16 de Julio #1542, Zona Central', 'La Paz'
WHERE NOT EXISTS (SELECT 1 FROM sucursales WHERE id_emprendimiento = @id_negocio AND nombre_sucursal = 'Tienda Central');

SET @id_sucursal = (SELECT id_sucursal FROM sucursales WHERE id_emprendimiento = @id_negocio LIMIT 1);

-- 6. Productos Electrodomésticos con atributos JSON
INSERT INTO productos (id_emprendimiento, nombre, descripcion_larga, atributos, precio_base, stock, estado) VALUES
-- REFRIGERADORES
(@id_negocio, 'Refrigerador Samsung RS50N 500L',
 'Refrigerador Samsung RS50N de 500 litros con tecnología Twin Cooling Plus, dispenser de agua y hielo, y eficiencia energética A++.',
 '{"marca":"Samsung","modelo":"RS50N","consumo_watts":"350","color":"Acero Inoxidable","garantia_meses":"24","eficiencia":"A++","tipo":"Refrigerador"}',
 4599.00, 12, 'Publicado'),

(@id_negocio, 'Refrigerador LG GT32B 320L',
 'Refrigerador LG GT32B de 320 litros con sistema Smart Inverter, Frost Free y filtro Hygiene Fresh.',
 '{"marca":"LG","modelo":"GT32B","consumo_watts":"280","color":"Gris Titanio","garantia_meses":"12","eficiencia":"A+","tipo":"Refrigerador"}',
 3299.00, 8, 'Publicado'),

(@id_negocio, 'Refrigerador Mabe RMA200 200L',
 'Refrigerador Mabe RMA200 de 200 litros ideal para hogares pequeños, con sistema de descongelación automática.',
 '{"marca":"Mabe","modelo":"RMA200","consumo_watts":"220","color":"Blanco","garantia_meses":"12","eficiencia":"A","tipo":"Refrigerador"}',
 2199.00, 15, 'Publicado'),

-- LAVADORAS
(@id_negocio, 'Lavadora Samsung WA15T 15kg',
 'Lavadora Samsung WA15T de 15kg con carga superior, tecnología EcoBubble y centrifugado de 700 RPM.',
 '{"marca":"Samsung","modelo":"WA15T","consumo_watts":"500","color":"Blanco","garantia_meses":"24","eficiencia":"A++","tipo":"Lavadora"}',
 3899.00, 10, 'Publicado'),

(@id_negocio, 'Lavadora LG F4V5 12kg',
 'Lavadora LG F4V5 de 12kg con carga frontal, motor Smart Inverter Direct Drive y Steam Technology.',
 '{"marca":"LG","modelo":"F4V5","consumo_watts":"480","color":"Blanco","garantia_meses":"12","eficiencia":"A++","tipo":"Lavadora"}',
 4299.00, 6, 'Publicado'),

(@id_negocio, 'Lavadora Mabe LMA10 10kg',
 'Lavadora Mabe LMA10 de 10kg con carga superior, 12 programas de lavado y sistema de llenado inteligente.',
 '{"marca":"Mabe","modelo":"LMA10","consumo_watts":"400","color":"Blanco","garantia_meses":"12","eficiencia":"A+","tipo":"Lavadora"}',
 2699.00, 20, 'Publicado'),

-- COCINAS / HORNOS
(@id_negocio, 'Cocina Indurama 5 Hornillas',
 'Cocina Indurama con 5 hornillas a gas, horno con convección natural, encendido eléctrico y timer digital.',
 '{"marca":"Indurama","modelo":"I-500","consumo_watts":"0","color":"Acero Inoxidable","garantia_meses":"24","eficiencia":"A","tipo":"Cocina"}',
 3599.00, 7, 'Publicado'),

(@id_negocio, 'Horno Microondas Samsung 25L',
 'Horno microondas Samsung de 25 litros con tecnología Triple Distribution System, grill 1200W y descongelado rápido.',
 '{"marca":"Samsung","modelo":"MG25T","consumo_watts":"1200","color":"Negro","garantia_meses":"12","eficiencia":"A","tipo":"Microondas"}',
 899.00, 25, 'Publicado'),

(@id_negocio, 'Horno Eléctrico Imaco 42L',
 'Horno eléctrico Imaco de 42 litros con temperatura regulable hasta 230°C, temporizador y luz interior.',
 '{"marca":"Imaco","modelo":"HE42","consumo_watts":"1600","color":"Plata","garantia_meses":"6","eficiencia":"A","tipo":"Horno"}',
 599.00, 18, 'Publicado'),

-- TELEVISORES
(@id_negocio, 'TV Samsung QLED 65" 4K',
 'Smart TV Samsung QLED 65 pulgadas, resolución 4K UHD, HDR10+, Tizen OS, asistentes de voz integrados.',
 '{"marca":"Samsung","modelo":"QN65Q80","consumo_watts":"180","color":"Negro","garantia_meses":"24","eficiencia":"A+","tipo":"Televisor"}',
 7999.00, 5, 'Publicado'),

(@id_negocio, 'TV LG NanoCell 55" 4K',
 'Smart TV LG NanoCell 55 pulgadas, resolución 4K UHD, webOS 22, Dolby Vision IQ y Dolby Atmos.',
 '{"marca":"LG","modelo":"55NANO75","consumo_watts":"150","color":"Negro Titanio","garantia_meses":"12","eficiencia":"A+","tipo":"Televisor"}',
 5499.00, 8, 'Publicado'),

(@id_negocio, 'TV LED Noblex 43" HD',
 'Smart TV Noblex 43 pulgadas, resolución HD Ready, sistema Android TV, WiFi integrado y 3 HDMI.',
 '{"marca":"Noblex","modelo":"NB43","consumo_watts":"90","color":"Negro","garantia_meses":"12","eficiencia":"A","tipo":"Televisor"}',
 2499.00, 14, 'Publicado'),

-- ASPIRADORAS / LIMPIEZA
(@id_negocio, 'Aspiradora Robot Xiaomi S10',
 'Aspiradora robot Xiaomi S10 con navegación LDS, succión 4000Pa, mapeo inteligente y control por app.',
 '{"marca":"Xiaomi","modelo":"S10","consumo_watts":"65","color":"Blanco","garantia_meses":"12","eficiencia":"A++","tipo":"Aspiradora"}',
 2199.00, 9, 'Publicado'),

(@id_negocio, 'Aspiradora Electrolux ZSP430',
 'Aspiradora Electrolux ZSP430 de 2200W con bolsa, filtro HEPA, radio de acción 9m y turbo cepillo.',
 '{"marca":"Electrolux","modelo":"ZSP430","consumo_watts":"2200","color":"Rojo","garantia_meses":"12","eficiencia":"A","tipo":"Aspiradora"}',
 1299.00, 11, 'Publicado'),

-- AIRE ACONDICIONADO / CLIMATIZACIÓN
(@id_negocio, 'Aire Acondicionado Samsung 12000 BTU',
 'Aire acondicionado Samsung Wind-Free de 12000 BTU, tecnología Digital Inverter, modo eco y filtro antipolvo.',
 '{"marca":"Samsung","modelo":"AR12","consumo_watts":"1300","color":"Blanco","garantia_meses":"24","eficiencia":"A++","tipo":"Aire Acondicionado"}',
 4599.00, 4, 'Publicado'),

(@id_negocio, 'Ventilador Imaco Turbo 20"',
 'Ventilador Imaco Turbo de 20 pulgadas con 3 velocidades, oscilación automática y base cromada.',
 '{"marca":"Imaco","modelo":"VT20","consumo_watts":"120","color":"Plata","garantia_meses":"6","eficiencia":"A","tipo":"Ventilador"}',
 349.00, 30, 'Publicado'),

-- PEQUEÑOS ELECTRODOMÉSTICOS
(@id_negocio, 'Licuadora Oster 600W',
 'Licuadora Oster de 600W con vaso de vidrio de 1.5L, 7 velocidades y función pulse.',
 '{"marca":"Oster","modelo":"BLSTVB","consumo_watts":"600","color":"Negro","garantia_meses":"12","eficiencia":"A","tipo":"Licuadora"}',
 449.00, 22, 'Publicado'),

(@id_negocio, 'Cafetera Dolce Gusto Genio S',
 'Cafetera Dolce Gusto Genio S, sistema de cápsulas, presión 15 bares, depósito 0.8L, preparación en segundos.',
 '{"marca":"Dolce Gusto","modelo":"Genio S","consumo_watts":"1500","color":"Negro/Rojo","garantia_meses":"12","eficiencia":"A","tipo":"Cafetera"}',
 1199.00, 16, 'Publicado'),

(@id_negocio, 'Plancha Philips GC455',
 'Plancha Philips GC455 de 2400W con suela cerámica, sistema anti-goteo y spray incorporado.',
 '{"marca":"Philips","modelo":"GC455","consumo_watts":"2400","color":"Azul","garantia_meses":"6","eficiencia":"A","tipo":"Plancha"}',
 299.00, 35, 'Publicado'),

(@id_negocio, 'Freidora Sin Aceite Imaco 5.5L',
 'Freidora de aire Imaco 5.5L con 8 programas predefinidos, temperatura regulable hasta 200°C y temporizador.',
 '{"marca":"Imaco","modelo":"AF55","consumo_watts":"1700","color":"Negro","garantia_meses":"12","eficiencia":"A+","tipo":"Freidora"}',
 899.00, 13, 'Publicado');

(@id_negocio, 'Smartwatch Samsung Galaxy Watch 6',
 'Smartwatch Samsung Galaxy Watch 6 de 44mm, GPS, monitor cardíaco, oxímetro, batería 40h, resistencia IP68.',
 '{"marca":"Samsung","modelo":"GW6","consumo_watts":"5","color":"Negro Grafito","garantia_meses":"12","eficiencia":"A++","tipo":"Smartwatch","imagenes_adicionales":"[]"}',
 2899.00, 10, 'Publicado'),

(@id_negocio, 'Tablet Lenovo Tab M10 3ra Gen',
 'Tablet Lenovo Tab M10 de 10.1 pulgadas HD, 4GB RAM, 64GB ROM, WiFi, Android 12, batería 5100mAh.',
 '{"marca":"Lenovo","modelo":"Tab M10","consumo_watts":"10","color":"Gris Oscuro","garantia_meses":"12","eficiencia":"A+","tipo":"Tablet","imagenes_adicionales":"[]"}',
 1599.00, 15, 'Publicado'),

(@id_negocio, 'Parlante Bluetooth JBL Charge 5',
 'Parlante Bluetooth JBL Charge 5 portátil con sonido envolvente, 20h de batería, resistencia IP67 y powerbank.',
 '{"marca":"JBL","modelo":"Charge 5","consumo_watts":"30","color":"Azul","garantia_meses":"12","eficiencia":"A","tipo":"Audio","imagenes_adicionales":"[]"}',
 999.00, 20, 'Publicado'),

(@id_negocio, 'Exprimidor Eléctrico Imaco 400W',
 'Exprimidor eléctrico Imaco de 400W con cesto filtrante de acero inoxidable, 2 velocidades y sistema anti-goteo.',
 '{"marca":"Imaco","modelo":"EX400","consumo_watts":"400","color":"Blanco","garantia_meses":"6","eficiencia":"A","tipo":"Exprimidor","imagenes_adicionales":"[]"}',
 349.00, 25, 'Publicado'),

(@id_negocio, 'Batidora KitchenAid Artisan 5KSM175',
 'Batidora KitchenAid Artisan de 5 cuartos, 10 velocidades, motor 300W, incluye batidor, gancho y mezclador.',
 '{"marca":"KitchenAid","modelo":"5KSM175","consumo_watts":"300","color":"Rojo","garantia_meses":"24","eficiencia":"A+","tipo":"Batidora","imagenes_adicionales":"[]"}',
 4599.00, 6, 'Publicado'),

(@id_negocio, 'Extractora de Jugos Philips HR1869',
 'Extractora de jugos Philips HR1869 de 800W, sistema de extracción en frío, fácil limpieza y depósito 1.5L.',
 '{"marca":"Philips","modelo":"HR1869","consumo_watts":"800","color":"Negro/Plata","garantia_meses":"12","eficiencia":"A","tipo":"Extractora","imagenes_adicionales":"[]"}',
 1299.00, 11, 'Publicado'),

(@id_negocio, 'Arrocera Oster 20 Tazas',
 'Arrocera Oster de 20 tazas con olla antiadherente extraíble, tapa de vidrio, función mantener caliente y vaporera.',
 '{"marca":"Oster","modelo":"CKSTAR20","consumo_watts":"700","color":"Blanco","garantia_meses":"12","eficiencia":"A","tipo":"Arrocera","imagenes_adicionales":"[]"}',
 549.00, 18, 'Publicado'),

(@id_negocio, 'Sandwichera Eléctrica Imaco 750W',
 'Sandwichera eléctrica Imaco de 750W con placas antiadherentes, indicador luminoso, para 2 sándwiches.',
 '{"marca":"Imaco","modelo":"SW750","consumo_watts":"750","color":"Negro","garantia_meses":"6","eficiencia":"A","tipo":"Sandwichera","imagenes_adicionales":"[]"}',
 249.00, 30, 'Publicado'),

(@id_negocio, 'Cafetera Espresso Oster Perfect Brew',
 'Cafetera espresso Oster Perfect Brew de 15 bares de presión, vaporizador de leche, depósito 1.2L y bandeja calienta tazas.',
 '{"marca":"Oster","modelo":"BVSTEMP","consumo_watts":"1100","color":"Acero Inoxidable","garantia_meses":"12","eficiencia":"A","tipo":"Cafetera","imagenes_adicionales":"[]"}',
 1799.00, 9, 'Publicado'),

(@id_negocio, 'Purificador de Aire Xiaomi Mi 4 Pro',
 'Purificador de aire Xiaomi Mi 4 Pro con filtro HEPA H13, cobertura 60m², control por app, modo automático y nocturno.',
 '{"marca":"Xiaomi","modelo":"Mi 4 Pro","consumo_watts":"50","color":"Blanco","garantia_meses":"12","eficiencia":"A++","tipo":"Purificador","imagenes_adicionales":"[]"}',
 1899.00, 7, 'Publicado');

SELECT CONCAT('✓ Seed Electrodomésticos completado: ', COUNT(*), ' productos insertados') AS resultado FROM productos WHERE id_emprendimiento = @id_negocio;
