<?php

namespace EdiExpert\WebapiModels\Models;

class ActionResult
{
    public bool $isSuccess;
    public string $message;
    public mixed $data;

    public function __construct(bool $isSuccess, string $message = '', mixed $data = null)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->data = $data;
    }

    public static function success(string $message = '', mixed $data = null): self
    {
        return new self(true, $message, $data);
    }

    public static function failure(string $message = '', mixed $data = null): self
    {
        return new self(false, $message, $data);
    }
}
