<?php

namespace Lena\Lena\Core;

abstract class Controller
{
    function return_json($return)
    {
        echo json_encode($return);
        die;
    }
}
