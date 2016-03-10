<?php

namespace TradeSmarter\Tests;

use TradeSmarter\Requests\Register;

class UsersTest extends TestCase
{
    protected $email;

    protected $password;

    protected $countries;

    public function __construct(){
        parent::__construct();
        $this->email = 'text' . time() . '@gmail.com';
        $this->password = md5(rand());
    }

    public function testCountries(){
        $this->countries = $this->apiClient->countries();
    }

    public function XtestRegister()
    {
//        $x = [                'firstName' => $this->faker->firstName,
//            'lastName' => $this->faker->lastName,
//            'email' => $this->faker->email,
//            'mobilePhone' => $this->faker->randomNumber(8),
//            'password' => $password,
//            'password2' => $password,
//            'countryName' => $this->getRandomCountryISOAlpha3(),
//            'ip' => '127.0.0.1',
//            'terms' => '',];

        $request = new Register([
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->email,
            'confirmed' => 1,
            'password' => $this->password,
            'phone' => $this->faker->randomNumber(8),
            'country' => $this->getRandomCountry(),
            'locale' => 'en-US',
            'params' => [],
            'lead' => 0,
        ]);
    }
}