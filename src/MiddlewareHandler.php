<?php

namespace FitdevPro\FitMiddleware;

/**
 * Class MiddlewareHandler
 * @package FitdevPro\FitMiddleware
 */
class MiddlewareHandler
{
    private $resolver;
    private $queue;
    private $level = 0;

    /**
     * Queue constructor.
     * @param IResolver $resolver
     * @param IQueue $queue
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
    public function handle($input, $output)
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

        $this->level++;

        $output = $middleware($input, $output, $this);

        $this->level--;

        if($this->level == 0){
            $this->queue->rewind();
        }

        return $output;
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
