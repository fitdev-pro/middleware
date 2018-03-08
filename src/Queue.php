<?php

namespace FitdevPro\FitMiddleware;

class Queue implements IQueue
{
    private $key = 0;
    private $queue = array();

    public function append($middleware)
    {
        $this->queue[] = $middleware;
    }

    public function shift()
    {
        if(isset($this->queue[$this->key])){
            $out = $this->queue[$this->key];
            $this->key++;

            return $out;
        }

        $this->key = 0;
        return false;
    }

    public function rewind()
    {
        $this->key = 0;
    }
}
