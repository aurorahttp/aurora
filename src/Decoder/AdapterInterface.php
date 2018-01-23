<?php

namespace Aurora\Http\Message\Codec\Decoder;

use Aurora\Http\Message\Codec\Decoder;
use Psr\Http\Message\ServerRequestInterface;

interface AdapterInterface
{
    /**
     * Returns a ServerRequest object via stream.
     *
     * @param Decoder $decoder
     * @param Stream  $stream
     * @return ServerRequestInterface
     */
    public function createServerRequest(Decoder $decoder, Stream $stream);
}