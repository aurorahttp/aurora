<?php

namespace Panlatent\Http\Message;

use Panlatent\Http\Message\Encoder\AdapterInterface;
use RuntimeException;

class EncoderException extends RuntimeException
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
}