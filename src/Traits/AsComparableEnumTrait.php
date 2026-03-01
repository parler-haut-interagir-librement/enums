<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

trait AsComparableEnumTrait
{
    /**
     * Determine whether this case matches the given target.
     */
    public function is(mixed $enum): bool
    {
        return $this === $enum;
    }

    /**
     * Determine whether this case does not match the given target.
     */
    public function isNot(mixed $enum): bool
    {
        return !$this->is($enum);
    }

    /**
     * Determine whether this case matches at least one of the given targets.
     *
     * @param iterable<array-key, mixed> $targets
     */
    public function in(iterable $targets): bool
    {
        foreach ($targets as $target) {
            if ($this->is($target)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether this case does not match any of the given targets.
     *
     * @param iterable<array-key, mixed> $targets
     */
    public function notIn(iterable $targets): bool
    {
        return !$this->in($targets);
    }

    /**
     * Determine whether the enum includes the given target.
     */
    public static function has(mixed $target): bool
    {
        foreach (self::cases() as $case) {
            if ($case->is($target)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the enum does not include the given target.
     */
    public static function doesntHave(mixed $target): bool
    {
        return !self::has($target);
    }

    /**
     * @param array<self> $enums
     */
    public function equalsOneOf(array $enums): bool
    {
        foreach ($enums as $value) {
            if ($this->has($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<self> $enums
     */
    public function notEqualsOneOf(array $enums): bool
    {
        return !$this->equalsOneOf($enums);
    }
}
