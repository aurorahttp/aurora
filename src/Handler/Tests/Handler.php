<?php

namespace Aurora\Handler\Tests;

class Handler implements \Aurora\Handler\HandlerInterface
{
    public $number;

    public function __construct($number = null)
    {
        $this->number = $number;
    }

    public function handle($request, \Aurora\Handler\HandlerInterface $handler)
    {
        return $handler->handle($request . $this->number, $handler);
    }
}