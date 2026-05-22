-- ==============================================================================
-- SCRIPT CORREGIDO: DB_JACHA - CON PARTICIONES (VERSIÓN FUNCIONAL)
-- Corrige: error #1010 al dropear DB con particiones,
--          trigger que actualizaba stock con id incorrecto,
--          inserts faltantes de sucursales,
--          campo fecha_pedido sin DEFAULT
-- ==============================================================================

-- ==============================
-- 0. LIMPIEZA INICIAL (segura para particiones)
-- ==============================
CREATE DATABASE IF NOT EXISTS db_jacha CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_jacha;

DROP TABLE IF EXISTS movimientos_kardex;
DROP TABLE IF EXISTS inventario;
DROP TABLE IF EXISTS variantes_producto;
DROP TABLE IF EXISTS detalles_pedido;
DROP TABLE IF EXISTS envios_logistica;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS personalizacion_emprendimiento;
DROP TABLE IF EXISTS plantillas;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS sucursales;
DROP TABLE IF EXISTS emprendimientos;
DROP TABLE IF EXISTS usuario_roles;
DROP TABLE IF EXISTS otp_verificacion;
DROP TABLE IF EXISTS rol_permiso;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS permisos;
DROP TABLE IF EXISTS logs_auditoria;
DROP TABLE IF EXISTS usuarios;

-- ==============================
-- 1. TABLAS PRINCIPALES
-- ==============================
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
    avatar VARCHAR(255) NULL,
    bio TEXT NULL,
    ubicacion VARCHAR(100) NULL,
    estado ENUM('Activo', 'Inactivo', 'Suspendido') DEFAULT 'Activo',
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

CREATE TABLE logs_auditoria (
    id_log BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT,
    tabla_afectada VARCHAR(50) NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    datos_viejos JSON,
    datos_nuevos JSON,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_origen VARCHAR(45),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==============================
-- 2. EMPRENDIMIENTOS Y SUCURSALES
-- ==============================
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

-- ==============================
-- 3. CATÁLOGO Y PRODUCTOS
-- ==============================
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
    atributos JSON NULL,
    imagen_url VARCHAR(255) DEFAULT NULL,
    precio_base DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    estado ENUM('Borrador', 'Publicado', 'Oculto') DEFAULT 'Borrador',
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

-- ==============================
-- 4. INVENTARIO Y KARDEX
-- ==============================
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
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario_responsable BIGINT NOT NULL,
    observacion TEXT,
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_usuario_responsable) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ==============================
-- 5. PEDIDOS CON PARTICIONES
-- ==============================
CREATE TABLE pedidos (
    id_pedido BIGINT AUTO_INCREMENT,
    id_cliente BIGINT NOT NULL,
    id_sucursal_origen BIGINT NOT NULL,
    codigo_seguimiento VARCHAR(50) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    costo_envio DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('QR', 'Tarjeta', 'Efectivo', 'Transferencia') NOT NULL,
    estado_pago ENUM('Pendiente', 'Completado', 'Fallido', 'Reembolsado') DEFAULT 'Pendiente',
    estado_logistico ENUM('Recibido', 'Preparando', 'En_Ruta', 'Entregado', 'Cancelado') DEFAULT 'Recibido',
    direccion_entrega TEXT NOT NULL,
    fecha_creacion DATE NOT NULL,
    PRIMARY KEY (id_pedido, fecha_creacion),
    INDEX idx_cliente (id_cliente),
    INDEX idx_sucursal (id_sucursal_origen),
    INDEX idx_fecha (fecha_creacion),
    INDEX idx_codigo (codigo_seguimiento)
) ENGINE=InnoDB
PARTITION BY RANGE COLUMNS(fecha_creacion)
(
    PARTITION p_ene_2025 VALUES LESS THAN ('2025-02-01'),
    PARTITION p_feb_2025 VALUES LESS THAN ('2025-03-01'),
    PARTITION p_mar_2025 VALUES LESS THAN ('2025-04-01'),
    PARTITION p_abr_2025 VALUES LESS THAN ('2025-05-01'),
    PARTITION p_may_2025 VALUES LESS THAN ('2025-06-01'),
    PARTITION p_jun_2025 VALUES LESS THAN ('2025-07-01'),
    PARTITION p_jul_2025 VALUES LESS THAN ('2025-08-01'),
    PARTITION p_ago_2025 VALUES LESS THAN ('2025-09-01'),
    PARTITION p_sep_2025 VALUES LESS THAN ('2025-10-01'),
    PARTITION p_oct_2025 VALUES LESS THAN ('2025-11-01'),
    PARTITION p_nov_2025 VALUES LESS THAN ('2025-12-01'),
    PARTITION p_dic_2025 VALUES LESS THAN ('2026-01-01'),
    PARTITION p_futuro VALUES LESS THAN MAXVALUE
);

-- CORREGIDO: fecha_pedido con DEFAULT para compatibilidad con PedidoModel
CREATE TABLE detalles_pedido (
    id_detalle BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT NOT NULL,
    id_variante BIGINT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL, 
    subtotal DECIMAL(10,2) NOT NULL,
    fecha_pedido DATE DEFAULT (CURRENT_DATE),
    INDEX idx_pedido (id_pedido),
    INDEX idx_variante (id_variante)
) ENGINE=InnoDB;

