<?php


namespace Panlatent\Http\Message\Encoder;

use Panlatent\Http\Message\Encoder;
use Psr\Http\Message\ResponseInterface;

class GeneralAdapter implements AdapterInterface
{
    public function createStream(Encoder $encoder, ResponseInterface $response): Stream
    {
        $stream = $this->getStream();
        $stream->writeln(implode(' ',
            [
                'HTTP/' . $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase(),
            ]));

        foreach (array_keys($response->getHeaders()) as $key) {
            $stream->writeln($key . ': ' . $response->getHeaderLine($key));
        }
        $stream->writeln();
        $stream->writeBodyStream($response->getBody());

        return $stream;
    }

    protected function getStream()
    {
        return new Stream();
    }
}