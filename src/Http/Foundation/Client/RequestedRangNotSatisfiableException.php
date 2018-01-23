<?php
/**
 * Http Exception - HTTP error PHP exception interface and class
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-exception
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Client;

use Aurora\Http\ClientException;

class RequestedRangNotSatisfiableException extends ClientException
{
    protected $statusCode = 416;

    protected $statusReason = 'Requested Rang Not Satisfiable';
}