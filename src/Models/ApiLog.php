<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ApiLog extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';
    public $timestamps = false;

    protected $fillable = [
        'user',
        'method',
        'path',
        'request_body',
        'response_body',
        'status_code',
        'ip_address'
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * Log an API request and response
     *
     * @param Model $loggable The model to associate with the log
     * @param string $user The user performing the action
     * @param string $method The HTTP method used
     * @param string $path The API endpoint path
     * @param string $requestBody The request body
     * @param string $responseBody The response body
     * @param int $statusCode The response status code
     * @param string|null $ipAddress The IP address of the request (optional)
     * @return ApiLog The created ApiLog instance
     */
    public static function log(
        Model $loggable,
        string $user,
        string $method,
        string $path,
        string $requestBody,
        string $responseBody,
        int $statusCode,
        ?string $ipAddress = null
    ): ApiLog {
        $apiLog = new ApiLog();
        $apiLog->loggable()->associate($loggable);
        $apiLog->user = $user;
        $apiLog->method = $method;
        $apiLog->path = $path;
        $apiLog->request_body = $requestBody;
        $apiLog->response_body = $responseBody;
        $apiLog->status_code = $statusCode;
        $apiLog->ip_address = $ipAddress ?? $_SERVER['REMOTE_ADDR'];
        $apiLog->save();

        return $apiLog;
    }
}
