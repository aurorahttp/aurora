<?php
/**
 * Http Exception - HTTP error PHP exception interface and class
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-exception
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http;

use InvalidArgumentException;

class ClientException extends ResponsiveException
{
    public function __construct($message = "", $statusCode = 0, \Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);

        if ($this->statusCode < 400 || $this->statusCode > 499) {
            throw new InvalidArgumentException("Status code out of range: #$statusCode");
        }
    }
}