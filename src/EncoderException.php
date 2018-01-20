<?php

namespace Aurora\Http\Message;

use Aurora\Http\Message\Encoder\AdapterInterface;
use RuntimeException;

class EncoderException extends RuntimeException
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
}