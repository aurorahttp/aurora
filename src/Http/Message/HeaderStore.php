<?php
/**
 * Http Message - A HTTP Message library that implements the Psr-7 standard
 *
 * @author  panlatent@gmail.com
 * @link    https://github.com/panlatent/http-message
 * @license https://opensource.org/licenses/MIT
 */

namespace Aurora\Http\Message;

class HeaderStore extends ParameterStore
{
    /**
     * HeaderStore constructor.
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        foreach (array_keys($parameters) as $key) {
            $name = $this->prepareName($key);
            if ($name != $key) {
                $parameters[$name] = $parameters[$key];
                unset($parameters[$key]);
            }
        }

        parent::__construct($parameters);
    }

    /**
     * @param string $name
     * @param bool   $default
     * @return string[]
     */
    public function get($name, $default = false)
    {
        return parent::get($this->prepareName($name), $default);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getLine($name)
    {
        if (false === ($values = $this->get($name))) {
            return '';
        }

        return implode(', ', $values);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getRawLine($name)
    {
        $name = $this->prepareName($name);
        if ('' === ($line = $this->getLine($name))) {
            return $name . ': ';
        }

        return $name . ': ' . $line;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return parent::has($this->prepareName($name));
    }

    /**
     * @param string   $name
     * @param string[] $values
     */
    public function set($name, $values)
    {
        parent::set($this->prepareName($name), $values);
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        parent::remove($this->prepareName($name));
    }

    /**
     * Standard header name format.
     *
     * @param string $name
     * @return string
     */
    private function prepareName($name)
    {
        $name = strtolower($name);
        $name = ucwords(str_replace('-', ' ', $name));

        return str_replace(' ', '-', $name);
    }
}