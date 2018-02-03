<?php

namespace Aurora\Http\Codec;

use Aurora\Http\Codec\Encoder\AdapterInterface;
use RuntimeException;

class EncoderException extends RuntimeException
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
}