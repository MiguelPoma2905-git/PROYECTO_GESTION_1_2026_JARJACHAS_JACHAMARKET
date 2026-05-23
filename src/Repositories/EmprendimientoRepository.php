<?php
namespace App\Repositories;

class EmprendimientoRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findByPropietario(int $idPropietario): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, p.id_plantilla, p.nombre as plantilla_nombre,
                   pe.color_primario, pe.color_secundario, pe.color_texto, pe.color_fondo,
                   pe.logo_personalizado, pe.banner_personalizado, pe.modo_oscuro, pe.tipografia, pe.faqs,
                   (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.id_propietario = ?
            ORDER BY e.id_emprendimiento DESC
        ");
        $stmt->execute([$idPropietario]);
        return $stmt->fetchAll();
    }

    public function findAprobadosExcept(int $exceptUserId): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, 
                   p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario,
                   pe.logo_personalizado, pe.banner_personalizado,
                   (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.estado = 'Aprobado' AND e.id_propietario != ?
            ORDER BY e.id_emprendimiento DESC
            LIMIT 12
        ");
        $stmt->execute([$exceptUserId]);
        return $stmt->fetchAll();
    }

    public function findFeatured(): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, 
                   p.nombre as plantilla_nombre, p.color_primario, p.color_secundario,
                   pe.logo_personalizado, pe.banner_personalizado
            FROM emprendimientos e
            JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.estado = 'Aprobado'
            LIMIT 6
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, p.id_plantilla, p.nombre as plantilla_nombre,
                   pe.color_primario, pe.color_secundario, pe.color_fondo, pe.color_texto,
                   pe.logo_personalizado, pe.banner_personalizado, pe.modo_oscuro, pe.tipografia, pe.faqs
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.id_emprendimiento = ? AND e.estado = 'Aprobado'
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByIdAndPropietario(int $id, int $idPropietario): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, pe.id_plantilla, pe.color_primario, pe.color_secundario, pe.color_fondo, pe.color_texto,
                   pe.logo_personalizado, pe.banner_personalizado, pe.modo_oscuro, pe.tipografia, pe.faqs
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            WHERE e.id_emprendimiento = ? AND e.id_propietario = ?
        ");
        $stmt->execute([$id, $idPropietario]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function insert(array $data, int $idPropietario): int
    {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, telefono, descripcion, estado)
                VALUES (?, ?, ?, ?, ?, 'Aprobado')
            ");
            $stmt->execute([$idPropietario, $data['nombre_comercial'], $data['nit'] ?? null, $data['telefono'] ?? null, $data['descripcion'] ?? null]);
            $idEmprendimiento = (int)$this->conn->lastInsertId();

            $stmt = $this->conn->prepare("
                INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo, color_texto, modo_oscuro, tipografia, faqs)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $idEmprendimiento,
                $data['id_plantilla'],
                $data['color_primario'],
                $data['color_secundario'],
                $data['color_fondo'] ?? null,
                $data['color_texto'] ?? null,
                $data['modo_oscuro'] ?? 0,
                $data['tipografia'] ?? 'Inter',
                $data['faqs'] ?? null
            ]);

            $stmt = $this->conn->prepare("
                INSERT INTO sucursales (id_emprendimiento, nombre_sucursal, direccion, ciudad)
                VALUES (?, 'Sucursal principal', ?, ?)
            ");
            $stmt->execute([
                $idEmprendimiento,
                $data['direccion'] ?? 'Dirección no especificada',
                $data['ciudad'] ?? 'Ciudad no especificada'
            ]);

            $this->conn->commit();
            return $idEmprendimiento;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getPersonalizacion(int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT p.id_plantilla as plantilla_id, p.nombre as plantilla_nombre, p.descripcion as plantilla_descripcion,
                   p.color_primario as plantilla_color_primario, p.color_secundario as plantilla_color_secundario,
                   p.color_fondo as plantilla_color_fondo, p.color_texto as plantilla_color_texto, p.activo,
                   pe.id_personalizacion, pe.id_emprendimiento, pe.id_plantilla,
                   pe.color_primario, pe.color_secundario, pe.color_fondo, pe.color_texto,
                   pe.logo_personalizado, pe.banner_personalizado, pe.modo_oscuro, pe.tipografia, pe.faqs
            FROM personalizacion_emprendimiento pe
            JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE pe.id_emprendimiento = ?
        ");
        $stmt->execute([$idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function createDefaultPersonalizacion(int $idEmprendimiento): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo, color_texto, modo_oscuro, tipografia)
            SELECT ?, id_plantilla, color_primario, color_secundario, color_fondo, color_texto, 0, 'Inter' FROM plantillas LIMIT 1
        ");
        $stmt->execute([$idEmprendimiento]);
    }

    public function updatePersonalizacion(int $idEmprendimiento, array $data): void
    {
        $fields = [];
        $params = [];

        if (array_key_exists('id_plantilla', $data)) {
            $fields[] = 'id_plantilla = ?';
            $params[] = $data['id_plantilla'];
        }
        if (array_key_exists('color_primario', $data)) {
            $fields[] = 'color_primario = ?';
            $params[] = $data['color_primario'];
        }
        if (array_key_exists('color_secundario', $data)) {
            $fields[] = 'color_secundario = ?';
            $params[] = $data['color_secundario'];
        }
        if (array_key_exists('color_fondo', $data)) {
            $fields[] = 'color_fondo = ?';
            $params[] = $data['color_fondo'];
        }
        if (array_key_exists('color_texto', $data)) {
            $fields[] = 'color_texto = ?';
            $params[] = $data['color_texto'] ?? '#1A1A2E';
        }
        if (array_key_exists('modo_oscuro', $data)) {
            $fields[] = 'modo_oscuro = ?';
            $params[] = $data['modo_oscuro'] ? 1 : 0;
        }
        if (array_key_exists('tipografia', $data)) {
            $fields[] = 'tipografia = ?';
            $params[] = $data['tipografia'] ?? 'Inter';
        }
        if (array_key_exists('logo_personalizado', $data)) {
            $fields[] = 'logo_personalizado = ?';
            $params[] = $data['logo_personalizado'];
        }
        if (array_key_exists('banner_personalizado', $data)) {
            $fields[] = 'banner_personalizado = ?';
            $params[] = $data['banner_personalizado'];
        }
        if (array_key_exists('faqs', $data)) {
            $fields[] = 'faqs = ?';
            $params[] = $data['faqs'];
        }

        if (empty($fields)) return;

        $params[] = $idEmprendimiento;
        $sql = "UPDATE personalizacion_emprendimiento SET " . implode(', ', $fields) . " WHERE id_emprendimiento = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    public function findSucursalByEmprendimiento(int $idEmprendimiento): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM sucursales WHERE id_emprendimiento = ? LIMIT 1");
        $stmt->execute([$idEmprendimiento]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function countAll(): int
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM emprendimientos WHERE estado = 'Aprobado'");
        return (int)$stmt->fetch()['total'];
    }

    public function countAllUsuarios(): int
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Activo'");
        return (int)$stmt->fetch()['total'];
    }
}
