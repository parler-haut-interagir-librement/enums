<?php

declare(strict_types=1);

namespace Phil\Enums\Meta;

/**
 * @template TValue
 */
abstract class AbstractMetaProperty
{
    /**
     * @param TValue $value
     */
    final public function __construct(
        public mixed $value,
    ) {
        $this->value = $this->transform($value);
    }

    /**
     * Value used when a case does not carry this meta property.
     *
     * Narrow the return type in a child class (`string`, `int`, ...) so the
     * generated accessor is not nullable.
     *
     * @return TValue|null
     */
    public static function defaultValue(): mixed
    {
        return null;
    }

    /**
     * @abstract
     *
     * @param TValue $value
     */
    public function make(mixed $value): static
    {
        return new static($value); // @phpstan-ignore return.type
    }

    /**
     * @param TValue $value
     *
     * @return TValue
     */
    protected function transform(mixed $value): mixed
    {
        // Feel free to override this to transform the value during instantiation

        return $value;
    }

    /**
     * Override this in a child class to explicitly define
     * the accessor method name (otherwise, it falls back to the class name).
     */
    protected static function customMethodName(): ?string
    {
        return null;
    }

    /** Get the name of the accessor method */
    public static function method(): string
    {
        $custom = static::customMethodName();

        if (null !== $custom && '' !== $custom) {
            return $custom;
        }

        $parts = explode('\\', static::class); // @phpstan-ignore symplify.forbiddenStaticClassConstFetch

        return lcfirst(end($parts));
    }
}
