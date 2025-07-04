<?php

namespace EdiExpert\WebapiModels\Models;

use App\Enums\AddressType;
use App\Enums\OrderItemStatus;
use App\Events\OrderItemProcessed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property int Id
 * @property string TimeSlot
 * @property decimal Cost
 * @property Order Order
 */
class OrderItem extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $connection = 'ticketsender';
    protected $table = 'OrderItems';
    public $timestamps = true;

    protected $primaryKey = 'Id';

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ServiceDateTime' => 'datetime', // Adjust the column name as needed
        'ProcessDateTime' => 'datetime',
    ];

    protected $attributes = [
        'CheckStatus' => 0,
        'Availibility' => 0,
        'BookingStatus' => 0,
        'DeliveryStatus' => 0,
        'RaynaBookingId' => 0,
        'Children' => 0,
        'IsProcessed' => 0,
        'Cost' => 0
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderId', 'Id');
    }

    public function communications(): MorphMany
    {
        return $this->morphMany(Communication::class, 'communicable');
    }

    public function loggable(): MorphMany
    {
        return $this->morphMany(ApiLog::class, 'loggable');
    }

    // Define a mutator for IsProcessed attribute
    public function setIsProcessedAttribute($value)
    {
        $this->attributes['IsProcessed'] = $value;

        // Automatically update OrderItemStatus based on conditions
        // $this->updateOrderItemStatus();

        // 2) Update the status based on $value
        if ($value) {
            // If true, set status to "Processed"
            $this->attributes['OrderItemStatus'] = OrderItemStatus::PROCESSED;
            // e.g., 2
        }
    }

    // Define a mutator for PostpondDelivery attribute
    public function setPostpondDeliveryAttribute($value)
    {
        $this->attributes['PostpondDelivery'] = $value;

        // Automatically update OrderItemStatus based on conditions
        $this->updateOrderItemStatus();
    }

    // Method to update OrderItemStatus attribute based on conditions
    protected function updateOrderItemStatus()
    {
        if ($this->IsProcessed) {
            $this->OrderItemStatus = OrderItemStatus::PROCESSED;
        } elseif (!$this->IsProcessed && $this->PostpondDelivery) {
            $this->OrderItemStatus = OrderItemStatus::CANCELLED;
        }
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'order_item_id', 'Id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'order_item_id');
    }

    // this will mark the order items status as vouchers, which means tickets are issue via API, but not send. After sending status will be marked as Processed
    public function markAsVouchered()
    {
        $this->OrderItemStatus = OrderItemStatus::VOUCHERED;
        $this->save();
    }

    public function markAsProcessed()
    {
        $this->IsProcessed = true;
        $this->OrderItemStatus = OrderItemStatus::PROCESSED;
        $this->save();

        // fire the orderItemProcessed event
        event(new OrderItemProcessed($this));
    }

    public function markAsCancelled()
    {
        if ($this->IsProcessed)
            return; // cannot cancel a processed order

        $this->PostpondDelivery = true;
        $this->OrderItemStatus = OrderItemStatus::CANCELLED;
        $this->save();
    }

    public function markAsUnprocessed()
    {
        $this->IsProcessed = false;
        $this->OrderItemStatus = OrderItemStatus::PENDING;
        $this->save();
    }

    public function isEligibleForProcessing(): bool
    {
        // payment status is PAID, delivery is not postpod and NOT-Processed
        return $this->PostpondDelivery == false && $this->IsProcessed == false && $this->order->PaymentStatus == 2;
    }

    public function pickupAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('address_type', AddressType::Pickup);
    }

    /**
     * Get the minimum price provider for the given order item.
     *
     * @return ActionResult
     */
    public function getMinPriceProvider(): ActionResult
    {
        $minPrice = $this->product->getMinPrice($this->ServiceDateTime);
        if ($minPrice) {
            // add a communication log for the found provider
            Communication::log(
                $this,
                "GetMinPrice - Success",
                "{$minPrice->provider} providing best rates for service date: {$this->ServiceDateTime}"
            );
            return new ActionResult(
                true,
                "Provider found for service date: {$this->ServiceDateTime}",
                $minPrice->provider
            );
        }

        // log that price not found for the given date
        Communication::log(
            $this,
            "GetMinPrice - Failed",
            "Price not found for service date: {$this->ServiceDateTime}"
        );

        return new ActionResult(
            false,
            "Price not found for service date: {$this->ServiceDateTime}"
        );
    }

    public function orderProcessingTasks()
    {
        return $this->hasMany(OrderProcessingTask::class, 'order_item_id', 'Id');
    }
}
