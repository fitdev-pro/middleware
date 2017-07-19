<?php

namespace FitdevPro\FitMiddleware\Tests;

use FitdevPro\FitMiddleware\MiddlewareHundler;
use FitdevPro\FitMiddleware\Queue;
use FitdevPro\FitMiddleware\Resolver;
use PHPUnit\Framework\TestCase;

class MiddlewareHundlerTest extends TestCase
{
    public function test1()
    {
        $hundler = new MiddlewareHundler(new Resolver(), new Queue());

        $hundler->append(function ($data, $next){
           $data += 1;

           return $next($data);
        });

        $hundler->append(function ($data, $next){
            $data += 2;

            if($data > 4){
                return $data;
            }
            return $next($data);
        });

        $hundler->append(function ($data, $next){
            $data += 3;

            return $next($data);
        });


        $this->assertEquals(7, $hundler(1));
        $this->assertEquals(5, $hundler->hundle(2));
    }
}
