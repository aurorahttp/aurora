<?php

namespace Aurora\Http\Codec\Encoder;

use Aurora\Context\ContextSensitiveInterface;
use Aurora\Http\Codec\Stream\ResolveStreamInterface;
use Psr\Http\Message\StreamInterface;

class Stream implements ResolveStreamInterface, ContextSensitiveInterface
{
    const MSG_LINE_WAITING = 1;
    const MSG_LINE_DOING = 2;
    const MSG_HEAD_WAITING = 4;
    const MSG_HEAD_DOING = 5;
    const MSG_HEAD_DONE = 6;
    const MSG_BODY_WAITING = 7;
    const MSG_BODY_DOING = 8;
    const MSG_BODY_DONE = 9;

    const MSG_READ_HEAD = 10;
    const MSG_READ_BODY = 11;

    const BUFFER_PHP_STREAM = 0;
    const BUFFER_FILESYSTEM = 1;

    /**
     * @var int
     */
    protected $messageStatus;
    /**
     * @var StreamContext
     */
    protected $context;
    /**
     * @var resource
     */
    protected $buffer;
    /**
     * @var int
     */
    protected $bufferType;

    /**
     * Stream constructor.
     */
    public function __construct()
    {
        $this->context = new StreamContext();
        $this->bufferType = static::BUFFER_PHP_STREAM;
        $this->messageStatus = static::MSG_LINE_WAITING;
    }

    /**
     * @param string $content
     * @return bool|int
     */
    public function write($content)
    {
        $this->prepare();

        $writtenLength = fwrite($this->buffer, $content, $this->context->bufferWriteSize);
        if (ftell($this->buffer) >= $this->context->bufferWriteSize) {
            $this->context->bufferFlushReady();
        }

        return $writtenLength;
    }

    public function writeln($content = '')
    {
        $this->write($content . static::HTTP_MESSAGE_LINE_ENDING);
        if ($this->messageStatus == static::MSG_LINE_WAITING) {

            $this->messageStatus = static::MSG_LINE_DOING;
        } elseif ($this->messageStatus == static::MSG_LINE_DOING ||
            $this->messageStatus == static::MSG_HEAD_WAITING) {
            $this->messageStatus = static::MSG_HEAD_DOING;
        } elseif ($this->messageStatus == static::MSG_HEAD_DOING ||
            $content === '') {
            $this->messageStatus = static::MSG_HEAD_DONE;
        } elseif ($this->messageStatus == static::MSG_HEAD_DONE ||
            $this->messageStatus == static::MSG_BODY_WAITING) {
            $this->messageStatus = static::MSG_BODY_DOING;
        }
    }

    /**
     * @param resource $source
     * @return int
     */
    public function writeStream($source)
    {
        return stream_copy_to_stream($source, $this->buffer);
    }

    /**
     * @param StreamInterface $stream
     * @return int
     */
    public function writeBodyStream(StreamInterface $stream)
    {
        $length = 0;
        for ($stream->rewind(); ! $stream->eof(); ) {
            for ($part = $stream->read(1024); $part !== ''; ) {
                $writtenLength = fwrite($this->buffer, $part);
                $part = substr($part, $writtenLength);
                $length += $writtenLength;
            }
        }

        return $length;
    }

    public function close()
    {
        return fclose($this->buffer);
    }

    public function detach()
    {
        return $this->buffer;
    }

    public function getSize()
    {
        fseek($this->buffer, 0, SEEK_END);

        return ftell($this->buffer);
    }

    public function tell()
    {
        return ftell($this->buffer);
    }

    public function eof()
    {
        return feof($this->buffer);
    }

    public function isSeekable()
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        return fseek($this->buffer, $offset, $whence);
    }

    public function rewind()
    {
        return rewind($this->buffer);
    }

    public function read($length)
    {
        return fread($this->buffer, $length);
    }

    public function getContents()
    {
        $contents = '';
        for ($this->rewind(); ! $this->eof(); ) {
            $contents .= $this->read(1024);
        }

        return $contents;
    }

    public function getMetadata($key = null)
    {
        return null;
    }

    /**
     * @return StreamContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return int
     */
    public function getBufferType(): int
    {
        return $this->bufferType;
    }

    /**
     * @param int $bufferType
     */
    public function setBufferType(int $bufferType)
    {
        $this->bufferType = $bufferType;
    }

    public function isReadable()
    {
        return true;
    }

    public function isWritable()
    {
        return false;
    }

    public function __toString()
    {
        return $this->getContents();
    }

    protected function prepare()
    {
        if ($this->messageStatus == static::MSG_LINE_WAITING) {
            if ($this->bufferType == static::BUFFER_PHP_STREAM) {
                $this->buffer = fopen('php://temp', 'r+');
            } else {
                $this->buffer = tmpfile();
            }
        }
    }
}