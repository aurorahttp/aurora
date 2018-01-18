<?php

namespace Panlatent\Http\Message\Decoder;

use Panlatent\Context;

class StreamContext extends Context
{
    /**
     * @var int Allow http method length.
     */
    public $methodMaxLength = 10;
    /**
     * @var int request line version max length.
     */
    public $versionMaxLength = 8;
    /**
     * @var int request line uri part max length. If the value is zero means no limit,
     * but request line length is subject to a php://memory stream memory limit.
     */
    public $uriMaxLength = 0;
    /**
     * @var array
     */
    public $methods = [];
    /**
     * @var array
     */
    public $withoutBodyMethods = ['GET', 'HEAD', 'OPTIONS', 'CONNECT'];
    /**
     * @var array
     */
    public $withBodyMethods = ['POST', 'PUT', 'DELETE', 'TRACE'];
    /**
     * @var int
     */
    public $headerLineMaxLength = 8192;


    public function headerReady()
    {
        if ($this->getHeaderReady() !== null) {
            call_user_func($this->getHeaderReady());
        }
    }

    public function bodyReady()
    {
        if ($this->getBodyReady() !== null) {
            call_user_func($this->getBodyReady());
        }
    }

    /**
     * @var callable|null
     */
    private $_headerReady;

    /**
     * @return callable|null
     */
    public function getHeaderReady(): callable
    {
        return $this->_headerReady;
    }

    /**
     * @param callable|null $headerReady
     */
    public function setHeaderReady(callable $headerReady)
    {
        $this->_headerReady = $headerReady;
    }

    /**
     * @var callable|null
     */
    private $_bodyReady;

    /**
     * @return callable|null
     */
    public function getBodyReady(): callable
    {
        return $this->_bodyReady;
    }

    /**
     * @param callable|null $bodyRead
     */
    public function setBodyReady(callable $bodyRead)
    {
        $this->_bodyReady = $bodyRead;
    }
}