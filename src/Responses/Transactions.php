<?php

namespace TradeSmarter\Responses;

use TradeSmarter\Payload;
use TradeSmarter\Response;

class Transactions extends Response
{
    const FIELD_ROWS = 'rows';

    const FIELD_SUMMARY = 'summary';

    const FIELD_DEPOSITS = 'deposits';

    const FIELD_PROFIT = 'profit';

    const FIELD_BONUSES = 'bonuses';

    const FIELD_WITHDRAWALS = 'withdrawals';

    /**
     * Returns deposits amounts. With the currency sign.
     * Example: '-$2.00'.
     *
     * @return string
     */
    public function getDeposits()
    {
        return $this->deposits;
    }

    /**
     * Returns total profit. With the currency sign.
     * Example: '-$2.00'.
     *
     * @return string
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Returns bonuses amounts. With the currency sign.
     * Example: '-$2.00'.
     *
     * @return string
     */
    public function getBonuses()
    {
        return $this->bonuses;
    }

    /**
     * Returns withdrawals amounts. With the currency sign.
     * Example: '-$2.00'.
     *
     * @return string
     */
    public function getWithdrawals()
    {
        return $this->withdrawals;
    }

    /**
     * @var \TradeSmarter\Responses\Transaction[]
     */
    protected $rows;

    /**
     * @var string
     */
    protected $deposits;

    /**
     * @var string
     */
    protected $profit;

    /**
     * @var string
     */
    protected $bonuses;

    /**
     * @var string
     */
    protected $withdrawals;

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if ($this->isSuccess()) {
            $this->deposits = $payload[static::FIELD_SUMMARY][static::FIELD_DEPOSITS];
            $this->profit = $payload[static::FIELD_SUMMARY][static::FIELD_PROFIT];
            $this->bonuses = $payload[static::FIELD_SUMMARY][static::FIELD_BONUSES];
            $this->withdrawals = $payload[static::FIELD_SUMMARY][static::FIELD_WITHDRAWALS];
            $this->rows = [];
            foreach ($payload[static::FIELD_ROWS] as $row) {
                $this->rows[] = new Transaction($row);
            }
        }
    }

    /**
     * Returns the user's transactions.
     *
     * @return \TradeSmarter\Responses\Transaction[]
     */
    public function getRows()
    {
        return $this->rows;
    }
}
