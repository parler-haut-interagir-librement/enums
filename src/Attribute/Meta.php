<?php

namespace Phil\Enums\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

#[Attribute(Attribute::TARGET_CLASS)]
class Meta
{
    /** @var string[]|class-string<AbstractMetaProperty>[] */
    public array $metaProperties;

    /**
     * @paran class-string<AbstractMetaProperty> $metaProperties
     */
    public function __construct(string ...$metaProperties)
    {
        $this->metaProperties = $metaProperties;
    }
}
