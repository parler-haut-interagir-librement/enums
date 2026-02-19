<?php
declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;
use Closure;

trait AsStringSelectableEnumTrait
{
    use AsSelectableEnumTrait;

    /**
     * Generate a string format of the enum options using the provided callback and glue.
     * @param Closure(string $name, mixed $value): string $callback
     */
    public static function stringOptions(?Closure $callback = null, string $glue = '\n'): string
    {
        $firstCase = static::cases()[0] ?? null;

        if ($firstCase === null) {
            return '';
        }

        // [name, name]
        $options = static::options();
        if (! $firstCase instanceof BackedEnum) {
            // [name => name, name => name]
            $options = array_combine($options, $options);
        }

        // Default callback
        $callback ??= function ($name, $value) {
            if (str_contains($name, '_')) {
                // Snake case
                $words = explode('_', $name);
            } elseif (strtoupper($name) === $name) {
                // If the entire name is uppercase without underscores, it's a single word
                $words = [$name];
            } else {
                // Pascal case or camel case
                $words = array_filter(preg_split('/(?=[A-Z])/', $name));
            }

            return "<option value=\"{$value}\">" . ucfirst(strtolower(implode(' ', $words))) . '</option>';
        };

        $options = array_map($callback, array_keys($options), array_values($options));

        return implode($glue, $options);
    }

}
