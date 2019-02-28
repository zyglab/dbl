<?php declare(strict_types=1);

namespace Dbl\Types;

use Dbl\Column;

class IntegerType implements Type
{
    /**
     * @param mixed $value
     * @param Column $column
     *
     * @return int
     */
    public static function code($value, Column $column): int
    {
        return (int) $value;
    }

    /**
     * @param mixed $value
     * @param Column $column
     *
     * @return int
     */
    public static function database($value, Column $column): int
    {
        return (int) $value;
    }
}
