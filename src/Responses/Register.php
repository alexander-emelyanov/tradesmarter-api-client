<?php

namespace TradeSmarter\Responses;

use TradeSmarter\Exception;
use TradeSmarter\Exceptions\BlockedCountry;
use TradeSmarter\Exceptions\EmailAlreadyExists;
use TradeSmarter\Payload;
use TradeSmarter\Response;

class Register extends Response
{
    const FIELD_ID = 'id';

    /**
     * @var int
     */
    protected $id;

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if ($this->isSuccess()){
            $this->id = $payload[static::FIELD_ID];
        } else {
            switch ($this->getErrorCode()){
                case static::ERROR_EMAIL_ALREADY_EXISTS: {
                    throw new EmailAlreadyExists($payload, 'Password invalid');
                }
                case static::ERROR_BLOCKED_COUNTRY: {
                    throw new BlockedCountry($payload, 'Country is not allowed');
                }
                default: {
                    throw new Exception($payload, 'Trade platform error');
                }
            }
        }
    }

    /**
     * Returns the newly created userID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}