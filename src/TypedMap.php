<?php

namespace Types;
use IteratorAggregate;
use ArrayAccess;
use Serializable;
use Countable;
use InvalidArgumentException;
use ArrayIterator;
use Traversable;

/**
 * Created by IntelliJ IDEA.
 * User: trentonmaki
 * Date: 8/19/15
 * Time: 12:04 PM
 */
abstract class TypedMap implements IteratorAggregate, ArrayAccess, Serializable, Countable
{

    private $map;

    /**
     * @param mixed $key
     * @return boolean
     */
    protected abstract function keyType($key);

    /**
     * @param mixed $value
     * @return boolean
     */
    protected abstract function valueType($value);

    public function __construct($array)
    {
        foreach ($array as $key => $value) {
            if ($this->keyType($key) && $this->valueType($value)) {
                $this->map[$key] = $value;
            } else {
                throw new InvalidArgumentException("Invalid key or value type passed to constructor");
            }
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->map);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($this->valueType($value) && $this->keyType($offset)) {
            $this->map[$offset] = $value;
        } else {
            throw new InvalidArgumentException("Invalid key or value type, appending to this map is not supported");
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public
    function offsetExists($offset)
    {
        return isset($this->map[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public
    function offsetGet($offset)
    {
        return $this->map[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public
    function offsetUnset($offset)
    {
        unset($this->map[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public
    function count()
    {
        return count($this->map);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public
    function serialize()
    {
        return serialize($this->map);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public
    function unserialize($serialized)
    {
        $this->map = unserialize($serialized);
    }
}