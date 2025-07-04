<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Communication extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';

    function communicable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function log(
        Model $model,
        string $action,
        string $description
    ): Communication {
        $comm = new Communication();
        $comm->communicable()->associate($model);
        $comm->action = $action;
        $comm->description = $description;
        $comm->save();

        return $comm;
    }
}
