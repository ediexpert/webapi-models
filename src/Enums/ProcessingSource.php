<?php

namespace EdiExpert\WebapiModels\Enums;

class ProcessingSource
{
    public const FTPAutomation = 0;

    /** @var int Process via API */
    public const ProcessViaAPI = 10;

    /** @var int Process via API with new provider */
    public const ProcessViaAPINew = 11;

    /** @var int Process via API with auto provider */
    public const ProcessAuto = 12;

    public const ProcessPendingOrders = 13;

    /**
     * Get all address type labels.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::FTPAutomation => 'FTP Automation',
            self::ProcessViaAPI => 'Process Via API',
            self::ProcessViaAPINew => 'Process Via API New',
            self::ProcessAuto => 'Process Auto',
        ];
    }

    /**
     * Get the label for a given address type code.
     *
     * @param int $source
     * @return string
     */
    public static function label(int $source): string
    {
        return self::labels()[$source] ?? 'Unknown';
    }
}
