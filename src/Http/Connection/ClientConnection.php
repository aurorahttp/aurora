<?php

namespace Aurora\Http\Connection;

use Aurora\Http\Connection\Client\RateTrait;
use Aurora\Http\Connection\Client\TimeTrait;

class ClientConnection implements ClientConnectionInterface
{
    use TimeTrait, RateTrait;
    /**
     * @var resource
     */
    protected $socket;
    /**
     * @var string
     */
    protected $address;
    /**
     * @var int
     */
    protected $port;

    /**
     * Connection constructor.
     *
     * @param resource $socket
     */
    public function __construct($socket)
    {
        $this->socket = $socket;
        $this->updatedAt = $this->createdAt = time();
        list($this->address, $this->port) = explode(':', stream_socket_get_name($socket, true), 2);
    }

    /**
     * @var int
     */
    private $readAllowance = 0;

    /**
     * Read data from socket.
     *
     * @param int $length
     * @return string
     */
    public function read($length)
    {
        $now = time();
        $content = fread($this->socket, $length);
        $this->readCount += $readLength = strlen($content);
        if (($interval = $now - $this->readUpdatedAt) !== 0) {
            $this->readRate = ($this->readAllowance + $readLength) / $interval;
            $this->readTimeSpend += 1;
            $this->readAllowance = 0;
        } else {
            $this->readAllowance += $readLength;
        }
        $this->updatedAt = $this->readUpdatedAt = $now;

        return $content;
    }

    /**
     * @var int
     */
    private $writeAllowance = 0;

    /**
     * Write data to socket.
     *
     * @param string $content
     * @param int $length
     * @return int
     */
    public function write($content, $length = null)
    {
        $now = time();
        $this->writeCount += $writtenLength = fwrite($this->socket, $content, $length);
        if (($interval = $now - $this->writeUpdatedAt) !== 0) {
            $this->writeRate = ($this->writeAllowance + $writtenLength) / $interval;
            $this->writeTimeSpend += 1;
            $this->writeAllowance = 0;
        } else {
            $this->writeAllowance += $writtenLength;
        }
        $this->updatedAt = $this->writeUpdatedAt = $now;

        return $writtenLength;
    }

    /**
     * Write data to socket with flow control.
     *
     * @param string $content
     * @return int
     */
    public function send($content)
    {
        if ($this->writeRateLimit == 0) {
            return $this->write($content);
        }
        $now = time();
        if (($interval = $now - $this->writeUpdatedAt) !== 0) {
            $window = $this->writeRateLimit;
        } else {
            $window = $this->writeRateLimit - $this->writeAllowance;
            if ($window <= 0) {
                return 0;
            }
        }

        return $this->write($content, $window);
    }

    /**
     * Close the connection.
     */
    public function close()
    {
        stream_socket_shutdown($this->socket, 2);
        fclose($this->socket);
        $this->createdAt = time();
    }

    /**
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isClose()
    {
        return $this->updatedAt != 0;
    }
}