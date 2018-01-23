<?php

namespace Aurora\Http\Message\Codec\Stream;

/**
 * The input stream can only be written.
 *
 * @package Aurora\Http\Message\Codec\Stream
 */
abstract class InputStream extends ResolveStream
{
    public function isSeekable()
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new SeekableException('Stream only writable');
    }

    public function isWritable()
    {
        return true;
    }

    public function isReadable()
    {
        return false;
    }

    public function read($length)
    {
        throw new ReadableException('Stream only writable');
    }

    public function getContents()
    {
        throw new ReadableException('Stream only writable');
    }

    public function __toString()
    {
        return '';
    }
}