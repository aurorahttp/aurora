<?php

namespace Aurora\Http\Handler\Tests;

class Handler implements \Aurora\Http\Handler\HandlerInterface
{
    public $number;

    public function __construct($number = null)
    {
        $this->number = $number;
    }

    public function handle($request, \Aurora\Http\Handler\HandlerInterface $handler)
    {
        return $handler->handle($request . $this->number, $handler);
    }
}