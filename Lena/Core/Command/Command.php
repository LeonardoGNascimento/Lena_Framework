<?php

namespace Lena\Core\Command;

abstract class Command
{
    public function destruct()
    {
        foreach ($this as $key => $value) {
            $retorno[$key] = $value;
        }

        return $retorno;
    }
}
