-- Crear tabla para roles de usuario (relación muchos a muchos)
CREATE TABLE usuario_roles (
    id_usuario BIGINT NOT NULL,
    id_rol INT NOT NULL,
    PRIMARY KEY (id_usuario, id_rol),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Migrar roles existentes a la nueva tabla
INSERT INTO usuario_roles (id_usuario, id_rol)
SELECT id_usuario, id_rol FROM usuarios WHERE id_rol IS NOT NULL;

-- Eliminar columna id_rol de usuarios (opcional, mantener para compatibilidad)
ALTER TABLE usuarios ADD COLUMN rol_principal INT NULL;
UPDATE usuarios u SET rol_principal = (
    SELECT id_rol FROM usuario_roles WHERE id_usuario = u.id_usuario LIMIT 1
);