<?php

namespace EdiExpert\WebapiModels\Enums;

class PaymentStatus
{
    public const Unpaid = 0;
    public const PartiallyPaid = 1;
    public const Paid = 2;
    public const Refunded = 3;

    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::Unpaid => 'Unpaid',
            self::PartiallyPaid   => 'PartiallyPaid',
            self::Paid => 'Paid',
            self::Refunded => 'Refunded',
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
