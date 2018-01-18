<?php

namespace Panlatent\Http\Message;

use Panlatent\Http\Message\Decoder\AdapterInterface;
use Panlatent\Http\Message\Decoder\Context;
use Panlatent\Http\Message\Decoder\Stream;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Decoder decode raw HTTP message to ServerRequest object.
 *
 * @author Panlatent <panlatent@gmail.com>
 */
class Decoder
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Decoder constructor.
     *
     * @param Context|null $context
     */
    public function __construct(Context $context = null)
    {
        if ($context === null) {
            $this->context = new Context();
        } else {
            $this->context = $context;
        }
    }

    /**
     * Decode a stream to request.
     *
     * @param Stream $stream
     * @return ServerRequestInterface
     * @throws DecoderException
     */
    public function decode(Stream $stream): ServerRequestInterface
    {
        return $this->adapter->createServerRequest($this, $stream);
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