<?php

namespace App\Usuario\Dominio\Entity;

use App\Core\Entity\Entity;

class Usuario extends Entity
{
    public function __construct(
        public $id,
        public $nome,
        public $idade
    ) {
    }
}
