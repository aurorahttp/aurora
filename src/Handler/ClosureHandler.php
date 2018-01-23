<?php

namespace Aurora\Handler;

use Aurora\Handler\Bundle\ListBundle;

class ClosureHandler implements HandlerInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * ClosureHandler constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param callable $callback
     * @return static
     */
    public static function create(callable $callback)
    {
        return new static($callback);
    }

    /**
     * @param mixed            $request
     * @param HandlerInterface $next
     * @return mixed
     */
    public function handle($request, HandlerInterface $next)
    {
        if (! $next instanceof BundleInterface) {
            $next = new ListBundle();
            $next->backPush($next);
        }

        return call_user_func($this->callback, $request, $next);
    }
}