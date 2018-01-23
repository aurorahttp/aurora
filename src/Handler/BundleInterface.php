<?php

namespace Aurora\Handler;

use Countable;
use Iterator;
use Serializable;

interface BundleInterface extends HandlerInterface, Iterator, Countable, Serializable
{
    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return bool
     */
    public function isShadow();
}