<?php
namespace App\Core;

abstract class Controller
{
    public function __construct() {}
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \RuntimeException("View not found: {$view}");
        }
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function getDB(): \PDO
    {
        return getDB();
    }

    protected function requireAuth(): void
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect(BASE_URL . '/login');
        }
    }
}
