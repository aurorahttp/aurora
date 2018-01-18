<?php

namespace Panlatent\Http\Message;

use Panlatent\Http\Message\Encoder\AdapterInterface;
use Panlatent\Http\Message\Encoder\Stream;
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