<?php

namespace App\Core\QueryBuild;

class QueryBuild
{
    public static function createSelect()
    {
        return Select::create();
    }
}
