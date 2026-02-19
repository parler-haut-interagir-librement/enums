<?php

declare(strict_types=1);

namespace Phil\Enums\Attribute;

use Phil\Enums\Meta\AbstractMetaProperty;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE)]
class Group extends AbstractMetaProperty
{
}
