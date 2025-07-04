<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CredentialType;

/**
 * Class Credential
 *
 * @property int $Id
 * @property bool $Active
 * @property CredentialType $CredentialType
 * @property string $BaseUrl
 * @property string $Username
 * @property string $Password
 * @property string|null $Comment
 * @property string $Name
 */
class Credential extends Model
{
    use HasFactory;

    protected $connection = 'ticketsender';
    protected $table = 'Credentials';
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

    /**
     * The attributes that are enum.
     *
     * @var array
     */
    // protected $enums = [
    //     'CredentialType' => [
    //         0 => 'Ecwid',
    //         1 => 'Bokun',
    //         3 => 'Rayna',
    //         4 => 'Stripe',
    //         5 => 'Razorpay',
    //         6 => 'Twilio',
    //         7 => 'CurrencyConverter'
    //     ],
    // ];

    // protected $casts = [
    //     'CredentialType' => CredentialType::class,
    // ];
}
