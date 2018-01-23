<?php

namespace Aurora\Context;

interface ContextSensitiveInterface
{
    /**
     * @return ContextInterface
     */
    public function getContext();
}