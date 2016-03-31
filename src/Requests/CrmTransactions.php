<?php

namespace TradeSmarter\Requests;

use TradeSmarter\Request;

class CrmTransactions extends Request
{
    /**
     * @return array
     */
    public function getUserIds()
    {
        return $this->userIds;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getFromTimestamp()
    {
        return $this->fromTimestamp;
    }

    /**
     * @return int
     */
    public function getToTimestamp()
    {
        return $this->toTimestamp;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Users IDs.
     *
     * @var array
     */
    protected $userIds;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $fromTimestamp;

    /**
     * @var int
     */
    protected $toTimestamp;

    /**
     * @var int
     */
    protected $page;
}
