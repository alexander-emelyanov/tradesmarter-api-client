<?php

namespace TradeSmarter\Responses;

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

    /**
     * @var string
     */
    public $defaultLanguage;

    public function __construct($id, $name, $dialCode, $defaultLanguage = 'en')
    {
        $this->id = $id;
        $this->name = $name;
        $this->dialCode = $dialCode;
        $this->defaultLanguage = $defaultLanguage;
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

    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }
}
