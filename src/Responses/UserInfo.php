<?php

namespace TradeSmarter\Responses;

use TradeSmarter\Exception;
use TradeSmarter\Payload;
use TradeSmarter\Response;

class UserInfo extends Response
{
    const FIELD_USER_ID = 'userID';

    const FIELD_DATE_OF_BIRTH = 'dob';

    const FIELD_CONFIRMED = 'confirmed';

    const FIELD_VALIDATED = 'validated';

    const FIELD_FROZEN = 'frozen';

    const FIELD_BLOCKED = 'blocked';

    const FIELD_AFFILIATE_ID = 'affiliateID';

    const FIELD_USER_CURRENCY = 'userCurrency';

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * @return boolean
     */
    public function isFrozen()
    {
        return $this->frozen;
    }

    /**
     * @return boolean
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @return int
     */
    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    /**
     * @return int
     */
    public function getUserCurrency()
    {
        return $this->userCurrency;
    }

    /**
     * @var int
     */
    protected $userId;

    /**
     * Date of birth.
     * Example: '1982-02-14'.
     *
     * @var string
     */
    protected $dateOfBirth;

    /**
     * @var bool
     */
    protected $confirmed;

    /**
     * @var bool
     */
    protected $validated;

    /**
     * @var bool
     */
    protected $frozen;

    /**
     * @var bool
     */
    protected $blocked;

    /**
     * @var int
     */
    protected $affiliateId;

    /**
     * @var int
     */
    protected $userCurrency;

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if ($this->isSuccess()) {
            $this->userId = $this->data[static::FIELD_USER_ID];
            $this->dateOfBirth = $this->data[static::FIELD_DATE_OF_BIRTH];
            $this->confirmed = $this->data[static::FIELD_CONFIRMED];
            $this->validated = $this->data[static::FIELD_VALIDATED];
            $this->frozen = $this->data[static::FIELD_FROZEN];
            $this->blocked = $this->data[static::FIELD_BLOCKED];
            $this->affiliateId = $this->data[static::FIELD_AFFILIATE_ID];
            $this->userCurrency = $this->data[static::FIELD_USER_CURRENCY];
        } else {
            switch ($this->getErrorCode()) {
                default: {
                    throw new Exception($payload, 'Trade platform error');
                }
            }
        }
    }
}
