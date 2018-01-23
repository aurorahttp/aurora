<?php

namespace Aurora\Handler\Bundle;

use ArrayAccess;
use Aurora\Handler\Bundle;
use Aurora\Handler\HandlerInterface;
use InvalidArgumentException;
use SplDoublyLinkedList;

/**
 * Class HandlerList
 *
 * @author Panlatent <panlatent@gmail.com>
 */
class ListBundle extends Bundle implements ArrayAccess
{
    /**
     * HandlerList constructor.
     */
    public function __construct()
    {
        $this->store = new SplDoublyLinkedList();
    }

    /**
     * Process a request using all stored handlers.
     *
     * @param mixed            $request
     * @param HandlerInterface $next
     * @return mixed
     */
    public function handle($request, HandlerInterface $next)
    {
        if ($this->isEmpty()) {
            return $request;
        }
        if ($this->shadow == false) {
            $bundle = clone $this;
            $bundle->store->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE);
            $this->shadow = true;

            return $next->handle($request, $bundle);
        }
        $handler = $this->frontPop();

        return $handler->handle($request, $this);
    }

    /**
     * @param int              $index
     * @param HandlerInterface $handler
     */
    public function insert($index, HandlerInterface $handler)
    {
        $this->store->add($index, $handler);
    }

    /**
     * @return HandlerInterface
     */
    public function backPop()
    {
        return $this->store->pop();
    }

    /**
     * @return HandlerInterface
     */
    public function frontPop()
    {
        return $this->store->shift();
    }

    /**
     * @param HandlerInterface $value
     */
    public function backPush(HandlerInterface $value)
    {
        $this->store->push($value);
    }

    /**
     * @param HandlerInterface $value
     */
    public function frontPush(HandlerInterface $value)
    {
        $this->store->unshift($value);
    }

    /**
     * @return HandlerInterface
     */
    public function front()
    {
        return $this->store->bottom();
    }

    /**
     * @return HandlerInterface
     */
    public function back()
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

    /**
     * Clear all handlers.
     */
    public function clear()
    {
        for (; ! $this->store->isEmpty();) {
            $this->store->pop();
        }
    }

    /**
     * Reverse handlers.
     */
    public function reverse()
    {
        $length = count($this->store);
        for ($i = 0; $i < $length; ++$i) {
            $this->store->unshift($this->store->pop());
        }
    }

    /**
     * @param int $size
     */
    public function resize($size)
    {
        for ($i = $this->store->count(); $i > $size; --$i) {
            $this->store->pop();
        }
    }

    /**
     * @param ListBundle $handlerList
     */
    public function merge(ListBundle $handlerList)
    {
        foreach ($handlerList as $handler) {
            $this->store->push($handler);
        }
    }

    /**
     * @param int $index
     * @return bool
     */
    public function offsetExists($index)
    {
        return $this->store->offsetExists($index);
    }

    /**
     * @param int $index
     * @return HandlerInterface
     */
    public function offsetGet($index)
    {
        return $this->store->offsetGet($index);
    }

    /**
     * @param int              $index
     * @param HandlerInterface $handler
     */
    public function offsetSet($index, $handler)
    {
        if (! $handler instanceof HandlerInterface) {
            throw new InvalidArgumentException('The second parameter must implement the ' .
                HandlerInterface::class . ' interface');
        }

        $this->store->offsetSet($index, $handler);
    }

    /**
     * @param int $index
     */
    public function offsetUnset($index)
    {
        $this->store->offsetUnset($index);
    }


    /**
     * Move to previous entry
     */
    public function prev()
    {
        $this->store->prev();
    }
}