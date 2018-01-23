<?php

namespace Aurora\Handler\Tests;

use Aurora\Handler\Bundle\ListBundle;
use PHPUnit\Framework\TestCase;

class HandlerBundleTest extends TestCase
{
    public function testReadAndWrite()
    {
        $bundle = new ListBundle();
        $this->assertCount(0, $bundle);
        list($o, $p, $q) = $this->insertBundle($bundle, 3);


        $this->assertCount(3, $bundle);
        $this->assertSame($o, $bundle->front());
        $this->assertSame($q, $bundle->back());

        $bundle->backPop();
        $this->assertSame($p, $bundle->back());

        $bundle->clear();
        $this->assertTrue($bundle->isEmpty());
    }

    public function testSerialize()
    {
        $bundle = new ListBundle();
        $this->insertBundle($bundle, 3);
        $serialize = $bundle->serialize();
        $bundle->clear();
        $this->assertCount(0, $bundle);
        $bundle->unserialize($serialize);
        $this->assertCount(3, $bundle);
    }

    public function testIterator()
    {
        $bundle = new ListBundle();
        $list = $this->insertBundle($bundle, 3);
        foreach ($bundle as $key => $handler) {
            $this->assertSame($list[$key], $handler);
        }
    }

    public function testArrayAccess()
    {
        $bundle = new ListBundle();
        $bundle[] = $handler = new Handler();
        $this->assertSame($handler, $bundle[0]);
        $this->assertTrue(isset($bundle[0]));
        unset($bundle[0]);
        $this->assertFalse(isset($bundle[0]));
    }

    public function testHandle()
    {
        $bundle = new ListBundle();
        $this->insertBundle($bundle, 3);
        $this->assertEquals('x.012', $bundle->handle('x', new Handler('.')));
    }

    protected function insertBundle(ListBundle $bundle, $count)
    {
        $list = [];
        for ($i = 0; $i < $count; ++$i) {
            $list[$i] = new Handler($i);
            $bundle->insert($i, $list[$i]);
        }

        return $list;
    }
}
