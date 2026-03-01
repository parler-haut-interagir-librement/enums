<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;
use Closure;
use UnitEnum;

trait AsStringSelectableEnumTrait
{
    use AsSelectableEnumTrait;

    /**
     * Generate a string format of the enum options using the provided callback and glue.
     *
     * @param (Closure(string, string): string)|null $callback
     * @param string                                 $glue
     *
     * @return string
     */
    public static function stringOptions(?Closure $callback = null, string $glue = '\n'): string
    {
        $cases = static::cases();

        if ($cases === []) {
            return '';
        }

        $options = array_column($cases, 'value', 'name');

        // Default callback
        $callback ??= static function (string $name, string $value): string {
            if (str_contains($name, '_')) {
                // Snake case
                $words = explode('_', $name);
            } elseif (mb_strtoupper($name) === $name) {
                // If the entire name is uppercase without underscores, it's a single word
                $words = [$name];
            } else {
                // Pascal case or camel case
                $split = preg_split('/(?=[A-Z])/', $name);

                /** @var list<non-empty-string> $words */
                $words = array_filter(
                    $split !== false ? $split : [],
                    static fn (string $word): bool => $word !== '',
                );
            }

            return '<option value="' . $value . '">' . ucfirst(mb_strtolower(implode(' ', $words))) . '</option>';
        };

        /** @var list<string> $result */
        $result = array_map($callback, array_keys($options), array_values($options));

        return implode($glue, $result);
    }
}
