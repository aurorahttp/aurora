<?php

namespace Aurora\Http\Connection;

use InvalidArgumentException;

class ServerConnection implements ServerConnectionInterface
{
    const PORT_NUMBER_MIN = 1;
    const PORT_NUMBER_MAX = 65535;
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
     * @var bool
     */
    protected $security;
    /**
     * @var int
     */
    protected $createdAt;
    /**
     * @var int
     */
    protected $closedAt;
    /**
     * @var int
     */
    protected $acceptCount = 0;
    /**
     * @var int
     */
    protected $errorNumber;
    /**
     * @var string
     */
    protected $errorContent;

    /**
     * ServerConnection constructor.
     *
     * @param string $address
     * @param        $port
     * @param bool   $security
     * @param array  $options
     */
    public function __construct($address, $port, $security = false, $options = [])
    {
        $context = stream_context_create($options);
        $this->security = $security;
        $this->prepare($address, $port);
        $this->socket = stream_socket_server(
            $this->address . ':' . $this->port,
            $this->errorNumber,
            $this->errorContent,
            STREAM_SERVER_BIND |
            STREAM_SERVER_LISTEN,
            $context);
        stream_set_blocking($this->socket, 0);
        $this->createdAt = time();
    }

    /**
     * Close socket.
     */
    public function close()
    {
        stream_socket_shutdown($this->socket, 2);
        fclose($this->socket);
        $this->closedAt = time();
    }

    /**
     * @return resource
     */
    public function accept()
    {
        $this->acceptCount += 1;

        return stream_socket_accept($this->socket);
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
    public function isSecurity()
    {
        return $this->security;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getClosedAt(): int
    {
        return $this->closedAt;
    }

    /**
     * @return int
     */
    public function getAcceptCount(): int
    {
        return $this->acceptCount;
    }

    /**
     * @return int
     */
    public function getErrorNumber(): int
    {
        return $this->errorNumber;
    }

    /**
     * @return string
     */
    public function getErrorContent(): string
    {
        return $this->errorContent;
    }

    /**
     * @param string $address
     * @param int    $port
     */
    protected function prepare($address, $port)
    {
        if ($address == '*' || $address == '') {
            $this->address = '0.0.0.0';
        } elseif (false !== filter_var($address, FILTER_VALIDATE_IP)) {
            $this->address = $address;
        } elseif (false !== ($hosts = gethostbynamel($address))) {
            if (count($hosts) != 1) {
                throw new InvalidArgumentException("Host has multiple addresses : $address");
            }
            $this->address = $hosts[0];
        } else {
            throw new InvalidArgumentException("Invalid socket bind address: $address");
        }

        if (! ctype_digit($port) || $port > static::PORT_NUMBER_MAX || $port < static::PORT_NUMBER_MIN) {
            throw new InvalidArgumentException("Port number limit exceeded: $port");
        }
        $this->port = $port;
    }
}