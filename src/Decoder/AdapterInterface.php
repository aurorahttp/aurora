<?php

namespace Panlatent\Http\Message\Decoder;

use Panlatent\Http\Message\Decoder;
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