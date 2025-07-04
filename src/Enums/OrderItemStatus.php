<?php

namespace EdiExpert\WebapiModels\Enums;

class OrderItemStatus
{
    // Define statuses as constants
    public const UNDEFINED = 0;
    public const PENDING   = 1; // order is not processed
    public const PROCESSED = 2; // tickets or vouchers has been sent to the customer
    public const CANCELLED = 3; // order item has been cancelled
    public const VOUCHERED = 4; // tikcets are vouchered via API, but not sent to customer yet

    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::UNDEFINED => 'UNDEFINED',
            self::PENDING   => 'Pending',
            self::PROCESSED => 'Processed',
            self::CANCELLED => 'Cancelled',
            self::VOUCHERED => 'Vouchered',
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
