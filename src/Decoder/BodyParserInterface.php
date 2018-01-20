<?php

namespace Aurora\Http\Message\Decoder;

use Psr\Http\Message\StreamInterface;

interface BodyParserInterface
{
    /**
     * @param Stream $stream
     * @return mixed
     */
    public function parse(Stream $stream): StreamInterface;
}