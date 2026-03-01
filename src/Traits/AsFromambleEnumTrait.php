<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use ValueError;

trait AsFromambleEnumTrait
{
    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `from()` method on BackedEnums
     *
     * @throws ValueError
     */
    public static function from(int|string $case): static
    {
        return static::fromName((string) $case);
    }

    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `tryFrom()` method on BackedEnums
     */
    public static function tryFrom(int|string $case): ?static
    {
        return static::tryFromName((string) $case);
    }

    /**
     * Gets the Enum by name.
     *
     * @throws ValueError
     */
    public static function fromName(string $case): static
    {
        $enumClass = static::class; // @phpstan-ignore symplify.forbiddenStaticClassConstFetch

        return static::tryFromName($case) ?? throw new ValueError('"' . $case . '" is not a valid name for enum ' . $enumClass);
    }

    /**
     * Gets the Enum by name, if it exists.
     */
    public static function tryFromName(string $case): ?static
    {
        $cases = array_filter(
            static::cases(),
            static fn ($c): bool => $c->name === $case
        );

        return array_values($cases)[0] ?? null;
    }
}
