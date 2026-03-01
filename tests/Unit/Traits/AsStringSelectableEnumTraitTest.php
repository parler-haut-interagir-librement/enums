<?php
// tests/Unit/Traits/AsStringSelectableEnumTraitTest.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Tests\Fixtures\StringBackedEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AsStringSelectableEnumTraitTest extends TestCase
{
    #[Test]
    public function stringOptionsWithCustomCallback(): void
    {
        $result = StringBackedEnum::stringOptions(
            static fn (string $name, mixed $value): string => "{$name}:{$value}",
            ', ',
        );

        self::assertSame('DRAFT:draft, PUBLISHED:published, ARCHIVED:archived', $result);
    }

    #[Test]
    public function stringOptionsDefaultCallbackGeneratesHtmlOptions(): void
    {
        $result = StringBackedEnum::stringOptions();

        self::assertStringContainsString('<option value="draft">Draft</option>', $result);
        self::assertStringContainsString('<option value="published">Published</option>', $result);
    }
}
