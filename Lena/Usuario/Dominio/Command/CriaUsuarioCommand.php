<?php

namespace Lena\Usuario\Dominio\Command;

use Lena\Core\Command\Command;

class CriaUsuarioCommand extends Command
{
    public function __construct(
        public $nome,
        public $idade
    ) {
    }
}
