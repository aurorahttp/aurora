<?php

namespace Panlatent\Http\Message\Encoder;

use Panlatent\Http\Message\Encoder;
use Psr\Http\Message\ResponseInterface;

interface AdapterInterface
{
    /**
     * Bind decoder and stream to this object.
     *
     * @param Encoder           $encoder
     * @param ResponseInterface $response
     * @return bool True mean successful binding or false mean failed.
     */
    public function bind(Encoder $encoder, ResponseInterface $response);

    /**
     * @return Stream
     */
    public function createStream(): Stream;
}