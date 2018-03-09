<?php

namespace FitdevPro\FitMiddleware\Tests;

use FitdevPro\FitMiddleware\MiddlewareHandler;
use FitdevPro\FitMiddleware\Queue;
use FitdevPro\FitMiddleware\Resolver;
use FitdevPro\FitMiddleware\TestLib\SimplyMiddleware;
use PHPUnit\Framework\TestCase;

class MiddlewareHandlerTest extends TestCase
{
    public function testCallable()
    {
        $handler = new MiddlewareHandler(new Resolver(), new Queue());

        $handler->append(function ($input, $output, $next){
            $output = $input + 1;

            $output = $next($output, $output);

            return $output;
        });

        $handler->append(function ($input, $output, $next){
            $output = $input + 2;

            if($output > 4){
                return $output;
            }

            $output = $next($output, $output);

            return $output;
        });

        $handler->append(function ($input, $output, $next){
            $output = $input + 3;

            $output = $next($output, $output);

            return $output;
        });


        $this->assertEquals(5, $handler->hundle(2, 0));
        $this->assertEquals(7, $handler(1, 0));
    }

    public function testMiddlewareObject()
    {
        $handler = new MiddlewareHandler(new Resolver(), new Queue());

        $handler->append(SimplyMiddleware::class);

        $handler->append(function ($input, $output, $next){
            $output = $input + 2;

            if($output > 4){
                return $output;
            }

            return $next($output, $output);
        });


        $this->assertEquals(5, $handler(1, 0));
        $this->assertEquals(6, $handler->hundle(2, 0));
    }
}
