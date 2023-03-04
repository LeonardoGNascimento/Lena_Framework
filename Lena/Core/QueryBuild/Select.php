<?php

namespace Lena\Core\QueryBuild;

class Select
{
    public $selectBase = [];
    public $fromBase = '';
    public $whereBase = [];
    public $andBase = [];

    public static function create()
    {
        return new Select();
    }

    public function select(...$select)
    {
        $this->selectBase = $select;
        return $this;
    }

    public function from($tabela)
    {
        $this->fromBase = $tabela;
        return $this;
    }

    public function whereAnd($campo, $operador, $dado)
    {
        $this->whereBase[] = "{$campo} {$operador} {$dado}";
        return $this;
    }

    public function get()
    {
        $select = implode(', ', $this->selectBase);

        return "SELECT {$select} FROM {$this->fromBase}";
    }

    public function getOne()
    {
        $select = implode(', ', $this->selectBase);
        $whereImplode = implode(" AND ", $this->whereBase);
        $where = !empty($whereImplode) ? " WHERE {$whereImplode}" : "";

        return "SELECT {$select} FROM {$this->fromBase} {$where} LIMIT 1";
    }
}
