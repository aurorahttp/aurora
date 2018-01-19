<?php

namespace Panlatent\Http\Message\Parser;

use Panlatent\Http\Message\Decoder\BodyParser;
use Panlatent\Http\Message\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class XmlParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {
        // TODO: Implement parse() method.
    }
}