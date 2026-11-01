<?php declare(strict_types=1);

namespace Framework\Http;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function put(string $path, array $handler): void
    {
        $this->add('PUT', $path, $handler);
    }

    public function patch(string $path, array $handler): void
    {
        $this->add('PATCH', $path, $handler);
    }

    public function delete(string $path, array $handler): void
    {
        $this->add('DELETE', $path, $handler);
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if (!preg_match($route['pattern'], $request->path(), $matches)) {
                continue;
            }

            if ($route['method'] !== $request->method()) {
                continue;
            }

            $params = [];

            foreach ($route['params'] as $name) {
                $params[] = rawurldecode($matches[$name]);
            }

            [$class, $method] = $route['handler'];

            $controller = new $class();
            $response   = $controller->$method($request, ...$params);

            return $response instanceof Response
                ? $response
                : Response::html((string) $response);
        }

        return Response::html('Not Found', 404);
    }

    private function add(string $method, string $path, array $handler): void
    {
        $path   = '/' . trim($path, '/');
        $params = [];

        $pattern = preg_replace_callback(
            '#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#',
            static function (array $matches) use (&$params): string {
                $params[] = $matches[1];

                return '(?P<' . $matches[1] . '>[^/]+)';
            },
            $path,
        );

        $this->routes[] = [
            'method'  => $method,
            'pattern' => '#^' . $pattern . '$#',
            'handler' => $handler,
            'params'  => $params,
        ];
    }
}
