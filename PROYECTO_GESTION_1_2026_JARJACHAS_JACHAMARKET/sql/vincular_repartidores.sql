-- Tabla para vincular repartidores a emprendimientos
CREATE TABLE IF NOT EXISTS emprendimiento_repartidores (
    id_vinculo BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_emprendimiento BIGINT NOT NULL,
    id_repartidor BIGINT NOT NULL,
    fecha_ingreso DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_emprendimiento) REFERENCES emprendimientos(id_emprendimiento) ON DELETE CASCADE,
    FOREIGN KEY (id_repartidor) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    UNIQUE (id_emprendimiento, id_repartidor)
) ENGINE=InnoDB;
