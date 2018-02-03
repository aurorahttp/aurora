<?php

namespace Aurora\Http\Message\Parser;

use Aurora\Http\Codec\Decoder\BodyParser;
use Aurora\Http\Codec\Decoder\Stream;
use Psr\Http\Message\StreamInterface;

class FormDataBodyParser extends BodyParser
{
    public function parse(Stream $stream): StreamInterface
    {

    }
}