<?php

namespace Lena\Lena\Core;

class App
{
    private $routes = [];
    private $prefix = '';

    public function get($route, $controller, $method)
    {
        $this->addRoute('GET', $route, $controller, $method);
    }

    public function post($route, $controller, $method)
    {
        $this->addRoute('POST', $route, $controller, $method);
    }

    public function patch($route, $controller, $method)
    {
        $this->addRoute('PATCH', $route, $controller, $method);
    }

    public function group($prefix, $callback)
    {
        $oldPrefix = $this->prefix;
        $this->prefix .= $prefix;
        $callback($this);
        $this->prefix = $oldPrefix;
    }

    private function addRoute($method, $route, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $this->prefix . $route,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_GET['path'] ?? '';

        $matchedRoutes = array_filter($this->routes, function ($route) use ($method, $path) {
            return $route['method'] === $method && $route['route'] === $path;
        });

        if (empty($matchedRoutes)) {
            return (new Response())->json('Rota não encontrada', 404);
        }

        $route = reset($matchedRoutes);

        $controller = (new Resolver())->resolve($route['controller']);
        $controller->{$route['action']}(
            new Request(),
            new Response()
        );
    }
}
