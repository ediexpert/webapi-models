<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalProductAttribute extends Model
{
    use HasFactory;

    protected $connection = 'ticketsender';

    protected $fillable = ['external_product_id', 'name', 'value'];

    public function externalProduct()
    {
        return $this->belongsTo(ExternalProduct::class, 'external_product_id', 'id');
    }
}
