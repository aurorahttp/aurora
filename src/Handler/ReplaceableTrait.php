<?php

namespace Aurora\Handler;

use Closure;

trait ReplaceableTrait
{
    /**
     * @var callable
     */
    protected $handler;

    /**
     * Replace class handle method.
     *
     * @param callable $handler
     * @param bool     $bindTo
     */
    public function replace($handler, $bindTo = true)
    {
        if ($bindTo && $handler instanceof Closure) {
            $handler = $handler->bindTo($this, $this);
        }
        $this->handler = $handler;
    }

    public function handle()
    {
        if ($this->handler !== null) {
            call_user_func($this->handler);
        }
    }
}