<?php

namespace Aurora\Http\Transaction\Middleware;

use Aurora\Http\Handler\Bundle\PriorityBundle;
use Aurora\Http\Handler\ClosureHandler;
use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Transaction\TransactionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareBundle implements MiddlewareInterface
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;
    /**
     * @var PriorityBundle
     */
    protected $bundle;
    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
        $this->bundle = new PriorityBundle();
    }

    /**
     * @param MiddlewareInterface $middleware
     */
    public function insert(MiddlewareInterface $middleware)
    {
        if (! $middleware instanceof HandlerInterface) {
            $middleware = new ClosureHandler(function($request, HandlerInterface $handler) use($middleware) {
                $response = $middleware->process($request, $this->requestHandler);
                return $handler->handle($response, $handler);
            });
        }
        $this->bundle->insert($middleware);
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->requestHandler = $handler;
        return $this->bundle->handle($request, ClosureHandler::create(function() {
            throw new MiddlewareProcessException('No middleware involved in processing');
        }));
    }
}