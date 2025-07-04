<?php

namespace EdiExpert\WebapiModels\Enums;


class Suppliers
{
    public const Rathin = 0;
    public const Rayna = 1;

    /**
     * Return an array mapping each status code to its label.
     */
    public static function labels(): array
    {
        return [
            self::Rathin => 'Rathin',
            self::Rayna   => 'Rayna',
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
