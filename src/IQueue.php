<?php

namespace FitdevPro\FitMiddleware;

interface IQueue
{
    public function append($middleware);
    public function shift();
    public function rewind();
}
