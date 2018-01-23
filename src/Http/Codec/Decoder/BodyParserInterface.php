<?php

namespace Aurora\Http\Codec\Decoder;

use Psr\Http\Message\StreamInterface;

interface BodyParserInterface
{
    /**
     * @param Stream $stream
     * @return mixed
     */
    public function parse(Stream $stream): StreamInterface;
}