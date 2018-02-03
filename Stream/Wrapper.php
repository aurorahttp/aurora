<?php
/**
 * Http Message - A HTTP Message library that implements the Psr-7 standard
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-message
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Message\Stream;

use Psr\Http\Message\StreamInterface;

class Wrapper
{
    /**
     * @var resource
     */
    public $context;
    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Register stream wrapper.
     *
     * @param string $protocol
     * @param string $streamClass
     */
    public static function register($protocol, $streamClass)
    {
        if (in_array($protocol, stream_get_wrappers())) {
            stream_wrapper_unregister($protocol);
        }
        stream_register_wrapper($protocol, get_called_class());

        $default = stream_context_get_default();
        $options = stream_context_get_options($default);
        $options[$protocol] = ['class' => $streamClass];
        stream_context_set_option($default, $options);
    }

    public function stream_close()
    {
        $this->stream->close();
    }

    public function stream_eof()
    {
        return $this->stream->eof();
    }

    public function stream_metadata($path, $option, $value)
    {
        $this->prepare($path);

        return $this->stream->getMetadata($option);
    }

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $this->prepare($path);
    }

    public function stream_read($length)
    {
        return $this->stream->read($length);
    }

    public function stream_seek($offset, $whence = SEEK_SET)
    {
        return $this->stream->seek($offset, $whence);
    }

    public function stream_tell()
    {
        return $this->stream->tell();
    }

    public function stream_write($data)
    {
        return $this->stream->write($data);
    }

    private function prepare($path)
    {
        $info = parse_url($path);
        $protocol = $info['scheme'];
        $options = stream_context_get_options(stream_context_get_default());
        $streamClass = $options[$protocol]['class'];
        $this->stream = new $streamClass;
    }
}