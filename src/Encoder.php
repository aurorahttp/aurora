<?php

namespace Aurora\Http\Message;

use Aurora\Http\Message\Encoder\AdapterInterface;
use Aurora\Http\Message\Encoder\GeneralAdapter;
use Aurora\Http\Message\Encoder\Stream;
use Psr\Http\Message\ResponseInterface;

/**
 * Encoder encode response object to raw HTTP message.
 *
 * @author Panlatent <panlatent@gmail.com>
 */
class Encoder
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Decode a response to stream.
     *
     * @param ResponseInterface $response
     * @return Stream
     */
    public function encode(ResponseInterface $response): Stream
    {
        return $this->getAdapter()->createStream($this, $response);
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        if ($this->adapter === null) {
            $this->adapter = new GeneralAdapter();
        }
        return $this->adapter;
    }

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

}