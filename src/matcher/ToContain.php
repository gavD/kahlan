<?php
namespace kahlan\matcher;

class ToContain
{
    /**
     * Expect that `$actual` contain the `$expected` value.
     *
     * @param  collection $actual The actual value.
     * @param  mixed      $expected The expected value.
     * @return boolean
     */
    public static function match($actual, $expected)
    {
        foreach ($actual as $key => $value) {
            if ($value === $expected) {
                return true;
            }
        }
        return false;
    }

    public static function description()
    {
        return "contain expected.";
    }
}
