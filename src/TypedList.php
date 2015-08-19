<?php

namespace Types;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Serializable;
use Traversable;

abstract class TypedList implements IteratorAggregate , ArrayAccess , Serializable , Countable {

    /**
     * @var array
     */
    private $list;


    public function __construct(...$items)
    {
        foreach ($items as $item) {
            if($this->isType($item)) {
                $this->list[] = $item;
            } else {
                throw new InvalidArgumentException("Type mismatch, check constructor arguments");
            }
        }
    }

    /**
     * @param mixed $val
     * @return bool
     */
    protected abstract function isType($val);

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->list);
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
        if ($this->isType($value)) {
            if (is_int($offset)) {
                $this->list[$offset] = $value;
            } else if (is_null($offset)) {
                $this->list[] = $value;
            } else {
                throw new InvalidArgumentException("Invalid offset, this object is a list not a map");
            }
        } else {
            throw new InvalidArgumentException("Invalid type exception, not inserted into list");
        }
    }

    //ALL OTHER ARRAY BEHAVIOR IS THE SAME AS NATIVE ARRAYS, ONLY CONSTRUCTION AND SETTING HAVE CHANGED
    //BELOW THIS POINT ARE ALL THE NATIVE METHODS, NOTHING IMPORTANT.
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
    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
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
    public function offsetGet($offset)
    {
        return $this->list[$offset];
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
    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
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
    public function count()
    {
        return count($this->list);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->list);
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
    public function unserialize($serialized)
    {
        $this->list = unserialize($serialized);
    }

    /**
     * Get the array backing this list
     * @return array
     */
    public function getArray() {
        return $this->list;
    }
}