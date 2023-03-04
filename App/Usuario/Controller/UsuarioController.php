<?php

namespace App\Usuario\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Usuario\Dominio\Command\CriaUsuarioCommand;
use App\Usuario\Dominio\Entity\Usuario;

class UsuarioController extends Controller
{
    public function lista(Request $request)
    {
        $resultado = Usuario::all([
            "nome = leo",
            "idade = 20"
        ]);

        $teste = Usuario::startSelect('coluna1', 'coluna2');

        var_dump($teste->get());
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
