<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;
use ReflectionEnum;

trait AsValuableEnumTrait
{
    /**
     * Get an array of case values.
     *
     * @return list<string|int>
     */
    public static function values(): array
    {
        $cases = static::cases();

        /** @var list<string|int> */
        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value')
            : array_column($cases, 'name');
    }
}
