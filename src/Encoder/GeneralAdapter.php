<?php


namespace Panlatent\Http\Message\Encoder;

use Panlatent\Http\Message\Encoder;
use Psr\Http\Message\ResponseInterface;

class GeneralAdapter implements AdapterInterface
{
    public function createStream(Encoder $encoder, ResponseInterface $response): Stream
    {
        $stream = new Stream();
        $stream->writeln(implode(' ',
            [
                'HTTP/' . $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase(),
            ]));

        foreach (array_keys($response->getHeaders()) as $key) {
            $stream->writeln($key . ': ' . $response->getHeaderLine($key) . "\r\n");
        }
        $stream->writeln();
        $stream->withBodyStream($response->getBody());

        return $stream;
    }
}