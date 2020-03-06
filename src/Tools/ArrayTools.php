<?php


namespace ChenJiaJing\WeWork\Tools;

use ArrayAccess;

class ArrayTools implements ArrayAccess
{
    private $config = [];

    public function __construct($options)
    {
        $this->config = $options;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

}
