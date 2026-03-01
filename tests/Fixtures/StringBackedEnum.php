<?php
// tests/Fixtures/StringBackedEnum.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Fixtures;

use Phil\Enums\Traits\AsInvocableEnumTrait;
use Phil\Enums\Traits\AsSelectableEnumTrait;
use Phil\Enums\Traits\AsSelfAwareableEnumTrait;
use Phil\Enums\Traits\AsStringSelectableEnumTrait;

enum StringBackedEnum: string
{
    use AsInvocableEnumTrait;
    use AsStringSelectableEnumTrait;
    use AsSelfAwareableEnumTrait;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
