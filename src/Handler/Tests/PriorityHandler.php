<?php

namespace Aurora\Http\Handler\Tests;

use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Handler\PriorityInterface;

class PriorityHandler implements HandlerInterface, PriorityInterface
{
    public $number;

    public function __construct($number = 0)
    {
        $this->number = $number;
    }

    public function handle($request, HandlerInterface $next)
    {
        return $next->handle($request . $this->number, $next);
    }

    public function getPriority()
    {
        return $this->number;
    }
}