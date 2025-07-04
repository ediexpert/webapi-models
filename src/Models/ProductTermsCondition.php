<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTermsCondition extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';

    protected $fillable = ['product_id', 'sequence', 'content'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'Id');
    }
}
