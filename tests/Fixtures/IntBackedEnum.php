<?php
// tests/Fixtures/IntBackedEnum.php

declare(strict_types=1);

namespace Phil\Enums\Tests\Fixtures;

use Phil\Enums\Traits\AsComparableEnumTrait;
use Phil\Enums\Traits\AsFromambleEnumTrait;
use Phil\Enums\Traits\AsInvocableEnumTrait;
use Phil\Enums\Traits\AsNameableEnumTrait;
use Phil\Enums\Traits\AsSelectableEnumTrait;
use Phil\Enums\Traits\AsSelfAwareableEnumTrait;
use Phil\Enums\Traits\AsValuableEnumTrait;

enum IntBackedEnum: int
{
    use AsInvocableEnumTrait;
    use AsNameableEnumTrait;
    use AsValuableEnumTrait;
    use AsSelectableEnumTrait;
    use AsComparableEnumTrait;
    use AsFromambleEnumTrait;
    use AsSelfAwareableEnumTrait;

    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
}
