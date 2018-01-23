<?php

namespace Aurora\Http\Connection;

interface ServerConnectionInterface extends ConnectionInterface
{
    public function accept();
}