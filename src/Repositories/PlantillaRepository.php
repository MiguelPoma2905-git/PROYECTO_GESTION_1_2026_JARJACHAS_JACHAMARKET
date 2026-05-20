<?php
namespace App\Repositories;

class PlantillaRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findAllActive(): array
    {
        $stmt = $this->conn->query("SELECT * FROM plantillas WHERE activo = 1");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM plantillas WHERE id_plantilla = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
