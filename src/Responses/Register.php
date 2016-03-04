<?php

namespace TradeSmarter\Responses;

class Register
{
    /**
     * @var string
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the newly created userID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}