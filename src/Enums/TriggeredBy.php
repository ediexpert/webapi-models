<?php

namespace EdiExpert\WebapiModels\Enums;

class TriggeredBy
{
    /** @var int User triggered action */
    public const User = 0;

    /** @var int Automation triggered action */
    public const Automation = 100;

    /**
     * Get all trigger source labels.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::User => 'User',
            self::Automation => 'Automation',
        ];
    }

    /**
     * Get the label for a given trigger source code.
     *
     * @param int $source
     * @return string
     */
    public static function label(int $source): string
    {
        return self::labels()[$source] ?? 'Unknown';
    }
}
