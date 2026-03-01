<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;

trait AsSelectableEnumTrait
{
    /**
     * Get an associative array of [case name => case value] or an indexed array [case name, case name] in the case of pure enums.
     *
     * @return array<string, string|int>|list<string>
     */
    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }
}
