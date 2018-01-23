<?php

namespace Aurora\Http;

class ResponsiveException extends Exception implements StatusInterface
{
    /**
     * @var int
     */
    protected $statusCode;
    /**
     * @var string
     */
    protected $statusReason = '';

    public function __construct($message = "", $statusCode = 0, \Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);

        if ( ! empty($statusCode)) {
            $this->statusCode = $statusCode;
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusReason()
    {
        return $this->statusReason;
    }

    /**
     * @return string
     */
    public function getStatusPhrase()
    {
        return $this->getStatusCode() . ' ' . $this->getStatusReason();
    }
}