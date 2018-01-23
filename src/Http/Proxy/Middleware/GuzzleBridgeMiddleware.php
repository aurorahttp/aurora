<?php

namespace Aurora\Http\Proxy\Middleware;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\TransferException;
use Aurora\Http\Transaction\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GuzzleBridgeMiddleware extends Middleware
{
    /**
     * @var Client
     */
    protected static $guzzle;

    /**
     * Bridge constructor.
     */
    public function __construct()
    {
        if (static::$guzzle === null) {
            static::$guzzle = new Client();
        }
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /*
         * Transmit client request to target server.
         */
        $options = [
            'timeout'         => 30.0,
            'connect_timeout' => 10.0,
        ];
        try {
            $response = $this->send($request, $options);
            // Aurxy::debug("GuzzleBridgeMiddleware response data {$response->getBody()->getSize()} bytes");
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
        } catch (TransferException $exception) {
            // Aurxy::error("GuzzleBridgeMiddleware response data failed. {$exception->getMessage()}");
            $response = (new BadGatewayResponseFactory($request, $exception))->createResponse();
        }

        return $response;
    }

    /**
     * Send request via Guzzle by PSR-7 Request object.
     *
     * @param RequestInterface $request
     * @param array            $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return static::$guzzle->send($request, $options);
    }
}