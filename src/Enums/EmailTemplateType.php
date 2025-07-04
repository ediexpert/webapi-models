<?php

namespace EdiExpert\WebapiModels\Enums;

class EmailTemplateType
{
    public const NA = 0;
    public const TicketsAsAttachment = 1;
    public const TicketAsDownloadLink = 2;
    public const PaymentLink = 3;
    public const ThankYou = 40;
    public const ReviewRequest = 41;
    public const InformationRequired = 51;
    public const Delay = 52;
    public const Newsletter = 100;
    public const Promotion = 101;

    public static function labels(): array
    {
        return [
            self::NA => 'Not Applicable',
            self::TicketsAsAttachment => 'Tickets As Attachment',
            self::TicketAsDownloadLink => 'Ticket As Download Link',
            self::PaymentLink => 'Payment Link',
            self::ThankYou => 'Thank You',
            self::ReviewRequest => 'Review Request',
            self::InformationRequired => 'Information Required',
            self::Delay => 'Delay',
            self::Newsletter => 'Newsletter',
            self::Promotion => 'Promotion',
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
