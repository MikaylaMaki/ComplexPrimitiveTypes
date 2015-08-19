<?php

/**
 * Created by IntelliJ IDEA.
 * User: trentonmaki
 * Date: 8/19/15
 * Time: 12:25 PM
 */
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