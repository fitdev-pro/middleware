<?php

namespace FitdevPro\FitMiddleware;

interface IMiddleware
{
    public function __invoke($data, callable $next = null);
}
