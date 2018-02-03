<?php
/**
 * Http Message - A HTTP Message library that implements the Psr-7 standard
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-message
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Message;


use Aurora\Http\Message\Stream\FileStream;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $clientFilename;
    /**
     * @var string
     */
    protected $clientMediaType;

    public function __construct($path, $clientFilename, $clientMediaType)
    {
        $this->path = $path;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    public function getStream()
    {
        return new FileStream($this->path);
    }

    public function moveTo($targetPath)
    {
        rename($this->path, $targetPath);
    }

    public function getSize()
    {
        return filesize($this->path);
    }

    public function getError()
    {

    }

    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }
}