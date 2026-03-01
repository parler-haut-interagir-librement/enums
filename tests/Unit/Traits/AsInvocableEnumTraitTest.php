<?php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Exceptions\UndefinedCaseError;
use Phil\Enums\Tests\Fixtures\IntBackedEnum;
use Phil\Enums\Tests\Fixtures\PureEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AsInvocableEnumTraitTest extends TestCase
{
    #[Test]
    public function staticCallReturnsValueForBackedEnum(): void
    {
        self::assertSame(1, IntBackedEnum::ONE());
        self::assertSame(3, IntBackedEnum::THREE());
    }

    #[Test]
    public function staticCallReturnsNameForPureEnum(): void
    {
        self::assertSame('ONE', PureEnum::ONE());
        self::assertSame('THREE', PureEnum::THREE());
    }

    #[Test]
    public function invokeInstanceReturnsValueForBackedEnum(): void
    {
        $case = IntBackedEnum::TWO;
        self::assertSame(2, $case());
    }

    #[Test]
    public function invokeInstanceReturnsNameForPureEnum(): void
    {
        $case = PureEnum::TWO;
        self::assertSame('TWO', $case());
    }

    #[Test]
    public function staticCallOnUndefinedCaseThrowsError(): void
    {
        $this->expectException(UndefinedCaseError::class);
        $this->expectExceptionMessageMatches('/NOPE/');

        /** @phpstan-ignore staticMethod.notFound */
        IntBackedEnum::NOPE();
    }
}
