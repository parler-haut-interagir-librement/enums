<?php

declare(strict_types=1);

namespace Phil\Enums\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
final class Label extends AbstractMetaProperty
{
}
