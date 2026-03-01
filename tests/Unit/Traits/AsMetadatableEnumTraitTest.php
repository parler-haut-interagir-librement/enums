<?php

declare(strict_types=1);

namespace Phil\Enums\Tests\Unit\Traits;

use Phil\Enums\Attribute\Description;
use Phil\Enums\Attribute\Label;
use Phil\Enums\Tests\Fixtures\MetaEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ValueError;

/**
 * @internal
 */
final class AsMetadatableEnumTraitTest extends TestCase
{
    #[Test]
    public function metaPropertyIsAccessibleViaMagicCall(): void
    {
        self::assertSame('Incomplete task', MetaEnum::INCOMPLETE->description());
        self::assertSame('Completed', MetaEnum::COMPLETED->label());
    }

    #[Test]
    public function colorMetaPropertyAppliesTransform(): void
    {
        self::assertSame('text-red-500', MetaEnum::INCOMPLETE->color());
        self::assertSame('text-green-500', MetaEnum::COMPLETED->color());
    }

    #[Test]
    public function caseWithoutAttributeReturnsDefaultValue(): void
    {
        // Description and Label default to null, Color default to null
        self::assertNull(MetaEnum::CANCELED->description());
        self::assertNull(MetaEnum::CANCELED->label());
        self::assertNull(MetaEnum::CANCELED->color());
    }

    #[Test]
    public function tryFromMetaReturnsMatchingCase(): void
    {
        $result = MetaEnum::tryFromMeta(new Description('Completed task'));
        self::assertSame(MetaEnum::COMPLETED, $result);
    }

    #[Test]
    public function tryFromMetaReturnsNullOnNoMatch(): void
    {
        self::assertNull(MetaEnum::tryFromMeta(new Description('Unknown')));
    }

    #[Test]
    public function fromMetaReturnsMatchingCase(): void
    {
        self::assertSame(MetaEnum::INCOMPLETE, MetaEnum::fromMeta(new Label('Incomplete')));
    }

    #[Test]
    public function fromMetaThrowsOnNoMatch(): void
    {
        $this->expectException(ValueError::class);
        MetaEnum::fromMeta(new Label('Unknown'));
    }

    #[Test]
    public function undefinedMetaPropertyReturnsNull(): void
    {
        // Calling a method that doesn't correspond to any registered meta property
        self::assertNull(MetaEnum::INCOMPLETE->nonExistentMeta()); // @phpstan-ignore method.notFound
    }
}
