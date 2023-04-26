<?php

namespace Lena\Lena\Core;

class Response
{
    public function json($return, $code = 200)
    {
        http_response_code($code);
        echo json_encode($return);
        die;
    }
}
