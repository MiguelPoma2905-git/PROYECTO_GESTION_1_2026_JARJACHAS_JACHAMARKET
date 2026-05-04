-- ==============================================================================
-- POBLACIÓN DE 5000 PRODUCTOS CON NOMBRES REALISTAS
-- Para TecnoStore Bolivia y Artesanías Los Andes
-- ==============================================================================
USE db_jacha;

-- Obtener IDs de los emprendimientos
SET @id_tecnostore = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'TecnoStore Bolivia' LIMIT 1);
SET @id_artesanias = (SELECT id_emprendimiento FROM emprendimientos WHERE nombre_comercial = 'Artesanías Los Andes' LIMIT 1);

-- Verificar que existen
SELECT @id_tecnostore AS id_tecnostore, @id_artesanias AS id_artesanias;

-- ==============================================================================
-- 1. PRODUCTOS PARA TECNOSTORE BOLIVIA (2500 productos - Electrónica)
-- ==============================================================================

-- Laptops y computadoras (300 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock) VALUES
(@id_tecnostore, 'Laptop Lenovo ThinkPad E15', 1899.99, 'Laptop empresarial con procesador Intel Core i5, 8GB RAM, 256GB SSD', 'Publicado', 15),
(@id_tecnostore, 'MacBook Air M2', 4999.99, 'Apple MacBook Air con chip M2, 8GB RAM, 256GB SSD', 'Publicado', 8),
(@id_tecnostore, 'HP Pavilion Gaming 15', 2899.99, 'Laptop gamer con RTX 3050, 16GB RAM, 512GB SSD', 'Publicado', 12),
(@id_tecnostore, 'Dell XPS 13 Plus', 3899.99, 'Ultrabook premium con pantalla OLED, Intel i7, 16GB RAM', 'Publicado', 5),
(@id_tecnostore, 'Asus ROG Zephyrus G14', 3599.99, 'Laptop gamer compacta con AMD Ryzen 9, RTX 4060', 'Publicado', 7);

-- Insertar más laptops (295 productos generados)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 295)
SELECT 
    @id_tecnostore,
    ELT(1 + (n % 10),
        'Laptop Acer Aspire 5', 'Laptop Lenovo IdeaPad 3', 'Laptop HP 15s', 'Laptop Dell Inspiron 15', 
        'Laptop Asus Vivobook 15', 'Laptop MSI Modern 14', 'Laptop Huawei MateBook D15', 
        'Laptop Samsung Galaxy Book2', 'Laptop Gigabyte G5', 'Laptop Acer Swift 3'
    ) AS nombre,
    ROUND(800 + RAND() * 3000, 2) AS precio,
    'Laptop de alta calidad para uso diario' AS descripcion,
    'Publicado',
    FLOOR(5 + RAND() * 30) AS stock
FROM generador;

-- Celulares y smartphones (400 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock) VALUES
(@id_tecnostore, 'iPhone 15 Pro Max', 5999.99, 'Apple iPhone 15 Pro Max con cámara de 48MP', 'Publicado', 20),
(@id_tecnostore, 'Samsung Galaxy S24 Ultra', 5399.99, 'Smartphone premium con pantalla Dynamic AMOLED', 'Publicado', 18),
(@id_tecnostore, 'Xiaomi 13 Pro', 2899.99, 'Smartphone con cámara Leica, Snapdragon 8 Gen 2', 'Publicado', 25),
(@id_tecnostore, 'Google Pixel 8 Pro', 3199.99, 'Pixel con IA integrada, mejor cámara del año', 'Publicado', 12),
(@id_tecnostore, 'Motorola Edge 40', 1899.99, 'Moto Edge con pantalla curva 144Hz', 'Publicado', 22);

INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 395)
SELECT 
    @id_tecnostore,
    ELT(1 + (n % 12),
        'Xiaomi Redmi Note 12', 'Samsung Galaxy A54', 'Motorola G84', 'POCO F5', 
        'Realme 11 Pro', 'OnePlus Nord 3', 'Tecno Camon 20', 'Infinix Note 30',
        'iPhone 14', 'Samsung Galaxy A34', 'Xiaomi 12 Lite', 'Honor 90'
    ) AS nombre,
    ROUND(150 + RAND() * 2000, 2) AS precio,
    'Smartphone de última generación' AS descripcion,
    'Publicado',
    FLOOR(10 + RAND() * 50) AS stock
FROM generador;

