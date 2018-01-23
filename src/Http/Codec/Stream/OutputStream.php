<?php

namespace Aurora\Http\Codec\Stream;

abstract class OutputStream extends ResolveStream
{
    public function isSeekable()
    {
        return true;
    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {
        throw new WritableException('Stream only readable');
    }

    public function isReadable()
    {
        return true;
    }
}