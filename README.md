# ComplexPrimitiveTypes
Complex list and map types for PHP

# API

The TypedMap and TypedList API support almost the same interface as an Array (see (ArrayObject)[http://php.net/manual/en/class.arrayobject.php] for an example of this)
    the differences are in the key values these two types allow and the icompatability with the array_* functions

# Usage
Simple subclass `TypedList` or `TypedMap` for each kind of list or map you want, then write the `isType()` or `keyType()` and `valueType()` methods.

Example:


  class StringList extends TypedList
    {

      /**
       * @param mixed $val
       * @return bool
       */
      protected function isType($val)
      {
          return is_string($val);
      }
  }

You can now use StringList as you would a normal array. If someone attempts to put a non string in your list, an exception will be thrown immediately.
