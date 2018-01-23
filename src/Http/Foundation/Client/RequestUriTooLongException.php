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

class RequestUriTooLongException extends ClientException
{
    protected $statusCode = 414;

    protected $statusReason = 'Request URI Too Long';
}