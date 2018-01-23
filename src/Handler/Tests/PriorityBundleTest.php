<?php

namespace Aurora\Handler\Tests;

use Aurora\Handler\Bundle\PriorityBundle;
use PHPUnit\Framework\TestCase;

class PriorityBundleTest extends TestCase
{
    public function testInsertAndIsEmpty()
    {
        $bundle = new PriorityBundle();
        $this->assertTrue($bundle->isEmpty());
        $bundle->insert(new PriorityHandler(1));
        $this->assertFalse($bundle->isEmpty());
    }

    public function testExtractAndTop()
    {
        $bundle = new PriorityBundle();
        $handler1 = new PriorityHandler(10);
        $handler2 = new PriorityHandler(20);
        $bundle->insert($handler1);
        $bundle->insert($handler2);
        $this->assertSame($handler2, $bundle->extract());
        $this->assertSame($handler1, $bundle->top());
    }

    public function testHandle()
    {
        $bundle = new PriorityBundle();
        foreach ([12, 5, 7, 19, 3] as $priority) {
            $bundle->insert(new PriorityHandler($priority));
        }
        $this->assertEquals('x191275311', $bundle->handle('x', new Handler(11)));
        $this->assertEquals('y191211753', $bundle->handle('y', new PriorityHandler(11)));
    }
}
