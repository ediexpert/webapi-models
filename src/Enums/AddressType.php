<?php

namespace EdiExpert\WebapiModels\Enums;

/**
 * AddressType enum for reusable address classifications.
 */
class AddressType
{
    /** @var int Billing address */
    public const Billing = 0;

    /** @var int Pickup address */
    public const Pickup = 1;

    /** @var int Shipping address */
    public const Shipping = 2;

    /** @var int Dropoff address */
    public const Dropoff = 3;

    /**
     * Get all address type labels.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::Billing => 'Billing',
            self::Pickup => 'Pickup',
            self::Shipping => 'Shipping',
            self::Dropoff => 'Dropoff',
        ];
    }

    /**
     * Get the label for a given address type code.
     *
     * @param int $addressType
     * @return string
     */
    public static function label(int $addressType): string
    {
        return self::labels()[$addressType] ?? 'Unknown';
    }
}
