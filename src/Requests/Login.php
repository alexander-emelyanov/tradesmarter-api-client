<?php

namespace TradeSmarter\Requests;

class Login
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    public function __construct($params = [])
    {
        foreach ($params as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * Returns user's email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns plain user's password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
