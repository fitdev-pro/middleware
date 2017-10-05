<?php

namespace FitdevPro\FitMiddleware;

/**
 * Class MiddlewareHundler
 * @package FitdevPro\FitMiddleware
 */
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

    /**
     * @param IMiddleware|string|callable $middleware
     */
    public function append($middleware)
    {
        $this->queue->append($middleware);
    }

    /**
     * @param $input
     * @param $output
     * @return mixed
     */
    public function hundle($input, $output)
    {
        return $this($input, $output);
    }

    /**
     * @param $input
     * @param $output
     * @return mixed
     */
    public function __invoke($input, $output)
    {
        $middleware = $this->resolve($this->queue->shift());

        return $middleware($input, $output, $this);
    }

    /**
     * @param $entry
     * @return \Closure|IMiddleware
     */
    private function resolve($entry)
    {
        if (!$entry) {
            // the default callable when the queue is empty
            return function ($input, $output) {
                return $output;
            };
        }

        return $this->resolver->resolve($entry);
    }
}
