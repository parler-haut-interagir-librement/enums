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
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

use function count;

class ReflectionExtension implements MethodsClassReflectionExtension
{
    public function __construct(
        private readonly ReflectionProvider $reflectionProvider,
    ) {
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return null !== $this->metaPropertyFor($classReflection, $methodName);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $metaProperty = $this->metaPropertyFor($classReflection, $methodName);

        return new MetadatableMethodReflection(
            $classReflection,
            $methodName,
            null === $metaProperty ? new MixedType() : $this->valueType($classReflection, $metaProperty),
        );
    }

    /**
     * The meta property class whose accessor is named $methodName, if any.
     *
     * @return class-string<AbstractMetaProperty<*>>|null
     */
    private function metaPropertyFor(ClassReflection $classReflection, string $methodName): ?string
    {
        $nativeReflection = $classReflection->getNativeReflection();

        if (!$nativeReflection instanceof ReflectionEnum) {
            return null;
        }

        if (!$classReflection->hasTraitUse(AsMetadatableEnumTrait::class)) {
            return null;
        }

        $metaAttributes = $nativeReflection->getAttributes(Meta::class);

        if ([] === $metaAttributes) {
            return null;
        }

        /** @var Meta $meta */
        $meta = $metaAttributes[0]->newInstance();

        foreach ($meta->metaProperties as $metaPropertyClass) {
            if ($metaPropertyClass::method() === $methodName) {
                return $metaPropertyClass;
            }
        }

        return null;
    }

    /**
     * Resolve what the accessor hands back: the meta property's `TValue`, unioned
     * with whatever `defaultValue()` returns -- but only when some case can
     * actually reach the default. An enum that attributes every one of its cases
     * never falls back, so its accessor keeps the bare `TValue`.
     *
     * @param class-string<AbstractMetaProperty<*>> $metaPropertyClass
     */
    private function valueType(ClassReflection $classReflection, string $metaPropertyClass): Type
    {
        if (!$this->reflectionProvider->hasClass($metaPropertyClass)) {
            return new MixedType();
        }

        $metaClass = $this->reflectionProvider->getClass($metaPropertyClass);
        $ancestor = $metaClass->getAncestorWithClassName(AbstractMetaProperty::class);

        $valueType = $ancestor?->getActiveTemplateTypeMap()->getType('TValue') ?? new MixedType();

        if ($this->everyCaseCarries($classReflection, $metaPropertyClass)) {
            return $valueType;
        }

        if (!$metaClass->hasNativeMethod('defaultValue')) {
            return $valueType;
        }

        $variants = $metaClass->getNativeMethod('defaultValue')->getVariants();

        if (1 !== count($variants)) {
            return $valueType;
        }

        return TypeCombinator::union($valueType, $variants[0]->getReturnType());
    }

    /**
     * Whether every case of the enum carries $metaPropertyClass, making
     * `defaultValue()` unreachable for it.
     *
     * @param class-string<AbstractMetaProperty<*>> $metaPropertyClass
     */
    private function everyCaseCarries(ClassReflection $classReflection, string $metaPropertyClass): bool
    {
        $nativeReflection = $classReflection->getNativeReflection();

        if (!$nativeReflection instanceof ReflectionEnum) {
            return false;
        }

        $cases = $nativeReflection->getCases();

        if ([] === $cases) {
            return false;
        }

        foreach ($cases as $case) {
            if ([] === $case->getAttributes($metaPropertyClass)) {
                return false;
            }
        }

        return true;
    }
}
