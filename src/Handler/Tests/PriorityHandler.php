<?php

namespace Aurora\Handler\Tests;

use Aurora\Handler\HandlerInterface;
use Aurora\Handler\PriorityInterface;

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