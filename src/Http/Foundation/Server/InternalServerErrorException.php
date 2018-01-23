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

class InternalServerErrorException extends ServerException
{
    protected $statusCode = 500;

    protected $statusReason = 'Internal Server Error';
} 