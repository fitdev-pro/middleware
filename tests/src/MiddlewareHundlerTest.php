<?php

namespace FitdevPro\FitMiddleware\Tests;

use FitdevPro\FitMiddleware\MiddlewareHundler;
use FitdevPro\FitMiddleware\Queue;
use FitdevPro\FitMiddleware\Resolver;
use FitdevPro\FitMiddleware\TestLib\SimplyMiddleware;
use PHPUnit\Framework\TestCase;

class MiddlewareHundlerTest extends TestCase
{
    public function testCallabel()
    {
        $hundler = new MiddlewareHundler(new Resolver(), new Queue());

        $hundler->append(function ($input, $output, $next){
            $output = $input + 1;

            $output = $next($output, $output);

            return $output;
        });

        $hundler->append(function ($input, $output, $next){
            $output = $input + 2;

            if($output > 4){
                return $output;
            }

            $output = $next($output, $output);

            return $output;
        });

        $hundler->append(function ($input, $output, $next){
            $output = $input + 3;

            $output = $next($output, $output);

            return $output;
        });


        $this->assertEquals(5, $hundler->hundle(2, 0));
        $this->assertEquals(7, $hundler(1, 0));
    }

    public function testMiddlewareObject()
    {
        $hundler = new MiddlewareHundler(new Resolver(), new Queue());

        $hundler->append(SimplyMiddleware::class);

        $hundler->append(function ($input, $output, $next){
            $output = $input + 2;

            if($output > 4){
                return $output;
            }

            return $next($output, $output);
        });


        $this->assertEquals(5, $hundler(1, 0));
        $this->assertEquals(6, $hundler->hundle(2, 0));
    }
}
