<?php
// tests/Unit/Traits/AsSelfAwareableEnumTraitTest.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Tests\Fixtures\IntBackedEnum;
use Phil\Enums\Tests\Fixtures\PureEnum;
use Phil\Enums\Tests\Fixtures\StringBackedEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AsSelfAwareableEnumTraitTest extends TestCase
{
    #[Test]
    public function pureEnumIsPure(): void
    {
        self::assertTrue(PureEnum::isPure());
        self::assertFalse(PureEnum::isBacked());
    }

    #[Test]
    public function intBackedEnumIsBacked(): void
    {
        self::assertTrue(IntBackedEnum::isBacked());
        self::assertFalse(IntBackedEnum::isPure());
    }

    #[Test]
    public function intBackedEnumIsBackedByInteger(): void
    {
        self::assertTrue(IntBackedEnum::isBackedByInteger());
        self::assertFalse(IntBackedEnum::isBackedByString());
    }

    #[Test]
    public function stringBackedEnumIsBackedByString(): void
    {
        self::assertTrue(StringBackedEnum::isBackedByString());
        self::assertFalse(StringBackedEnum::isBackedByInteger());
    }
}
