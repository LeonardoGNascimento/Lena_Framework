<?php

namespace Lena\Usuario\Dominio\Entity;

use Lena\Core\Entity\Entity;

class Usuario extends Entity
{
    public function __construct(
        public $id,
        public $nome,
        public $idade
    ) {
    }
}
