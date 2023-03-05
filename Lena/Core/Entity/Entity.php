<?php

namespace Lena\Lena\Core\Entity;

use Lena\Lena\Core\QueryBuild\QueryBuild;
use PDO;

class Entity extends QueryBuild
{
    public function save($values = [])
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuario", "root", "");
        $retorno = explode('\\', get_class($this));
        $tabela = end($retorno);

        foreach ($this as $key => $value) {
            $props[] = $key;
            $propsValue[] = ":{$key}";
        }

        $propsColunas = implode(', ', array_filter($props, function ($item) {
            if ($item !== 'id') {
                if ($item !== 'tabela') {
                    return $item;
                }
            }
        }));

        $propsValues = implode(', ', array_filter($propsValue, function ($item) {
            if ($item !== ':id') {
                if ($item !== ':tabela') {
                    return $item;
                }
            }
        }));

        $query = "INSERT INTO {$tabela} ({$propsColunas}) VALUES ({$propsValues})";
        $teste = $pdo->prepare($query);

        foreach ($this as $keys => $values) {
            if (!empty($keys)) {
                if ($keys !== 'id') {
                    if ($keys !== 'tabela') {
                        $teste->bindValue(":$keys", $values);
                    }
                }
            }
        }
        $teste->execute();

        return $pdo->lastInsertId();
    }

    public static function create($values = [])
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuario", "root", "");
        $retorno = explode('\\', get_called_class());
        $tabela = end($retorno);

        foreach ($values as $key => $value) {
            $props[] = $key;
            $propsValue[] = ":{$key}";
        }

        $propsColunas = implode(', ', array_filter($props, function ($item) {
            if ($item !== 'id') {
                if ($item !== 'tabela') {
                    return $item;
                }
            }
        }));

        $propsValues = implode(', ', array_filter($propsValue, function ($item) {
            if ($item !== ':id') {
                if ($item !== ':tabela') {
                    return $item;
                }
            }
        }));

        $query = "INSERT INTO {$tabela} ({$propsColunas}) VALUES ({$propsValues})";
        $teste = $pdo->prepare($query);

        foreach ($values as $keys => $values) {
            if (!empty($keys)) {
                if ($keys !== 'id') {
                    if ($keys !== 'tabela') {
                        $teste->bindValue(":$keys", $values);
                    }
                }
            }
        }
        $teste->execute();

        return $pdo->lastInsertId();
    }

    public static function all($options = [])
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuario", "root", "");
        $retorno = explode('\\', get_called_class());
        $tabela = end($retorno);

        $queryBuild = QueryBuild::createSelect($pdo);
        $queryBuild->select('*')
            ->from($tabela);

        foreach ($options as $key => $value) {
            if ($key == 'where') {
                foreach ($value as $item) {
                    $queryBuild->whereAnd($item[0], $item[1], $item[2]);
                }
            }
        }
        $resultado = $queryBuild->get();

        return $resultado;
    }

    public static function startSelect(...$select)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuario", "root", "");
        $retorno = explode('\\', get_called_class());
        $tabela = end($retorno);

        $queryBuild = self::createSelect($pdo);

        $queryBuild->select(...$select)
            ->from($tabela);

        return $queryBuild;
    }
}
