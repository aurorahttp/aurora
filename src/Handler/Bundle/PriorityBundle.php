<?php

namespace Aurora\Handler\Bundle;

use Aurora\Handler\Bundle;
use Aurora\Handler\HandlerInterface;
use Aurora\Handler\PriorityInterface;
use SplPriorityQueue;

class PriorityBundle extends Bundle
{
    /**
     * @var HandlerInterface[]|SplPriorityQueue
     */
    protected $store;

    public function __construct()
    {
        $this->store = new SplPriorityQueue();
    }

    /**
     * @param mixed            $request
     * @param HandlerInterface $next
     * @return HandlerInterface|mixed
     */
    public function handle($request, HandlerInterface $next)
    {
        if ($this->isEmpty()) {
            return $request;
        }
        if ($this->shadow == false) {
            $bundle = clone $this;
            $bundle->shadow = true;
            $bundle->insert($next);;

            return $bundle->extract()->handle($request, $bundle);
        }
        $handler = $this->extract();

        return $handler->handle($request, $this);
    }

    /**
     * @return HandlerInterface
     */
    public function extract()
    {
        return $this->store->extract();
    }

    /**
     * @param HandlerInterface $value
     * @param int              $priority
     */
    public function insert(HandlerInterface $value, $priority = null)
    {
        if ($priority === null && $value instanceof PriorityInterface) {
            $priority = $value->getPriority();
        }
        $this->store->insert($value, $priority);
    }

    /**
     * @return HandlerInterface
     */
    public function top()
    {
        return $this->store->top();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->store->isEmpty();
    }
}