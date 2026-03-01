<?php

namespace Phil\Enums\Attribute;

use Attribute;
use Phil\Enums\Meta\AbstractMetaProperty;

#[Attribute(Attribute::TARGET_CLASS)]
class Meta
{
    /** @var list<class-string<AbstractMetaProperty>> */
    public array $metaProperties;

    /**
     * @paran class-string<AbstractMetaProperty> $metaProperties
     */
    public function __construct(string ...$metaProperties)
    {
        /** @var list<class-string<AbstractMetaProperty>> $list */
        $list = array_values($metaProperties);

        $this->metaProperties = $list;
    }
}
