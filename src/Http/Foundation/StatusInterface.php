<?php

namespace Aurora\Http;

interface StatusInterface
{
    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getStatusReason();
}