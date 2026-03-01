<?php
// tests/Fixtures/Color.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Fixtures\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

#[Attribute]
final class Color extends AbstractMetaProperty
{
    protected function transform(mixed $value): mixed
    {
        return "text-{$value}-500";
    }
}
