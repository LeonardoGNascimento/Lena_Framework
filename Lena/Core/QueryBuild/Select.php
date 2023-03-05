<?php

namespace Lena\Lena\Core\QueryBuild;

use PDO;

class Select
{
    public $selectBase = [];
    public $fromBase = '';
    public $whereBase = [];
    public $whereDados = [];
    public $bindParamBase = [];
    public $andBase = [];

    public function __construct(
        public PDO $pdo
    ) {
    }

    public static function create(PDO $pdo)
    {
        return new Select($pdo);
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
        $this->whereBase[] = [
            "query" => "{$campo} {$operador} :{$campo}",
            "campo" => ":{$campo}",
            "dados" => $dado
        ];
        return $this;
    }

    public function get()
    {
        $select = implode(', ', $this->selectBase);

        $whereString = implode(
            ' AND ',
            array_map(fn ($item) => $item['query'], $this->whereBase)
        );

        $whereString = !empty($whereString) ?  " WHERE {$whereString}"  : '';

        $stmt = $this->pdo->prepare("SELECT {$select} FROM {$this->fromBase} {$whereString}");

        foreach ($this->whereBase as $item) {
            $stmt->bindValue($item['campo'], $item['dados']);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne()
    {
        $select = implode(', ', $this->selectBase);
        $whereImplode = implode(" AND ", $this->whereBase);
        $where = !empty($whereImplode) ? " WHERE {$whereImplode}" : "";

        return "SELECT {$select} FROM {$this->fromBase} {$where} LIMIT 1";
    }
}
