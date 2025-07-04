<?php

namespace EdiExpert\WebapiModels\Enums;

class CredentialType
{
    public const Ecwid = 0;
    public const Bokun = 1;
    public const Rayna = 3;
    public const Stripe = 4;
    public const Razorpay = 5;
    public const Twilio = 6;
    public const CurrencyConverter = 7;
    public const Woo = 8;
    public const DPR = 9;
    public const Rathin = 10;
    public const Klook = 11;
    public const OpenAI = 100; // to give some space for other API implementations

    public static function labels(): array
    {
        return [
            self::Ecwid => 'Ecwid',
            self::Bokun => 'Bokun',
            self::Rayna => 'Rayna',
            self::Stripe => 'Stripe',
            self::Razorpay => 'Razorpay',
            self::Twilio => 'Twilio',
            self::CurrencyConverter => 'CurrencyConverter',
            self::Woo => 'Woo',
            self::Rathin => 'Rathin',
            self::DPR => 'DPR',
            self::Klook => 'Klook',
            self::OpenAI => 'OpenAI',
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
