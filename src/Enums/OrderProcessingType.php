<?php

namespace EdiExpert\WebapiModels\Enums;

class OrderProcessingType
{
    // Define statuses as constants
    public const None = 0;
    public const FTP   = 1; // processing using FTP
    public const Rayna = 2; // processing via Rayna API
    public const DPR = 9; // processing via DPR API
    public const Rathin = 10; // processing via Rathin API
    public const Klook = 11; // processing via Klook API

    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::None => 'NONE',
            self::FTP   => 'FTP',
            self::Rayna => 'Rayna',
            self::DPR => 'DPR',
            self::Rathin => 'Rathin',
            self::Klook => 'Klook',
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
