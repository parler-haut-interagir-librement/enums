<?php

namespace Phil\Enums\Meta;

abstract class AbstractMetaProperty
{
    final public function __construct(
        public mixed $value,
    ) {
        $this->value = $this->transform($value);
    }

    public static function defaultValue(): mixed
    {
        return null;
    }

    /**
     * @abstract
     */
    public function make(mixed $value): static
    {
        return new static($value);
    }

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

        if ($custom !== null && $custom !== '') {
            return $custom;
        }

        $parts = explode('\\', static::class); // @phpstan-ignore symplify.forbiddenStaticClassConstFetch

        return lcfirst(end($parts));
    }
}
