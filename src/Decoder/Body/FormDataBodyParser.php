<?php

namespace Aurora\Http\Message\Parser;

use Aurora\Http\Message\Codec\Decoder\BodyParser;
use Aurora\Http\Message\Codec\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class FormDataBodyParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {

    }
}