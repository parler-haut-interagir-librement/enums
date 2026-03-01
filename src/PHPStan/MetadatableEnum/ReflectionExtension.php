<?php

declare(strict_types=1);

namespace Phil\Enums\PHPStan\MetadatableEnum;

use Phil\Enums\Attribute\Meta;
use Phil\Enums\Meta\AbstractMetaProperty;
use Phil\Enums\Traits\AsMetadatableEnumTrait;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionEnum;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use ReflectionAttribute;

class ReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        $nativeReflection = $classReflection->getNativeReflection();

        if (!$nativeReflection instanceof ReflectionEnum) {
            return false;
        }

        if (!$classReflection->hasTraitUse(AsMetadatableEnumTrait::class)) {
            return false;
        }

        // Check if the method name matches any registered meta property
        $metaAttributes = $nativeReflection->getAttributes(Meta::class);

        if ($metaAttributes === []) {
            return false;
        }

        /** @var Meta $meta */
        $meta = $metaAttributes[0]->newInstance();

        foreach ($meta->metaProperties as $metaPropertyClass) {
            if ($metaPropertyClass::method() === $methodName) {
                return true;
            }
        }

        return false;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new MetadatableMethodReflection($classReflection, $methodName);
    }
}
