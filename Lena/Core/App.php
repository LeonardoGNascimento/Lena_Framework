<?php

namespace Lena\Lena\Core;

class App
{
    public $GET = [];
    public $POST = [];
    public $PATCH = [];
    public $PUT = [];
    public $DELETE = [];
    public $METHOD = [];

    public function GET($rota, $controller, $method)
    {
        $this->GET[] = [
            "rota" => $rota,
            "controller" => $controller,
            "method" => $method
        ];
    }

    public function POST($rota, $controller, $method)
    {
        $this->POST[] = [
            "rota" => $rota,
            "controller" => $controller,
            "method" => $method
        ];
    }

    public function PATCH($rota, $controller, $method)
    {
        $this->PATCH[] = [
            "rota" => $rota,
            "controller" => $controller,
            "method" => $method
        ];
    }

    public function GROUP($prefix, $rotas)
    {
        // var_dump($this->GET);
        var_dump($rotas);
    }

    public function run()
    {
        foreach ($this as $item => $value) {
            if ($item === $_SERVER['REQUEST_METHOD']) {
                foreach ($value as $rota) {
                    if ($rota['rota'] == $_GET['path']) {
                        $resolver = new Resolver();
                        $controller = $resolver->resolve($rota['controller']);
                        $controller->{$rota['method']}(
                            new Request()
                        );
                    }
                }
            }
        }
        http_response_code(404);
        echo json_encode('Rota não encontrada');
    }
}
