<?php

namespace Panlatent\Http\Message\Encoder;

use Panlatent\Http\Message\CodecStreamInterface;
use Psr\Http\Message\StreamInterface;

class Stream implements CodecStreamInterface
{
    const MSG_LINE_WAITING = 1;
    const MSG_LINE_DOING = 2;
    const MSG_HEAD_WAITING = 4;
    const MSG_HEAD_DOING = 5;
    const MSG_HEAD_DONE = 6;
    const MSG_BODY_WAITING = 7;
    const MSG_BODY_DOING = 8;
    const MSG_BODY_DONE = 9;

    /**
     * @var int
     */
    protected $messageStatus;
    /**
     * @var StreamOptions
     */
    protected $options;
    /**
     * @var resource
     */
    protected $buffer;
    /**
     * @var int
     */
    protected $bufferSize;
    /**
     * @var StreamInterface
     */
    protected $bodyStream;


    protected $bufferFlushEvent;

    public function __construct(StreamOptions $options = null)
    {
        if ($options === null) {
            $this->options = new StreamOptions();
        } else {
            $this->options = $options;
        }
        $this->messageStatus = static::MSG_LINE_WAITING;
    }

    public function write($content)
    {
        $this->prepare();
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

    public function withBodyStream(StreamInterface $stream)
    {
        $this->bodyStream = $stream;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    public function detach()
    {
        // TODO: Implement detach() method.
    }

    public function getSize()
    {
        // TODO: Implement getSize() method.
    }

    public function tell()
    {
        // TODO: Implement tell() method.
    }

    public function eof()
    {
        // TODO: Implement eof() method.
    }

    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function read($length)
    {
        // TODO: Implement read() method.
    }

    public function getContents()
    {
        // TODO: Implement getContents() method.
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }


    public function getStatusCode()
    {
        return 200;
    }

    public function isReadable()
    {
        return true;
    }

    public function isWritable()
    {
        return false;
    }

    protected function prepare()
    {

    }
}