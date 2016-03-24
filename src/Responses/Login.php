<?php

namespace TradeSmarter\Responses;

use TradeSmarter\Exceptions\InvalidCredentials;
use TradeSmarter\Payload;
use TradeSmarter\Response;

class Login extends Response
{
    const FIELD_SESSION = 'session';

    const FIELD_USER = 'user';

    const FIELD_USER_ID = 'userID';

    protected $session;

    protected $userId;

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if ($this->isSuccess()) {
            $this->session = $payload[static::FIELD_SESSION];
            $this->userId = $payload[static::FIELD_USER][static::FIELD_USER_ID];
        } else {
            if ($this->getErrorCode() == static::ERROR_INVALID_CREDENTIALS) {
                throw new InvalidCredentials($payload, 'Password invalid');
            }
        }
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
