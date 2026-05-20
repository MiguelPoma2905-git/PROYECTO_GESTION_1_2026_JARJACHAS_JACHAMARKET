<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $handler): void
    {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post(string $uri, array $handler): void
    {
        $this->routes['POST'][$uri] = $handler;
    }

    public function match(array $methods, string $uri, array $handler): void
    {
        foreach ($methods as $method) {
            $this->routes[strtoupper($method)][$uri] = $handler;
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        $methodRoutes = $this->routes[$method] ?? [];

        // Check for exact match first
        if (isset($methodRoutes[$uri])) {
            $handler = $methodRoutes[$uri];
            $controller = new $handler[0]();
            call_user_func([$controller, $handler[1]]);
            return;
        }

        // Check for parameterized routes
        foreach ($methodRoutes as $pattern => $handler) {
            $patternRegex = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
            $patternRegex = '#^' . $patternRegex . '$#';

            if (preg_match($patternRegex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $controller = new $handler[0]();
                call_user_func([$controller, $handler[1]], $params);
                return;
            }
        }

        http_response_code(404);
        echo '404 - Página no encontrada';
    }
}
