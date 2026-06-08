<?php
namespace App\Repositories;

class EmprendimientoRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    private function imgUrl(string $type, int $id): string
    {
        return 'serve.php?t=' . $type . '&id=' . $id;
    }

    public function findByPropietario(int $idPropietario): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, p.id_plantilla, p.nombre as plantilla_nombre,
                   pe.color_primario, pe.color_secundario, pe.color_texto, pe.color_fondo,
                   pe.modo_oscuro, pe.tipografia, pe.faqs,
                   pe.logo_blob, pe.banner_blob, pe.portada_blob,
                   (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.id_propietario = ?
            ORDER BY e.id_emprendimiento DESC
        ");
        $stmt->execute([$idPropietario]);
        return $this->injectImgUrls($stmt->fetchAll());
    }

    public function findAprobadosExcept(int $exceptUserId): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, e.telefono,
                   p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario, pe.color_texto,
                   pe.logo_blob, pe.banner_blob, pe.portada_blob, pe.tipografia,
                   (SELECT COUNT(*) FROM productos WHERE id_emprendimiento = e.id_emprendimiento) as total_productos,
                   e.id_emprendimiento as orden_nuevos
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.estado = 'Aprobado' AND e.id_propietario != ?
            ORDER BY e.id_emprendimiento DESC
            LIMIT 50
        ");
        $stmt->execute([$exceptUserId]);
        return $this->injectImgUrls($stmt->fetchAll());
    }

    public function findFeatured(): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.id_emprendimiento, e.nombre_comercial, e.descripcion, 
                   p.nombre as plantilla_nombre, p.color_primario, p.color_secundario,
                   pe.logo_blob, pe.banner_blob, pe.portada_blob
            FROM emprendimientos e
            JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.estado = 'Aprobado'
            LIMIT 6
        ");
        $stmt->execute();
        return $this->injectImgUrls($stmt->fetchAll());
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, p.id_plantilla, p.nombre as plantilla_nombre,
                   pe.color_primario, pe.color_secundario, pe.color_fondo, pe.color_texto,
                   pe.modo_oscuro, pe.tipografia, pe.faqs,
                   pe.logo_blob, pe.banner_blob, pe.portada_blob
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            LEFT JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE e.id_emprendimiento = ? AND e.estado = 'Aprobado'
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ? $this->injectImgUrls([$result])[0] : null;
    }

    public function findByIdAndPropietario(int $id, int $idPropietario): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, pe.id_plantilla, pe.color_primario, pe.color_secundario, pe.color_fondo, pe.color_texto,
                   pe.modo_oscuro, pe.tipografia, pe.faqs,
                   pe.logo_blob, pe.banner_blob, pe.portada_blob
            FROM emprendimientos e
            LEFT JOIN personalizacion_emprendimiento pe ON e.id_emprendimiento = pe.id_emprendimiento
            WHERE e.id_emprendimiento = ? AND e.id_propietario = ?
        ");
        $stmt->execute([$id, $idPropietario]);
        $result = $stmt->fetch();
        return $result ? $this->injectImgUrls([$result])[0] : null;
    }

    private function injectImgUrls(array $rows): array
    {
        foreach ($rows as &$row) {
            $id = $row['id_emprendimiento'] ?? 0;
            $row['logo_personalizado'] = !empty($row['logo_blob']) ? $this->imgUrl('logo', $id) : null;
            $row['banner_personalizado'] = !empty($row['banner_blob']) ? $this->imgUrl('banner', $id) : null;
            $row['portada'] = !empty($row['portada_blob']) ? $this->imgUrl('portada', $id) : null;
            unset($row['logo_blob'], $row['banner_blob'], $row['portada_blob']);
        }
        return $rows;
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
                   pe.modo_oscuro, pe.tipografia, pe.faqs,
                   pe.logo_blob, pe.banner_blob
            FROM personalizacion_emprendimiento pe
            JOIN plantillas p ON pe.id_plantilla = p.id_plantilla
            WHERE pe.id_emprendimiento = ?
        ");
        $stmt->execute([$idEmprendimiento]);
        $result = $stmt->fetch();
        if ($result) {
            $id = $result['id_emprendimiento'] ?? 0;
            $result['logo_personalizado'] = !empty($result['logo_blob']) ? $this->imgUrl('logo', $id) : null;
            $result['banner_personalizado'] = !empty($result['banner_blob']) ? $this->imgUrl('banner', $id) : null;
            unset($result['logo_blob'], $result['banner_blob']);
        }
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
        if (array_key_exists('logo_blob', $data)) {
            $fields[] = 'logo_blob = ?';
            $params[] = $data['logo_blob'];
        }
        if (array_key_exists('logo_mime', $data)) {
            $fields[] = 'logo_mime = ?';
            $params[] = $data['logo_mime'];
        }
        if (array_key_exists('banner_blob', $data)) {
            $fields[] = 'banner_blob = ?';
            $params[] = $data['banner_blob'];
        }
        if (array_key_exists('banner_mime', $data)) {
            $fields[] = 'banner_mime = ?';
            $params[] = $data['banner_mime'];
        }
        if (array_key_exists('portada_blob', $data)) {
            $fields[] = 'portada_blob = ?';
            $params[] = $data['portada_blob'];
        }
        if (array_key_exists('portada_mime', $data)) {
            $fields[] = 'portada_mime = ?';
            $params[] = $data['portada_mime'];
        }
        if (array_key_exists('faqs', $data)) {
            $fields[] = 'faqs = ?';
            $params[] = $data['faqs'];
        }
        if (array_key_exists('eliminar_logo', $data) && $data['eliminar_logo']) {
            $fields[] = 'logo_blob = NULL, logo_mime = NULL';
        }
        if (array_key_exists('eliminar_banner', $data) && $data['eliminar_banner']) {
            $fields[] = 'banner_blob = NULL, banner_mime = NULL';
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

    public function agregarRepartidor(int $idEmprendimiento, int $idRepartidor): void
    {
        $stmt = $this->conn->prepare("INSERT INTO emprendimiento_repartidores (id_emprendimiento, id_repartidor, estado) VALUES (?, ?, 'Pendiente')");
        $stmt->execute([$idEmprendimiento, $idRepartidor]);
    }

    public function quitarRepartidor(int $idEmprendimiento, int $idRepartidor): void
    {
        $stmt = $this->conn->prepare("DELETE FROM emprendimiento_repartidores WHERE id_emprendimiento = ? AND id_repartidor = ?");
        $stmt->execute([$idEmprendimiento, $idRepartidor]);
    }

    public function listarRepartidores(int $idEmprendimiento): array
    {
        $stmt = $this->conn->prepare("
            SELECT u.id_usuario, u.nombres, u.apellidos, u.email, er.estado
            FROM usuarios u
            JOIN emprendimiento_repartidores er ON u.id_usuario = er.id_repartidor
            WHERE er.id_emprendimiento = ?
            ORDER BY FIELD(er.estado, 'Pendiente', 'Aceptado', 'Rechazado')
        ");
        $stmt->execute([$idEmprendimiento]);
        return $stmt->fetchAll();
    }

    public function actualizarEstadoRepartidor(int $idEmprendimiento, int $idRepartidor, string $estado): void
    {
        $stmt = $this->conn->prepare("UPDATE emprendimiento_repartidores SET estado = ? WHERE id_emprendimiento = ? AND id_repartidor = ?");
        $stmt->execute([$estado, $idEmprendimiento, $idRepartidor]);
    }

    public function listarSolicitudesRepartidor(int $idRepartidor): array
    {
        $stmt = $this->conn->prepare("
            SELECT er.id_emprendimiento, er.estado, er.fecha_ingreso,
                   e.nombre_comercial, e.descripcion,
                   u.nombres as prop_nombre, u.apellidos as prop_apellidos, u.email as prop_email
            FROM emprendimiento_repartidores er
            JOIN emprendimientos e ON er.id_emprendimiento = e.id_emprendimiento
            JOIN usuarios u ON e.id_propietario = u.id_usuario
            WHERE er.id_repartidor = ?
            ORDER BY FIELD(er.estado, 'Pendiente', 'Aceptado', 'Rechazado'), er.fecha_ingreso DESC
        ");
        $stmt->execute([$idRepartidor]);
        return $stmt->fetchAll();
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
