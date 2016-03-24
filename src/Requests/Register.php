<?php

namespace TradeSmarter\Requests;

class Register
{
    /**
     * @var string The user’s email address.
     */
    protected $email;

    /**
     * @var string Password string of user's password.
     */
    protected $password;

    /**
     * @var string The user’s first name.
     */
    protected $firstName;

    /**
     * @var string The user’s last name.
     */
    protected $lastName;

    /**
     * @var string The user’s phone number.
     */
    protected $phone;

    /**
     * @var string The user’s two-character ISO country code
     *
     * @see \TradeSmarter\ApiClient::countries()
     */
    protected $country;

    /**
     * @var bool Optional. If set, user will be created as already confirmed.
     */
    protected $confirmed = true;

    /**
     * @var string Optional. The new national ID number to set.
     */
    protected $nationalId;

    /**
     * @var string Optional. The new date of birth to set.
     */
    protected $birthday;

    /**
     * @var string Optional. The language code (should be lower case). lang_Country (e.g. en_US, fr_FR....etc).
     */
    protected $locale;

    /**
     * @var array Optional. Landing parameters to be assigned to the registered user (affiliate id, serial, campaign...etc).
     */
    protected $params;

    public function __construct($params = [])
    {
        foreach ($params as $name => $value) {
            $this->{$name} = $value;
        }
    }

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
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return string
     */
    public function getNationalId()
    {
        return $this->nationalId;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return (array) $this->params;
    }
}
