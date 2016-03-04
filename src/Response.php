<?php

namespace TradeSmarter;

class Response
{
    CONST FIELD_API_CODE = 'apiCode';

    CONST FIELD_API_CODE_DESCRIPTION = 'apiCodeDescription';

    CONST FIELD_USER_MESSAGES = 'userMessages';

    CONST VALUE_API_CODE_G000 = 'G000';

    /**
     * @var string
     */
    protected $apiCode = '';

    /**
     * @var string
     */
    protected $apiCodeDescription = '';

    /**
     * @var array
     */
    protected $userMessages = [];

    public function __construct(Payload $payload){
        $this->apiCode = $payload[static::FIELD_API_CODE];
        $this->apiCodeDescription = $payload[static::FIELD_API_CODE_DESCRIPTION];
        $this->userMessages = isset($payload[static::FIELD_USER_MESSAGES]) ? $payload[static::FIELD_USER_MESSAGES] : [];
    }

    public function isSuccess(){
        return ($this->apiCode == static::VALUE_API_CODE_G000);
    }

    public function getApiCode(){
        return $this->apiCode;
    }

    public function getApiCodeDescription(){
        return $this->apiCodeDescription;
    }

    public function getUserMessages(){
        return $this->userMessages;
    }
}