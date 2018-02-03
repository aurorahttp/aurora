<?php

namespace Aurora\Http\Codec\Stream;

use Aurora\Context\ContextSensitiveInterface;

abstract class ResolveStream implements ResolveStreamInterface, ContextSensitiveInterface
{
    public function getContext()
    {
        // TODO: Implement getContext() method.
    }
}