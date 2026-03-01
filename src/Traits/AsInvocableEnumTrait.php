<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use BackedEnum;
use Phil\Enums\Exceptions\UndefinedCaseError;

trait AsInvocableEnumTrait
{
    /** Return the enum's value when it's $invoked(). */
    public function __invoke(): string|int
    {
        return $this instanceof BackedEnum ? $this->value : $this->name;
    }

    /**
     * Return the enum's value or name when it's called ::STATICALLY().
     *
     * @param array<int, mixed> $args
     */
    public static function __callStatic(string $name, array $args): string|int
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case instanceof BackedEnum ? $case->value : $case->name; // @phpstan-ignore rector.noInstanceOfStaticReflection
            }
        }

        throw new UndefinedCaseError(static::class, $name);
    }
}
