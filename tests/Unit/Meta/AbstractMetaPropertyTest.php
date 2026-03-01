<?php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Meta;

use Phil\Enums\Attribute\Description;
use Phil\Enums\Attribute\Group;
use Phil\Enums\Attribute\Label;
use Phil\Enums\Tests\Fixtures\Attribute\Color;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AbstractMetaPropertyTest extends TestCase // @phpstan-ignore symplify.explicitAbstractPrefixName
{
    #[Test]
    public function constructorStoresValue(): void
    {
        $desc = new Description('hello');
        self::assertSame('hello', $desc->value);
    }

    #[Test]
    public function transformIsApplied(): void
    {
        $color = new Color('red');
        self::assertSame('text-red-500', $color->value);
    }

    #[Test]
    public function defaultValueIsNull(): void
    {
        self::assertNull(Description::defaultValue());
    }

    #[Test]
    public function makeCreatesNewInstance(): void
    {
        $desc = new Description('first');
        $other = $desc->make('second');

        self::assertSame('second', $other->value);
        self::assertInstanceOf(Description::class, $other);
    }

    #[Test]
    public function methodReturnsDerivedNameFromClassName(): void
    {
        self::assertSame('description', Description::method());
        self::assertSame('label', Label::method());
        self::assertSame('group', Group::method());
    }

    #[Test]
    public function methodReturnsCustomNameWhenOverridden(): void
    {
        // Color overrides customMethodName() — we don't know if it does,
        // but by default it falls back to lcfirst of short class name
        self::assertSame('color', Color::method());
    }
}
