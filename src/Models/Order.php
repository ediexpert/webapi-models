<?php

namespace EdiExpert\WebapiModels\Models;

use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Events\OrderCompleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Auditable;


/**
 * @property int Id
 * @property string ShopOrderNumber
 */
class Order extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $connection = 'ticketsender';
    protected $table = 'Orders';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ShopOrderNumber',
        'status',
        'PaymentStatus',
        'CustomerName',
        'CustomerEmail'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'OrderId', 'Id');
    }

    public function getRouteKeyName()
    {
        return 'Id'; // Replace 'id' with your route key name if different
    }

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
    protected $enums = [
        'Status' => [
            0 => 'New',
            1 => 'PartiallyCompleted',
            2 => 'Completed',
            3 => 'Cancelled'
        ],
        'PaymentStatus' => [
            0 => 'Unpaid',
            1 => 'PartiallyPaid',
            2 => 'Paid',
            3 => 'Refunded'
        ],
    ];

    public function externalConnection()
    {
        return $this->belongsTo(ExternalConnection::class, 'external_connection_id', 'id');
    }

    protected $attributes = [
        'Status' => 0,
        'PaymentStatus' => 0,
        'ShopSystem' => 0 // in next version this will be obsolete as we will use external_connection
    ];

    //Casts of the model dates
    protected $casts = [
        'OrderDateTime' => 'date'
    ];


    public function communications(): MorphMany
    {
        return $this->morphMany(Communication::class, 'communicable');
    }

    public function addCommunication($action, $description)
    {
        $comm = new Communication();
        $comm->action = $action;
        $comm->description = $description;

        $this->communications()->save($comm);
    }

    public function getNames()
    {
        // Trim any leading or trailing whitespace from the full name
        $fullName = trim($this->CustomerName);

        // Explode the full name into parts using space as the delimiter
        $nameParts = explode(' ', $fullName);

        // Check the number of parts after splitting
        if (count($nameParts) > 1) {
            // More than one part found, so we have both first and last names
            $firstName = $nameParts[0];
            $lastName = $nameParts[count($nameParts) - 1];
        } else {
            // Only one part found, use it as both first and last name
            $firstName = $lastName = $nameParts[0];
        }

        return [
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
    }

    public function checkAndMarkAsCompleted()
    {
        // Ensure we load the relationship if not already loaded
        $this->loadMissing('orderItems');

        $items = $this->orderItems;

        if ($items->isEmpty()) {
            return; // No items = nothing to update
        }

        $allProcessed = $items->every(function ($item) {
            return $item->OrderItemStatus === OrderItemStatus::PROCESSED;
        });

        $allCancelled = $items->every(function ($item) {
            return $item->OrderItemStatus === OrderItemStatus::CANCELLED;
        });

        if ($allProcessed && $this->Status !== OrderStatus::Completed) {
            $this->markOrderAsCompleted();
        } elseif ($allCancelled && $this->Status !== OrderStatus::Cancelled) {
            $this->markOrderAsCancelled();
        }
    }

    public function markOrderAsCompleted()
    {
        $this->Status = OrderStatus::Completed;
        $this->save();

        // Optional: fire event, log, notify etc.
        event(new OrderCompleted($this));
    }

    public function markOrderAsCancelled(): void
    {
        $this->Status = OrderStatus::Cancelled;
        $this->save();
    }

    public function markAsPaid(): void
    {
        $this->PaymentStatus = PaymentStatus::Paid; // Assuming 2 is the status for 'Paid'
        $this->save();
    }
}
