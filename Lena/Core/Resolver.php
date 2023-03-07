<?php

namespace Lena\Lena\Core;

use Exception;
use ReflectionClass;

class Resolver
{
    private $parameters;

    public function __construct()
    {
        $this->parameters = array();
    }

    public function setParameters($className, array $values)
    {
        $this->parameters[$className] = $values;
    }

    public function resolve($className)
    {
        $reflectionClass = new ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return $reflectionClass->newInstanceWithoutConstructor();
        }

        $params = $constructor->getParameters();
        if (count($params) === 0) {
            return $reflectionClass->newInstance();
        }

        $arguments = $this->tryGetArguments($className, $params);
        return $reflectionClass->newInstanceArgs($arguments);
    }

    private function tryGetArguments($className, array $params)
    {
        foreach ($params as $param) {
            $args = $this->resolveParam($className, $param);
        }

        return $args;
    }

    private function resolveParam($className, $param)
    {
        if ($this->paramExistsForClass($className, $param->getName())) {
            return $this->getParameterValue($className, $param->getName());
        }

        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        if (!$param->hasType() || $param->getType()->isBuiltin()) {
            throw new Exception('erro', 500);
        }

        $type = (string) $param->getType();
        return $this->resolve($type);
    }

    private function getParameterValue($className, $paramName)
    {
        $classParams = $this->parameters[$className];

        return $classParams[$paramName];
    }

    private function paramExistsForClass($className, $paramName)
    {
        return array_key_exists($className, $this->parameters)
            && array_key_exists($paramName, $this->parameters[$className]);
    }
}
