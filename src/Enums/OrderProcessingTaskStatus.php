<?php



namespace EdiExpert\WebapiModels\Enums;

enum OrderProcessingTaskStatus
{
    public const PENDING = 0;
    public const PROCESSING = 10;
    public const FAILED = 20;
    public const COMPLETED = 100;

    public static function labels(): array
    {
        return [
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::FAILED => 'Failed',
            self::COMPLETED => 'Completed',
        ];
    }

    public static function label(int $statusCode): string
    {
        return self::labels()[$statusCode] ?? 'Unknown';
    }
}
