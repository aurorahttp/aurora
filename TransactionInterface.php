<?php

namespace Aurora\Http\Transaction;

use Aurora\Http\Handler\HandlerInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface TransactionInterface extends HandlerInterface
{
    /**
     * @return RequestHandlerInterface
     */
    public function getRequestHandler();
}