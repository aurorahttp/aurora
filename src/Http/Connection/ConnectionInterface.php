<?php

namespace Aurora\Http\Connection;

interface ConnectionInterface
{
    public function close();

    public function getSocket();
}