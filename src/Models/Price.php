<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Price
 *
 * @property int $id
 * @property int $product_id
 * @property string $provider
 * @property string $service_date
 * @property string|null $time_slot
 * @property float|null $adult_price
 * @property float|null $child_price
 * @property string $currency
 * @property array|null $raw_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Product $product
 */
class Price extends Model
{
    use HasFactory;

    /** To use connection */
    protected $connection = 'ticketsender';


    protected $fillable = [
        'product_id',
        'provider',
        'service_date',
        'time_slot',
        'adult_price',
        'child_price',
        'currency',
        'raw_data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'Id');
    }
}
