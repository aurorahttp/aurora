<?php

namespace Aurora\Http\Message\Encoder;

use Panlatent\Context\AttributeContext;

class StreamContext extends AttributeContext
{

    public $bufferWriteSize = 1024;

    private $_bufferFlushReady;

    public function bufferFlushReady()
    {
        if ($this->getBufferFlushReady() !== null) {
            call_user_func($this->getBufferFlushReady());
        }
    }

    /**
     * @return mixed
     */
    public function getBufferFlushReady()
    {
        return $this->_bufferFlushReady;
    }

    /**
     * @param mixed $bufferFlushReady
     */
    public function setBufferFlushReady($bufferFlushReady)
    {
        $this->_bufferFlushReady = $bufferFlushReady;
    }
}