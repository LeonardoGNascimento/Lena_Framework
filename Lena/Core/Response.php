<?php

namespace Lena\Lena\Core;

class Response
{
    public function json($return)
    {
        echo json_encode($return);
        die;
    }
}
