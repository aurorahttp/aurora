<?php

namespace Aurora\Http\Connection;

interface ClientConnectionInterface extends ConnectionInterface
{
    const KEEL_ALIVE = 'keep-alive';
    const HTTP_PERSISTENT = '1.1';
    const HTTP_CLOSE = 'close';
    const HTTP_1_0 = '1.0';
    const HTTP_1_1 = '1.1';
    const HTTP_2_0 = '2.0';

    public function read($length);

    public function write($content, $length = 0);

    public function send($content);
}