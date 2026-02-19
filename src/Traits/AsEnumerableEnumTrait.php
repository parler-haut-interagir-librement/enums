<?php
declare(strict_types=1);

namespace Phil\Enums\Traits;

trait AsEnumerableEnumTrait
{
    use AsInvocableEnumTrait;
    use AsNameableEnumTrait;
    use AsValuableEnumTrait;
    use AsSelectableEnumTrait;
    use AsComparableEnumTrait;
    use AsFromambleEnumTrait;
    use AsMetadatableEnumTrait;
}
