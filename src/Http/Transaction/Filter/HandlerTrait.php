<?php

namespace Aurora\Http\Transaction;

use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Message\Filter\FilterInterface;
use Psr\Http\Message\MessageInterface;

trait HandlerTrait
{
    public function handle($request, HandlerInterface $next)
    {
        if (! $request instanceof MessageInterface) {
            return $next->handle($request, $next);
        }
        /** @var FilterInterface  $this */
        $request = $this->process($request);

        return $next->handle($request, $next);
    }
}