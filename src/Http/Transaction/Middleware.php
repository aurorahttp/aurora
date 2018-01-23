<?php

namespace Aurora\Http\Transaction;

use Aurora\Http\Handler\Bundle;
use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Transaction\Middleware\MiddlewareBundle;
use Aurora\Http\Transaction\Middleware\MiddlewareProcessException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Middleware implements MiddlewareInterface, PriorityInterface
{
    use PriorityTrait;
    /**
     * @var MiddlewareBundle
     */
    protected $bundle;
    /**
     * @var RequestHandlerInterface
     */
    protected $handler;

    public function handle($request, HandlerInterface $next)
    {
        if (! $request instanceof ServerRequestInterface) {
            return $next->handle($request, $next);
        }
        if ($next instanceof Bundle) {
            $this->bundle = $next;
        }
        if (empty($this->handler)) {
            throw new MiddlewareProcessException('Invalid server request handler');
        }
        $response = $this->process($request, $this->handler);

        return $next->handle($response, $next);
    }

    /**
     * @return RequestHandlerInterface
     */
    public function getHandler(): RequestHandlerInterface
    {
        return $this->handler;
    }

    /**
     * @param RequestHandlerInterface $handler
     */
    public function setHandler(RequestHandlerInterface $handler)
    {
        $this->handler = $handler;
    }
}