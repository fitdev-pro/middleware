<?php

namespace FitdevPro\FitMiddleware;

class MiddlewareHundler
{
    private $resolver;
    private $queue;

    /**
     * Queue constructor.
     * @param IResolver $resolver
     */
    public function __construct(IResolver $resolver, IQueue $queue)
    {
        $this->resolver = $resolver;
        $this->queue = $queue;
    }

    public function append($middleware)
    {
        $this->queue->append($middleware);
    }

    public function hundle($data)
    {
        return $this($data);
    }

    public function __invoke($data)
    {
        $middleware = $this->resolve($this->queue->shift());

        return $middleware($data, $this);
    }

    protected function resolve($entry)
    {
        if (!$entry) {
            // the default callable when the queue is empty
            return function ($data) {
                return $data;
            };
        }

        if (!$this->resolver) {
            return $entry;
        }

        return call_user_func($this->resolver, $entry);
    }
}
