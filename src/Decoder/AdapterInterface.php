<?php

namespace Panlatent\Http\Message\Decoder;

use Panlatent\Http\Message\Decoder;

interface AdapterInterface
{
    /**
     * Bind decoder and stream to this object.
     *
     * @param Decoder $decoder
     * @param Stream  $stream
     * @return bool True mean successful binding or false mean failed.
     */
    public function bind(Decoder $decoder, Stream $stream);
}