<?php

namespace Aurora\Http\Connection\Tests;

use Aurora\Http\Connection\ServerConnection;
use PHPUnit\Framework\TestCase;

class ServerConnectionTest extends TestCase
{
    public function test__construct()
    {
        $server = new ServerConnection('127.0.0.1', $this->getPort());
        $this->assertAttributeEquals('127.0.0.1', 'address', $server);
        $this->assertAttributeNotEmpty('createdAt', $server);
    }

    public function testClose()
    {
        $server = new ServerConnection('127.0.0.1', $this->getPort());
        $server->close();
        $this->assertAttributeNotEmpty('closedAt', $server);
    }

    public function testGetSocket()
    {
        $server = new ServerConnection('127.0.0.1', $this->getPort());
        $this->assertInternalType('resource', $server->getSocket());
    }

    public function testGetAddress()
    {
        $server = new ServerConnection('127.0.0.1', $this->getPort());
        $this->assertEquals('127.0.0.1', $server->getAddress());

        $server = new ServerConnection('*', 10000);
        $this->assertEquals('0.0.0.0', $server->getAddress());

        $server = new ServerConnection('localhost', $this->getPort());
        $this->assertEquals('127.0.0.1', $server->getAddress());
    }

    public function testGetPort()
    {
        $server = new ServerConnection('127.0.0.1', $port = $this->getPort());
        $this->assertEquals($port, $server->getPort());
    }

    private function getPort()
    {
        static $port = 19900;

        return $port++;
    }
}