-- Accesorios electrónicos (500 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 500)
SELECT 
    @id_tecnostore,
    ELT(1 + (n % 25),
        'Audífonos Bluetooth Sony WH-1000XM5', 'Audífonos Samsung Galaxy Buds2', 'Audífonos Xiaomi Buds 3T Pro',
        'Mouse Logitech MX Master 3S', 'Teclado mecánico Redragon K552', 'Monitor Samsung Odyssey G5',
        'Disco SSD externo 1TB', 'Memoria USB 64GB', 'Cargador rápido 65W', 'Funda para laptop 15.6 pulgadas',
        'Base refrigeradora para laptop', 'Cable USB-C 2 metros', 'Adaptador HDMI a VGA', 'Webcam 4K Logitech',
        'Micrófono HyperX QuadCast', 'Silla gamer X-Plus', 'Pad de mouse RGB', 'Router Wi-Fi 6 TP-Link',
        'Power Bank 20000mAh', 'Lámpara LED para monitor', 'Soporte ajustable para laptop', 'Hub USB-C multipuerto',
        'Tarjeta gráfica RTX 4060', 'Procesador Intel i7-13700K', 'Placa madre ASUS ROG'
    ) AS nombre,
    ROUND(20 + RAND() * 1500, 2) AS precio,
    'Accesorio tecnológico de alta calidad' AS descripcion,
    'Publicado',
    FLOOR(15 + RAND() * 100) AS stock
FROM generador;

-- Componentes PC (500 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 500)
SELECT 
    @id_tecnostore,
    ELT(1 + (n % 20),
        'Procesador AMD Ryzen 7 7800X3D', 'Procesador Intel Core i9-13900K', 'Procesador AMD Ryzen 5 7600X',
        'Tarjeta gráfica NVIDIA RTX 4070', 'Tarjeta gráfica AMD Radeon RX 7800 XT', 'Memoria RAM DDR5 32GB Corsair',
        'Memoria RAM DDR4 16GB Kingston', 'SSD NVMe 1TB Samsung 980 Pro', 'Disco duro 2TB Seagate Barracuda',
        'Fuente de poder 750W Corsair', 'Gabinete gamer Lian Li PC-O11', 'Refrigeración líquida NZXT Kraken',
        'Ventilador 120mm RGB Cooler Master', 'Placa madre MSI B650', 'Placa madre ASUS Z790',
        'Tarjeta de sonido Creative', 'Tarjeta de red Wi-Fi 6E', 'Cables personalizados sleeved',
        'Kit de gestión de cables', 'Pasta térmica Arctic MX-6'
    ) AS nombre,
    ROUND(50 + RAND() * 2000, 2) AS precio,
    'Componente para PC de alto rendimiento' AS descripcion,
    'Publicado',
    FLOOR(5 + RAND() * 40) AS stock
FROM generador;

-- Electrónica de consumo (800 productos restantes)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 800)
SELECT 
    @id_tecnostore,
    ELT(1 + (n % 30),
        'Smart TV Samsung 55" 4K', 'Smart TV LG OLED 65"', 'Smart TV TCL 50" Android', 'Proyector Epson Home Cinema',
        'Tablet Samsung Galaxy Tab S9', 'Tablet iPad 10.9"', 'Tablet Lenovo Tab P11', 'Smartwatch Apple Watch Series 9',
        'Smartwatch Samsung Galaxy Watch 6', 'Smartwatch Xiaomi Watch 2 Pro', 'Bocina Bluetooth JBL Charge 5',
        'Bocina Sony SRS-XB43', 'Soundbar Samsung HW-Q990C', 'HomePod Apple', 'Echo Dot Alexa 5ta gen',
        'Cámara Canon EOS R10', 'Cámara Sony Alpha 7 III', 'Cámara Nikon Z50', 'Drone DJI Mini 3 Pro',
        'Drone DJI Air 2S', 'Grabadora Zoom H1n', 'Tripode profesional Manfrotto', 'Filtros para cámara',
        'Lente Canon 50mm f/1.8', 'Lente Sony 24-70mm', 'Kindle Paperwhite', 'Google Chromecast 4K', 
        'Apple TV 4K', 'Nintendo Switch OLED', 'PlayStation 5'
    ) AS nombre,
    ROUND(100 + RAND() * 4000, 2) AS precio,
    'Electrónica de consumo de alta calidad' AS descripcion,
    'Publicado',
    FLOOR(5 + RAND() * 60) AS stock
FROM generador;

-- ==============================================================================
-- 2. PRODUCTOS PARA ARTESANÍAS LOS ANDES (2500 productos - Artesanía)
-- ==============================================================================

