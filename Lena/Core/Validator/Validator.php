<?php

namespace Lena\Lena\Core\Validator;

use Lena\Lena\Core\Response;
use Lena\Lena\Exception\HttpException;

class Validator extends ValidatorOptions
{
    public function validate()
    {
        try {
            $regrasDeValidacao = $this->rules();

            foreach ($regrasDeValidacao as $propsParaValidar => $rules) {
                foreach ($this as $props => $propsValues) {
                    if ($props != 'error') {
                        if ($props == $propsParaValidar) {
                            foreach ($rules as $rule) {
                                $this->strategy($propsValues, $props)[$rule]();
                            }
                        }
                    }
                }
            }

            if (!empty($this->erros)) {
                throw new HttpException('Ocorreu um erro', 400, $this->erros);
            }
        } catch (HttpException $error) {
            return (new Response())->json($error->render(), $error->getCode());
        }
    }

    private function strategy($var, $nome)
    {
        return [
            'string' => fn () => $this->isString($var, $nome),
            'number' => fn () => $this->isInt($var, $nome),
            'array' => fn () => $this->isArray($var, $nome),
            'required' => fn () => $this->isRequired($var, $nome)
        ];
    }


    public function rules(): array
    {
        return [
            "nome" => ["string", 'required']
        ];
    }
}
