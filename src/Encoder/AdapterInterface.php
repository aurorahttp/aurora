<?php

namespace Aurora\Http\Message\Codec\Eecoder;

use Aurora\Http\Message\Codec\Eecoder;
use Psr\Http\Message\ResponseInterface;

interface AdapterInterface
{
    /**
     * Returns a response decode stream.
     *
     * @param Encoder           $encoder
     * @param ResponseInterface $response
     * @return Stream
     */
    public function createStream(Encoder $encoder, ResponseInterface $response): Stream;
}