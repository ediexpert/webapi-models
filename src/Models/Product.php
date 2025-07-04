<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $connection = 'ticketsender';
    protected $table = 'Products';
    protected $primaryKey = 'Id';

    public $timestamps = true;

    protected $fillable = [
        'Name',
        'FullName',
        'Folder',
        'ImageUrl',
        'ProductType',
        'OrderProcessingType',
        'GatePrice',
        'Content'
    ];

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


    public function externalProducts()
    {
        return $this->belongsToMany(ExternalProduct::class, 'product_external_product', 'product_id', 'external_product_id');
    }

    /**
     * The attributes that are enum.
     *
     * @var array
     */
    protected $enums = [
        'ProductType' => [
            0 => 'Single',
            1 => 'Combo'
        ],
        'OrderProcessingType' => [
            0 => 'None',
            1 => 'FTP',
            2 => 'Rayna',
            3 => 'Rathin'
        ]
    ];

    protected $attributes = [
        'OrderProcessingType' => 0,
        'RaynaTourId' => 0,
        'RaynaTourOptionId' => 0,
        'RaynaContractId' => 0,
        'RaynaAdultPrice' => 0,
        'RaynaChildPrice' => 0,
        'GatePrice' => 0,
        'CostINR' => 0,
        'MinumumSellingPriceAED' => 0
    ];


    public static $orderProcessingTypes = [
        'rayna' => 'Rayna',
        'dpr' => 'DPR',
        'rathin' => 'Rathin',
        'klook' => 'Klook'
    ];

    public function termsConditions()
    {
        return $this->hasMany(ProductTermsCondition::class, 'product_id')->orderBy('sequence');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id', 'Id');
    }

    /**
     * Get the minimum price for a specific service date.
     *
     * @param string $serviceDate
     * @return Price|null
     */
    public function getMinPrice($serviceDate): Price|null
    {
        // only take service date and remvove time part
        $date = date('Y-m-d', strtotime($serviceDate));
        $price = $this->prices()
            ->where('service_date', $date)
            ->orderBy('adult_price', 'asc')
            ->first();

        return $price;
    }

    // public function getPromotionProduct(int $externalConnectionId): ActionResult
    // {
    //     $externalProduct = $this->externalProducts()
    //         ->where('external_connection_id', $externalConnectionId)
    //         ->first();

    //     if (!$externalProduct) {
    //         return new ActionResult(false, 'No promotion product found for this connection');
    //     }

    //     $promotionProduct = [
    //         'name' => $this->FullName,
    //         'price' => $externalProduct->starting_price_text ?? $this->GatePrice,
    //         'image_url' => $this->ImageUrl,
    //         'link' => $externalProduct->link ?? null,
    //     ];
    //     return new ActionResult(true, 'Promotion product found', $promotionProduct);
    // }
}
