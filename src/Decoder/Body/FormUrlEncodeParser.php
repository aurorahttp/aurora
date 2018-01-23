<?php

namespace Aurora\Http\Message\Parser;

use Aurora\Http\Message\Codec\Decoder\BodyParser;
use Aurora\Http\Message\Codec\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class FormUrlEncodeParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {
        // TODO: Implement parse() method.
    }
}