<?php

namespace Aurora\Handler;

interface PriorityInterface
{
    /**
     * @return int
     */
    public function getPriority();
}