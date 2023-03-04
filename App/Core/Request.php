<?php

namespace App\Core;

class Request
{
    public $body = [];
    public $queryParams = [];

    public function __construct()
    {
        $this->body = (array) json_decode(file_get_contents("php://input"));
        $this->queryParams = $_GET;
    }

    public function getBody($key = null)
    {
        $retorno = !empty($key) ? $this->body[$key] : $this->body;
        return $retorno;
    }

    public function getQueryParams($key = null)
    {
        $retorno = !empty($key) ? $this->queryParams[$key] : $this->queryParams;
        return $retorno;
    }
}
