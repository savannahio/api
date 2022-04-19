<?php

declare(strict_types=1);

namespace App\Support\Traits;

trait HasEnumCases
{
    /** @return array<string> */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /** @return array */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /** @return array<mixed, string> */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
