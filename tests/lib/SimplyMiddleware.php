<?php

namespace FitdevPro\FitMiddleware\TestLib;


use FitdevPro\FitMiddleware\IMiddleware;

class SimplyMiddleware implements IMiddleware
{

    public function __invoke($input, $output, callable $next = null)
    {
        $output = $input + 2;

        $output = $next($output, $output);

        return $output;
    }
}
