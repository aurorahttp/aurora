<?php
/**
 * Http Message - A HTTP Message library that implements the Psr-7 standard
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-message
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Message;

/**
 * Class ParameterStore
 *
 * @package Aurora\Http\Message
 */
class ParameterStore implements \ArrayAccess, \Countable, \Iterator
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * ParameterStore constructor.
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->parameters);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * @param string $name
     * @param bool   $default
     * @return mixed
     */
    public function get($name, $default = false)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->parameters[$name]);
    }

    public function rewind()
    {
        reset($this->parameters);
    }

    public function current()
    {
        return current($this->parameters);
    }

    public function next()
    {
        next($this->parameters);
    }

    public function key()
    {
        return key($this->parameters);
    }

    public function valid()
    {
        return false !== $this->current();
    }


    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}