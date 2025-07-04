<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

/**
 * Class Setting
 *
 * @property int $Id
 * @property \Carbon\Carbon|null $CreatedAt
 * @property \Carbon\Carbon|null $UpdatedAt
 * @property bool Active
 * @property string TicketFolder
 * @property string TemplateFolder
 * @property string Comment
 * @property bool EnableNotifications
 * @property bool EnableWooStatus
 * @property string NotificationKey
 * @property bool EnableAutoProcessingViaAPI
 * @property integer AutoProcessingDaysThreshold
 *
 */
class Setting extends Model
{
    use HasFactory;

    protected $connection = 'ticketsender';
    protected $table = 'Settings';
    protected $primaryKey = 'Id';
    public $timestamps = true;


    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'CreatedAt'; // Replace with your uppercase column name

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'UpdatedAt'; // Replace with your uppercase column name

    public static function isAutoProcessingEnabled(): bool
    {
        return (bool) self::query()->value('EnableAutoProcessingViaAPI') ?? false;
    }

    public static function getAutoProcessingDaysThreshold(): int
    {
        return (int) self::query()->value('AutoProcessingDaysThreshold') ?? 0;
    }

    public static function isWooStatusEnabled(): bool
    {
        return (bool) self::query()->value('EnableWooStatus') ?? false;
    }
}
