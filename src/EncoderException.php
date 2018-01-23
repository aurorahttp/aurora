<?php

namespace Aurora\Http\Message\Codec;

use Aurora\Http\Message\Encoder\AdapterInterface;
use RuntimeException;

class EncoderException extends RuntimeException
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
}