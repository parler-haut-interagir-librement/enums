<?php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Tests\Fixtures\IntBackedEnum;
use Phil\Enums\Tests\Fixtures\PureEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AsNameableEnumTraitTest extends TestCase
{
    #[Test]
    public function namesReturnsCaseNames(): void
    {
        self::assertSame(['ONE', 'TWO', 'THREE'], PureEnum::names());
        self::assertSame(['ONE', 'TWO', 'THREE'], IntBackedEnum::names());
    }
}
