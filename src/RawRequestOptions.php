<?php

namespace Panlatent\Http\RawMessage;

class RawRequestOptions
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
}