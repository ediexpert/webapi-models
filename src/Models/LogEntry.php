<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property id
 * @property level
 * @property message
 * @property context
 */
class LogEntry extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $fillable = ['level', 'message', 'context'];
    protected $casts = [
        'context' => 'array',
    ];
}