-- Textiles y tejidos (500 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 500)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 25),
        'Chaleco de alpaca tejido a mano', 'Bufanda de lana de oveja', 'Poncho tradicional andino', 
        'Aguayo multicolor artesanal', 'Chullo con orejeras de llama', 'Frazada de alpaca size queen',
        'Alfombra tejida a telar', 'Cojín bordado a mano', 'Camiseta de algodón de alpaca',
        'Chompa de alpaca para dama', 'Chompa de alpaca para caballero', 'Guantes de lana de oveja',
        'Gorro tejido con diseños andinos', 'Manta de baby alpaca', 'Ruana de lana merino',
        'Saco de alpaca elegante', 'Cardigan tejido a mano', 'Poncho de lana para niño',
        'Faja tradicional andina', 'Bolso de tela artesanal', 'Mochila tejida a telar',
        'Cinturón de lana tejido', 'Vincha de lana de alpaca', 'Calentadores de lana', 'Cubre brazos artesanal'
    ) AS nombre,
    ROUND(30 + RAND() * 500, 2) AS precio,
    'Prenda tejida a mano con materiales 100% naturales' AS descripcion,
    'Publicado',
    FLOOR(10 + RAND() * 80) AS stock
FROM generador;

-- Joyería artesanal (400 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 400)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 25),
        'Collar de plata 925 con piedra andina', 'Pulsera de plata con turquesa', 'Aretes de plata y lapislázuli',
        'Anillo de plata con ópalo', 'Dije de plata con forma de sol', 'Brazalete de alpaca artesanal',
        'Collar de semillas naturales', 'Pulsera de cuero con plata', 'Aretes de plata filigrana',
        'Anillo de plata con piedra luna', 'Collar de conchas marinas', 'Pulsera de nudo andino',
        'Broche de plata con esmeralda', 'Colgante de plata con cóndor', 'Aretes de plata y perla',
        'Anillo de plata con inca rosa', 'Collar de chaquiras multicolor', 'Pulsera de hilo con mostacillas',
        'Aretes de plata y ágata', 'Tupo de plata (prendedor)', 'Nudo infinito de plata', 
        'Cruz andina de alpaca', 'Espiral de plata pura', 'Collar de plata con ojo de tigre', 
        'Pulsera de plata con citrino'
    ) AS nombre,
    ROUND(15 + RAND() * 300, 2) AS precio,
    'Joyería artesanal elaborada por manos bolivianas' AS descripcion,
    'Publicado',
    FLOOR(15 + RAND() * 60) AS stock
FROM generador;

-- Cerámica y alfarería (400 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 400)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 20),
        'Jarrón de cerámica pintado a mano', 'Plato decorativo andino', 'Taza de barro artesanal', 
        'Áncora de cerámica esmaltada', 'Figura de llama en cerámica', 'Puma de arcilla policromada',
        'Cóndor artesanal de cerámica', 'Máscara ceremonial de barro', 'Macetero decorativo pintado',
        'Fuente de agua en cerámica', 'Vasija ceremonial inca', 'Queru (vaso ceremonial)',
        'Pucará de arcilla (torito)', 'Iguana de cerámica esmaltada', 'Sapo de la suerte en cerámica',
        'Campana decorativa de barro', 'Portalápices artesanal', 'Bandera de cerámica Wiphala',
        'Reloj de pared en cerámica', 'Cenicero decorativo de barro'
    ) AS nombre,
    ROUND(20 + RAND() * 250, 2) AS precio,
    'Cerámica artesanal cocida a mano y pintada' AS descripcion,
    'Publicado',
    FLOOR(10 + RAND() * 50) AS stock
FROM generador;

-- Madera tallada (400 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 400)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 20),
        'Máscara de madera de nogal', 'Figura tallada de cóndor', 'Retablo de madera pintado', 
        'Caja de madera incrustada', 'Cuchara de palo tallada', 'Cruz de madera artesanal',
        'Carranca (máscara de madera)', 'Bastón de madera tallada', 'Marco de fotos tallado',
        'Reloj de pared de madera', 'Bandera Wiphala en madera', 'Rompecabezas de madera',
        'Juego de ajedrez tallado', 'Cuna para bebé en madera', 'Sillón de madera tallada',
        'Mesa auxiliar de nogal', 'Porta velas de madera', 'Copa de madera torneada',
        'Pisa papeles de madera', 'Llavero de madera tallada'
    ) AS nombre,
    ROUND(25 + RAND() * 400, 2) AS precio,
    'Artesanía en madera tallada a mano' AS descripcion,
    'Publicado',
    FLOOR(5 + RAND() * 40) AS stock
