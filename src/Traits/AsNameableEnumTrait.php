<?php
declare(strict_types=1);

namespace Phil\Enums\Traits;

trait AsNameableEnumTrait
{

    /**
     * Get an array of case names.
     *
     * @return list<string>
     */
    public static function names(): array
    {
        /** @var list<string> */
        return array_column(static::cases(), 'name');
    }
}
