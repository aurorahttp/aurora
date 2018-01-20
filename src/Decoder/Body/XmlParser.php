<?php

namespace Aurora\Http\Message\Parser;

use Aurora\Http\Message\Decoder\BodyParser;
use Aurora\Http\Message\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class XmlParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {
        // TODO: Implement parse() method.
    }
}