<?php

declare(strict_types=1);

namespace Phil\Enums\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

#[Attribute(Attribute::IS_REPEATABLE)]
final class Group extends AbstractMetaProperty
{
}
