<?php

declare(strict_types=1);

namespace Phil\Enums\Meta;

use Phil\Enums\Attribute\Meta;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionEnumUnitCase;
use ReflectionObject;
use UnitEnum;

class Reflection
{
    /**
     * Get the meta properties enabled on an Enum.
     *
     * @param \Phil\Enums\Traits\AsMetadatableEnumTrait $enum
     *
     * @return list<class-string<AbstractMetaProperty>>
     *
     * @phpstan-ignore parameter.trait
     */
    public static function metaProperties(mixed $enum): array
    {
        $reflection = new ReflectionObject($enum);
        $metaProperties = static::parseMetaProperties($reflection);

        // Traits except the `Metadata` trait
        $traits = array_values(array_filter($reflection->getTraits(), static fn (ReflectionClass $class) => 'ArchTech\Enums\Metadata' !== $class->getName()));

        /** @var list<list<class-string<AbstractMetaProperty>>> $traitsMeta */
        $traitsMeta = array_map(
            static fn (ReflectionClass $trait) => static::parseMetaProperties($trait),
            $traits
        );

        return array_merge($metaProperties, ...$traitsMeta);
    }

    /**
     * @param ReflectionClass<object> $reflection
     *
     * @return list<class-string<AbstractMetaProperty>>
     */
    protected static function parseMetaProperties(ReflectionClass $reflection): array
    {
        // Only the `Meta` attribute
        $attributes = $reflection->getAttributes(Meta::class);

        if ([] !== $attributes) {
            /** @var Meta $meta */
            $meta = $attributes[0]->newInstance();

            return $meta->metaProperties;
        }

        return [];
    }

    /**
     * Get the value of a meta property on the provided enum.
     *
     * @param class-string<AbstractMetaProperty> $metaProperty
     */
    public static function metaValue(string $metaProperty, UnitEnum $enum): mixed
    {
        // Find the case used by $enum
        $reflection = new ReflectionEnumUnitCase($enum::class, $enum->name);
        $attributes = $reflection->getAttributes();

        // Instantiate each ReflectionAttribute
        /** @var list<AbstractMetaProperty> $properties */
        $properties = array_map(static fn (ReflectionAttribute $attr) => $attr->newInstance(), $attributes);

        // Find the property that matches the $metaProperty class
        $properties = array_filter($properties, static fn (AbstractMetaProperty $property) => $property::class === $metaProperty);

        // Reset array index
        $properties = array_values($properties);

        if ([] !== $properties) {
            return $properties[0]->value;
        }

        return $metaProperty::defaultValue();
    }
}
