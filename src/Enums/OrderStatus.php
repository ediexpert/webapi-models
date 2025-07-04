<?php

namespace EdiExpert\WebapiModels\Enums;


class OrderStatus
{
    public const New = 0;
    public const PartiallyCompleted = 1;
    public const Completed = 2;
    public const Cancelled = 3;

    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::New => 'New',
            self::PartiallyCompleted   => 'PartiallyCompleted',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        ];
    }

    /**
     * Optional convenience method to get label by code.
     */
    public static function label(int $statusCode): string
    {
        return self::labels()[$statusCode] ?? 'Unknown';
    }
}
