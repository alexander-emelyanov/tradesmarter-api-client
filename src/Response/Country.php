<?php

namespace TradeSmarter\Response;

class Country
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $dialCode;

    public function __construct($id, $name, $dialCode)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dialCode = $dialCode;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDialCode()
    {
        return $this->dialCode;
    }
}