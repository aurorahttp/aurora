<?php

namespace Aurora\Http\Transaction;

interface PriorityInterface extends \Aurora\Http\Handler\PriorityInterface
{
    /**
     * @param int $priority
     */
    public function setPriority($priority);
}