-- Insertar plantillas por defecto
INSERT INTO plantillas (nombre, descripcion, color_primario, color_secundario, activo) VALUES
('Moderno', 'Diseño limpio y moderno para tiendas generales', '#C0392B', '#2C3E50', 1),
('Elegante', 'Para negocios de moda y accesorios', '#2C3E50', '#C0392B', 1),
('Rústico', 'Para artesanías y productos naturales', '#8B4513', '#D2691E', 1),
('Tecnológico', 'Para electrónica y gadgets', '#3498DB', '#2C3E50', 1),
('Gastronómico', 'Para restaurantes y delivery de comida', '#E67E22', '#C0392B', 1),
('Electrodomésticos', 'Diseño moderno y profesional para tiendas de electrodomésticos y tecnología del hogar', '#1A3A5C', '#2C6FBB', 1);

-- Insertar roles si no existen
INSERT IGNORE INTO roles (nombre_rol) VALUES 
('Administrador'),
('Emprendedor'),
('Cliente'),
('Repartidor');

-- Insertar categorías por defecto
INSERT INTO categorias (nombre, slug) VALUES
('Moda', 'moda'),
('Artesanía', 'artesania'),
('Comida', 'comida'),
('Tecnología', 'tecnologia'),
('Hogar', 'hogar');