<?php

namespace Aurora\Context;

use BadMethodCallException;

class AttributeContext implements ContextInterface
{
    /**
     * @var ContextInterface
     */
    protected $scope;

    /**
     * @return ContextInterface
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return ContextInterface[]
     */
    public function getScopes()
    {
        $parents = [];
        for ($parent = $this; $parent = $parent->getScope();) {
            $parents[] = $parent;
        }

        return $parents;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if ($this->scope) {
            return call_user_func_array([$this->scope, $name], $arguments);
        }
        throw new BadMethodCallException();
    }

    /**
     * @param string $name
     * @return mixed
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif ($this->scope) {
            return $this->scope->$name;
        } elseif (method_exists($this, 'set' . $name)) {
            throw new ProtectedPropertyException('Getting write-only property: ' . get_class($this) . '::' . $name);
        }
        throw new UnknownPropertyException("Invalid context attribute: $name");
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @throws UnknownPropertyException
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif ($this->scope) {
            $this->scope->$name = $value;
        } elseif (method_exists($this, 'get' . $name)) {
            throw new ProtectedPropertyException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } elseif ($this->scope) {
            return isset($this->scope->$name);
        }

        return false;
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif ($this->scope) {
            unset($this->scope->$name);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new ProtectedPropertyException('Unset read-only property: ' . get_class($this) . '::' .
                $name);
        }
    }
}