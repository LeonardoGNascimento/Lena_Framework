<?php

namespace Lena\Lena\Core;

use Lena\Resolver\Resolver\Resolver;

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
        $matchedRoutes = array_filter(
            $this->routes,
            fn ($route) => $route['method'] === $_SERVER['REQUEST_METHOD'] && $route['route'] === ($_GET['path'] ?? '')
        );

        if (empty($matchedRoutes)) {
            return (new Response())->json('Rota não encontrada', StatusCode::HTTP_NOT_FOUND->value);
        }

        $route = reset($matchedRoutes);
        $controller = (new Resolver())->resolve($route['controller']);
        $controller->{$route['action']}(
            new Request(),
            new Response()
        );
    }
}
