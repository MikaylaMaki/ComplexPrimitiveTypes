<?php

require("vendor/autoload.php");

class IntegerList extends \Types\TypedList {

    /**
     * @param mixed $val
     * @return bool
     */
    protected function isType($val)
    {
        return is_int($val);
    }
}

$integerList = new IntegerList(4,5,6);

var_dump(array_filter($integerList));