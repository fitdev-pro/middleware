<?php

namespace FitdevPro\FitMiddleware;

use ReflectionClass;

class Resolver implements IResolver
{

    public function __invoke($entry)
    {
        if(is_string($entry)){
            $reflectionClass = new ReflectionClass($entry);
            return $reflectionClass->newInstance();
        }

        return $entry;
    }
}
