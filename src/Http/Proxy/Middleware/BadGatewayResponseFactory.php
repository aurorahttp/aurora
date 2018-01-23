<?php

namespace Aurora\Http\Proxy\Middleware;

use Exception;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\RequestInterface;

class BadGatewayResponseFactory
{
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var Exception
     */
    protected $exception;

    public function __construct(RequestInterface $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    public function createResponse()
    {
        $content = $this->getContent();
        $response = new Response($this->getStatusCode(), [], $this->createStream($content));

        return $response;
    }

    protected function getStatusCode()
    {
        return 502;
    }

    protected function createStream($content = '')
    {
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        fseek($stream, 0);

        return new Stream($stream);
    }

    protected function getContent()
    {
        extract([
            'request' => $this->request,
            'exception' => $this->exception,
            'statusCode' => $this->getStatusCode(),
        ]);
        ob_start();
        // require(__DIR__ . '/Support/error.php');
        $content = ob_get_clean();

        return $content;
    }
}