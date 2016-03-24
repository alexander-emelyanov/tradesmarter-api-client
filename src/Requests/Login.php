<?php

namespace TradeSmarter\Requests;

use TradeSmarter\Request;

class Login extends Request
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

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
