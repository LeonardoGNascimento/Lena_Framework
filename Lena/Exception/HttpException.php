<?php

namespace Lena\Lena\Exception;

use Exception;

class HttpException extends Exception
{
    public function __construct(
        public $message,
        public $code,
        public $erros = []
    ) {
        parent::__construct($this->message, $this->code);
    }

    public function render(): array
    {
        return [
            'message' => $this->message,
            'erros' => $this->erros,
            'code' => $this->code
        ];
    }
}
