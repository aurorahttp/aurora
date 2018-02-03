<?php

namespace Aurora\Http\Codec\Stream;

use Psr\Http\Message\StreamInterface;

interface ResolveStreamInterface extends StreamInterface
{
    const HTTP_MESSAGE_LINE_ENDING = "\r\n";
    const HTTP_MESSAGE_HEADER_ENDING = "\r\n\r\n";

    const HTTP_1_1 = '1.1';
    const HTTP_2_0 = '2.0';
}