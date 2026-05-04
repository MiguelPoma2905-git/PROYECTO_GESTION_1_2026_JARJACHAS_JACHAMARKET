-- ============================================
-- TAREA 4: Particionar la tabla pedidos
-- ============================================
USE db_jacha;

-- ============================================
-- PARTE A: Crear tabla pedidos con particiones (si no existe)
-- ============================================

-- NOTA: Si ya existe la tabla pedidos, hay que recrearla
-- Primero, respaldamos la estructura actual

-- Verificar si la tabla pedidos tiene datos
SELECT COUNT(*) as pedidos_existentes FROM pedidos;

-- Crear nueva tabla pedidos particionada por rango de fechas
-- (Ejecutar solo si la tabla actual tiene pocos datos)

-- Tabla con particiones por mes
CREATE TABLE pedidos_particionado (
    id_pedido BIGINT AUTO_INCREMENT,
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
    PRIMARY KEY (id_pedido, fecha_creacion)
) ENGINE=InnoDB
PARTITION BY RANGE (YEAR(fecha_creacion) * 100 + MONTH(fecha_creacion))
(
    PARTITION p_enero_2025 VALUES LESS THAN (202502),
    PARTITION p_febrero_2025 VALUES LESS THAN (202503),
    PARTITION p_marzo_2025 VALUES LESS THAN (202504),
    PARTITION p_abril_2025 VALUES LESS THAN (202505),
    PARTITION p_mayo_2025 VALUES LESS THAN (202506),
    PARTITION p_junio_2025 VALUES LESS THAN (202507),
    PARTITION p_julio_2025 VALUES LESS THAN (202508),
    PARTITION p_agosto_2025 VALUES LESS THAN (202509),
    PARTITION p_septiembre_2025 VALUES LESS THAN (202510),
    PARTITION p_octubre_2025 VALUES LESS THAN (202511),
    PARTITION p_noviembre_2025 VALUES LESS THAN (202512),
    PARTITION p_diciembre_2025 VALUES LESS THAN (202601),
    PARTITION p_futuro VALUES LESS THAN MAXVALUE
);

-- Mostrar las particiones creadas
SELECT PARTITION_NAME, PARTITION_METHOD, PARTITION_DESCRIPTION
FROM INFORMATION_SCHEMA.PARTITIONS
WHERE TABLE_NAME = 'pedidos_particionado';

-- ============================================
-- PARTE B: Medir mejora de rendimiento
-- ============================================

-- Insertar datos de prueba en la tabla particionada
INSERT INTO pedidos_particionado (id_cliente, id_sucursal_origen, codigo_seguimiento, 
    subtotal, costo_envio, total, metodo_pago, direccion_entrega, fecha_creacion)
SELECT 
    id_usuario,
    1,
    CONCAT('TEST-', id_usuario, '-', UNIX_TIMESTAMP()),
    RAND() * 1000,
    20,
    RAND() * 1020,
    'QR',
    'Dirección de prueba',
    DATE_ADD('2025-01-01', INTERVAL FLOOR(RAND() * 365) DAY)
FROM usuarios
LIMIT 100;

-- Consulta de prueba (filtrando por rango de fechas)
SET @start = NOW(6);
SELECT COUNT(*) FROM pedidos_particionado 
WHERE fecha_creacion BETWEEN '2025-03-01' AND '2025-04-01';
SET @end = NOW(6);
SELECT TIMEDIFF(@end, @start) AS tiempo_con_particion;

-- Comparar con tabla sin partición (si existe)
-- La partición mejora las consultas por rango de fechas