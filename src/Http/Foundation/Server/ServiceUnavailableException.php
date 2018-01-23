<?php
/**
 * Http Exception - HTTP error PHP exception interface and class
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-exception
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Server;

use Aurora\Http\ServerException;

class ServiceUnavailableException extends ServerException
{
    protected $statusCode = 503;

    protected $statusReason = 'Service Unavailable';
} 