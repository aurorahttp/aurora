<?php

namespace Aurora\Context;

interface ContextSwitchInterface
{
    /**
     * Switch a context.
     *
     * @param ContextInterface $context
     * @return ContextInterface
     */
    public function contextSwitch(ContextInterface $context);
}