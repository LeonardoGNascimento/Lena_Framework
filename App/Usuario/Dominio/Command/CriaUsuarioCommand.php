<?php

namespace App\Usuario\Dominio\Command;

use App\Core\Command\Command;

class CriaUsuarioCommand extends Command
{
    public function __construct(
        public $nome,
        public $idade
    ) {
    }
}
