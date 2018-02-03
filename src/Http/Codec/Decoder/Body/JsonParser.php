<?php

namespace Aurora\Http\Message\Parser;

use Aurora\Http\Codec\Decoder\BodyParser;
use Aurora\Http\Codec\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class JsonParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {
        // TODO: Implement parse() method.
    }
}