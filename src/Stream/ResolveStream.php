<?php

namespace Aurora\Http\Message\Codec\Stream;

use Panlatent\Context\ContextSensitiveInterface;

abstract class ResolveStream implements ResolveStreamInterface, ContextSensitiveInterface
{
    public function getContext()
    {
        // TODO: Implement getContext() method.
    }
}