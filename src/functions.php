<?php

/**
 * Increment Integer values by 1
 * @return void
 */
function incrementIntegerInArray(&$array) {
    if (!is_array($array))
        throw new InvalidArgumentException('Invalid Array');

    foreach ($array as $key => &$value) {
        if (is_array($value))
            incrementIntegerInArray($value);
        else
            if (is_integer($value))
                $value++;
    }
}

/**
 * Search sorted list of values in haystack for needle.
 * @return boolean
 */
function locate($sortedIntegerArray = array(), $integerValue) {
    if (!is_array($sortedIntegerArray) || empty($sortedIntegerArray))
        throw new InvalidArgumentException('Invalid Array');
 
    if (!is_numeric($integerValue))
        throw new InvalidArgumentException('Invalid Value');

    $count = count($sortedIntegerArray);
    list($left, $right) = array_chunk($sortedIntegerArray, ceil($count/2));
    $mid = end($left);

    if ($mid == $integerValue) {
        return true;
    } elseif ($integerValue < $mid) {
        return locate($left, $integerValue);
    } else {
        if ($count == 2 || $count == 3) 
            if ($integerValue == end($right))
                return true;
            else
                return false;
        else 
            return locate($right, $integerValue);
    } 
}
