<?php

declare(strict_types=1);

namespace Phil\Enums\Traits;

use Phil\Enums\Meta\AbstractMetaProperty;
use Phil\Enums\Meta\Reflection;
use ValueError;

trait AsMetadatableEnumTrait
{
    /** Try to get the first case with this meta property value. */
    public static function tryFromMeta(AbstractMetaProperty $metaProperty): ?static
    {
        foreach (static::cases() as $case) {
            if (Reflection::metaValue($metaProperty::class, $case) === $metaProperty->value) {
                return $case;
            }
        }

        return null;
    }

    /** Get the first case with this meta property value. */
    public static function fromMeta(AbstractMetaProperty $metaProperty): static
    {
        return static::tryFromMeta($metaProperty) ?? throw new ValueError('Enum ' . static::class . ' does not have a case with a meta property "' . $metaProperty::class . '" of value "' . $metaProperty->value . '"');
    }

    public function __call(string $property, array $arguments): mixed
    {
        $metaProperties = Reflection::metaProperties($this);

        foreach ($metaProperties as $metaProperty) {
            if ($metaProperty::method() === $property) {
                return Reflection::metaValue($metaProperty, $this);
            }
        }

        return null;
    }
}
