<?php

namespace Lena\Lena\Core\Validator;

class ValidatorOptions
{
    public $erros = [];

    public function isString($var, $nome)
    {
        if (!is_string($var)) {
            $this->erros[$nome][] = "{$nome} deve ser do tipo texto";
        }
    }

    public function isInt($var, $nome)
    {
        if (!is_int($var)) {
            $this->erros[$nome][] = "{$nome} deve ser do tipo inteiro";
        }
    }

    public function isArray($var, $nome)
    {
        if (!is_array($var)) {
            $this->erros[$nome][] = "{$nome} deve ser do tipo array";
        }
    }

    public function isRequired($var, $nome)
    {
        if (empty($var)) {
            $this->erros[$nome][] = "{$nome} é obrigatório";
        }
    }
}
