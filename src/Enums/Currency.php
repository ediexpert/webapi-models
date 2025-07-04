<?php

namespace EdiExpert\WebapiModels\Enums;

class Currency
{
    const AED = 'AED';
    const SGD = 'SGD';

    public static function getAll(): array
    {
        return [
            self::AED,
            self::SGD,
        ];
    }
}
