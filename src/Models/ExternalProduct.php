<?php

namespace EdiExpert\WebapiModels\Models;

use App\ViewModels\ProductCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class ExternalProduct extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';

    const TRANSFER_TYPE_NO_TRANSFER = 0;
    const TRANSFER_TYPE_SHARING_TRANSFER = 1;
    const TRANSFER_TYPE_PRIVATE_TRANSFER = 2;

    protected $fillable = [
        'external_product_id',
        'name',
        'transfer_type',
        'external_connection_id',
        'link',
        'image_url',
        'starting_price',
        'currency',
        // 'starting_price_text' // removed and replaced with starting_price and currency
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_external_product', 'external_product_id', 'product_id');
    }

    public function externalConnection()
    {
        return $this->belongsTo(ExternalConnection::class);
    }

    public function externalProductAttributes()
    {
        return $this->hasMany(ExternalProductAttribute::class, 'external_product_id', 'id');
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'additional_data' => 'array',
            'starting_price' => 'decimal:2', // Ensure starting_price is cast to decimal
        ];
    }

    // Optionally, you can add a method to get the transfer type label
    public function getTransferTypeLabelAttribute()
    {
        $types = [
            self::TRANSFER_TYPE_NO_TRANSFER => 'NoTransfer',
            self::TRANSFER_TYPE_SHARING_TRANSFER => 'SharingTransfer',
            self::TRANSFER_TYPE_PRIVATE_TRANSFER => 'PrivateTransfer',
        ];

        return $types[$this->transfer_type];
    }

    public function loggable(): MorphMany
    {
        return $this->morphMany(ApiLog::class, 'loggable');
    }
    protected $attributes = [
        'is_active' => true
    ];

    /**
     * Get the promotion product details for a single product.
     *
     * @return ActionResult
     */
    public function getPromotionProduct(): ActionResult
    {
        // Validate required properties
        // Check if required values are present and not empty
        $requiredFields = ['name', 'starting_price', 'image_url', 'link', 'currency'];
        foreach ($requiredFields as $field) {
            if (!isset($this->$field) || ($field !== 'starting_price' && $this->$field === '')) {
                return new ActionResult(false, "Missing required promotion product property: {$field}");
            }
        }

        // Check if starting_price is a valid number and greater than 0
        if (!is_numeric($this->starting_price) || $this->starting_price <= 0) {
            return new ActionResult(false, 'Starting price must be greater than 0');
        }

        // Validate link URL
        if (!filter_var($this->link, FILTER_VALIDATE_URL)) {
            return new ActionResult(false, 'Invalid product link URL');
        }

        // Validate image_url
        if (!filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return new ActionResult(false, 'Invalid image URL');
        }

        $promotionProduct = new ProductCard(
            $this->name,
            number_format($this->starting_price, 2), // Format price to 2 decimal places
            $this->currency,
            $this->image_url,
            $this->link
        );
        return new ActionResult(true, 'Promotion product found', $promotionProduct->toArray());
    }
}
