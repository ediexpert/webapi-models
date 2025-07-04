<?php

namespace EdiExpert\WebapiModels\Enums;


class RaynaTransferType
{
    public const WithoutTransfer = 41865;
    public const SharingTransfer = 41843;
    public const PrivateTransfer = 41844;
    public const PrivateBoatWithoutTransfers = 43129;
    public const PvtYachWithoutTransfer = 43110;


    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::WithoutTransfer => 'WithoutTransfer',
            self::SharingTransfer   => 'SharingTransfer',
            self::PrivateTransfer => 'PrivateTransfer',
            self::PrivateBoatWithoutTransfers => 'PrivateBoatWithoutTransfers',
            self::PvtYachWithoutTransfer => 'PvtYachWithoutTransfer',
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
