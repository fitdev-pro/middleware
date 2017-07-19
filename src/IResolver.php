<?php

namespace FitdevPro\FitMiddleware;

interface IResolver
{
    public function __invoke($entry);
}
