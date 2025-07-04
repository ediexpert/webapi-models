<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderProcessingTask
 *
 * Represents a task for processing an order in the system.
 *
 * @property int $id The unique identifier for the task.
 * @property int $order_item_id The ID of the order item associated with this task.
 * @property int $status The status of the task (0: pending, 10: processing, 30: completed, 20: failed).
 * @property string|null $protocol Additional protocol information related to the task.
 */
class OrderProcessingTask extends Model
{
    use HasFactory;

    protected $connection = 'ticketsender';

    protected $casts = [
        'id' => 'integer',
        'order_item_id' => 'integer',
        'status' => 'integer',
        'protocol' => 'string',
    ];

    protected $fillable = [
        'order_item_id',
        'status',
        'protocol',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'Id');
    }
}
