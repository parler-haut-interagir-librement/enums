<?php
// tests/Unit/Traits/AsComparableEnumTraitTest.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Tests\Fixtures\PureEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AsComparableEnumTraitTest extends TestCase
{
    #[Test]
    public function isReturnsTrueForSameCase(): void
    {
        self::assertTrue(PureEnum::ONE->is(PureEnum::ONE));
    }

    #[Test]
    public function isReturnsFalseForDifferentCase(): void
    {
        self::assertFalse(PureEnum::ONE->is(PureEnum::TWO));
    }

    #[Test]
    public function isNotIsInverse(): void
    {
        self::assertTrue(PureEnum::ONE->isNot(PureEnum::TWO));
        self::assertFalse(PureEnum::ONE->isNot(PureEnum::ONE));
    }

    #[Test]
    public function inChecksPresenceInIterable(): void
    {
        self::assertTrue(PureEnum::ONE->in([PureEnum::ONE, PureEnum::TWO]));
        self::assertFalse(PureEnum::THREE->in([PureEnum::ONE, PureEnum::TWO]));
    }

    #[Test]
    public function notInIsInverse(): void
    {
        self::assertTrue(PureEnum::THREE->notIn([PureEnum::ONE, PureEnum::TWO]));
        self::assertFalse(PureEnum::ONE->notIn([PureEnum::ONE]));
    }

    #[Test]
    public function hasChecksIfEnumContainsCase(): void
    {
        self::assertTrue(PureEnum::has(PureEnum::ONE));
        self::assertFalse(PureEnum::has('something-else'));
    }

    #[Test]
    public function doesntHaveIsInverse(): void
    {
        self::assertTrue(PureEnum::doesntHave('nope'));
        self::assertFalse(PureEnum::doesntHave(PureEnum::ONE));
    }

    #[Test]
    public function equalsOneOfMatchesAnyInArray(): void
    {
        self::assertTrue(PureEnum::ONE->equalsOneOf([PureEnum::ONE, PureEnum::TWO]));
        self::assertFalse(PureEnum::THREE->equalsOneOf([PureEnum::ONE, PureEnum::TWO]));
    }

    #[Test]
    public function notEqualsOneOfIsInverse(): void
    {
        self::assertTrue(PureEnum::THREE->notEqualsOneOf([PureEnum::ONE, PureEnum::TWO]));
        self::assertFalse(PureEnum::ONE->notEqualsOneOf([PureEnum::ONE]));
    }
}
