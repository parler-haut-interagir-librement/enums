<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;
use ReflectionEnum;

trait AsSelfAwareableEnumTrait
{
    /**
     * Determine whether the enum is pure.
     */
    public static function isPure(): bool
    {
        return !self::isBacked();
    }

    /**
     * Determine whether the enum is backed.
     */
    public static function isBacked(): bool
    {
        /** @phpstan-ignore function.impossibleType */
        return is_subclass_of(self::class, BackedEnum::class);
    }

    /**
     * Determine whether the enum is backed by integer.
     */
    public static function isBackedByInteger(): bool
    {
        return 'int' === (string) (new ReflectionEnum(self::class))->getBackingType();
    }

    /**
     * Determine whether the enum is backed by string.
     */
    public static function isBackedByString(): bool
    {
        return 'string' === (string) (new ReflectionEnum(self::class))->getBackingType();
    }
}