CREATE TABLE envios_logistica (
    id_envio BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT NOT NULL UNIQUE,
    id_repartidor BIGINT NULL,
    distancia_km DECIMAL(6,2),
    tiempo_estimado_min INT,   
    fecha_despacho DATETIME NULL,
    fecha_entrega DATETIME NULL,
    INDEX idx_pedido (id_pedido),
    INDEX idx_repartidor (id_repartidor)
) ENGINE=InnoDB;

-- ==============================
-- 6. PLANTILLAS Y PERSONALIZACIÓN
-- ==============================
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

CREATE TABLE otp_verificacion (
    id_otp BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    codigo VARCHAR(6) NOT NULL,
    expira_en DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    intentos INT DEFAULT 0,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_codigo (email, codigo)
) ENGINE=InnoDB;

-- ==============================
-- 7. ROLES DE USUARIO
-- ==============================
CREATE TABLE usuario_roles (
    id_usuario BIGINT NOT NULL,
    id_rol INT NOT NULL,
    PRIMARY KEY (id_usuario, id_rol),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==============================
-- 8. DATOS INICIALES
-- ==============================
INSERT INTO roles (nombre_rol) VALUES 
('Administrador'), ('Emprendedor'), ('Cliente'), ('Repartidor');

INSERT INTO plantillas (nombre, descripcion, color_primario, color_secundario, activo) VALUES
('Moderno', 'Diseño limpio y moderno', '#C0392B', '#2C3E50', 1),
('Elegante', 'Para negocios de moda', '#2C3E50', '#C0392B', 1),
('Rústico', 'Para artesanías', '#8B4513', '#D2691E', 1),
('Tecnológico', 'Para electrónica', '#3498DB', '#2C3E50', 1),
('Gastronómico', 'Para restaurantes', '#E67E22', '#C0392B', 1),
('Electrodomésticos', 'Diseño moderno y profesional para tiendas de electrodomésticos y tecnología del hogar', '#1A3A5C', '#2C6FBB', 1);

INSERT INTO categorias (nombre, slug) VALUES
('Moda', 'moda'),
('Artesanía', 'artesania'),
('Comida', 'comida'),
('Tecnología', 'tecnologia'),
('Hogar', 'hogar');

-- ==============================
-- 9. SUPER ADMINISTRADOR
-- ==============================
INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado) VALUES
('Miguel Angel', 'Poma Ramos', 'mikypramos2905@gmail.com', '$2y$10$okmF5BfryvYouyDxkc.P7uLVGs/AhqMZDdeuJrT/UrxTU4xOtLXWi', '71234567', 'Activo');

INSERT INTO usuario_roles (id_usuario, id_rol)
SELECT u.id_usuario, r.id_rol
FROM usuarios u, roles r
WHERE u.email = 'mikypramos2905@gmail.com'
AND r.nombre_rol IN ('Administrador', 'Emprendedor', 'Cliente');

-- ==============================
-- 10. ÍNDICE
-- ==============================
CREATE INDEX idx_productos_emprendimiento_precio ON productos(id_emprendimiento, precio_base);

-- ==============================
-- 11. FUNCIÓN
-- ==============================
DELIMITER //
CREATE FUNCTION fn_calcular_ganancia_neta(p_precio_venta DECIMAL(10,2), p_costo DECIMAL(10,2), p_impuesto_porcentaje DECIMAL(5,2))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE v_ganancia_bruta DECIMAL(10,2);
    DECLARE v_impuesto DECIMAL(10,2);
    SET v_ganancia_bruta = p_precio_venta - p_costo;
    SET v_impuesto = v_ganancia_bruta * (p_impuesto_porcentaje / 100);
    RETURN v_ganancia_bruta - v_impuesto;
END //
DELIMITER ;

-- ==============================
-- 12. PROCEDIMIENTO
-- ==============================
DELIMITER //
CREATE PROCEDURE sp_reporte_ventas_emprendimiento(IN p_id_emprendimiento INT, IN p_fecha_inicio DATE, IN p_fecha_fin DATE)
BEGIN
    SELECT e.nombre_comercial, COUNT(DISTINCT p.id_pedido) AS total_pedidos
    FROM emprendimientos e
    JOIN sucursales s ON e.id_emprendimiento = s.id_emprendimiento
    JOIN pedidos p ON s.id_sucursal = p.id_sucursal_origen
    WHERE e.id_emprendimiento = p_id_emprendimiento AND p.fecha_creacion BETWEEN p_fecha_inicio AND p_fecha_fin
    GROUP BY e.id_emprendimiento;
END //
DELIMITER ;

-- ==============================
-- 13. TRIGGER
-- ==============================
DELIMITER //
CREATE TRIGGER trg_actualizar_stock_venta
AFTER INSERT ON detalles_pedido
FOR EACH ROW
BEGIN
    UPDATE productos p
    JOIN variantes_producto vp ON p.id_producto = vp.id_producto
    SET p.stock = p.stock - NEW.cantidad
    WHERE vp.id_variante = NEW.id_variante;
END //
DELIMITER ;

-- ==============================
-- 14. VERIFICACIÓN
-- ==============================
SELECT '=== DB_JACHA CREADA CON ÉXITO ===' AS mensaje;
SHOW TABLES;
