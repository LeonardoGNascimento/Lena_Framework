<?php

namespace Lena\Lena\Core\QueryBuild;

use PDO;

class QueryBuild
{
    public static function createSelect(PDO $pdo)
    {
        return Select::create($pdo);
    }
}