FROM generador;

-- Instrumentos musicales (300 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 300)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 20),
        'Zampoña profesional 25 tubos', 'Quena de bambú en Re', 'Charango de tapa de cedro', 
        'Bombo legüero artesanal', 'Tarka de madera', 'Pinkillo tradicional',
        'Violín artesanal de cedro', 'Guitarra criolla', 'Cuatro venezolano', 'Mandolina de cedro',
        'Maracas de calabaza', 'Cajón peruano artesanal', 'Sikus (zampoña pequeña)',
        'Antara de cerámica', 'Pututo (corneta de concha)', 'Tinya (tambor pequeño)',
        'Caja de madera para instrumentos', 'Soporte para charango', 'Cuerdas para charango', 
        'Capodastro para instrumentos'
    ) AS nombre,
    ROUND(50 + RAND() * 800, 2) AS precio,
    'Instrumento musical artesanal de alta calidad sonora' AS descripcion,
    'Publicado',
    FLOOR(5 + RAND() * 30) AS stock
FROM generador;

-- Cuadros y arte (500 productos)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 500)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 25),
        'Cuadro óleo Salar de Uyuni', 'Acuarela Lago Titicaca', 'Grabado de la ciudad de La Paz', 
        'Dibujo ceremonial andino', 'Tapiz mural colorido', 'Retrato en tela de mujer andina',
        'Pintura acrílica cóndor andino', 'Cuadro textil wiphala', 'Estampa de mineros potosinos',
        'Acuarela de flores tradicionales', 'Óleo de paisaje valluno', 'Dibujo de cerro Rico',
        'Cuadro de danza de los tinkus', 'Pintura de la Virgen de Copacabana', 'Tapiz de lana bordado',
        'Grabado de la Casa de la Libertad', 'Acuarela de los Yungas', 'Cuadro de lago Poopó',
        'Dibujo de flora y fauna andina', 'Pintura de carnaval de Oruro', 'Óleo de tradiciones bolivianas',
        'Acuarela de salteñas', 'Cuadro abstracto andino', 'Tapiz de feria de alasitas', 
        'Grabado de la Revolución boliviana'
    ) AS nombre,
    ROUND(50 + RAND() * 1500, 2) AS precio,
    'Obra de arte original de artistas bolivianos' AS descripcion,
    'Publicado',
    FLOOR(3 + RAND() * 25) AS stock
FROM generador;

-- más artesanías varias (el resto hasta 2500)
INSERT INTO productos (id_emprendimiento, nombre, precio_base, descripcion_larga, estado, stock)
WITH RECURSIVE generador AS (SELECT 1 AS n UNION ALL SELECT n + 1 FROM generador WHERE n < 400)
SELECT 
    @id_artesanias,
    ELT(1 + (n % 25),
        'Manta de vicuña', 'Bolso de cuero de llama', 'Cartera de aguayo tejido', 'Mochila andina colorida',
        'Sombrero de lana de alpaca', 'Zapatos artesanales de cuero', 'Manillas de mostacilla', 
        'Llavero de lana de alpaca', 'Porta celular tejido', 'Billetera de cuero grabado',
        'Calzado de cuero artesanal', 'Cinturón de cuero de res', 'Gorra de lana con diseños',
        'Chaleco reversible andino', 'Poncho para bebé de alpaca', 'Cuna de madera para muñeca',
        'Cochecito artesanal de madera', 'Mueble para TV de cedro', 'Biblioteca de madera tallada',
        'Perchero de madera de algarrobo', 'Espejo de marco artesanal', 'Lámpara de pie de madera',
        'Bandeja de madera con incrustaciones', 'Juego de cubiertos de madera', 'Porta botellas de madera'
    ) AS nombre,
    ROUND(10 + RAND() * 200, 2) AS precio,
    'Artesanía boliviana de alta calidad' AS descripcion,
    'Publicado',
    FLOOR(20 + RAND() * 100) AS stock
FROM generador;

-- ==============================================================================
-- VERIFICACIÓN FINAL
-- ==============================================================================
SELECT 
    e.nombre_comercial,
    COUNT(*) AS total_productos
FROM productos p
JOIN emprendimientos e ON p.id_emprendimiento = e.id_emprendimiento
GROUP BY e.id_emprendimiento;

SELECT COUNT(*) AS total_general FROM productos;
SELECT 'POBLACIÓN DE PRODUCTOS COMPLETADA' AS mensaje;