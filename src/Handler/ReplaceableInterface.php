<?php

namespace Aurora\Handler;

use Closure;

interface ReplaceableInterface
{
    /**
     * @param Closure $handle
     */
    public function replace($handle);
}