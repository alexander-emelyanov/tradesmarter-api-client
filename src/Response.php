<?php

namespace TradeSmarter;

class Response
{
    /**
     * Email already exists
     */
    const ERROR_EMAIL_ALREADY_EXISTS = 10;

    /**
     * Could not log in. Please verify that you're using the correct email and password.
     */
    const ERROR_INVALID_CREDENTIALS = 20;

    /**
     * Banned country - not in use
     */
    const ERROR_BLOCKED_COUNTRY = 102;

    protected $data;

    public function __construct(Payload $payload)
    {
        $this->data = $payload;
    }

    public function isSuccess()
    {
         return ((isset($this->data['success']) && $this->data['success']) || !isset($this->data['error']));
    }

    public function getErrorCode()
    {
        if (isset($this->data['error']['code'])){
            return $this->data['error']['code'];
        }
    }

    public function getErrorMessage()
    {
        if (isset($this->data['error']['message'])){
            return $this->data['error']['message'];
        }
    }
}