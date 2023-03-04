<?php

namespace App\Core;

class Config
{
    public static function config()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        date_default_timezone_set("America/Sao_Paulo");
    }
}
