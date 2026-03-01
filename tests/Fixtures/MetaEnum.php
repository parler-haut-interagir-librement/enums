<?php
// tests/Fixtures/MetaEnum.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Fixtures;

use Phil\Enums\Attribute\Description;
use Phil\Enums\Attribute\Label;
use Phil\Enums\Attribute\Meta;
use Phil\Enums\Tests\Fixtures\Attribute\Color;
use Phil\Enums\Traits\AsMetadatableEnumTrait;

#[Meta(Description::class, Label::class, Color::class)]
enum MetaEnum: int
{
    use AsMetadatableEnumTrait;

    #[Description('Incomplete task')] #[Label('Incomplete')] #[Color('red')]
    case INCOMPLETE = 0;

    #[Description('Completed task')] #[Label('Completed')] #[Color('green')]
    case COMPLETED = 1;

    // Case without attributes — tests defaultValue() fallback
    case CANCELED = 2;
}
