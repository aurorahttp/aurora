<?php

namespace Aurora\Http\Transaction;

trait PriorityTrait
{
    /**
     * @var int
     */
    protected $priority = 0;

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}