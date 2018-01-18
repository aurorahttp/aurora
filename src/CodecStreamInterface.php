<?php

namespace Panlatent\Http\Message;

use Psr\Http\Message\StreamInterface;

interface CodecStreamInterface extends StreamInterface
{
    const HTTP_MESSAGE_LINE_ENDING = "\r\n";
    const HTTP_MESSAGE_HEADER_ENDING = "\r\n\r\n";
}