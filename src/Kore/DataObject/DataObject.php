<?php

namespace Kore\DataObject;

class DataObject
{
    /**
     * Generic constructor
     *
     * @param array $values
     * @return void
     */
    public function __construct(array $values = array())
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * Throw exception on get on unknown property
     *
     * @param string $name
     * @return void
     */
    public function __get($name)
    {
        throw new \OutOfRangeException("Unknown property \${$name} in " . get_class($this) . ".");
    }

    /**
     * Throw exception on set on unknown property
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        throw new \OutOfRangeException("Unknown property \${$name} in " . get_class($this) . ".");
    }

    /**
     * Throw exception on unset on unknown property
     *
     * @param string $name
     * @return void
     */
    public function __unset($name)
    {
        throw new \OutOfRangeException("Unknown property \${$name} in " . get_class($this) . ".");
    }

    /**
     * Deep clone for structs
     *
     * @return void
     */
    public function __clone()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (is_object($value)) {
                $this->$property = clone $value;
            }

            if (is_array($value)) {
                $this->cloneArray($this->$property);
            }
        }
    }

    /**
     * Clone array
     *
     * @param array $array
     */
    private function cloneArray(array &$array)
    {
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                $array[$key] = clone $value;
            }

            if (is_array($value)) {
                $this->cloneArray($array[$key]);
            }
        }
    }

    /**
     * Restore object from var_export
     *
     * @param array $values
     * @return DataObject
     */
    public static function __set_state(array $values)
    {
        return new static($values);
    }
}
