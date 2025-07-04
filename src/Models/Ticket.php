<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'ticketsender';

    protected $fillable = [
        'order_item_id',
        'booking_reference',
        'service_name',
        'ticket_Type',
        'ticket_number',
        'pax_name',
        'ticket_category',
        'ticket_status',
        'travel_date',
        'expiry_date',
        'adult_quantity',
        'child_quantity',
        'total_pax',
        'time_slot',
        'supplier'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'Id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'travel_date' => 'datetime',
        'expiry_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
