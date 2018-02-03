<?php

namespace Aurora\Http\Transaction\Filter;

use Aurora\Http\Handler\Bundle\PriorityBundle;
use Aurora\Http\Handler\ClosureHandler;
use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Message\Filter\FilterInterface;
use Aurora\Http\Transaction\TransactionInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FilterQueue
 *
 * @author Panlatent <panlatent@gmail.com>
 */
class FilterBundle implements FilterInterface
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;
    /**
     * @var PriorityBundle
     */
    protected $bundle;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
        $this->bundle = new PriorityBundle();
    }

    public function insert(FilterInterface $filter)
    {
        if (! $filter instanceof HandlerInterface) {
            $filter = new ClosureHandler(function ($request, HandlerInterface $handler) use ($filter) {
                if (! $request instanceof MessageInterface) {
                    return $handler->handle($request, $handler);
                }
                $request = $filter->process($request);

                return $handler->handle($request, $handler);
            });
        }
        $this->bundle->insert($filter);
    }

    public function process(MessageInterface $request): MessageInterface
    {
        $message = $this->bundle->handle($request, ClosureHandler::create(function ($request) {
            return $request;
        }));
        if (! $message instanceof MessageInterface) {
            throw new FilterProcessException('Invalid filter behavior: The returned type is wrong');
        }

        return $message;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function processServerRequest(ServerRequestInterface $request)
    {
        $request = $this->process($request);
        if (! $request instanceof ServerRequestInterface) {
            throw new FilterProcessException('Invalid filter behavior: The returned type is wrong');
        }

        return $request;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function processResponse(ResponseInterface $response)
    {
        $response = $this->process($response);
        if (! $response instanceof ResponseInterface) {
            throw new FilterProcessException('Invalid filter behavior: The returned type is wrong');
        }

        return $response;
    }
}