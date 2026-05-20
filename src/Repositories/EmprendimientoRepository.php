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
            SELECT e.*, p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario,
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
                   p.nombre as plantilla_nombre, p.color_primario, p.color_secundario
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
            SELECT e.*, p.nombre as plantilla_nombre, pe.color_primario, pe.color_secundario, pe.color_fondo
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
            SELECT * FROM emprendimientos 
            WHERE id_emprendimiento = ? AND id_propietario = ?
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
                INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado)
                VALUES (?, ?, ?, ?, 'Aprobado')
            ");
            $stmt->execute([$idPropietario, $data['nombre_comercial'], $data['nit'] ?? null, $data['descripcion'] ?? null]);
            $idEmprendimiento = (int)$this->conn->lastInsertId();

            $stmt = $this->conn->prepare("
                INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$idEmprendimiento, $data['id_plantilla'], $data['color_primario'], $data['color_secundario']]);

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
            SELECT p.*, pe.* 
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
            INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla)
            SELECT ?, id_plantilla FROM plantillas LIMIT 1
        ");
        $stmt->execute([$idEmprendimiento]);
    }

    public function updatePersonalizacion(int $idEmprendimiento, array $data): void
    {
        $stmt = $this->conn->prepare("
            UPDATE personalizacion_emprendimiento 
            SET id_plantilla = ?, color_primario = ?, color_secundario = ?, 
                color_fondo = ?, modo_oscuro = ?
            WHERE id_emprendimiento = ?
        ");
        $stmt->execute([
            $data['id_plantilla'], $data['color_primario'], $data['color_secundario'],
            $data['color_fondo'], $data['modo_oscuro'], $idEmprendimiento
        ]);
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
