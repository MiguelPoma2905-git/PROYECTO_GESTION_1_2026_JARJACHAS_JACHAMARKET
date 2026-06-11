<?php
namespace App\Repositories;

class CategoriaRepository
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function findAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM categorias ORDER BY id_categoria ASC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->execute([$id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function getTree(?int $idEmprendimiento = null): array
    {
        $all = $this->findAll();
        $map = [];
        foreach ($all as $c) {
            $c['children'] = [];
            $c['product_count'] = $idEmprendimiento
                ? $this->countProductsInCategory($c['id_categoria'], $idEmprendimiento)
                : 0;
            $map[$c['id_categoria']] = $c;
        }
        $tree = [];
        foreach ($map as &$c) {
            if ($c['id_padre'] && isset($map[$c['id_padre']])) {
                $map[$c['id_padre']]['children'][] = &$c;
            } else {
                $tree[] = &$c;
            }
        }
        return $tree;
    }

    public function getFlatOptions(?int $excluirId = null): array
    {
        $all = $this->findAll();
        $result = [];
        foreach ($all as $c) {
            $result[] = $c;
        }
        if ($excluirId) {
            $result = array_filter($result, fn($c) => $c['id_categoria'] !== $excluirId);
        }
        return $result;
    }

    public function getPath(int $idCategoria): array
    {
        $path = [];
        $current = $this->findById($idCategoria);
        while ($current) {
            array_unshift($path, $current);
            $current = $current['id_padre'] ? $this->findById($current['id_padre']) : null;
        }
        return $path;
    }

    public function getChildrenIds(int $idPadre): array
    {
        $stmt = $this->conn->prepare("SELECT id_categoria FROM categorias WHERE id_padre = ?");
        $stmt->execute([$idPadre]);
        return array_column($stmt->fetchAll(), 'id_categoria');
    }

    public function exists(int $id): bool
    {
        return $this->findById($id) !== null;
    }

    public function slugExists(string $slug, ?int $excluirId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM categorias WHERE slug = ?";
        $params = [$slug];
        if ($excluirId) {
            $sql .= " AND id_categoria != ?";
            $params[] = $excluirId;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function hasChildren(int $id): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM categorias WHERE id_padre = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }

    public function hasProducts(int $id): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM productos WHERE id_categoria = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }

    public function countProductsInCategory(int $idCategoria, int $idEmprendimiento): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM productos WHERE id_categoria = ? AND id_emprendimiento = ?");
        $stmt->execute([$idCategoria, $idEmprendimiento]);
        return (int)$stmt->fetchColumn();
    }

    public function insert(array $data): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO categorias (id_padre, nombre, slug) VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $data['id_padre'] ?: null,
            $data['nombre'],
            $data['slug']
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->conn->prepare("
            UPDATE categorias SET id_padre = ?, nombre = ?, slug = ? WHERE id_categoria = ?
        ");
        $stmt->execute([
            $data['id_padre'] ?: null,
            $data['nombre'],
            $data['slug'],
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $this->conn->beginTransaction();
        try {
            $this->conn->prepare("UPDATE categorias SET id_padre = NULL WHERE id_padre = ?")->execute([$id]);
            $this->conn->prepare("UPDATE productos SET id_categoria = NULL WHERE id_categoria = ?")->execute([$id]);
            $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
            $stmt->execute([$id]);
            $this->conn->commit();
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function renderTreeOptions(array $tree, int $level = 0, ?int $selectedId = null): string
    {
        $html = '';
        foreach ($tree as $node) {
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;', $level);
            $sel = $selectedId && (int)$node['id_categoria'] === $selectedId ? ' selected' : '';
            $prefix = $level > 0 ? $indent . '└ ' : '';
            $html .= '<option value="' . $node['id_categoria'] . '"' . $sel . '>' . $prefix . htmlspecialchars($node['nombre']) . '</option>';
            if (!empty($node['children'])) {
                $html .= $this->renderTreeOptions($node['children'], $level + 1, $selectedId);
            }
        }
        return $html;
    }

    public function renderTreeHtml(array $tree, int $level = 0): string
    {
        $html = '<ul' . ($level === 0 ? ' class="category-tree"' : '') . '>';
        foreach ($tree as $node) {
            $hasChildren = !empty($node['children']);
            $prodCount = $node['product_count'] ?? 0;
            $badge = $prodCount > 0 ? ' <span class="prod-badge">' . $prodCount . ' productos</span>' : '';
            $toggle = $hasChildren ? '<span class="tree-toggle" onclick="this.nextElementSibling.classList.toggle(\'hidden\')">▶</span>' : '<span class="tree-toggle tree-toggle-empty">▶</span>';
            $html .= '<li>';
            $html .= $toggle;
            $html .= '<span class="cat-name">' . htmlspecialchars($node['nombre']) . $badge . '</span>';
            $html .= ' <a href="?edit=' . $node['id_categoria'] . '" class="btn-sm">✏️</a>';
            $html .= ' <a href="?delete=' . $node['id_categoria'] . '" class="btn-sm btn-danger" onclick="return confirm(\'¿Eliminar categoría?\')">🗑️</a>';
            if ($hasChildren) {
                $html .= $this->renderTreeHtml($node['children'], $level + 1);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
