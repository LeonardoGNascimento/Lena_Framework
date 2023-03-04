<?php

namespace Lena\Usuario\Controller;

use Lena\Core\Controller;
use Lena\Core\Request;
use Lena\Usuario\Dominio\Command\CriaUsuarioCommand;
use Lena\Usuario\Dominio\Entity\Usuario;

class UsuarioController extends Controller
{
    public function lista(Request $request)
    {
        $resultado = Usuario::all([
            "idade in (20, 40)"
        ]);

        return $this->return_json($resultado);
    }

    public function cadastra(Request $request)
    {
        //tres formas de cadastrar
        $body = $request->getBody();
        $criaUsuarioCommand = new CriaUsuarioCommand($body['nome'], $body['idade']);
        $usuario = new Usuario(null, $body['nome'], $body['idade']);

        //primeira
        $usuario->save();

        //segunda
        Usuario::create([
            "nome" => $body['nome'],
            "idade" => $body['idade']
        ]);

        //ou, essa funciona pois o destruct monta o array da mesma forma que o de cima em base da props da command
        Usuario::create($criaUsuarioCommand->destruct());

        return $this->return_json($request->getQueryParams());
    }

    public function atualiza(Request $request)
    {
        return $this->return_json($request->getBody());
    }
}
