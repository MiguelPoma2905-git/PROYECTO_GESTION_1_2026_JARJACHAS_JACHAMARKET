-- ==============================================================================
-- 1. PREPARACIÓN DE LA BASE DE DATOS
-- ==============================================================================
DROP DATABASE IF EXISTS db_jacha;
CREATE DATABASE db_jacha CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_jacha;

-- ==============================================================================
-- MÓDULO 1: SEGURIDAD, IDENTIDAD Y AUDITORÍA
-- ==============================================================================

CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB;

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE rol_permiso (
    id_rol INT,
    id_permiso INT,
    PRIMARY KEY (id_rol, id_permiso),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    id_rol INT NOT NULL,
    estado ENUM('Activo', 'Inactivo', 'Suspendido') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
    INDEX idx_email (email)
) ENGINE=InnoDB;

CREATE TABLE logs_auditoria (
    id_log BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT,
    tabla_afectada VARCHAR(50) NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    datos_viejos JSON,
    datos_nuevos JSON,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_origen VARCHAR(45),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==============================================================================
-- MÓDULO 2: NÚCLEO MULTI-TENANT (EMPRENDIMIENTOS Y SUCURSALES)
-- ==============================================================================

CREATE TABLE emprendimientos (
    id_emprendimiento BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_propietario BIGINT NOT NULL,
    nombre_comercial VARCHAR(150) NOT NULL,
    nit VARCHAR(30) UNIQUE,
    descripcion TEXT,
    logo_url VARCHAR(255),
    estado ENUM('Pendiente', 'Aprobado', 'Rechazado') DEFAULT 'Pendiente',
    FOREIGN KEY (id_propietario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

CREATE TABLE sucursales (
    id_sucursal BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_emprendimiento BIGINT NOT NULL,
    nombre_sucursal VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    ciudad VARCHAR(50) NOT NULL,
    latitud DECIMAL(10,8),
    longitud DECIMAL(11,8),
    FOREIGN KEY (id_emprendimiento) REFERENCES emprendimientos(id_emprendimiento) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==============================================================================
-- MÓDULO 3: CATÁLOGO Y ESTRUCTURA DE PRODUCTOS
-- ==============================================================================

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    id_padre INT NULL,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    FOREIGN KEY (id_padre) REFERENCES categorias(id_categoria) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE productos (
    id_producto BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_emprendimiento BIGINT NOT NULL,
    id_categoria INT,
    nombre VARCHAR(200) NOT NULL,
    descripcion_larga TEXT,
    precio_base DECIMAL(10,2) NOT NULL,
    estado ENUM('Borrador', 'Publicado', 'Oculto') DEFAULT 'Borrador',
    FOREIGN KEY (id_emprendimiento) REFERENCES emprendimientos(id_emprendimiento) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    INDEX idx_busqueda (nombre)
) ENGINE=InnoDB;

CREATE TABLE variantes_producto (
    id_variante BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_producto BIGINT NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    atributo_1 VARCHAR(50), 
    valor_1 VARCHAR(50),    
    atributo_2 VARCHAR(50), 
    valor_2 VARCHAR(50),    
    precio_adicional DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==============================================================================
-- MÓDULO 4: INVENTARIO Y KARDEX (TRANSACCIONES ACID)
-- ==============================================================================

CREATE TABLE inventario (
    id_inventario BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_variante BIGINT NOT NULL,
    id_sucursal BIGINT NOT NULL,
    cantidad_actual INT DEFAULT 0,
    alerta_minima INT DEFAULT 5,
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante) ON DELETE CASCADE,
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id_sucursal) ON DELETE CASCADE,
    UNIQUE (id_variante, id_sucursal)
) ENGINE=InnoDB;

CREATE TABLE movimientos_kardex (
    id_movimiento BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_inventario BIGINT NOT NULL,
    tipo ENUM('Ingreso_Compra', 'Salida_Venta', 'Ajuste_Perdida', 'Transferencia') NOT NULL,
    cantidad INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario_responsable BIGINT NOT NULL,
    observacion TEXT,
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_usuario_responsable) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ==============================================================================
-- MÓDULO 5: MARKETPLACE, LOGÍSTICA Y VENTAS
-- ==============================================================================

CREATE TABLE pedidos (
    id_pedido BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_cliente BIGINT NOT NULL,
    id_sucursal_origen BIGINT NOT NULL,
    codigo_seguimiento VARCHAR(50) UNIQUE NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    costo_envio DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('QR', 'Tarjeta', 'Efectivo', 'Transferencia') NOT NULL,
    estado_pago ENUM('Pendiente', 'Completado', 'Fallido', 'Reembolsado') DEFAULT 'Pendiente',
    estado_logistico ENUM('Recibido', 'Preparando', 'En_Ruta', 'Entregado', 'Cancelado') DEFAULT 'Recibido',
    direccion_entrega TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_sucursal_origen) REFERENCES sucursales(id_sucursal)
) ENGINE=InnoDB;

CREATE TABLE detalles_pedido (
    id_detalle BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT NOT NULL,
    id_variante BIGINT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL, 
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante)
) ENGINE=InnoDB;

CREATE TABLE envios_logistica (
    id_envio BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT NOT NULL UNIQUE,
    id_repartidor BIGINT NULL,
    distancia_km DECIMAL(6,2),
    tiempo_estimado_min INT,   
    fecha_despacho TIMESTAMP NULL,
    fecha_entrega TIMESTAMP NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_repartidor) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ==============================================================================
-- MÓDULO 6: PLANTILLAS Y PERSONALIZACIÓN (NUEVO)
-- ==============================================================================

-- Tabla para plantillas predefinidas de diseño
CREATE TABLE plantillas (
    id_plantilla INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    color_primario VARCHAR(7) DEFAULT '#C0392B',
    color_secundario VARCHAR(7) DEFAULT '#2C3E50',
    color_fondo VARCHAR(7) DEFAULT '#FDFBF7',
    color_texto VARCHAR(7) DEFAULT '#2D2D2D',
    vista_previa_url VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- Insertar plantillas por defecto
INSERT INTO plantillas (nombre, descripcion, color_primario, color_secundario) VALUES
('Moderno', 'Diseño limpio y moderno para tiendas generales', '#C0392B', '#2C3E50'),
('Elegante', 'Para negocios de moda y accesorios', '#2C3E50', '#C0392B'),
('Rústico', 'Para artesanías y productos naturales', '#8B4513', '#D2691E'),
('Tecnológico', 'Para electrónica y gadgets', '#3498DB', '#2C3E50'),
('Gastronómico', 'Para restaurantes y delivery de comida', '#E67E22', '#C0392B');

-- Tabla para personalización específica de cada emprendimiento (NUEVA)
CREATE TABLE personalizacion_emprendimiento (
    id_personalizacion BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_emprendimiento BIGINT NOT NULL,
    id_plantilla INT NOT NULL,
    color_primario VARCHAR(7),
    color_secundario VARCHAR(7),
    color_fondo VARCHAR(7),
    color_texto VARCHAR(7),
    logo_personalizado VARCHAR(255),
    banner_personalizado VARCHAR(255),
    modo_oscuro BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_emprendimiento) REFERENCES emprendimientos(id_emprendimiento) ON DELETE CASCADE,
    FOREIGN KEY (id_plantilla) REFERENCES plantillas(id_plantilla)
) ENGINE=InnoDB;

-- Tabla para OTP - Verificación por correo electrónico (NUEVA)
CREATE TABLE otp_verificacion (
    id_otp BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    codigo VARCHAR(6) NOT NULL,
    expira_en TIMESTAMP NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    intentos INT DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_codigo (email, codigo)
) ENGINE=InnoDB;

-- ==============================================================================
-- AUTOMATIZACIÓN AVANZADA: TRIGGERS (DISPARADORES)
-- ==============================================================================

DELIMITER //

CREATE TRIGGER trg_descontar_stock_y_kardex
AFTER INSERT ON detalles_pedido
FOR EACH ROW
BEGIN
    DECLARE v_id_sucursal BIGINT;
    DECLARE v_id_inventario BIGINT;
    DECLARE v_id_cliente BIGINT;

    -- 1. Averiguar de qué sucursal salió el pedido y quién lo compró
    SELECT id_sucursal_origen, id_cliente INTO v_id_sucursal, v_id_cliente
    FROM pedidos WHERE id_pedido = NEW.id_pedido;

    -- 2. Buscar el ID exacto del inventario para ese producto en esa sucursal específica
    SELECT id_inventario INTO v_id_inventario
    FROM inventario
    WHERE id_variante = NEW.id_variante AND id_sucursal = v_id_sucursal;

    -- 3. Descontar el stock automáticamente
    UPDATE inventario
    SET cantidad_actual = cantidad_actual - NEW.cantidad
    WHERE id_inventario = v_id_inventario;

    -- 4. Registrar la salida en el Kardex para auditoría
    INSERT INTO movimientos_kardex (id_inventario, tipo, cantidad, id_usuario_responsable, observacion)
    VALUES (v_id_inventario, 'Salida_Venta', -NEW.cantidad, v_id_cliente, CONCAT('Descuento automático por Venta. Pedido #', NEW.id_pedido));
END //

DELIMITER ;