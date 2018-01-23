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

class MethodNotAllowedException extends ClientException
{
    protected $statusCode = 405;

    protected $statusReason = 'Method Not Allowed';
} 