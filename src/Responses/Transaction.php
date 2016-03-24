<?php

namespace TradeSmarter\Responses;

class Transaction
{
    /**
     * @return int
     */
    public function getRecordId()
    {
        return $this->recordID;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getTradeId()
    {
        return $this->tradeID;
    }

    /**
     * @return string
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @return string
     */
    public function getDebit()
    {
        return $this->debit;
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return string
     */
    public function getReserved()
    {
        return $this->reserved;
    }

    /**
     * @return string
     */
    public function getWalletBalance()
    {
        return $this->walletBalance;
    }

    /**
     * @var int
     */
    protected $recordID;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $tradeID;

    /**
     * @var string
     */
    protected $credit;

    /**
     * @var string
     */
    protected $debit;

    /**
     * @var string
     */
    protected $balance;

    /**
     * @var string
     */
    protected $reserved;

    /**
     * @var string
     */
    protected $walletBalance;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
