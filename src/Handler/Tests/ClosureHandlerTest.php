<?php

namespace Aurora\Handler\Tests;

use Aurora\Handler\ClosureHandler;
use Aurora\Handler\HandlerInterface;
use PHPUnit\Framework\TestCase;

class ClosureHandlerTest extends TestCase
{
    public function testHandle()
    {
        $handler = new ClosureHandler(function($request) {
           return 'A and ' . $request;
        });
        $this->assertEquals('A and B', $handler->handle('B', new Handler()));

        $handler = new ClosureHandler(function($request, HandlerInterface $next) {
            return $next->handle('A and ' . $request, $next);
        });
        $this->assertEquals('A and B', $handler->handle('B', new Handler()));
    }
}
