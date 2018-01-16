<?php

namespace Tests;

use Panlatent\Http\RawMessage\Request\RawMessageBodyException;
use Panlatent\Http\RawMessage\RequestStream;
use PHPUnit\Framework\TestCase;

class RequestStreamTest extends TestCase
{
    public function testWriteViaGet()
    {
        $stream = $this->getRequestStream();
        $this->assertEquals(RequestStream::MSG_HEAD_DOING, $stream->getMessageStatus());
        $this->assertAttributeNotEmpty('lineBuffer', $stream);
        $this->assertAttributeNotEmpty('headerBuffer', $stream);
        $this->assertAttributeEmpty('bodyBuffer', $stream);
    }

    public function testGetMethod()
    {
        $stream = $this->getRequestStream();
        $this->assertEquals('GET', $stream->getMethod());
    }

    public function testGetUri()
    {
        $stream = $this->getRequestStream();
        $this->assertEquals('/', $stream->getUri());
    }

    public function testGetVersion()
    {
        $stream = $this->getRequestStream();
        $this->assertEquals('HTTP/1.1', $stream->getVersion());
    }

    public function testGetHeaders()
    {
        $stream = $this->getRequestStream();
        $headers = $stream->getHeaders();
        $this->assertCount(9, $headers);
    }

    public function testGetStandardHeaders()
    {
        $stream = $this->getRequestStream();
        $headers = $stream->getStandardHeaders();
        $this->assertArrayHasKey('Host', $headers);
        $this->assertEquals('www.laruence.com', $headers['Host']);
    }

    public function testGetBodyContent()
    {
        $stream = new RequestStream();
        $this->assertEquals('', $stream->getBodyContent());
    }

    public function testGetBodyStreamContent()
    {
        $this->expectException(RawMessageBodyException::class);
        $stream = new RequestStream();
        $this->assertEquals('', $stream->getBodyStream());
    }

    private function getRequestStream()
    {
        $stream = new RequestStream();
        $fp = fopen(__DIR__ . '/data/request_get.http', 'r');
        for (; ! feof($fp);) {
            $part = fread($fp, 30);
            $length = 0;
            for (; $length != strlen($part);) {
                $length += $successLength = $stream->write(substr($part, $length));

            }
        }

        return $stream;
    }
}
