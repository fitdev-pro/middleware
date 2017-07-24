<?php

namespace FitdevPro\FitMiddleware;

interface IMiddleware
{
    public function __invoke($input, $output, callable $next = null);
}
