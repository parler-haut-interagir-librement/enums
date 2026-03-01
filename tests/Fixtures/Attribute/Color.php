<?php

declare(strict_types=1);

namespace Phil\Enums\Tests\Fixtures\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

use function assert;
use function is_string;

#[Attribute]
final class Color extends AbstractMetaProperty
{
    protected function transform(mixed $value): mixed
    {
        assert(is_string($value));

        return "text-{$value}-500";
    }
}
