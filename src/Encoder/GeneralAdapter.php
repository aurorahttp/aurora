<?php


namespace Panlatent\Http\Message\Encoder;

use Panlatent\Http\Message\Encoder;
use Psr\Http\Message\ResponseInterface;

class GeneralAdapter implements AdapterInterface
{
    /**
     * @var Encoder
     */
    protected $encoder;
    /**
     * @var ResponseInterface
     */
    protected $response;

    public function bind(Encoder $encoder, ResponseInterface $response)
    {
        $this->encoder = $encoder;
        $this->response = $response;
    }

    public function createStream(): Stream
    {
        $stream = new Stream();
        $stream->writeln(implode(' ',
            [
                'HTTP/' . $this->response->getProtocolVersion(),
                $this->response->getStatusCode(),
                $this->response->getReasonPhrase(),
            ]));

        foreach (array_keys($this->response->getHeaders()) as $key) {
            $stream->writeln($key . ': ' . $this->response->getHeaderLine($key) . "\r\n");
        }
        $stream->writeln();
        $stream->withBodyStream($this->response->getBody());

        return $stream;
    }

}