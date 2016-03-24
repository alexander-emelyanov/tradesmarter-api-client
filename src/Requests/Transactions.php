<?php

namespace TradeSmarter\Requests;

use TradeSmarter\Request;

class Transactions extends Request
{
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return bool
     */
    public function isFormatted()
    {
        return $this->formatted;
    }

    /**
     * A valid  user's email.
     *
     * @var string
     */
    protected $email;

    /**
     * A valid  user's password.
     *
     * @var string
     */
    protected $password;

    /**
     * Optional. The page number to display. Starts at (and defaults to) 1.
     *
     * @var int
     */
    protected $page;

    /**
     * Optional. Four-digit year number. Limits transactions to the given year.
     *
     * @var int
     */
    protected $year;

    /**
     * Optional. Two-digit month number (eg. 02 for February). Limits to the given month.
     * May only be specified alongside year.
     *
     * @var string
     */
    protected $month;

    /**
     * Option. If set, dates and prices will be formatted for display.
     *
     * @var bool
     */
    protected $formatted = false;
}
